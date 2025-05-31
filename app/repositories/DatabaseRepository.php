<?php
require_once __DIR__ . '/../classes/ErrorHandler.php';

/**
 * DatabaseRepository
 * 
 * Centralizes common database operations to reduce query repetition across controllers
 */
class DatabaseRepository {
    protected $pdo;
    
    /**
     * Constructor
     */
    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }
    
    /**
     * Get user progress for a specific lesson or all lessons
     * 
     * @param int $userId User ID
     * @param int|null $lessonId Lesson ID (null for all lessons)
     * @return array Progress data
     */
    public function getUserProgress($userId, $lessonId = null) {
        try {
            $params = [$userId];
            $lessonCondition = '';
            
            if ($lessonId !== null) {
                $lessonCondition = 'AND p.lesson_id = ?';
                $params[] = $lessonId;
            }
            
            $stmt = $this->pdo->prepare("
                SELECT 
                    p.lesson_id,
                    l.title,
                    p.chapter_id,
                    p.completed,
                    p.completed_at,
                    COALESCE(qr.score, 0) as quiz_score
                FROM progress p
                JOIN lessons l ON p.lesson_id = l.id
                LEFT JOIN quiz_results qr ON p.user_id = qr.user_id 
                    AND p.lesson_id = qr.lesson_id 
                    AND p.chapter_id = qr.chapter_id
                WHERE p.user_id = ? {$lessonCondition}
                ORDER BY l.title, p.chapter_id
            ");
            
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            ErrorHandler::logDatabaseError($e, "getUserProgress query");
            return [];
        }
    }
    
    /**
     * Get lesson completion statistics for a user
     * 
     * @param int $userId User ID
     * @return array Completion statistics
     */
    public function getUserLessonCompletionStats($userId) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT 
                    l.id as lesson_id,
                    l.title,
                    COUNT(DISTINCT c.chapter_id) as total_chapters,
                    COUNT(DISTINCT CASE WHEN p.completed = 1 THEN p.chapter_id END) as completed_chapters,
                    ROUND((COUNT(DISTINCT CASE WHEN p.completed = 1 THEN p.chapter_id END) / COUNT(DISTINCT c.chapter_id)) * 100) as completion_percentage,
                    MAX(p.completed_at) as last_activity
                FROM lessons l
                JOIN lesson_assignments la ON l.id = la.lesson_id AND la.user_id = ?
                LEFT JOIN chapters c ON l.id = c.lesson_id
                LEFT JOIN progress p ON l.id = p.lesson_id AND p.user_id = ? AND p.chapter_id = c.chapter_id
                WHERE l.active = 1
                GROUP BY l.id
                ORDER BY l.title
            ");
            
            $stmt->execute([$userId, $userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            ErrorHandler::logDatabaseError($e, "getUserLessonCompletionStats query");
            return [];
        }
    }
    
    /**
     * Get overall progress summary for a user
     * 
     * @param int $userId User ID
     * @return array Progress summary
     */
    public function getUserOverallProgress($userId) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT 
                    COUNT(DISTINCT c.id) as total_chapters,
                    COUNT(DISTINCT CASE WHEN p.completed = 1 THEN p.chapter_id END) as completed_chapters,
                    COUNT(DISTINCT l.id) as total_lessons,
                    COUNT(DISTINCT CASE WHEN 
                        (SELECT COUNT(DISTINCT c2.chapter_id) 
                         FROM chapters c2 
                         WHERE c2.lesson_id = l.id) = 
                        (SELECT COUNT(DISTINCT p2.chapter_id) 
                         FROM progress p2 
                         WHERE p2.lesson_id = l.id AND p2.user_id = ? AND p2.completed = 1)
                        AND (SELECT COUNT(DISTINCT c2.chapter_id) FROM chapters c2 WHERE c2.lesson_id = l.id) > 0
                    THEN l.id END) as completed_lessons
                FROM lessons l
                JOIN lesson_assignments la ON l.id = la.lesson_id AND la.user_id = ?
                LEFT JOIN chapters c ON l.id = c.lesson_id
                LEFT JOIN progress p ON l.id = p.lesson_id AND p.user_id = ? AND p.chapter_id = c.chapter_id
                WHERE l.active = 1
            ");
            
            $stmt->execute([$userId, $userId, $userId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Calculate completion percentage
            $result['chapter_completion_percentage'] = $result['total_chapters'] > 0 
                ? round(($result['completed_chapters'] / $result['total_chapters']) * 100) 
                : 0;
                
            return $result;
        } catch (PDOException $e) {
            ErrorHandler::logDatabaseError($e, "getUserOverallProgress query");
            return [
                'total_chapters' => 0,
                'completed_chapters' => 0,
                'total_lessons' => 0,
                'completed_lessons' => 0,
                'chapter_completion_percentage' => 0
            ];
        }
    }
    
    /**
     * Get quiz results for a user
     * 
     * @param int $userId User ID
     * @param int|null $lessonId Lesson ID (null for all lessons)
     * @return array Quiz results
     */
    public function getUserQuizResults($userId, $lessonId = null) {
        try {
            $params = [$userId];
            $lessonCondition = '';
            
            if ($lessonId !== null) {
                $lessonCondition = 'AND qr.lesson_id = ?';
                $params[] = $lessonId;
            }
            
            $stmt = $this->pdo->prepare("
                SELECT 
                    qr.lesson_id,
                    l.title as lesson_title,
                    qr.chapter_id,
                    qr.score
                FROM quiz_results qr
                JOIN lessons l ON qr.lesson_id = l.id
                WHERE qr.user_id = ? {$lessonCondition}
                ORDER BY qr.id DESC
            ");
            
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            ErrorHandler::logDatabaseError($e, "getUserQuizResults query");
            return [];
        }
    }
    
    /**
     * Get assigned students for a coach
     * 
     * @param int $coachId Coach ID
     * @return array Student data
     */
    public function getCoachStudents($coachId) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT 
                    u.id, 
                    u.username, 
                    u.name, 
                    u.email, 
                    u.created_at,
                    u.last_login,
                    COUNT(DISTINCT la.lesson_id) as assigned_lessons,
                    COUNT(DISTINCT CASE WHEN p.completed = 1 THEN p.chapter_id END) as completed_chapters,
                    COUNT(DISTINCT c.id) as total_chapters,
                    ROUND(
                        CASE WHEN COUNT(DISTINCT c.id) > 0 
                        THEN (COUNT(DISTINCT CASE WHEN p.completed = 1 THEN p.chapter_id END) / COUNT(DISTINCT c.id)) * 100
                        ELSE 0 END
                    ) as completion_percentage
                FROM users u
                LEFT JOIN lesson_assignments la ON u.id = la.user_id
                LEFT JOIN chapters c ON la.lesson_id = c.lesson_id
                LEFT JOIN progress p ON u.id = p.user_id AND p.chapter_id = c.chapter_id AND p.completed = 1
                WHERE u.coach_id = ? AND u.is_admin = 0 AND u.is_coach = 0
                GROUP BY u.id
                ORDER BY u.name, u.username
            ");
            
            $stmt->execute([$coachId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            ErrorHandler::logDatabaseError($e, "getCoachStudents query");
            return [];
        }
    }
    
    /**
     * Get user by ID
     * 
     * @param int $userId User ID
     * @return array|false User data or false if not found
     */
    public function getUserById($userId) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT u.*, 
                       r.name as role_name,
                       (SELECT COUNT(*) FROM lesson_assignments la WHERE la.user_id = u.id) as assigned_lessons
                FROM users u
                LEFT JOIN roles r ON u.role_id = r.id
                WHERE u.id = ?
            ");
            $stmt->execute([$userId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            ErrorHandler::logDatabaseError($e, "getUserById query");
            return false;
        }
    }
    
    /**
     * Get available lessons for a user
     * 
     * @param int $userId User ID
     * @return array Available lessons
     */
    public function getUserAvailableLessons($userId) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT l.*, 
                       COUNT(DISTINCT c.chapter_id) as total_chapters,
                       COUNT(DISTINCT CASE WHEN p.completed = 1 THEN p.chapter_id END) as completed_chapters,
                       la.assigned_at,
                       (SELECT GROUP_CONCAT(DISTINCT c2.title SEPARATOR ', ') 
                        FROM chapters c2 
                        WHERE c2.lesson_id = l.id 
                        LIMIT 3) as chapter_titles,
                       (SELECT COUNT(*) FROM quiz_results qr WHERE qr.lesson_id = l.id AND qr.user_id = ?) as quizzes_taken
                FROM lessons l
                JOIN lesson_assignments la ON l.id = la.lesson_id AND la.user_id = ?
                LEFT JOIN chapters c ON l.id = c.lesson_id
                LEFT JOIN progress p ON l.id = p.lesson_id AND p.user_id = ? AND p.chapter_id = c.chapter_id
                WHERE l.active = 1
                GROUP BY l.id
                ORDER BY la.assigned_at DESC
            ");
            
            $stmt->execute([$userId, $userId, $userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            ErrorHandler::logDatabaseError($e, "getUserAvailableLessons query");
            return [];
        }
    }

    /**
     * Get all chapters for a specific lesson
     * 
     * @param int $lessonId Lesson ID
     * @return array Chapter data
     */
    public function getLessonChapters($lessonId) {
        try {
            $stmt = $this->pdo->prepare(
                "SELECT chapter_id, title, sequence FROM chapters WHERE lesson_id = ? ORDER BY sequence ASC"
            );
            $stmt->execute([$lessonId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            ErrorHandler::logDatabaseError($e, "getLessonChapters query");
            return [];
        }
    }
}
