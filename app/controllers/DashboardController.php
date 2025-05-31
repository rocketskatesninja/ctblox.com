<?php
require_once __DIR__ . '/../models/Stats.php';
require_once __DIR__ . '/../repositories/DatabaseRepository.php';

class DashboardController extends Controller {
    protected $dbRepo;
    
    public function __construct() {
        parent::__construct();
        $this->requireLogin();
        $this->dbRepo = new DatabaseRepository();
    }
    
    public function index() {
        // Determine user role and show appropriate dashboard
        if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
            return $this->redirect('/admin/dashboard');
        } elseif (isset($_SESSION['is_coach']) && $_SESSION['is_coach']) {
            return $this->redirect('/coach/dashboard');
        }
        
        // For students, show lessons and progress using the database repository
        $progress = $this->dbRepo->getUserProgress($_SESSION['user_id']);
        
        // Get available lessons (only those assigned to the student) using the database repository
        $lessons = $this->dbRepo->getUserAvailableLessons($_SESSION['user_id']);
        
        // Get quiz results for the user
        $quizResults = $this->dbRepo->getUserQuizResults($_SESSION['user_id']);
        
        // Generate descriptive summaries for each lesson
        foreach ($lessons as &$lesson) {
            // Create a more descriptive summary based on lesson content
            $summary = '';
            
            // Add information about chapters
            if (!empty($lesson['chapter_titles'])) {
                $summary = 'Covers: ' . $lesson['chapter_titles'];
                if ($lesson['total_chapters'] > 3) {
                    $summary .= ' and more';
                }
            }
            
            // Add information about quizzes if applicable
            if ($lesson['quizzes_taken'] > 0) {
                $summary .= ($summary ? ' • ' : '') . $lesson['quizzes_taken'] . ' quiz' . ($lesson['quizzes_taken'] > 1 ? 'zes' : '') . ' completed';
            }
            
            // If we couldn't generate a meaningful summary, use the description
            if (empty($summary)) {
                $summary = $lesson['description'];
            }
            
            $lesson['custom_summary'] = $summary;
        }
        
        // Get user dashboard statistics using the Stats model
        $statsModel = Stats::getInstance();
        $stats = $statsModel->getUserDashboardStats($_SESSION['user_id']);
        
        return $this->view('dashboard/index', [
            'lessons' => $lessons,
            'progress' => $progress,
            'stats' => $stats
        ]);
    }
    
    public function profile() {
        $user = $this->user->getById($_SESSION['user_id']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->checkCsrfToken();
            
            $data = [
                'email' => $_POST['email'] ?? $user['email']
            ];
            
            if (!empty($_POST['new_password'])) {
                if (!password_verify($_POST['current_password'], $user['password'])) {
                    $this->flash('Current password is incorrect', 'error');
                    $this->redirect('/profile');
                }
                
                if ($_POST['new_password'] !== $_POST['confirm_password']) {
                    $this->flash('New passwords do not match', 'error');
                    $this->redirect('/profile');
                }
                
                $data['password'] = $_POST['new_password'];
            }
            
            if ($this->user->update($user['id'], $data)) {
                $this->flash('Profile updated successfully', 'success');
            } else {
                $this->flash('Error updating profile', 'error');
            }
            
            $this->redirect('/profile');
        }
        
        return $this->view('dashboard/profile', [
            'user' => $user,
            'csrf_token' => $this->generateCsrfToken()
        ]);
    }
    
    public function certificates() {
        // Get completed lessons
        $completedLessons = $this->pdo->prepare("
            SELECT l.*, 
                   COUNT(DISTINCT c.chapter_id) as total_chapters,
                   COUNT(DISTINCT CASE WHEN p.completed = 1 THEN p.chapter_id END) as completed_chapters,
                   MAX(p.completed_at) as completion_date
            FROM lessons l
            JOIN chapters c ON l.id = c.lesson_id
            JOIN progress p ON l.id = p.lesson_id AND p.user_id = ?
            GROUP BY l.id
            HAVING total_chapters = completed_chapters
            ORDER BY completion_date DESC
        ");
        $completedLessons->execute([$_SESSION['user_id']]);
        
        return $this->view('dashboard/certificates', [
            'lessons' => $completedLessons->fetchAll()
        ]);
    }
}
