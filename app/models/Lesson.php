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
                SELECT l.*, COUNT(DISTINCT p.user_id) as completed_users
                FROM lessons l
                LEFT JOIN progress p ON l.id = p.lesson_id AND p.completed = 1
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
    
    public function getUserProgress($userId) {
        try {
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
            foreach ($assignedLessons as $lesson) {
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
            $stmt = $this->pdo->prepare("
                SELECT l.id, l.title, l.description, la.assigned_at, u.username as assigned_by
                FROM lessons l
                JOIN lesson_assignments la ON l.id = la.lesson_id
                JOIN users u ON la.assigned_by = u.id
                WHERE la.user_id = ?
                ORDER BY la.assigned_at DESC
            ");
            $stmt->execute([$userId]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error getting assigned lessons: " . $e->getMessage());
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
            
            // Insert the assignment
            $stmt = $this->pdo->prepare("
                INSERT INTO lesson_assignments (user_id, lesson_id, assigned_by)
                VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE assigned_by = ?, assigned_at = NOW()
            ");
            return $stmt->execute([$userId, $lessonId, $assignedBy, $assignedBy]);
        } catch (PDOException $e) {
            error_log("Error assigning lesson: " . $e->getMessage());
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
            
            // Commit the transaction
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            // Roll back the transaction if any operation fails
            $this->pdo->rollBack();
            error_log("Error unassigning lesson: " . $e->getMessage());
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
            $stmt = $this->pdo->prepare("
                SELECT COUNT(DISTINCT c.id) as total_chapters,
                       COUNT(DISTINCT CASE WHEN p.completed = 1 THEN c.id END) as completed_chapters,
                       COUNT(DISTINCT l.id) as total_lessons,
                       COUNT(DISTINCT CASE WHEN l.id IN (
                           SELECT l2.id
                           FROM lessons l2
                           JOIN chapters c2 ON l2.id = c2.lesson_id
                           LEFT JOIN progress p2 ON l2.id = p2.lesson_id AND c2.chapter_id = p2.chapter_id AND p2.user_id = ?
                           GROUP BY l2.id
                           HAVING COUNT(DISTINCT c2.chapter_id) = COUNT(DISTINCT CASE WHEN p2.completed = 1 THEN p2.chapter_id END)
                           AND COUNT(DISTINCT c2.chapter_id) > 0
                       ) THEN l.id END) as completed_lessons
                FROM lessons l
                JOIN chapters c ON l.id = c.lesson_id
                LEFT JOIN progress p ON l.id = p.lesson_id AND c.chapter_id = p.chapter_id AND p.user_id = ?
            ");
            $stmt->execute([$userId, $userId]);
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
