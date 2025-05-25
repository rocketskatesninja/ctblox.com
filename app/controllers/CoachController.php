<?php
class CoachController extends Controller {
    protected $user;
    protected $lesson;
    
    public function __construct() {
        parent::__construct();
        $this->user = new User();
        $this->lesson = new Lesson();
        
        // Ensure user is logged in and is a coach
        $this->requireLogin();
        $this->requireCoach();
    }
    
    /**
     * Coach dashboard showing assigned students and their progress
     */
    public function dashboard() {
        $coachId = $_SESSION['user_id'];
        
        // Get students assigned to this coach
        $students = $this->user->getStudents($coachId);
        
        // Get progress data for each student
        $studentsWithProgress = [];
        foreach ($students as $student) {
            $progress = $this->lesson->getUserProgress($student['id']);
            
            // Group progress by lesson
            $lessonProgress = [];
            foreach ($progress as $item) {
                if (!isset($lessonProgress[$item['title']])) {
                    $lessonProgress[$item['title']] = [
                        'completed_chapters' => 0,
                        'total_chapters' => 0,
                        'last_activity' => null,
                        'quiz_scores' => []
                    ];
                }
                
                $lessonProgress[$item['title']]['total_chapters']++;
                
                if ($item['completed']) {
                    $lessonProgress[$item['title']]['completed_chapters']++;
                    
                    // Track the most recent activity
                    if (
                        !$lessonProgress[$item['title']]['last_activity'] || 
                        strtotime($item['completed_at']) > strtotime($lessonProgress[$item['title']]['last_activity'])
                    ) {
                        $lessonProgress[$item['title']]['last_activity'] = $item['completed_at'];
                    }
                }
                
                // Add quiz score if available
                if (!empty($item['quiz_score'])) {
                    $lessonProgress[$item['title']]['quiz_scores'][] = $item['quiz_score'];
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
            
            $studentsWithProgress[] = [
                'id' => $student['id'],
                'username' => $student['username'],
                'email' => $student['email'],
                'last_login' => $student['last_login'],
                'created_at' => $student['created_at'],
                'progress' => $lessonProgress
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
        
        // Get assigned lessons
        $assignedLessons = $this->lesson->getAssignedLessons($studentId);
        
        // Get all available lessons (for the assign modal)
        $allLessons = $this->lesson->getAllLessons();
        
        // Get detailed progress for assigned lessons only
        $progress = $this->lesson->getUserProgressForAssignedLessons($studentId);
        
        // Get overall progress statistics
        $overallProgress = $this->lesson->getOverallProgress($studentId);
        
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
            $this->flash('Lesson assigned successfully', 'success');
        } else {
            $this->flash('Failed to assign lesson', 'error');
        }
        
        // Redirect back to student page
        $this->redirect('/coach/student/' . $studentId);
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
