<?php
require_once __DIR__ . '/../models/Settings.php';

class CertificateController extends Controller {
    public function __construct() {
        parent::__construct();
        $this->requireLogin();
    }
    
    /**
     * Display the certificates page listing all earned certificates
     */
    public function index() {
        // Get user's completed lessons eligible for certificates
        $completedLessons = $this->lesson->getCompletedLessons($_SESSION['user_id']);
        
        // Get user data
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();
        
        // Get site settings for certificate template
        $settings = Settings::getInstance()->getAll();
        
        // Render the certificates page
        echo $this->view('certificates/index', [
            'completedLessons' => $completedLessons,
            'user' => $user,
            'settings' => $settings
        ]);
    }
    
    /**
     * Generate and download a certificate for a specific lesson
     */
    public function download($lessonId) {
        // Check if the lesson exists and is completed by the user
        $stmt = $this->pdo->prepare("
            SELECT l.*, MAX(p.completed_at) as completion_date
            FROM lessons l
            JOIN chapters c ON l.id = c.lesson_id
            LEFT JOIN progress p ON l.id = p.lesson_id AND c.chapter_id = p.chapter_id AND p.user_id = ?
            WHERE l.id = ?
            GROUP BY l.id
            HAVING COUNT(DISTINCT c.chapter_id) = COUNT(DISTINCT CASE WHEN p.completed = 1 THEN p.chapter_id END)
            AND COUNT(DISTINCT c.chapter_id) > 0
        ");
        $stmt->execute([$_SESSION['user_id'], $lessonId]);
        $lesson = $stmt->fetch();
        
        if (!$lesson) {
            $this->setFlash('error', 'Certificate not available. You must complete the lesson first.');
            return $this->redirect('/dashboard/certificates');
        }
        
        // Get user data
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();
        
        // Get instructor and admin info
        $instructor = $this->getInstructorInfo($lessonId);
        $admin = $this->getAdminInfo();
        
        // Format completion date
        $completion_date = $lesson['completion_date'];
        
        // Render the certificate
        ob_start();
        echo $this->view('certificates/template', [
            'user' => $user,
            'lesson' => $lesson,
            'completion_date' => $completion_date,
            'instructor' => $instructor,
            'admin' => $admin
        ], false);
        $html = ob_get_clean();
        
        // Generate PDF using the HTML
        require_once __DIR__ . '/../../vendor/autoload.php';
        
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L',
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0
        ]);
        
        $mpdf->WriteHTML($html);
        
        // Format filename
        $filename = 'Certificate_' . $this->sanitizeFilename($lesson['title']) . '_' . date('Y-m-d') . '.pdf';
        
        // Output PDF to browser
        $mpdf->Output($filename, 'D');
        exit;
    }
    
    /**
     * View a certificate in the browser
     */
    public function viewCertificate($lessonId) {
        // Check if the lesson exists and is completed by the user
        $stmt = $this->pdo->prepare("
            SELECT l.*, MAX(p.completed_at) as completion_date
            FROM lessons l
            JOIN chapters c ON l.id = c.lesson_id
            LEFT JOIN progress p ON l.id = p.lesson_id AND c.chapter_id = p.chapter_id AND p.user_id = ?
            WHERE l.id = ?
            GROUP BY l.id
            HAVING COUNT(DISTINCT c.chapter_id) = COUNT(DISTINCT CASE WHEN p.completed = 1 THEN p.chapter_id END)
            AND COUNT(DISTINCT c.chapter_id) > 0
        ");
        $stmt->execute([$_SESSION['user_id'], $lessonId]);
        $lesson = $stmt->fetch();
        
        if (!$lesson) {
            $this->setFlash('error', 'Certificate not available. You must complete the lesson first.');
            return $this->redirect('/dashboard/certificates');
        }
        
        // Get user data
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();
        
        // Get instructor and admin info
        $instructor = $this->getInstructorInfo($lessonId);
        $admin = $this->getAdminInfo();
        
        // Format completion date
        $completion_date = $lesson['completion_date'];
        
        // Render the certificate
        echo $this->view('certificates/template', [
            'user' => $user,
            'lesson' => $lesson,
            'completion_date' => $completion_date,
            'instructor' => $instructor,
            'admin' => $admin
        ]);
    }
    
    /**
     * Get instructor information for a lesson
     */
    private function getInstructorInfo($lessonId) {
        // Get lesson author
        $stmt = $this->pdo->prepare("SELECT author FROM lessons WHERE id = ?");
        $stmt->execute([$lessonId]);
        $author = $stmt->fetch();
        
        return [
            'name' => $author['author'] ?? 'Course Instructor'
        ];
    }
    
    /**
     * Get admin information
     */
    private function getAdminInfo() {
        // Get admin user
        $stmt = $this->pdo->prepare("SELECT name FROM users WHERE is_admin = 1 LIMIT 1");
        $stmt->execute();
        $admin = $stmt->fetch();
        
        return [
            'name' => $admin['name'] ?? 'Training Administrator'
        ];
    }
    

    
    /**
     * Sanitize a filename
     */
    private function sanitizeFilename($filename) {
        // Remove special characters
        $filename = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $filename);
        // Remove multiple underscores
        $filename = preg_replace('/_+/', '_', $filename);
        return $filename;
    }
}
