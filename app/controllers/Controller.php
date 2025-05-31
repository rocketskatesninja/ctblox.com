<?php
require_once __DIR__ . '/../classes/ErrorHandler.php';

abstract class Controller {
    protected $pdo;
    protected $user;
    protected $lesson;
    
    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
        $this->user = new User();
        $this->lesson = new Lesson();
    }
    
    protected function view($name, $data = []) {
        // Extract data to make variables available in view
        extract($data);
        
        // Start output buffering
        ob_start();
        
        // Include the view file
        $viewFile = APP_PATH . "/app/views/{$name}.php";
        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            throw new Exception("View {$name} not found");
        }
        
        // Return the buffered content
        return ob_get_clean();
    }
    
    protected function redirect($url) {
        header("Location: " . $url);
        exit;
    }
    
    protected function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    protected function isAjax() {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
    
    protected function requireLogin() {
        if (!isset($_SESSION['user_id'])) {
            if ($this->isAjax()) {
                $this->json(['error' => 'Unauthorized', 'redirect' => '/login']);
            } else {
                $this->redirect('/login');
            }
        }
    }
    
    protected function requireAdmin() {
        $this->requireLogin();
        
        if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
            if ($this->isAjax()) {
                $this->json(['error' => 'Unauthorized']);
            } else {
                $this->redirect('/dashboard');
            }
        }
    }
    
    protected function requireCoach() {
        $this->requireLogin();
        
        // Allow both coaches and admins to access coach functionality
        if ((!isset($_SESSION['is_coach']) || !$_SESSION['is_coach']) && 
            (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin'])) {
            if ($this->isAjax()) {
                $this->json(['error' => 'You must be a coach or admin to access this area']);
            } else {
                $this->flash('You must be a coach or admin to access this area', 'error');
                $this->redirect('/dashboard');
            }
        }
    }
    
    protected function checkCsrfToken() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST[CSRF_TOKEN_NAME]) || 
                !isset($_SESSION[CSRF_TOKEN_NAME]) || 
                $_POST[CSRF_TOKEN_NAME] !== $_SESSION[CSRF_TOKEN_NAME]) {
                if ($this->isAjax()) {
                    $this->json(['error' => 'Invalid CSRF token']);
                } else {
                    die('Invalid CSRF token');
                }
            }
        }
    }
    
    protected function requireStudent() {
        $this->requireLogin();
        
        // Check if user is a student (not an admin or coach)
        if ((isset($_SESSION['is_admin']) && $_SESSION['is_admin']) || 
            (isset($_SESSION['is_coach']) && $_SESSION['is_coach'])) {
            if ($this->isAjax()) {
                $this->json(['error' => 'This area is only accessible to students']);
            } else {
                $this->flash('This area is only accessible to students', 'error');
                $this->redirect('/dashboard');
            }
        }
    }
    
    protected function generateCsrfToken() {
        if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
            $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
        }
        return $_SESSION[CSRF_TOKEN_NAME];
    }
    
    protected function sanitize($text) {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }
    
    protected function flash($message, $type = 'info') {
        $_SESSION['flash'] = [
            'message' => $message,
            'type' => $type
        ];
    }
    
    protected function getFlash() {
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
        }
        return null;
    }
}
