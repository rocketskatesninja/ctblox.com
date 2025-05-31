<?php
class Lesson {
    private $pdo;
    
    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }
    
    public function create($data) {
        try {
            // Start transaction
            $this->pdo->beginTransaction();
            
            // Insert lesson
            $stmt = $this->pdo->prepare("
                INSERT INTO lessons (filename, title, description, author, version, language)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $data['filename'],
                $data['title'],
                $data['description'] ?? null,
                $data['author'] ?? null,
                $data['version'] ?? '1.0',
                $data['language'] ?? 'en'
            ]);
            
            $lessonId = $this->pdo->lastInsertId();
            
            // Insert chapters
            if (!empty($data['chapters'])) {
                $stmt = $this->pdo->prepare("
                    INSERT INTO chapters (lesson_id, chapter_id, title, sequence)
                    VALUES (?, ?, ?, ?)
                ");
                
                foreach ($data['chapters'] as $index => $chapter) {
                    $stmt->execute([
                        $lessonId,
                        $chapter['id'],
                        $chapter['title'],
                        $index + 1
                    ]);
                }
            }
            
            $this->pdo->commit();
            return $lessonId;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log("Error creating lesson: " . $e->getMessage());
            return false;
        }
    }
    
    public function update($id, $data) {
        try {
            $this->pdo->beginTransaction();
            
            // Update lesson
            $fields = [];
            $values = [];
            
            foreach ($data as $key => $value) {
                if ($key !== 'chapters' && !is_null($value)) {
                    $fields[] = "$key = ?";
                    $values[] = $value;
                }
            }
            
            if (!empty($fields)) {
                $values[] = $id;
                $sql = "UPDATE lessons SET " . implode(', ', $fields) . " WHERE id = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute($values);
            }
            
            // Update chapters if provided
            if (!empty($data['chapters'])) {
                // Remove existing chapters
                $stmt = $this->pdo->prepare("DELETE FROM chapters WHERE lesson_id = ?");
                $stmt->execute([$id]);
                
                // Insert new chapters
                $stmt = $this->pdo->prepare("
                    INSERT INTO chapters (lesson_id, chapter_id, title, sequence)
                    VALUES (?, ?, ?, ?)
                ");
                
                foreach ($data['chapters'] as $index => $chapter) {
                    $stmt->execute([
                        $id,
                        $chapter['id'],
                        $chapter['title'],
                        $index + 1
                    ]);
                }
            }
            
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log("Error updating lesson: " . $e->getMessage());
            return false;
        }
    }
    
    public function delete($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM lessons WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Error deleting lesson: " . $e->getMessage());
            return false;
        }
    }
    
    public function getById($id) {
        try {
            // First get the lesson data
            $stmt = $this->pdo->prepare("SELECT * FROM lessons WHERE id = ?");
            $stmt->execute([$id]);
            $lesson = $stmt->fetch();
            
            if (!$lesson) {
                return false;
            }
            
            // Then get the chapters separately
            $stmt = $this->pdo->prepare("
                SELECT chapter_id as id, title, sequence
                FROM chapters
                WHERE lesson_id = ?
                ORDER BY sequence ASC
            ");
            $stmt->execute([$id]);
            $lesson['chapters'] = $stmt->fetchAll();
            
            return $lesson;
        } catch (PDOException $e) {
            error_log("Error getting lesson: " . $e->getMessage());
            return false;
        }
    }
    
    public function getFilenameById($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT filename FROM lessons WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error getting lesson filename: " . $e->getMessage());
            return false;
        }
    }
    
    public function getAllLessons() {
        try {
            return $this->pdo->query("
                SELECT l.*, 
                    COUNT(DISTINCT complete_users.user_id) as completed_users
                FROM lessons l
                LEFT JOIN (
                    SELECT p.lesson_id, p.user_id
                    FROM progress p
                    JOIN (
                        SELECT lesson_id, COUNT(DISTINCT chapter_id) as chapter_count
                        FROM chapters
                        GROUP BY lesson_id
                    ) c ON p.lesson_id = c.lesson_id
                    WHERE p.completed = 1
                    GROUP BY p.lesson_id, p.user_id
                    HAVING COUNT(DISTINCT p.chapter_id) = MAX(c.chapter_count)
                ) complete_users ON l.id = complete_users.lesson_id
                GROUP BY l.id
                ORDER BY l.created_at DESC
            ")->fetchAll();
        } catch (PDOException $e) {
            error_log("Error getting lessons: " . $e->getMessage());
            return [];
        }
    }
    
    public function toggleActive($id) {
        try {
            $stmt = $this->pdo->prepare("UPDATE lessons SET active = NOT active WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Error toggling lesson status: " . $e->getMessage());
            return false;
        }
    }
    
    public function updateProgress($userId, $lessonId, $chapterId, $completed = true) {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO progress (user_id, lesson_id, chapter_id, completed, completed_at)
                VALUES (?, ?, ?, ?, NOW())
                ON DUPLICATE KEY UPDATE completed = ?, completed_at = NOW()
            ");
            return $stmt->execute([$userId, $lessonId, $chapterId, $completed, $completed]);
        } catch (PDOException $e) {
            error_log("Error updating progress: " . $e->getMessage());
            return false;
        }
    }
    
    public function saveQuizResult($userId, $lessonId, $chapterId, $score) {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO quiz_results (user_id, lesson_id, chapter_id, score)
                VALUES (?, ?, ?, ?)
            ");
            return $stmt->execute([$userId, $lessonId, $chapterId, $score]);
        } catch (PDOException $e) {
            error_log("Error saving quiz result: " . $e->getMessage());
            return false;
        }
    }
    
    public function getUserProgress($userId, $limit = null) {
        try {
            $this->pdo->beginTransaction();
            
            // First get all assigned lessons and their chapters
            $allLessons = $this->pdo->prepare("
                SELECT l.id, l.title, c.chapter_id
                FROM lessons l
                JOIN chapters c ON l.id = c.lesson_id
                JOIN lesson_assignments la ON l.id = la.lesson_id
                WHERE la.user_id = ?
                ORDER BY l.id, c.sequence
            ");
            $allLessons->execute([$userId]);
            $assignedLessons = $allLessons->fetchAll();
            
            if (empty($assignedLessons)) {
                $this->pdo->commit();
                return [];
            }
            
            // Count the total number of progress entries for this user
            $countStmt = $this->pdo->prepare("SELECT COUNT(*) FROM progress WHERE user_id = ?");
            $countStmt->execute([$userId]);
            $totalEntries = $countStmt->fetchColumn();
            
            // If there's a limit and there are more than the limit, delete the oldest entries
            if ($limit !== null && $totalEntries > $limit) {
                $deleteCount = $totalEntries - $limit;
                $deleteStmt = $this->pdo->prepare("
                    DELETE FROM progress 
                    WHERE id IN (
                        SELECT id FROM progress 
                        WHERE user_id = ? 
                        ORDER BY completed_at ASC 
                        LIMIT ?
                    )
                ");
                $deleteStmt->execute([$userId, $deleteCount]);
                error_log("Deleted {$deleteCount} old progress entries for user {$userId} to maintain limit of {$limit}");
            }
            
            // Then get the user's progress for these lessons
            if ($limit === null) {
                // Get all progress entries when no limit is specified (for coach dashboard)
                $stmt = $this->pdo->prepare("
                    SELECT l.id as lesson_id, l.title, p.chapter_id, p.completed, p.completed_at,
                           qr.score as quiz_score
                    FROM progress p
                    JOIN lessons l ON p.lesson_id = l.id
                    LEFT JOIN quiz_results qr ON p.lesson_id = qr.lesson_id 
                        AND p.chapter_id = qr.chapter_id 
                        AND p.user_id = qr.user_id
                    WHERE p.user_id = ? AND l.id IN (
                        SELECT DISTINCT lesson_id FROM lesson_assignments WHERE user_id = ?
                    )
                    ORDER BY p.completed_at DESC
                ");
                $stmt->execute([$userId, $userId]);
            } else {
                // Get limited progress entries (for student dashboard)
                $stmt = $this->pdo->prepare("
                    SELECT l.id as lesson_id, l.title, p.chapter_id, p.completed, p.completed_at,
                           qr.score as quiz_score
                    FROM progress p
                    JOIN lessons l ON p.lesson_id = l.id
                    LEFT JOIN quiz_results qr ON p.lesson_id = qr.lesson_id 
                        AND p.chapter_id = qr.chapter_id 
                        AND p.user_id = qr.user_id
                    WHERE p.user_id = ? AND l.id IN (
                        SELECT DISTINCT lesson_id FROM lesson_assignments WHERE user_id = ?
                    )
                    ORDER BY p.completed_at DESC
                    LIMIT ?
                ");
                $stmt->execute([$userId, $userId, $limit]);
            }
            $userProgress = $stmt->fetchAll();
            
            // Organize progress by lesson and chapter
            $progressByChapter = [];
            foreach ($userProgress as $progress) {
                $key = $progress['lesson_id'] . '-' . $progress['chapter_id'];
                $progressByChapter[$key] = $progress;
            }
            
            // Create a complete progress report including chapters with no progress
            $completeProgress = [];
            foreach ($userProgress as $progress) {
                $completeProgress[] = $progress;
            }
            
            $this->pdo->commit();
            return $completeProgress;
        } catch (PDOException $e) {
            error_log("Error getting user progress: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get assigned lessons for a user
     * 
     * @param int $userId The user ID
     * @return array List of assigned lesson IDs
     */
    public function getAssignedLessons($userId) {
        try {
            // Use a direct query without any caching to ensure fresh data
            $stmt = $this->pdo->prepare("
                SELECT l.id, l.title, l.description, la.assigned_at, u.username as assigned_by
                FROM lessons l
                JOIN lesson_assignments la ON l.id = la.lesson_id
                JOIN users u ON la.assigned_by = u.id
                WHERE la.user_id = ?
                ORDER BY la.assigned_at DESC
            ");
            $stmt->execute([$userId]);
            $results = $stmt->fetchAll();
            
            // Log the number of lessons found for debugging
            error_log("Found " . count($results) . " assigned lessons for user ID $userId");
            
            return $results;
        } catch (PDOException $e) {
            // Use the ErrorHandler if available
            if (class_exists('ErrorHandler')) {
                require_once __DIR__ . '/../classes/ErrorHandler.php';
                ErrorHandler::logDatabaseError($e, "Error getting assigned lessons for user ID $userId");
            } else {
                error_log("Error getting assigned lessons: " . $e->getMessage());
            }
            return [];
        }
    }
    
    /**
     * Check if a lesson is assigned to a user
     * 
     * @param int $userId The user ID
     * @param int $lessonId The lesson ID
     * @return bool Whether the lesson is assigned to the user
     */
    public function isLessonAssigned($userId, $lessonId) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT COUNT(*) FROM lesson_assignments
                WHERE user_id = ? AND lesson_id = ?
            ");
            $stmt->execute([$userId, $lessonId]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Error checking lesson assignment: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Assign a lesson to a user
     * 
     * @param int $userId The user ID
     * @param int $lessonId The lesson ID
     * @param int $assignedBy The ID of the user making the assignment
     * @return bool Whether the assignment was successful
     */
    public function assignLesson($userId, $lessonId, $assignedBy) {
        try {
            // Check if the lesson exists and is active
            $stmt = $this->pdo->prepare("SELECT id FROM lessons WHERE id = ? AND active = 1");
            $stmt->execute([$lessonId]);
            if (!$stmt->fetch()) {
                return false;
            }
            
            // Check if the user exists
            $userStmt = $this->pdo->prepare("SELECT id FROM users WHERE id = ?");
            $userStmt->execute([$userId]);
            if (!$userStmt->fetch()) {
                return false;
            }
            
            // Insert the assignment
            $stmt = $this->pdo->prepare("
                INSERT INTO lesson_assignments (user_id, lesson_id, assigned_by)
                VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE assigned_by = ?, assigned_at = NOW()
            ");
            $result = $stmt->execute([$userId, $lessonId, $assignedBy, $assignedBy]);
            
            if ($result) {
                // Log successful assignment
                error_log("Lesson ID $lessonId successfully assigned to User ID $userId by User ID $assignedBy");
            }
            
            return $result;
        } catch (PDOException $e) {
            // Use the ErrorHandler to log database errors
            require_once __DIR__ . '/../classes/ErrorHandler.php';
            ErrorHandler::logDatabaseError($e, "Error assigning lesson: User ID $userId, Lesson ID $lessonId, Assigned By $assignedBy");
            return false;
        }
    }
    
    /**
     * Unassign a lesson from a user and delete all progress
     * 
     * @param int $userId The user ID
     * @param int $lessonId The lesson ID
     * @return bool Whether the unassignment was successful
     */
    public function unassignLesson($userId, $lessonId) {
        try {
            // Start a transaction to ensure all operations succeed or fail together
            $this->pdo->beginTransaction();
            
            // First, log the current progress statistics before deletion for activity logging
            $progressStmt = $this->pdo->prepare("
                SELECT COUNT(*) as completed_chapters
                FROM progress
                WHERE user_id = ? AND lesson_id = ? AND completed = 1
            ");
            $progressStmt->execute([$userId, $lessonId]);
            $completedChapters = $progressStmt->fetchColumn();
            
            // Log the unassignment with progress info for auditing
            $logStmt = $this->pdo->prepare("
                INSERT INTO activity_log (username, activity_type, description, ip_address)
                SELECT username, 'lesson_unassigned', CONCAT('Lesson ID ', ?, ' unassigned. ', ?, ' completed chapters removed.'), ?
                FROM users WHERE id = ?
            ");
            $logStmt->execute([$lessonId, $completedChapters, $_SERVER['REMOTE_ADDR'] ?? 'unknown', $userId]);
            
            // Delete the lesson assignment
            $stmt = $this->pdo->prepare("
                DELETE FROM lesson_assignments
                WHERE user_id = ? AND lesson_id = ?
            ");
            $stmt->execute([$userId, $lessonId]);
            
            // Delete progress records for this lesson
            $stmt = $this->pdo->prepare("
                DELETE FROM progress
                WHERE user_id = ? AND lesson_id = ?
            ");
            $stmt->execute([$userId, $lessonId]);
            
            // Delete quiz results for this lesson
            $stmt = $this->pdo->prepare("
                DELETE FROM quiz_results
                WHERE user_id = ? AND lesson_id = ?
            ");
            $stmt->execute([$userId, $lessonId]);
            
            // Update user statistics cache if it exists
            $cacheStmt = $this->pdo->prepare("
                UPDATE user_statistics 
                SET total_completed_chapters = (
                    SELECT COUNT(*) FROM progress WHERE user_id = ? AND completed = 1
                ),
                total_completed_lessons = (
                    SELECT COUNT(DISTINCT lesson_id) FROM (
                        SELECT lesson_id, COUNT(*) as total_chapters, SUM(CASE WHEN completed = 1 THEN 1 ELSE 0 END) as completed_chapters
                        FROM progress 
                        WHERE user_id = ?
                        GROUP BY lesson_id
                        HAVING total_chapters = completed_chapters AND completed_chapters > 0
                    ) as completed_lessons
                )
                WHERE user_id = ?
            ");
            $cacheStmt->execute([$userId, $userId, $userId]);
            
            // Commit the transaction
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            // Roll back the transaction if any operation fails
            $this->pdo->rollBack();
            
            // Use the ErrorHandler to log database errors
            require_once __DIR__ . '/../classes/ErrorHandler.php';
            ErrorHandler::logDatabaseError($e, "Error unassigning lesson: User ID $userId, Lesson ID $lessonId");
            return false;
        }
    }
    
    /**
     * Get completed lessons for a user (eligible for certificates)
     * 
     * @param int $userId The user ID
     * @return array List of completed lessons with details
     */
    public function getCompletedLessons($userId) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT l.id, l.title, l.description, MAX(p.completed_at) as completion_date,
                       COUNT(DISTINCT c.chapter_id) as total_chapters,
                       COUNT(DISTINCT CASE WHEN p.completed = 1 THEN p.chapter_id END) as completed_chapters
                FROM lessons l
                JOIN chapters c ON l.id = c.lesson_id
                LEFT JOIN progress p ON l.id = p.lesson_id AND c.chapter_id = p.chapter_id AND p.user_id = ?
                GROUP BY l.id
                HAVING completed_chapters = total_chapters AND total_chapters > 0
                ORDER BY completion_date DESC
            ");
            $stmt->execute([$userId]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error getting completed lessons: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get user progress for assigned lessons only
     * 
     * @param int $userId The user ID
     * @return array Progress data for assigned lessons
     */
    public function getUserProgressForAssignedLessons($userId) {
        try {
            // First get all assigned lessons and their chapters
            $assignedLessons = $this->pdo->prepare("
                SELECT l.id, l.title, c.chapter_id
                FROM lessons l
                JOIN chapters c ON l.id = c.lesson_id
                JOIN lesson_assignments la ON l.id = la.lesson_id
                WHERE la.user_id = ?
                ORDER BY l.id, c.sequence
            ");
            $assignedLessons->execute([$userId]);
            $allLessons = $assignedLessons->fetchAll();
            
            if (empty($allLessons)) {
                return [];
            }
            
            // Then get the user's progress for these lessons
            $stmt = $this->pdo->prepare("
                SELECT l.id as lesson_id, l.title, p.chapter_id, p.completed, p.completed_at,
                       qr.score as quiz_score
                FROM progress p
                JOIN lessons l ON p.lesson_id = l.id
                LEFT JOIN quiz_results qr ON p.lesson_id = qr.lesson_id 
                    AND p.chapter_id = qr.chapter_id 
                    AND p.user_id = qr.user_id
                WHERE p.user_id = ? AND l.id IN (
                    SELECT DISTINCT lesson_id FROM lesson_assignments WHERE user_id = ?
                )
                ORDER BY l.id, p.chapter_id
            ");
            $stmt->execute([$userId, $userId]);
            $userProgress = $stmt->fetchAll();
            
            // Organize progress by lesson and chapter
            $progressByChapter = [];
            foreach ($userProgress as $progress) {
                $key = $progress['lesson_id'] . '-' . $progress['chapter_id'];
                $progressByChapter[$key] = $progress;
            }
            
            // Create a complete progress report including chapters with no progress
            $completeProgress = [];
            foreach ($allLessons as $lesson) {
                $key = $lesson['id'] . '-' . $lesson['chapter_id'];
                
                if (isset($progressByChapter[$key])) {
                    // Chapter has progress record
                    $completeProgress[] = $progressByChapter[$key];
                } else {
                    // Chapter has no progress record, create a default one
                    $completeProgress[] = [
                        'lesson_id' => $lesson['id'],
                        'title' => $lesson['title'],
                        'chapter_id' => $lesson['chapter_id'],
                        'completed' => 0,
                        'completed_at' => null,
                        'quiz_score' => null
                    ];
                }
            }
            
            return $completeProgress;
        } catch (PDOException $e) {
            error_log("Error getting user progress for assigned lessons: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get overall progress for a user across all lessons
     * 
     * @param int $userId The user ID
     * @return array Overall progress statistics
     */
    public function getOverallProgress($userId) {
        try {
            // Only count lessons and chapters that are currently assigned to the student
            $stmt = $this->pdo->prepare("
                SELECT 
                    COUNT(DISTINCT c.id) as total_chapters,
                    COUNT(DISTINCT CASE WHEN p.completed = 1 THEN c.id END) as completed_chapters,
                    COUNT(DISTINCT l.id) as total_lessons,
                    COUNT(DISTINCT CASE WHEN l.id IN (
                        SELECT l2.id
                        FROM lessons l2
                        JOIN lesson_assignments la2 ON l2.id = la2.lesson_id AND la2.user_id = ?
                        JOIN chapters c2 ON l2.id = c2.lesson_id
                        LEFT JOIN progress p2 ON l2.id = p2.lesson_id AND c2.chapter_id = p2.chapter_id AND p2.user_id = ?
                        GROUP BY l2.id
                        HAVING COUNT(DISTINCT c2.chapter_id) = COUNT(DISTINCT CASE WHEN p2.completed = 1 THEN p2.chapter_id END)
                        AND COUNT(DISTINCT c2.chapter_id) > 0
                    ) THEN l.id END) as completed_lessons
                FROM lessons l
                JOIN lesson_assignments la ON l.id = la.lesson_id AND la.user_id = ?
                JOIN chapters c ON l.id = c.lesson_id
                LEFT JOIN progress p ON l.id = p.lesson_id AND c.chapter_id = p.chapter_id AND p.user_id = ?
            ");
            $stmt->execute([$userId, $userId, $userId, $userId]);
            $result = $stmt->fetch();
            
            // Calculate percentages
            $result['chapter_completion_percentage'] = $result['total_chapters'] > 0 
                ? round(($result['completed_chapters'] / $result['total_chapters']) * 100) 
                : 0;
                
            $result['lesson_completion_percentage'] = $result['total_lessons'] > 0 
                ? round(($result['completed_lessons'] / $result['total_lessons']) * 100) 
                : 0;
                
            return $result;
        } catch (PDOException $e) {
            error_log("Error getting overall progress: " . $e->getMessage());
            return [
                'total_chapters' => 0,
                'completed_chapters' => 0,
                'total_lessons' => 0,
                'completed_lessons' => 0,
                'chapter_completion_percentage' => 0,
                'lesson_completion_percentage' => 0
            ];
        }
    }
}
