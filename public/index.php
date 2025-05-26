<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/routes/Router.php';
require_once __DIR__ . '/../app/controllers/Controller.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/AdminController.php';
require_once __DIR__ . '/../app/controllers/DashboardController.php';
require_once __DIR__ . '/../app/controllers/LessonController.php';
require_once __DIR__ . '/../app/controllers/CoachController.php';
require_once __DIR__ . '/../app/controllers/ProfileController.php';
require_once __DIR__ . '/../app/controllers/ErrorController.php';
require_once __DIR__ . '/../app/models/User.php';
require_once __DIR__ . '/../app/models/Lesson.php';

// Initialize router
$router = new Router();

// Auth routes
$router->add('GET', '/login', 'AuthController', 'login');
$router->add('POST', '/login', 'AuthController', 'login');
$router->add('GET', '/logout', 'AuthController', 'logout');
$router->add('GET', '/reset-password', 'AuthController', 'resetPassword');
$router->add('POST', '/reset-password', 'AuthController', 'resetPassword');

// Dashboard routes
$router->add('GET', '/', 'DashboardController', 'index');
$router->add('GET', '/dashboard', 'DashboardController', 'index');
$router->add('GET', '/dashboard/certificates', 'DashboardController', 'certificates');

// Lesson routes
$router->add('GET', '/lesson/{id}', 'LessonController', 'viewLesson');
$router->add('POST', '/lesson/progress', 'LessonController', 'updateProgress');
$router->add('POST', '/lesson/quiz', 'LessonController', 'saveQuizResult');
$router->add('GET', '/lesson/quiz/{id}', 'LessonController', 'getQuiz');
$router->add('POST', '/lesson/saveFeedback', 'LessonController', 'saveFeedback');
$router->add('GET', '/lesson/{id}/certificate', 'LessonController', 'generateCertificate');

// Admin routes
$router->add('GET', '/admin/dashboard', 'AdminController', 'dashboard');
$router->add('GET', '/admin/users', 'AdminController', 'users');
$router->add('POST', '/admin/users', 'AdminController', 'users');
$router->add('GET', '/admin/lessons', 'AdminController', 'lessons');
$router->add('POST', '/admin/lessons', 'AdminController', 'lessons');
$router->add('GET', '/admin/settings', 'AdminController', 'settings');
$router->add('POST', '/admin/settings', 'AdminController', 'settings');
$router->add('POST', '/admin/settings/test-email', 'AdminController', 'testEmail');
$router->add('POST', '/admin/clear-activity-log', 'AdminController', 'clearActivityLog');

// Profile routes
$router->add('GET', '/profile', 'ProfileController', 'index');
$router->add('POST', '/profile/update', 'ProfileController', 'update');
$router->add('POST', '/profile/change-password', 'ProfileController', 'changePassword');

// Coach routes
$router->add('GET', '/coach/dashboard', 'CoachController', 'dashboard');
$router->add('GET', '/coach/student/{id}', 'CoachController', 'viewStudent');
$router->add('POST', '/coach/assign-lesson', 'CoachController', 'assignLesson');
$router->add('POST', '/coach/unassign-lesson', 'CoachController', 'unassignLesson');

// Dispatch the request
echo $router->dispatch();
