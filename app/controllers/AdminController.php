<?php
require_once __DIR__ . '/../classes/ActivityLogger.php';

class AdminController extends Controller {
    public function __construct() {
        parent::__construct();
        $this->requireAdmin();
    }
    
    /**
     * Clear all activity logs
     */
    public function clearActivityLog() {
        // Check CSRF token
        $this->checkCsrfToken();
        
        if ($this->user->clearActivityLog()) {
            $this->flash('Activity log cleared successfully', 'success');
            $this->user->logActivity($_SESSION['username'], 'clear_activity_log', null, 'Activity log was cleared');
        } else {
            $this->flash('Failed to clear activity log', 'error');
        }
        
        $this->redirect('/admin/dashboard');
    }
    
    public function dashboard() {
        // Basic stats
        $stats = [
            'total_users' => $this->pdo->query("SELECT COUNT(*) FROM users")->fetchColumn(),
            'active_users' => count($this->user->getActiveUsers()),
            'total_lessons' => $this->pdo->query("SELECT COUNT(*) FROM lessons")->fetchColumn(),
            'completed_lessons' => $this->pdo->query("SELECT COUNT(*) FROM progress WHERE completed = 1")->fetchColumn()
        ];
        
        // Additional statistics
        $stats['admin_users'] = $this->pdo->query("SELECT COUNT(*) FROM users WHERE is_admin = 1")->fetchColumn();
        $stats['coach_users'] = $this->pdo->query("SELECT COUNT(*) FROM users WHERE is_coach = 1")->fetchColumn();
        $stats['student_users'] = $stats['total_users'] - $stats['admin_users'] - $stats['coach_users'];
        
        // Get completion rate
        if ($stats['total_users'] > 0) {
            $completionData = $this->pdo->query("
                SELECT 
                    COUNT(DISTINCT user_id) as users_with_completions
                FROM progress 
                WHERE completed = 1
            ")->fetch();
            $stats['users_with_completions'] = $completionData['users_with_completions'];
            $stats['completion_rate'] = round(($stats['users_with_completions'] / $stats['total_users']) * 100);
        } else {
            $stats['users_with_completions'] = 0;
            $stats['completion_rate'] = 0;
        }
        
        // Get recent activity counts
        $stats['logins_today'] = $this->pdo->query("
            SELECT COUNT(*) FROM users 
            WHERE last_login >= CURDATE()
        ")->fetchColumn();
        
        // Get system uptime and database size
        $stats['database_size'] = $this->pdo->query("
            SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) as size_mb
            FROM information_schema.TABLES 
            WHERE table_schema = DATABASE()
        ")->fetchColumn();
        
        // Get last system update time (based on settings table)
        $lastUpdateData = $this->pdo->query("
            SELECT MAX(updated_at) as last_update
            FROM settings
        ")->fetch();
        $stats['last_update'] = $lastUpdateData['last_update'];
        
        // Get completed lessons
        $completedLessons = $this->pdo->query("
            SELECT 
                u.username, 
                l.title, 
                p.completed_at as activity_date,
                'completed_lesson' as activity_type
            FROM progress p 
            JOIN users u ON p.user_id = u.id 
            JOIN lessons l ON p.lesson_id = l.id 
            WHERE p.completed = 1 AND p.chapter_id != 'user_deleted'
            ORDER BY p.completed_at DESC 
            LIMIT 10
        ")->fetchAll();
        
        // Get recently added users
        $newUsers = $this->pdo->query("
            SELECT 
                username, 
                'New User Registration' as title,
                created_at as activity_date,
                'new_user' as activity_type
            FROM users 
            ORDER BY created_at DESC 
            LIMIT 10
        ")->fetchAll();
        
        // Get user deletions
        $deletedUsers = [];
        try {
            error_log("Attempting to retrieve user deletion records");
            
            // First, check if there are any deletion records in the settings table
            $countQuery = $this->pdo->query("SELECT COUNT(*) FROM settings WHERE setting_key LIKE 'deleted_user_%'")->fetchColumn();
            error_log("Found $countQuery deletion records in settings table");
            
            // Get the deletion records
            $deletedUsersData = $this->pdo->query("
                SELECT 
                    setting_key,
                    setting_value
                FROM settings 
                WHERE setting_key LIKE 'deleted_user_%'
                ORDER BY updated_at DESC 
                LIMIT 10
            ")->fetchAll();
            
            error_log("Retrieved " . count($deletedUsersData) . " deletion records from database");
            
            foreach ($deletedUsersData as $data) {
                error_log("Processing deletion record: " . $data['setting_key']);
                $info = json_decode($data['setting_value'], true);
                if ($info) {
                    error_log("Valid deletion record found: " . json_encode($info));
                    $deletedUsers[] = [
                        'username' => $info['deleted_by'],
                        'title' => 'Deleted user: ' . $info['deleted_username'],
                        'activity_date' => $info['deleted_at'],
                        'activity_type' => 'user_deleted'
                    ];
                } else {
                    error_log("Invalid deletion record format: " . $data['setting_value']);
                }
            }
            
            error_log("Added " . count($deletedUsers) . " deletion records to recent activity");
        } catch (Exception $e) {
            error_log("Error retrieving deleted users: " . $e->getMessage());
        }
        
        // Use the ActivityLogger to get recent activity
        $activityLogger = new ActivityLogger();
        $recentActivity = $activityLogger->getRecentActivity(10);
        
        // If the activity log is empty, use the old method to populate it
        if (empty($recentActivity)) {
            // Combine and sort by date
            $recentActivity = array_merge($completedLessons, $newUsers, $deletedUsers);
            usort($recentActivity, function($a, $b) {
                return strtotime($b['activity_date']) - strtotime($a['activity_date']);
            });
            
            // Limit to 10 most recent activities
            $recentActivity = array_slice($recentActivity, 0, 10);
            
            // Log these activities to populate the activity log table
            foreach ($recentActivity as $activity) {
                $activityLogger->log(
                    $activity['username'],
                    null,
                    $activity['activity_type'],
                    $activity['title'] ?? null
                );
            }
            
            // Get the properly formatted activities from the logger
            $recentActivity = $activityLogger->getRecentActivity(10);
        }
        
        return $this->view('admin/dashboard', [
            'stats' => $stats,
            'recentActivity' => $recentActivity,
            'csrf_token' => $this->generateCsrfToken()
        ]);
    }
    
    public function users() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->checkCsrfToken();
            
            $action = $_POST['action'] ?? '';
            $userId = $_POST['user_id'] ?? '';
            
            switch ($action) {
                case 'create':
                    $this->createUser();
                    break;
                    
                case 'update':
                    $this->updateUser($userId);
                    break;
                    
                case 'delete':
                    $this->deleteUser($userId);
                    break;
            }
            
            $this->redirect('/admin/users');
        }
        
        return $this->view('admin/users', [
            'users' => $this->user->getAllUsers(),
            'coaches' => $this->user->getCoaches(),
            'csrf_token' => $this->generateCsrfToken()
        ]);
    }
    
    private function createUser() {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $isAdmin = isset($_POST['is_admin']) ? 1 : 0; // Convert to integer 1 or 0
        $isCoach = isset($_POST['is_coach']) ? 1 : 0; // Convert to integer 1 or 0
        $coachId = !empty($_POST['coach_id']) ? $_POST['coach_id'] : null;
        $sendWelcomeEmail = isset($_POST['send_welcome_email']);
        
        try {
            // Create the user
            $userId = $this->user->create($username, $email, $password, $isAdmin, $isCoach, $coachId);
            
            if ($userId) {
                // User created successfully
                $this->flash('User created successfully', 'success');
                
                // Log the user creation activity
                $activityLogger = new ActivityLogger();
                $activityLogger->log(
                    $_SESSION['username'], 
                    'new_user', 
                    $username, 
                    'Created new user: ' . $username
                );
                
                // Send welcome email if requested
                if ($sendWelcomeEmail) {
                    $this->sendWelcomeEmail($username, $email, $password);
                }
            } else {
                $this->flash('Error creating user', 'error');
            }
        } catch (Exception $e) {
            // Handle specific errors
            if (strpos($e->getMessage(), 'Email address is already in use') !== false) {
                $this->flash('Email address is already in use by another account', 'error');
            } else {
                $this->flash('Error creating user: ' . $e->getMessage(), 'error');
            }
        }
    }
    
    private function updateUser($userId) {
        $data = [
            'email' => $_POST['email'] ?? '',
            'is_admin' => isset($_POST['is_admin']) ? 1 : 0, // Convert to integer 1 or 0
            'is_coach' => isset($_POST['is_coach']) ? 1 : 0, // Convert to integer 1 or 0
        ];
        
        // Handle coach assignment
        if (!empty($_POST['coach_id'])) {
            $data['coach_id'] = $_POST['coach_id'];
        } else {
            $data['coach_id'] = null; // Remove coach assignment if not selected
        }
        
        if (!empty($_POST['password'])) {
            $data['password'] = $_POST['password'];
        }
        
        try {
            if ($this->user->update($userId, $data)) {
                $this->flash('User updated successfully', 'success');
            } else {
                $this->flash('Error updating user', 'error');
            }
        } catch (Exception $e) {
            // Handle specific errors
            if (strpos($e->getMessage(), 'Email address is already in use') !== false) {
                $this->flash('Email address is already in use by another account', 'error');
            } else {
                $this->flash('Error updating user: ' . $e->getMessage(), 'error');
            }
        }
    }
    
    private function deleteUser($userId) {
        if ($userId != $_SESSION['user_id']) {
            // Get user info before deletion
            $stmt = $this->pdo->prepare("SELECT username FROM users WHERE id = ?");
            $stmt->execute([$userId]);
            $user = $stmt->fetch();
            
            if (!$user) {
                $this->flash('User not found', 'error');
                error_log("User deletion failed: User ID $userId not found");
                return;
            }
            
            $deletedUsername = $user['username'];
            error_log("Attempting to delete user: $deletedUsername (ID: $userId)");
            
            // Delete the user
            if ($this->user->delete($userId)) {
                // Store the deleted username in a special table entry
                try {
                    $key = 'deleted_user_' . time(); // Unique key with timestamp
                    
                    // Get the current timestamp from the database to match new user format
                    $currentTime = $this->pdo->query("SELECT NOW() as timestamp")->fetch();
                    $timestamp = $currentTime['timestamp'];
                    
                    $value = json_encode([
                        'deleted_by' => $_SESSION['username'],
                        'deleted_username' => $deletedUsername,
                        'deleted_at' => $timestamp
                    ]);
                    
                    error_log("Storing deletion record with key: $key");
                    error_log("Deletion data: " . $value);
                    
                    $stmt = $this->pdo->prepare("
                        INSERT INTO settings (setting_key, setting_value)
                        VALUES (?, ?)
                    ");
                    $result = $stmt->execute([$key, $value]);
                    
                    // Log the user deletion activity
                    $activityLogger = new ActivityLogger();
                    $activityLogger->log(
                        $_SESSION['username'],
                        'user_deleted',
                        $deletedUsername,
                        'Deleted user: ' . $deletedUsername
                    );
                    
                    if ($result) {
                        error_log("Deletion record stored successfully");
                    } else {
                        error_log("Failed to store deletion record in settings table");
                    }
                    
                    $this->flash('User deleted successfully', 'success');
                } catch (Exception $e) {
                    error_log("Error storing deletion record: " . $e->getMessage());
                    $this->flash('User deleted but failed to log the action', 'warning');
                }
            } else {
                error_log("Failed to delete user: $deletedUsername (ID: $userId)");
                $this->flash('Error deleting user', 'error');
            }
        } else {
            error_log("Attempted to delete own account: {$_SESSION['user_id']}");
            $this->flash('Cannot delete your own account', 'error');
        }
    }
    
    public function lessons() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->checkCsrfToken();
            
            $action = $_POST['action'] ?? '';
            $lessonId = $_POST['lesson_id'] ?? '';
            
            switch ($action) {
                case 'toggle':
                    if ($this->lesson->toggleActive($lessonId)) {
                        $this->flash('Lesson status updated', 'success');
                    } else {
                        $this->flash('Error updating lesson status', 'error');
                    }
                    break;
                    
                case 'delete':
                    if ($this->lesson->delete($lessonId)) {
                        $this->flash('Lesson deleted successfully', 'success');
                    } else {
                        $this->flash('Error deleting lesson', 'error');
                    }
                    break;
                
                case 'update':
                    $lessonData = [
                        'title' => $_POST['title'] ?? '',
                        'description' => $_POST['description'] ?? '',
                        'author' => $_POST['author'] ?? '',
                        'version' => $_POST['version'] ?? '1.0'
                    ];
                    
                    if ($this->lesson->update($lessonId, $lessonData)) {
                        $this->flash('Lesson updated successfully', 'success');
                    } else {
                        $this->flash('Error updating lesson', 'error');
                    }
                    break;
                    
                case 'scan':
                    $result = $this->scanLessons();
                    if ($result['success']) {
                        $this->flash($result['message'], 'success');
                    } else {
                        // Store detailed error information in session for display
                        $_SESSION['scan_errors'] = $result['errors'] ?? [];
                        $this->flash($result['message'], 'error');
                    }
                    break;
            }
            
            $this->redirect('/admin/lessons');
        }
        
        return $this->view('admin/lessons', [
            'lessons' => $this->lesson->getAllLessons(),
            'csrf_token' => $this->generateCsrfToken()
        ]);
    }
    
    /**
     * Scan the lessons directory for new lessons and register them in the database
     * 
     * @return array Result with success status and message
     */
    private function scanLessons() {
        try {
            $lessonsPath = LESSONS_PATH;
            $result = [
                'success' => true,
                'message' => 'Lesson scan completed. ',
                'added' => 0,
                'updated' => 0,
                'errors' => []
            ];
            
            // Check if lessons directory exists
            if (!is_dir($lessonsPath)) {
                return [
                    'success' => false,
                    'message' => 'Lessons directory not found: ' . $lessonsPath
                ];
            }
            
            // Get all lesson directories
            $lessonDirs = array_filter(glob($lessonsPath . '/*'), 'is_dir');
            
            // Get existing lessons from database
            $existingLessons = [];
            $stmt = $this->pdo->query('SELECT id, filename FROM lessons');
            while ($row = $stmt->fetch()) {
                $existingLessons[$row['filename']] = $row['id'];
            }
            
            foreach ($lessonDirs as $lessonDir) {
                try {
                    $lessonDirName = basename($lessonDir);
                    
                    // Skip hidden directories
                    if (substr($lessonDirName, 0, 1) === '.') {
                        continue;
                    }
                    
                    error_log("Processing lesson directory: $lessonDirName");
                    
                    // Check if this lesson already exists in the database
                    $lessonExists = isset($existingLessons[$lessonDirName]);
                    $lessonId = $lessonExists ? $existingLessons[$lessonDirName] : null;
                    
                    // Get all PHP files in the lesson directory (excluding quiz files and final test)
                    $lessonFiles = array_filter(glob($lessonDir . '/*.php'), function($file) {
                        return strpos($file, '_quiz.php') === false && strpos($file, 'final_test.php') === false;
                    });
                    
                    error_log("Found " . count($lessonFiles) . " lesson files in $lessonDirName");
                    
                    // Skip if no lesson files found
                    if (empty($lessonFiles)) {
                        $result['errors'][] = "No lesson files found in $lessonDirName";
                        continue;
                    }
                    
                    // Get the introduction file if it exists, otherwise use the first file
                    $introFile = null;
                    foreach ($lessonFiles as $file) {
                        if (strpos($file, 'introduction.php') !== false) {
                            $introFile = $file;
                            break;
                        }
                    }
                    
                    if (!$introFile && !empty($lessonFiles)) {
                        $introFile = reset($lessonFiles); // Use first file with reset() instead of array index
                    }
                    
                    // Extract lesson title from the first heading in the introduction file
                    $title = $lessonDirName; // Default title
                    if ($introFile && file_exists($introFile)) {
                        $content = file_get_contents($introFile);
                        if (preg_match('/<h[1-2][^>]*>(.*?)<\/h[1-2]>/i', $content, $matches)) {
                            $title = strip_tags($matches[1]);
                        }
                    }
                    
                    error_log("Lesson title: $title");
                    
                    // Get all chapter files (excluding introduction, quiz files, and final test)
                    $chapterFiles = array_filter($lessonFiles, function($file) {
                        return strpos($file, 'introduction.php') === false && 
                               strpos($file, '_quiz.php') === false && 
                               strpos($file, 'final_test.php') === false;
                    });
                    
                    error_log("Found " . count($chapterFiles) . " chapter files in $lessonDirName");
                    
                    // Prepare chapter data
                    $chapters = [];
                    $sequence = 1;
                    
                    // Add introduction as first chapter if it exists
                    if ($introFile) {
                        $introId = pathinfo(basename($introFile), PATHINFO_FILENAME);
                        $chapters[] = [
                            'id' => $introId,
                            'title' => 'Introduction',
                            'sequence' => $sequence++
                        ];
                        error_log("Added introduction chapter: $introId");
                    }
                    
                    // Add remaining chapters
                    foreach ($chapterFiles as $chapterFile) {
                        $chapterId = pathinfo(basename($chapterFile), PATHINFO_FILENAME);
                        
                        // Extract chapter title from the first heading
                        $chapterTitle = $chapterId; // Default title
                        $content = file_get_contents($chapterFile);
                        if (preg_match('/<h[1-3][^>]*>(.*?)<\/h[1-3]>/i', $content, $matches)) {
                            $chapterTitle = strip_tags($matches[1]);
                        }
                        
                        $chapters[] = [
                            'id' => $chapterId,
                            'title' => $chapterTitle,
                            'sequence' => $sequence++
                        ];
                        error_log("Added chapter: $chapterId - $chapterTitle");
                    }
                    
                    // Skip if no chapters found
                    if (empty($chapters)) {
                        $result['errors'][] = "No valid chapters found in $lessonDirName";
                        continue;
                    }
                    
                    // Format the lesson title properly if it's using the directory name
                    if ($title === $lessonDirName) {
                        $title = $this->formatLessonTitle($lessonDirName);
                    }
                    
                    // Prepare lesson data
                    $lessonData = [
                        'filename' => $lessonDirName,
                        'title' => $title,
                        'description' => 'Automatically discovered lesson',
                        'author' => 'System',
                        'version' => '1.0',
                        'language' => 'en',
                        'chapters' => $chapters
                    ];
                    
                    // Create or update the lesson in the database
                    if ($lessonExists) {
                        if ($this->lesson->update($lessonId, $lessonData)) {
                            $result['updated']++;
                            error_log("Updated lesson: $lessonDirName (ID: $lessonId)");
                        } else {
                            $result['errors'][] = "Failed to update lesson: $lessonDirName";
                            error_log("Failed to update lesson: $lessonDirName");
                        }
                    } else {
                        $newLessonId = $this->lesson->create($lessonData);
                        if ($newLessonId) {
                            $result['added']++;
                            error_log("Added new lesson: $lessonDirName (ID: $newLessonId)");
                        } else {
                            $result['errors'][] = "Failed to create lesson: $lessonDirName";
                            error_log("Failed to create lesson: $lessonDirName");
                        }
                    }
                } catch (Exception $innerException) {
                    $errorMessage = "Error processing lesson directory {$lessonDirName}: {$innerException->getMessage()}";
                    $result['errors'][] = $errorMessage;
                    error_log($errorMessage);
                }
            }
            
            // Update the result message
            $result['message'] .= "Added {$result['added']} new lessons. Updated {$result['updated']} existing lessons.";
            if (!empty($result['errors'])) {
                $errorDetails = implode(", ", $result['errors']);
                $result['message'] .= " Encountered " . count($result['errors']) . " errors: $errorDetails";
                $result['success'] = false;
            }
            
            return $result;
        } catch (Exception $e) {
            $errorMessage = "Error scanning lessons: {$e->getMessage()}";
            error_log($errorMessage);
            return [
                'success' => false,
                'message' => $errorMessage
            ];
        }
    }
    
    /**
     * Format a lesson directory name into a properly formatted title
     * 
     * @param string $dirName The directory name to format
     * @return string The formatted title
     */
    private function formatLessonTitle($dirName) {
        // Replace underscores with spaces
        $title = str_replace('_', ' ', $dirName);
        
        // Capitalize each word
        $title = ucwords($title);
        
        // Handle common acronyms
        $acronyms = ['Dns' => 'DNS', 'Sql' => 'SQL', 'Php' => 'PHP', 'Html' => 'HTML', 'Css' => 'CSS', 'Ftp' => 'FTP'];
        foreach ($acronyms as $word => $acronym) {
            $title = str_replace($word, $acronym, $title);
        }
        
        return $title;
    }
    
    public function settings() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->checkCsrfToken();
            
            // Basic settings
            $settings = [
                'max_users' => $_POST['max_users'] ?? '100'
            ];
            
            // Handle IP ranges - convert from comma-separated to JSON array
            $ipRanges = $_POST['allowed_ip_ranges'] ?? '*';
            $ipRangesArray = array_map('trim', explode(',', $ipRanges));
            $settings['allowed_ip_ranges'] = json_encode($ipRangesArray);
            
            // Database settings
            if (isset($_POST['db_host'])) {
                $settings['db_host'] = $_POST['db_host'];
                $settings['db_port'] = $_POST['db_port'] ?? '3306';
                $settings['db_name'] = $_POST['db_name'] ?? '';
                $settings['db_username'] = $_POST['db_username'] ?? '';
                $settings['db_password'] = $_POST['db_password'] ?? '';
            }
            
            // Email settings
            $settings['smtp_host'] = $_POST['smtp_host'] ?? '';
            $settings['smtp_port'] = $_POST['smtp_port'] ?? '587';
            $settings['smtp_encryption'] = $_POST['smtp_encryption'] ?? 'tls';
            $settings['smtp_auth_enabled'] = isset($_POST['smtp_auth_enabled']) ? '1' : '0';
            $settings['smtp_verify_ssl'] = isset($_POST['smtp_verify_ssl']) ? '1' : '0';
            $settings['smtp_from_email'] = $_POST['smtp_from_email'] ?? '';
            $settings['smtp_from_name'] = $_POST['smtp_from_name'] ?? 'CT Blox System';
            
            // Only save username/password if auth is enabled
            if (isset($_POST['smtp_auth_enabled'])) {
                $settings['smtp_username'] = $_POST['smtp_username'] ?? '';
                $settings['smtp_password'] = $_POST['smtp_password'] ?? '';
            }
            
            // Certificate settings
            if (isset($_POST['certificate_template'])) {
                $settings['certificate_template'] = $_POST['certificate_template'];
            }
            
            try {
                foreach ($settings as $key => $value) {
                    $stmt = $this->pdo->prepare("
                        INSERT INTO settings (setting_key, setting_value) 
                        VALUES (?, ?) 
                        ON DUPLICATE KEY UPDATE setting_value = ?
                    ");
                    $stmt->execute([$key, $value, $value]);
                }
                $this->flash('Settings updated successfully', 'success');
            } catch (PDOException $e) {
                $this->flash('Error updating settings', 'error');
                error_log("Error updating settings: " . $e->getMessage());
            }
            
            $this->redirect('/admin/settings');
        }
        
        // Get current settings
        $settings = [];
        $stmt = $this->pdo->query("SELECT setting_key, setting_value FROM settings");
        while ($row = $stmt->fetch()) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        
        // Get system status information for the System Info section
        $systemInfo = [
            'php_version' => phpversion(),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'database_version' => $this->getDatabaseVersion(),
            'operating_system' => php_uname('s') . ' ' . php_uname('r'),
            'max_upload_size' => ini_get('upload_max_filesize'),
            'max_post_size' => ini_get('post_max_size'),
            'memory_limit' => ini_get('memory_limit'),
            'max_execution_time' => ini_get('max_execution_time') . ' seconds',
        ];
        
        return $this->view('admin/settings', [
            'settings' => $settings,
            'systemInfo' => $systemInfo,
            'csrf_token' => $this->generateCsrfToken()
        ]);
    }
    
    /**
     * Get the database version
     * 
     * @return string The database version
     */
    private function getDatabaseVersion() {
        try {
            $stmt = $this->pdo->query("SELECT VERSION() as version");
            $result = $stmt->fetch();
            return $result['version'] ?? 'Unknown';
        } catch (PDOException $e) {
            error_log("Error getting database version: " . $e->getMessage());
            return 'Unknown';
        }
    }
    

    

    

    

    

    

    

    
    public function testEmail() {
        // Accept both AJAX and direct API calls
        header('Content-Type: application/json');
        
        // Get email settings from POST data
        $smtpHost = $_POST['smtp_host'] ?? '';
        $smtpPort = $_POST['smtp_port'] ?? '587';
        $smtpEncryption = $_POST['smtp_encryption'] ?? 'tls';
        $smtpAuthEnabled = isset($_POST['smtp_auth_enabled']) && $_POST['smtp_auth_enabled'] === '1';
        $smtpVerifySsl = isset($_POST['smtp_verify_ssl']) && $_POST['smtp_verify_ssl'] === '1';
        $smtpFromEmail = $_POST['smtp_from_email'] ?? 'noreply@example.com';
        $smtpFromName = $_POST['smtp_from_name'] ?? 'CT Blox System';
        
        // Auth credentials only used if auth is enabled
        $smtpUser = $smtpAuthEnabled ? ($_POST['smtp_username'] ?? '') : '';
        $smtpPass = $smtpAuthEnabled ? ($_POST['smtp_password'] ?? '') : '';
        
        // Recipient email - use logged in user's email or admin email
        $recipientEmail = $_SESSION['email'] ?? 'admin@example.com';
        
        try {
            // Create the Transport
            $transport = new Swift_SmtpTransport($smtpHost, $smtpPort);
            
            // Set encryption if not 'none'
            if ($smtpEncryption !== 'none') {
                $transport->setEncryption($smtpEncryption);
            }
            
            // Set auth credentials if auth is enabled
            if ($smtpAuthEnabled) {
                $transport->setUsername($smtpUser);
                $transport->setPassword($smtpPass);
            }
            
            // Set SSL verification option
            if (!$smtpVerifySsl) {
                $transport->setStreamOptions(['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]]);
            }
            
            // Create the Mailer using your created Transport
            $mailer = new Swift_Mailer($transport);
            
            // Create a message
            $message = new Swift_Message('CTBlox Test Email');
            $message->setFrom([$smtpFromEmail => $smtpFromName]);
            $message->setTo([$recipientEmail]);
            $message->setBody(
                '<html>' .                
                '<head>' .                
                '<title>Email Test</title>' .                
                '</head>' .                
                '<body>' .                
                '<h1>Test Email</h1>' .                
                '<p>This is a test email from the CT Blox Training Platform.</p>' .                
                '<p>If you received this email, your email settings are configured correctly.</p>' .                
                '<p>Time sent: ' . date('Y-m-d H:i:s') . '</p>' .                
                '</body>' .                
                '</html>',                
                'text/html'
            );
            
            // Send the message
            $result = $mailer->send($message);
            
            echo json_encode([
                'success' => true,
                'message' => 'Test email sent successfully to ' . $recipientEmail
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
        
        exit; // Stop execution after sending JSON response
    }
}
