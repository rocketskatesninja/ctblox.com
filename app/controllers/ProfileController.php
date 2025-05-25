<?php
class ProfileController extends Controller {
    protected $user;
    
    public function __construct() {
        parent::__construct();
        $this->user = new User();
        
        // Ensure user is logged in
        $this->requireLogin();
    }
    
    /**
     * Display user profile
     */
    public function index() {
        $userId = $_SESSION['user_id'];
        $userData = $this->user->getUserById($userId);
        
        if (!$userData) {
            $this->flash('User not found', 'error');
            $this->redirect('/dashboard');
        }
        
        return $this->view('profile/index', [
            'user' => $userData,
            'csrf_token' => $this->generateCsrfToken()
        ]);
    }
    
    /**
     * Update user profile
     */
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/profile');
        }
        
        $this->checkCsrfToken();
        
        $userId = $_SESSION['user_id'];
        $userData = $this->user->getUserById($userId);
        
        if (!$userData) {
            $this->flash('User not found', 'error');
            $this->redirect('/dashboard');
        }
        
        // Get form data
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $bio = $_POST['bio'] ?? '';
        
        // Validate form data
        $errors = [];
        
        if (empty($name)) {
            $errors['name'] = 'Name is required';
        }
        
        if (empty($email)) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        }
        
        // Check if email is already taken by another user
        if (!empty($email) && $email !== $userData['email']) {
            if ($this->user->emailExists($email, $userId)) {
                $errors['email'] = 'Email is already in use';
            }
        }
        
        // If there are errors, redirect back to the form with errors
        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            $this->redirect('/profile');
        }
        
        // Update user profile
        $updated = $this->user->updateProfile($userId, [
            'name' => $name,
            'email' => $email,
            'bio' => $bio
        ]);
        
        if ($updated) {
            // Log the activity
            $this->user->logActivity($_SESSION['username'], 'profile_update', null, 'User updated their profile');
            
            $this->flash('Profile updated successfully', 'success');
        } else {
            $this->flash('Failed to update profile', 'error');
        }
        
        $this->redirect('/profile');
    }
    
    /**
     * Change password
     */
    public function changePassword() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/profile');
        }
        
        $this->checkCsrfToken();
        
        $userId = $_SESSION['user_id'];
        
        // Get form data
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        // Validate form data
        $errors = [];
        
        if (empty($currentPassword)) {
            $errors['current_password'] = 'Current password is required';
        }
        
        if (empty($newPassword)) {
            $errors['new_password'] = 'New password is required';
        } elseif (strlen($newPassword) < 8) {
            $errors['new_password'] = 'Password must be at least 8 characters';
        }
        
        if ($newPassword !== $confirmPassword) {
            $errors['confirm_password'] = 'Passwords do not match';
        }
        
        // Verify current password
        if (!empty($currentPassword) && !$this->user->verifyPassword($userId, $currentPassword)) {
            $errors['current_password'] = 'Current password is incorrect';
        }
        
        // If there are errors, redirect back to the form with errors
        if (!empty($errors)) {
            $_SESSION['password_errors'] = $errors;
            $this->redirect('/profile');
        }
        
        // Update password
        $updated = $this->user->updatePassword($userId, $newPassword);
        
        if ($updated) {
            // Log the activity
            $this->user->logActivity($_SESSION['username'], 'password_change', null, 'User changed their password');
            
            $this->flash('Password updated successfully', 'success');
        } else {
            $this->flash('Failed to update password', 'error');
        }
        
        $this->redirect('/profile');
    }
}
