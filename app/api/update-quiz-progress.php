<?php
/**
 * API Endpoint: Update Quiz Progress
 * 
 * This endpoint handles saving quiz progress for users.
 * It receives quiz_id, score, and total_questions as POST parameters.
 */

// Include necessary files
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';

// Set content type to JSON
header('Content-Type: application/json');

// Check if user is logged in
if (!isLoggedIn()) {
    echo json_encode([
        'success' => false,
        'message' => 'User not logged in'
    ]);
    exit;
}

// Check for POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
    exit;
}

// Get JSON data from request body
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

// Validate CSRF token
if (!validateCsrfToken($data['X-CSRF-TOKEN'] ?? '')) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid CSRF token'
    ]);
    exit;
}

// Validate required parameters
if (!isset($data['quiz_id']) || !isset($data['score']) || !isset($data['total_questions'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Missing required parameters'
    ]);
    exit;
}

// Sanitize and validate input
$quizId = filter_var($data['quiz_id'], FILTER_SANITIZE_STRING);
$score = filter_var($data['score'], FILTER_VALIDATE_INT);
$totalQuestions = filter_var($data['total_questions'], FILTER_VALIDATE_INT);

// Additional validation
if ($score === false || $totalQuestions === false || $score < 0 || $totalQuestions <= 0 || $score > $totalQuestions) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid score or total questions'
    ]);
    exit;
}

// Calculate percentage
$percentage = round(($score / $totalQuestions) * 100);

// Get user ID from session
$userId = $_SESSION['user_id'];

try {
    // Get database connection
    $pdo = getConnection();
    
    // Check if the quiz result already exists
    $stmt = $pdo->prepare("SELECT id FROM quiz_results WHERE user_id = ? AND quiz_id = ?");
    $stmt->execute([$userId, $quizId]);
    $existingResult = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($existingResult) {
        // Update existing record
        $stmt = $pdo->prepare("
            UPDATE quiz_results 
            SET score = ?, total_questions = ?, percentage = ?, completed_at = NOW() 
            WHERE id = ?
        ");
        $stmt->execute([$score, $totalQuestions, $percentage, $existingResult['id']]);
        
        $message = 'Quiz progress updated successfully';
    } else {
        // Insert new record
        $stmt = $pdo->prepare("
            INSERT INTO quiz_results (user_id, quiz_id, score, total_questions, percentage, completed_at) 
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
        $stmt->execute([$userId, $quizId, $score, $totalQuestions, $percentage]);
        
        $message = 'Quiz progress saved successfully';
    }
    
    // Also update the chapter progress in user_progress table
    // Extract chapter_id from quiz_id (assuming format like 'chapter_name_quiz')
    $chapterId = preg_replace('/_quiz$/', '', $quizId);
    
    if ($chapterId) {
        // Find the lesson_id for this chapter
        $stmt = $pdo->prepare("
            SELECT lesson_id FROM lesson_chapters 
            WHERE chapter_id = ?
        ");
        $stmt->execute([$chapterId]);
        $chapterInfo = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($chapterInfo) {
            $lessonId = $chapterInfo['lesson_id'];
            
            // Check if progress entry exists
            $stmt = $pdo->prepare("
                SELECT id FROM user_progress 
                WHERE user_id = ? AND lesson_id = ? AND chapter_id = ?
            ");
            $stmt->execute([$userId, $lessonId, $chapterId]);
            $progressEntry = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($progressEntry) {
                // Update existing progress
                $stmt = $pdo->prepare("
                    UPDATE user_progress 
                    SET completed = 1, updated_at = NOW() 
                    WHERE id = ?
                ");
                $stmt->execute([$progressEntry['id']]);
            } else {
                // Create new progress entry
                $stmt = $pdo->prepare("
                    INSERT INTO user_progress (user_id, lesson_id, chapter_id, completed, created_at, updated_at) 
                    VALUES (?, ?, ?, 1, NOW(), NOW())
                ");
                $stmt->execute([$userId, $lessonId, $chapterId]);
            }
        }
    }
    
    // Return success response
    echo json_encode([
        'success' => true,
        'message' => $message,
        'data' => [
            'quiz_id' => $quizId,
            'score' => $score,
            'total_questions' => $totalQuestions,
            'percentage' => $percentage
        ]
    ]);
    
} catch (PDOException $e) {
    // Log error (don't expose details to client)
    error_log('Error updating quiz progress: ' . $e->getMessage());
    
    // Return error response
    echo json_encode([
        'success' => false,
        'message' => 'Database error occurred'
    ]);
}
