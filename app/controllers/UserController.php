<?php

class UserController extends Controller {
    private $user;

    public function __construct() {
        parent::__construct();
        $this->user = new User();
    }

    public function showLogin() {
        $this->view('auth/login', ['title' => 'Login']);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /login');
            exit;
        }

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            $this->flash('Please enter both username and password', 'error');
            header('Location: /login');
            exit;
        }

        $user = $this->user->getByUsername($username);
        if (!$user || !password_verify($password, $user['password'])) {
            $this->flash('Invalid username or password', 'error');
            header('Location: /login');
            exit;
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['is_admin'] = $user['is_admin'];

        header('Location: /dashboard');
        exit;
    }

    public function logout() {
        session_destroy();
        header('Location: /login');
        exit;
    }

    public function showProfile() {
        $this->requireLogin();
        $user = $this->user->getById($_SESSION['user_id']);
        $this->view('user/profile', [
            'title' => 'Profile',
            'user' => $user
        ]);
    }

    public function updateProfile() {
        $this->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /profile');
            exit;
        }

        $email = $_POST['email'] ?? '';
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        $user = $this->user->getById($_SESSION['user_id']);

        if (!empty($currentPassword)) {
            if (!password_verify($currentPassword, $user['password'])) {
                $this->flash('Current password is incorrect', 'error');
                header('Location: /profile');
                exit;
            }

            if (empty($newPassword) || empty($confirmPassword)) {
                $this->flash('Please enter and confirm your new password', 'error');
                header('Location: /profile');
                exit;
            }

            if ($newPassword !== $confirmPassword) {
                $this->flash('New passwords do not match', 'error');
                header('Location: /profile');
                exit;
            }

            $this->user->updatePassword($_SESSION['user_id'], $newPassword);
            $this->flash('Password updated successfully');
        }

        if (!empty($email) && $email !== $user['email']) {
            $this->user->updateEmail($_SESSION['user_id'], $email);
            $this->flash('Email updated successfully');
        }

        header('Location: /profile');
        exit;
    }
}
