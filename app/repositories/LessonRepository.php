<?php
/**
 * LessonRepository Class
 * 
 * Provides database operations specific to the Lesson model.
 * Extends the DatabaseRepository class for common database operations.
 */
class LessonRepository extends DatabaseRepository {
    /**
     * Constructor
     * 
     * @param PDO $pdo Optional PDO connection (uses global $pdo if not provided)
     */
    public function __construct($pdo = null) {
        parent::__construct('lessons', $pdo);
    }
    
    /**
     * Get all active lessons
     * 
     * @return array Active lessons
     */
    public function getActiveLessons() {
        return $this->findWhere(['active' => 1], ['*'], 'title ASC');
    }
    
    /**
     * Get a lesson by filename
     * 
     * @param string $filename Lesson filename
     * @return array|bool Lesson data if found, false otherwise
     */
    public function getByFilename($filename) {
        return $this->findBy('filename', $filename);
    }
    
    /**
     * Get lessons assigned to a user
     * 
     * @param int $userId User ID
     * @return array Assigned lessons
     */
    public function getAssignedLessons($userId) {
        try {
            $sql = "SELECT l.id, l.title, l.description, la.assigned_at, u.username as assigned_by
                    FROM lessons l
                    JOIN lesson_assignments la ON l.id = la.lesson_id
                    LEFT JOIN users u ON la.assigned_by = u.id
                    WHERE la.user_id = ? AND l.active = 1
                    ORDER BY la.assigned_at DESC";
                    
            return $this->query($sql, [$userId]);
        } catch (PDOException $e) {
            $this->logError("Error getting assigned lessons", $e);
            return [];
        }
    }
    
