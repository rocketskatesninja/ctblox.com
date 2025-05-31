<?php
require_once __DIR__ . '/../repositories/DatabaseRepository.php';

class CoachController extends Controller {
    protected $user;
    protected $lesson;
    protected $dbRepo;
    
    public function __construct() {
        parent::__construct();
        $this->user = new User();
        $this->lesson = new Lesson();
        $this->dbRepo = new DatabaseRepository();
        
        // Ensure user is logged in and is a coach
        $this->requireLogin();
        $this->requireCoach();
    }
    
    /**
     * Coach dashboard showing assigned students and their progress
     */
    public function dashboard() {
        $coachId = $_SESSION['user_id'];
        
        // Get students assigned to this coach using the database repository
        $students = $this->dbRepo->getCoachStudents($coachId);
        
        // Get progress data for each student
        $studentsWithProgress = [];
        foreach ($students as $student) {
            // Get progress data using the database repository
            $progress = $this->dbRepo->getUserProgress($student['id']);
            
            // Get lesson completion statistics
            $lessonStats = $this->dbRepo->getUserLessonCompletionStats($student['id']);
            
            // Convert to the format expected by the view
            $lessonProgress = [];
            foreach ($lessonStats as $lesson) {
                $lessonProgress[$lesson['title']] = [
                    'completed_chapters' => $lesson['completed_chapters'],
                    'total_chapters' => $lesson['total_chapters'],
                    'last_activity' => $lesson['last_activity'],
                    'quiz_scores' => []
                ];
            }
            
            // Add quiz scores
            $quizResults = $this->dbRepo->getUserQuizResults($student['id']);
            foreach ($quizResults as $quiz) {
                if (isset($lessonProgress[$quiz['lesson_title']])) {
                    $lessonProgress[$quiz['lesson_title']]['quiz_scores'][] = $quiz['score'];
                }
            }
            
            // Calculate completion percentage for each lesson
            foreach ($lessonProgress as $title => &$data) {
                if ($data['total_chapters'] > 0) {
                    $data['completion_percentage'] = round(($data['completed_chapters'] / $data['total_chapters']) * 100);
                } else {
                    $data['completion_percentage'] = 0;
                }
                
                // Calculate average quiz score if available
                if (!empty($data['quiz_scores'])) {
                    $data['avg_quiz_score'] = round(array_sum($data['quiz_scores']) / count($data['quiz_scores']));
                } else {
                    $data['avg_quiz_score'] = null;
                }
            }
            
            // Get the overall progress for this student
            $overallProgress = $this->lesson->getOverallProgress($student['id']);
            
            $studentsWithProgress[] = [
                'id' => $student['id'],
                'username' => $student['username'],
                'email' => $student['email'],
                'last_login' => $student['last_login'],
                'created_at' => $student['created_at'],
                'progress' => $lessonProgress,
                'overall_progress' => $overallProgress
            ];
        }
        
        // Get all available lessons for reference
        $allLessons = $this->lesson->getAllLessons();
        
        return $this->view('coach/dashboard', [
            'students' => $studentsWithProgress,
            'allLessons' => $allLessons
        ]);
    }
    
    /**
     * View detailed progress for a specific student
     */
    public function viewStudent($studentId) {
        $userId = $_SESSION['user_id'];
        $isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
        
        // If user is not an admin, verify this student is assigned to the coach
        if (!$isAdmin) {
            $students = $this->user->getStudents($userId);
            $studentBelongsToCoach = false;
            
            foreach ($students as $student) {
                if ($student['id'] == $studentId) {
                    $studentBelongsToCoach = true;
                    break;
                }
            }
            
            if (!$studentBelongsToCoach) {
                $this->flash('You do not have permission to view this student', 'error');
                $this->redirect('/coach/dashboard');
            }
        }
        
        // Admins can view any student
        
        // Get student details
        $student = $this->user->getById($studentId);
        
        // Get assigned lessons - force a fresh query to avoid stale data
        $assignedLessons = $this->lesson->getAssignedLessons($studentId);
        
        // Log the assigned lessons for debugging
        error_log("Student $studentId has " . count($assignedLessons) . " assigned lessons");
        
        // Get all available lessons (for the assign modal)
        $allLessons = $this->lesson->getAllLessons();
        
        // Get detailed progress for assigned lessons using the database repository
        $progress = $this->dbRepo->getUserProgress($studentId);
        
        // Filter to only include assigned lessons
        $assignedLessonIds = array_column($assignedLessons, 'id');
        $progress = array_filter($progress, function($item) use ($assignedLessonIds) {
            return in_array($item['lesson_id'], $assignedLessonIds);
        });
        
        // Get all chapters for each assigned lesson to ensure accurate progress calculation
        foreach ($assignedLessonIds as $lessonId) {
            // Use repository pattern for consistency
            $chapters = $this->dbRepo->getLessonChapters($lessonId);
            
            // Check if we have progress records for each chapter
            foreach ($chapters as $chapter) {
                $hasProgressRecord = false;
                foreach ($progress as $progressItem) {
                    if ($progressItem['lesson_id'] == $lessonId && $progressItem['chapter_id'] == $chapter['chapter_id']) {
                        $hasProgressRecord = true;
                        break;
                    }
                }
                
                // If no progress record exists for this chapter, create a default one
                if (!$hasProgressRecord) {
                    // Get the lesson title
                    $lessonTitle = '';
                    foreach ($assignedLessons as $lesson) {
                        if ($lesson['id'] == $lessonId) {
                            $lessonTitle = $lesson['title'];
                            break;
                        }
                    }
                    
                    // Add a default progress record
                    $progress[] = [
                        'lesson_id' => $lessonId,
                        'title' => $lessonTitle,
                        'chapter_id' => $chapter['chapter_id'],
                        'completed' => 0,
                        'completed_at' => null,
                        'quiz_score' => null
                    ];
                }
            }
        }
        
        // Get overall progress statistics using the database repository
        $overallProgress = $this->dbRepo->getUserOverallProgress($studentId);
        
        // Get completed lessons (eligible for certificates)
        $completedLessons = $this->lesson->getCompletedLessons($studentId);
        
        return $this->view('coach/student', [
            'student' => $student,
            'progress' => $progress,
            'assignedLessons' => $assignedLessons,
            'allLessons' => $allLessons,
            'overallProgress' => $overallProgress,
            'completedLessons' => $completedLessons
        ]);
    }
    
