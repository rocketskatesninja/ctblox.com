<?php
class AuthController extends Controller {
    public function login() {
        // If already logged in, redirect to dashboard
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/dashboard');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->checkCsrfToken();
            
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if ($user = $this->user->authenticate($username, $password)) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['is_admin'] = $user['is_admin'];
                $_SESSION['is_coach'] = $user['is_coach'];
                $_SESSION['last_activity'] = time();
                
                // Redirect to appropriate dashboard
                if ($user['is_admin']) {
                    $this->redirect('/admin/dashboard');
                } else if ($user['is_coach']) {
                    $this->redirect('/coach/dashboard');
                } else {
                    $this->redirect('/dashboard');
                }
            } else {
                $this->flash('Invalid username or password', 'error');
                $this->redirect('/login');
            }
        }
        
        return $this->view('auth/login', [
            'csrf_token' => $this->generateCsrfToken()
        ]);
    }
    
    public function logout() {
        session_destroy();
        $this->redirect('/login');
    }
    
    public function resetPassword() {
        $this->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->checkCsrfToken();
            
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            if ($newPassword !== $confirmPassword) {
                $this->flash('New passwords do not match', 'error');
                $this->redirect('/reset-password');
            }
            
            $user = $this->user->getById($_SESSION['user_id']);
            if (!password_verify($currentPassword, $user['password'])) {
                $this->flash('Current password is incorrect', 'error');
                $this->redirect('/reset-password');
            }
            
            if ($this->user->update($_SESSION['user_id'], ['password' => $newPassword])) {
                $this->flash('Password updated successfully', 'success');
                $this->redirect('/dashboard');
            } else {
                $this->flash('Error updating password', 'error');
                $this->redirect('/reset-password');
            }
        }
        
        return $this->view('auth/reset-password', [
            'csrf_token' => $this->generateCsrfToken()
        ]);
    }
}