    /**
     * Check if a lesson is assigned to a user
     * 
     * @param int $userId User ID
     * @param int $lessonId Lesson ID
     * @return bool Whether the lesson is assigned to the user
     */
    public function isLessonAssigned($userId, $lessonId) {
        try {
            $sql = "SELECT COUNT(*) FROM lesson_assignments 
                    WHERE user_id = ? AND lesson_id = ?";
                    
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$userId, $lessonId]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            $this->logError("Error checking if lesson is assigned", $e);
            return false;
        }
    }
    
    /**
     * Assign a lesson to a user
     * 
     * @param int $userId User ID
     * @param int $lessonId Lesson ID
     * @param int $assignedBy User ID of the assigner
     * @return bool Whether the assignment was successful
     */
    public function assignLesson($userId, $lessonId, $assignedBy) {
        try {
            // Check if the lesson exists and is active
            $lesson = $this->find($lessonId);
            
            if (!$lesson || !$lesson['active']) {
                $this->logError("Cannot assign inactive or non-existent lesson (ID: {$lessonId})");
                return false;
            }
            
            // Check if the user exists
            $userRepo = new UserRepository($this->pdo);
            $user = $userRepo->find($userId);
            
            if (!$user) {
                $this->logError("Cannot assign lesson to non-existent user (ID: {$userId})");
                return false;
            }
            
            // Check if the lesson is already assigned
            if ($this->isLessonAssigned($userId, $lessonId)) {
                // Already assigned, consider this a success
                return true;
            }
            
            // Assign the lesson
            $assignmentRepo = new DatabaseRepository('lesson_assignments', $this->pdo);
            $data = [
                'user_id' => $userId,
                'lesson_id' => $lessonId,
                'assigned_by' => $assignedBy,
                'assigned_at' => date('Y-m-d H:i:s')
            ];
            
            return $assignmentRepo->insert($data) !== false;
        } catch (PDOException $e) {
            $this->logError("Error assigning lesson", $e);
            return false;
        }
    }
    
    /**
     * Unassign a lesson from a user
     * 
     * @param int $userId User ID
     * @param int $lessonId Lesson ID
     * @return bool Whether the unassignment was successful
     */
    public function unassignLesson($userId, $lessonId) {
        try {
            // Check if the lesson exists
            $lesson = $this->find($lessonId);
            
            if (!$lesson) {
                $this->logError("Cannot unassign non-existent lesson (ID: {$lessonId})");
                return false;
            }
            
            // Check if the user exists
            $userRepo = new UserRepository($this->pdo);
            $user = $userRepo->find($userId);
            
            if (!$user) {
                $this->logError("Cannot unassign lesson from non-existent user (ID: {$userId})");
                return false;
            }
            
            // Unassign the lesson
            $assignmentRepo = new DatabaseRepository('lesson_assignments', $this->pdo);
            return $assignmentRepo->deleteWhere([
                'user_id' => $userId,
                'lesson_id' => $lessonId
            ]);
        } catch (PDOException $e) {
            $this->logError("Error unassigning lesson", $e);
            return false;
        }
    }
    
    /**
     * Update lesson progress for a user
     * 
     * @param int $userId User ID
     * @param int $lessonId Lesson ID
     * @param int $chapterId Chapter ID
     * @param bool $completed Whether the chapter is completed
     * @return bool Whether the update was successful
     */
    public function updateProgress($userId, $lessonId, $chapterId, $completed = true) {
        try {
            $progressRepo = new DatabaseRepository('lesson_progress', $this->pdo);
            
            // Check if progress record exists
            $progress = $progressRepo->query(
                "SELECT * FROM lesson_progress WHERE user_id = ? AND lesson_id = ? AND chapter_id = ?",
                [$userId, $lessonId, $chapterId],
                false
            );
            
            if ($progress) {
                // Update existing record
                return $progressRepo->update($progress['id'], [
                    'completed' => $completed ? 1 : 0,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            } else {
                // Create new record
                return $progressRepo->insert([
                    'user_id' => $userId,
                    'lesson_id' => $lessonId,
                    'chapter_id' => $chapterId,
                    'completed' => $completed ? 1 : 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]) !== false;
            }
        } catch (PDOException $e) {
            $this->logError("Error updating lesson progress", $e);
            return false;
        }
    }
    
    /**
     * Save quiz result for a user
     * 
     * @param int $userId User ID
     * @param int $lessonId Lesson ID
     * @param int $chapterId Chapter ID
     * @param int $score Quiz score
     * @return bool Whether the save was successful
     */
    public function saveQuizResult($userId, $lessonId, $chapterId, $score) {
        try {
            $quizRepo = new DatabaseRepository('quiz_results', $this->pdo);
            
            // Check if quiz result exists
            $result = $quizRepo->query(
                "SELECT * FROM quiz_results WHERE user_id = ? AND lesson_id = ? AND chapter_id = ?",
                [$userId, $lessonId, $chapterId],
                false
            );
            
            if ($result) {
                // Update existing record
                return $quizRepo->update($result['id'], [
                    'score' => $score,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            } else {
                // Create new record
                return $quizRepo->insert([
                    'user_id' => $userId,
                    'lesson_id' => $lessonId,
                    'chapter_id' => $chapterId,
                    'score' => $score,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]) !== false;
            }
        } catch (PDOException $e) {
            $this->logError("Error saving quiz result", $e);
            return false;
        }
    }
    
    /**
     * Get user progress for a lesson
     * 
     * @param int $userId User ID
     * @param int $lessonId Lesson ID
     * @return array User progress
     */
    public function getUserProgress($userId, $lessonId) {
        try {
            $sql = "SELECT lp.*, qr.score
                    FROM lesson_progress lp
                    LEFT JOIN quiz_results qr ON lp.user_id = qr.user_id 
                        AND lp.lesson_id = qr.lesson_id 
                        AND lp.chapter_id = qr.chapter_id
                    WHERE lp.user_id = ? AND lp.lesson_id = ?
                    ORDER BY lp.chapter_id ASC";
                    
            return $this->query($sql, [$userId, $lessonId]);
        } catch (PDOException $e) {
            $this->logError("Error getting user progress", $e);
            return [];
        }
    }
    
    /**
     * Get completed lessons for a user
     * 
     * @param int $userId User ID
     * @return array Completed lessons
     */
    public function getCompletedLessons($userId) {
        try {
            $sql = "SELECT l.id, l.title, l.description, 
                           COUNT(DISTINCT lp.chapter_id) as completed_chapters,
                           (SELECT COUNT(*) FROM lesson_chapters WHERE lesson_id = l.id) as total_chapters,
                           MAX(lp.updated_at) as last_activity
                    FROM lessons l
                    JOIN lesson_progress lp ON l.id = lp.lesson_id
                    WHERE lp.user_id = ? AND lp.completed = 1
                    GROUP BY l.id
                    HAVING completed_chapters = total_chapters
                    ORDER BY last_activity DESC";
                    
            return $this->query($sql, [$userId]);
        } catch (PDOException $e) {
            $this->logError("Error getting completed lessons", $e);
            return [];
        }
    }
    
    /**
     * Get overall progress for a user
     * 
     * @param int $userId User ID
     * @return array Overall progress statistics
     */
    public function getOverallProgress($userId) {
        try {
            // Get total assigned lessons
            $assignedCount = $this->count([
                'user_id' => $userId
            ], 'lesson_assignments');
            
            // Get completed lessons
            $completedLessons = $this->getCompletedLessons($userId);
            $completedCount = count($completedLessons);
            
            // Get total chapters completed
            $sql = "SELECT COUNT(*) FROM lesson_progress WHERE user_id = ? AND completed = 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$userId]);
            $completedChapters = $stmt->fetchColumn();
            
            // Get total chapters available
            $sql = "SELECT COUNT(*) FROM lesson_chapters lc
                    JOIN lesson_assignments la ON lc.lesson_id = la.lesson_id
                    WHERE la.user_id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$userId]);
            $totalChapters = $stmt->fetchColumn();
            
            // Calculate completion percentage
            $completionPercentage = $totalChapters > 0 ? 
                round(($completedChapters / $totalChapters) * 100) : 0;
            
            return [
                'assigned_lessons' => $assignedCount,
                'completed_lessons' => $completedCount,
                'completed_chapters' => $completedChapters,
                'total_chapters' => $totalChapters,
                'completion_percentage' => $completionPercentage
            ];
        } catch (PDOException $e) {
            $this->logError("Error getting overall progress", $e);
            return [
                'assigned_lessons' => 0,
                'completed_lessons' => 0,
                'completed_chapters' => 0,
                'total_chapters' => 0,
                'completion_percentage' => 0
            ];
        }
    }
    
    /**
     * Count records from a specific table
     * 
     * @param array $criteria Criteria (column => value pairs)
     * @param string $table Table name (default: current table)
     * @return int Count
     */
    public function count($criteria = [], $table = null) {
        try {
            $tableName = $table ?? $this->table;
            
            $sql = "SELECT COUNT(*) FROM {$tableName}";
            
            $conditions = [];
            $values = [];
            
            foreach ($criteria as $column => $value) {
                $conditions[] = "{$column} = ?";
                $values[] = $value;
            }
            
            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(' AND ', $conditions);
            }
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($values);
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            $this->logError("Error counting records in {$tableName}", $e);
            return 0;
        }
    }
}