    // The requireCoach method is now defined in the parent Controller class
    
    /**
     * Assign a lesson to a student
     */
    public function assignLesson() {
        $this->requireCoach();
        
        // Validate request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->flash('Invalid request method', 'error');
            $this->redirect('/coach/dashboard');
        }
        
        // Get the user ID and check if admin
        $userId = $_SESSION['user_id'];
        $isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
        
        // Get the student and lesson IDs
        $studentId = isset($_POST['student_id']) ? (int)$_POST['student_id'] : 0;
        $lessonId = isset($_POST['lesson_id']) ? (int)$_POST['lesson_id'] : 0;
        
        // If not admin, validate student belongs to coach
        if (!$isAdmin) {
            $students = $this->user->getStudents($userId);
            $studentBelongsToCoach = false;
            
            foreach ($students as $student) {
                if ($student['id'] == $studentId) {
                    $studentBelongsToCoach = true;
                    break;
                }
            }
            
            if (!$studentBelongsToCoach) {
                $this->flash('You do not have permission to assign lessons to this student', 'error');
                $this->redirect('/coach/dashboard');
            }
        }
        
        // Admins can assign lessons to any student
        
        // Assign the lesson
        if ($this->lesson->assignLesson($studentId, $lessonId, $userId)) {
            // Clear any cached data to ensure fresh data is loaded
            if (function_exists('opcache_reset')) {
                opcache_reset();
            }
            $this->flash('Lesson assigned successfully', 'success');
        } else {
            $this->flash('Failed to assign lesson', 'error');
        }
        
        // Redirect back to student page with a cache-busting parameter
        $this->redirect('/coach/student/' . $studentId . '?t=' . time());
    }
    
    /**
     * Unassign a lesson from a student
     */
    public function unassignLesson() {
        $this->requireCoach();
        
        // Validate request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->flash('Invalid request method', 'error');
            $this->redirect('/coach/dashboard');
        }
        
        // Get the user ID and check if admin
        $userId = $_SESSION['user_id'];
        $isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
        
        // Get the student and lesson IDs
        $studentId = isset($_POST['student_id']) ? (int)$_POST['student_id'] : 0;
        $lessonId = isset($_POST['lesson_id']) ? (int)$_POST['lesson_id'] : 0;
        
        // If not admin, validate student belongs to coach
        if (!$isAdmin) {
            $students = $this->user->getStudents($userId);
            $studentBelongsToCoach = false;
            
            foreach ($students as $student) {
                if ($student['id'] == $studentId) {
                    $studentBelongsToCoach = true;
                    break;
                }
            }
            
            if (!$studentBelongsToCoach) {
                $this->flash('You do not have permission to unassign lessons from this student', 'error');
                $this->redirect('/coach/dashboard');
            }
        }
        
        // Admins can unassign lessons from any student
        
        // Unassign the lesson
        if ($this->lesson->unassignLesson($studentId, $lessonId)) {
            $this->flash('Lesson unassigned successfully', 'success');
        } else {
            $this->flash('Failed to unassign lesson', 'error');
        }
        
        // Redirect back to student page
        $this->redirect('/coach/student/' . $studentId);
    }
}
