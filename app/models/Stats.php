<?php
/**
 * Stats Model
 * 
 * Handles all operations related to application statistics
 */
class Stats {
    private $pdo;
    private static $instance = null;
    
    /**
     * Constructor
     */
    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }
    
    /**
     * Get singleton instance
     * 
     * @return Stats
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Get user statistics
     * 
     * @return array User statistics
     */
    /**
     * Update the last system update time
     */
    private function updateLastUpdateTime() {
        try {
            $settingsModel = Settings::getInstance();
            $settingsModel->set('last_system_update', date('Y-m-d H:i:s'));
        } catch (Exception $e) {
            error_log("Error updating last system update time: " . $e->getMessage());
        }
    }

    public function getUserStats() {
        try {
            $stats = [
                'total_users' => $this->pdo->query("SELECT COUNT(*) FROM users")->fetchColumn(),
                'admin_users' => $this->pdo->query("SELECT COUNT(*) FROM users WHERE is_admin = 1")->fetchColumn(),
                'coach_users' => $this->pdo->query("SELECT COUNT(*) FROM users WHERE is_coach = 1")->fetchColumn(),
            ];
            
            // Calculate student users
            $stats['student_users'] = $stats['total_users'] - $stats['admin_users'] - $stats['coach_users'];
            
            // Get active users (users who have logged in within the last 30 days)
            $stmt = $this->pdo->prepare("
                SELECT COUNT(*) FROM users 
                WHERE last_login >= DATE_SUB(NOW(), INTERVAL 30 DAY)
            ");
            $stmt->execute();
            $stats['active_users'] = $stmt->fetchColumn();
            
            // Get users with completed lessons
            $completionData = $this->pdo->query("
                SELECT COUNT(DISTINCT user_id) as users_with_completions
                FROM progress 
                WHERE completed = 1
            ")->fetch();
            $stats['users_with_completions'] = $completionData['users_with_completions'];
            
            // Calculate completion rate
            if ($stats['total_users'] > 0) {
                $stats['completion_rate'] = round(($stats['users_with_completions'] / $stats['total_users']) * 100);
            } else {
                $stats['completion_rate'] = 0;
            }
            
            // Update last system update time
            $this->updateLastUpdateTime();
            
            return $stats;
        } catch (PDOException $e) {
            error_log("Error getting user stats: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get lesson statistics
     * 
     * @return array Lesson statistics
     */
    public function getLessonStats() {
        try {
            $stats = [];
            
            // Count lessons by scanning the lessons directory
            $lessonsPath = __DIR__ . '/../lessons';
            $lessonDirs = array_filter(glob($lessonsPath . '/*'), 'is_dir');
            $stats['total_lessons'] = count($lessonDirs);
            
            // Count total chapters across all lessons
            $totalChapters = 0;
            foreach ($lessonDirs as $lessonDir) {
                $chapterFiles = glob($lessonDir . '/*.php');
                $totalChapters += count($chapterFiles);
            }
            
            // Get completed lessons from the progress table
            $stmt = $this->pdo->query("
                SELECT COUNT(DISTINCT lesson_id) FROM progress 
                WHERE completed = 1
            ");
            $stats['completed_lessons'] = $stmt->fetchColumn() ?: 0;
            
            // Add total chapters to stats
            $stats['total_chapters'] = $totalChapters;
            
            return $stats;
        } catch (PDOException $e) {
            error_log("Error getting lesson stats: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get quiz statistics
     * 
     * @return array Quiz statistics
     */
    public function getQuizStats() {
        try {
            $stats = [
                'total_quizzes' => $this->pdo->query("SELECT COUNT(*) FROM quiz_results")->fetchColumn(),
            ];
            
            // Get average quiz score
            $stmt = $this->pdo->query("
                SELECT AVG(score) as avg_score
                FROM quiz_results
            ");
            $avgScore = $stmt->fetchColumn();
            $stats['avg_score'] = $avgScore ? round($avgScore, 1) : 0;
            
            // Get pass rate
            $stmt = $this->pdo->query("
                SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN score >= 70 THEN 1 ELSE 0 END) as passed
                FROM quiz_results
            ");
            $quizData = $stmt->fetch();
            
            if ($quizData['total'] > 0) {
                $stats['pass_rate'] = round(($quizData['passed'] / $quizData['total']) * 100);
            } else {
                $stats['pass_rate'] = 0;
            }
            
            return $stats;
        } catch (PDOException $e) {
            error_log("Error getting quiz stats: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get dashboard statistics for a specific user
     * 
     * @param int $userId User ID
     * @return array User dashboard statistics
     */
    public function getUserDashboardStats($userId) {
        try {
            // Get assigned lessons
            $stmt = $this->pdo->prepare("
                SELECT COUNT(*) FROM lesson_assignments
                WHERE user_id = ?
            ");
            $stmt->execute([$userId]);
            $stats['assigned_lessons'] = $stmt->fetchColumn();
            
            // Get completed lessons
            $stmt = $this->pdo->prepare("
                SELECT 
                    COUNT(DISTINCT l.id) as total_lessons,
                    SUM(CASE WHEN (
                        SELECT COUNT(*) FROM chapters c WHERE c.lesson_id = l.id
                    ) = (
                        SELECT COUNT(*) FROM progress p 
                        WHERE p.lesson_id = l.id AND p.user_id = ? AND p.completed = 1
                    ) THEN 1 ELSE 0 END) as completed_lessons
                FROM lessons l
                JOIN lesson_assignments la ON l.id = la.lesson_id
                WHERE la.user_id = ?
            ");
            $stmt->execute([$userId, $userId]);
            $lessonData = $stmt->fetch();
            
            $stats['total_assigned_lessons'] = $lessonData['total_lessons'];
            $stats['total_completed_lessons'] = $lessonData['completed_lessons'];
            
            // Calculate lesson completion percentage
            if ($stats['total_assigned_lessons'] > 0) {
                $stats['lesson_completion_percentage'] = round(($stats['total_completed_lessons'] / $stats['total_assigned_lessons']) * 100);
            } else {
                $stats['lesson_completion_percentage'] = 0;
            }
            
            // Get total and completed chapters
            $stmt = $this->pdo->prepare("
                SELECT 
                    COUNT(DISTINCT c.chapter_id) as total_chapters,
                    COUNT(DISTINCT CASE WHEN p.completed = 1 THEN p.chapter_id END) as completed_chapters
                FROM chapters c
                JOIN lessons l ON c.lesson_id = l.id
                JOIN lesson_assignments la ON l.id = la.lesson_id AND la.user_id = ?
                LEFT JOIN progress p ON c.lesson_id = p.lesson_id AND c.chapter_id = p.chapter_id AND p.user_id = ?
            ");
            $stmt->execute([$userId, $userId]);
            $chapterData = $stmt->fetch();
            
            $stats['total_assigned_chapters'] = $chapterData['total_chapters'];
            $stats['total_completed_chapters'] = $chapterData['completed_chapters'];
            
            // Calculate chapter completion percentage
            if ($stats['total_assigned_chapters'] > 0) {
                $stats['chapter_completion_percentage'] = round(($stats['total_completed_chapters'] / $stats['total_assigned_chapters']) * 100);
            } else {
                $stats['chapter_completion_percentage'] = 0;
            }
            
            // Get quizzes taken
            $stmt = $this->pdo->prepare("
                SELECT COUNT(*) as quizzes_taken
                FROM quiz_results
                WHERE user_id = ?
            ");
            $stmt->execute([$userId]);
            $stats['total_quizzes_taken'] = $stmt->fetchColumn();
            
            // Get average quiz score
            $stmt = $this->pdo->prepare("
                SELECT AVG(score) as average_score
                FROM quiz_results
                WHERE user_id = ?
            ");
            $stmt->execute([$userId]);
            $avgScore = $stmt->fetchColumn();
            $stats['average_quiz_score'] = $avgScore ? round($avgScore) : 0;
            
            // Get last activity date
            $stmt = $this->pdo->prepare("
                SELECT MAX(created_at) as last_activity
                FROM activity_log
                WHERE user_id = ?
            ");
            $stmt->execute([$userId]);
            $stats['last_activity_date'] = $stmt->fetchColumn();
            
            return $stats;
        } catch (PDOException $e) {
            error_log("Error getting user dashboard stats: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get activity statistics
     * 
     * @param int $days Number of days to look back
     * @return array Activity statistics
     */
    public function getActivityStats($days = 30) {
        try {
            // Get login activity
            $stmt = $this->pdo->prepare("
                SELECT 
                    COUNT(*) as total_logins,
                    COUNT(DISTINCT username) as unique_users
                FROM activity_log
                WHERE activity_type = 'login'
                AND created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
            ");
            $stmt->execute([$days]);
            $loginData = $stmt->fetch();
            
            $stats['total_logins'] = $loginData['total_logins'];
            $stats['unique_users'] = $loginData['unique_users'];
            
            // Get chapter completion activity
            $stmt = $this->pdo->prepare("
                SELECT COUNT(*) as completed_chapters
                FROM progress
                WHERE completed = 1
                AND completed_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
            ");
            $stmt->execute([$days]);
            $stats['completed_chapters'] = $stmt->fetchColumn();
            
            // Get quiz activity
            $stmt = $this->pdo->prepare("
                SELECT COUNT(*) as total_quizzes
                FROM quiz_results
                WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
            ");
            $stmt->execute([$days]);
            $stats['total_quizzes'] = $stmt->fetchColumn();
            
            return $stats;
        } catch (PDOException $e) {
            error_log("Error getting activity stats: " . $e->getMessage());
            return [];
        }
    }
}
