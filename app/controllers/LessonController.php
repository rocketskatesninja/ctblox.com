<?php
require_once __DIR__ . '/../repositories/DatabaseRepository.php';

class LessonController extends Controller {
    protected $dbRepo;
    
    public function __construct() {
        parent::__construct();
        $this->requireStudent();
        $this->dbRepo = new DatabaseRepository();
    }
    
    public function viewLesson($id) {
        $lesson = $this->lesson->getById($id);
        if (!$lesson || !$lesson['active']) {
            $this->flash('Lesson not found or inactive', 'error');
            $this->redirect('/dashboard');
        }
        
        // Get user's progress for this lesson using the database repository
        $progressData = $this->dbRepo->getUserProgress($_SESSION['user_id'], $id);
        
        // Convert to key-value format for easier access in the view
        $progress = [];
        foreach ($progressData as $item) {
            $progress[$item['chapter_id']] = $item['completed'];
        }
        
        // Get quiz results using the database repository
        $quizResultsData = $this->dbRepo->getUserQuizResults($_SESSION['user_id'], $id);
        
        // Convert to key-value format for easier access in the view
        $quizResults = [];
        foreach ($quizResultsData as $item) {
            $quizResults[$item['chapter_id']] = $item['score'];
        }
        
        // Check if all chapters are completed
        $allChaptersCompleted = true;
        foreach ($lesson['chapters'] as $chapter) {
            if (!isset($progress[$chapter['id']]) || !$progress[$chapter['id']]) {
                $allChaptersCompleted = false;
                break;
            }
        }
        
        return $this->view('lessons/view', [
            'lesson' => $lesson,
            'progress' => $progress,
            'quizResults' => $quizResults,
            'csrf_token' => $this->generateCsrfToken(),
            'allChaptersCompleted' => $allChaptersCompleted
        ]);
    }
    
    public function updateProgress() {
        $this->checkCsrfToken();
        
        $lessonId = $_POST['lesson_id'] ?? null;
        $chapterId = $_POST['chapter_id'] ?? null;
        $completed = $_POST['completed'] ?? false;
        
        if (!$lessonId || !$chapterId) {
            if ($this->isAjax()) {
                $this->json(['error' => 'Invalid parameters']);
            } else {
                $this->flash('Invalid parameters', 'error');
                $this->redirect('/dashboard');
            }
            return;
        }
        
        $success = $this->lesson->updateProgress($_SESSION['user_id'], $lessonId, $chapterId, $completed);
        
        if ($this->isAjax()) {
            if ($success) {
                $this->json(['success' => true]);
            } else {
                $this->json(['error' => 'Error updating progress']);
            }
        } else {
            if ($success) {
                $this->flash('Progress updated successfully', 'success');
            } else {
                $this->flash('Error updating progress', 'error');
            }
            $this->redirect('/lesson/' . $lessonId);
        }
    }
    
    public function saveQuizResult() {
        // Make sure we're sending JSON response headers
        header('Content-Type: application/json');
        
        try {
            // Validate request
            if (!$this->isAjax()) {
                throw new Exception('Only AJAX requests are allowed');
            }
            
            $this->checkCsrfToken();
            
            // Get and validate required parameters
            $lessonId = $_POST['lesson_id'] ?? null;
            $chapterId = $_POST['chapter_id'] ?? null;
            
            if (!$lessonId || !$chapterId) {
                throw new Exception('Missing required parameters: lesson_id and chapter_id');
            }
            
            // Validate user is logged in
            if (!isset($_SESSION['user_id'])) {
                throw new Exception('User not authenticated');
            }
            
            // Calculate score based on submitted answers
            $score = $this->calculateQuizScore($_POST);
            $passed = $score >= 80; // 80% is passing score
            
            // Save quiz result
            if (!$this->lesson->saveQuizResult($_SESSION['user_id'], $lessonId, $chapterId, $score)) {
                throw new Exception('Failed to save quiz result');
            }
            
            // If student passed, mark chapter as complete
            if ($passed) {
                if (!$this->lesson->updateProgress($_SESSION['user_id'], $lessonId, $chapterId, true)) {
                    error_log("Warning: Failed to update progress after passing quiz. User: {$_SESSION['user_id']}, Lesson: {$lessonId}, Chapter: {$chapterId}");
                }
            }
            
            // Return success response
            echo json_encode([
                'success' => true,
                'score' => $score,
                'passed' => $passed,
                'autoCompleted' => $passed
            ]);
            
        } catch (Exception $e) {
            error_log('Error in saveQuizResult: ' . $e->getMessage());
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
        exit;
    }
    
    private function calculateQuizScore($answers) {
        // Get the chapter ID to determine which quiz we're scoring
        $chapterId = $answers['chapter_id'] ?? '';
        
        // Define correct answers for each quiz
        $quizAnswers = [
            'chapter_structure' => [
                'q1' => 'c',  // Both theoretical knowledge and practical skills
                'q2' => 'b',  // By practicing with real-world examples
                'q3' => 'c'   // Clear organization and flow
            ],
            'content_formatting' => [
                'q1' => 'b',  // Unordered lists (list-disc)
                'q2' => 'b',  // 3-5 sentences
                'q3' => 'c'   // When comparing multiple items across consistent categories
            ],
            'company_overview' => [
                'q1' => 'b',  // 2010
                'q2' => 'c',  // To empower entrepreneurs by simplifying business formation and compliance
                'q3' => 'd',  // Competitiveness
                'q4' => 'a',  // Celebrated 10 years of service and 40,000+ businesses formed
                'q5' => 'c'   // Technology-driven approach with proprietary platforms
            ],
            'service_offerings' => [
                'q1' => 'd',  // Tax return preparation
                'q2' => 'b',  // To receive important legal and government documents on behalf of businesses
                'q3' => 'c',  // Avoiding penalties and maintaining good standing
                'q4' => 'd',  // Enterprise
                'q5' => 'd'   // Inventory Management
            ],
            'customer_experience' => [
                'q1' => 'c',  // Combining expertise with empathy
                'q2' => 'b',  // Connect
                'q3' => 'b',  // 4 business hours
                'q4' => 'c',  // Customer Effort Score (CES)
                'q5' => 'c'   // Offer to transition to phone or email for better assistance
            ],
            'team_structure' => [
                'q1' => 'b',  // Operations
                'q2' => 'c',  // Ensuring services adhere to all applicable regulations
                'q3' => 'c',  // Monthly
                'q4' => 'c',  // Guaranteed promotions every year
                'q5' => 'c'   // Forming a rapid response team with a clear issue owner and supporting experts
            ],
            'technology_tools' => [
                'q1' => 'b',  // Client Portal
                'q2' => 'a',  // Compliance Management System (CMS)
                'q3' => 'c',  // Multi-factor authentication and 256-bit encryption
                'q4' => 'b',  // Receipt of physical or electronic document
                'q5' => 'c'   // Analytics Dashboard
            ],
            'compliance_expertise' => [
                'q1' => 'c',  // Assessment
                'q2' => 'a',  // Managing different requirements across multiple states
                'q3' => 'c',  // Board meetings and corporate minutes
                'q4' => 'b',  // Through proactive monitoring systems and regular compliance updates with impact assessments
                'q5' => 'd'   // Legal representation in court
            ],
            'quiz_implementation' => [
                'q1' => 'b',  // [chapter_name]_quiz.php
                'q2' => 'b',  // Via AJAX using the fetch API
                'q3' => 'c'   // The user should see their score and the correct answers immediately
            ],
            'introduction' => [
                'q1' => 'c',  // Both theoretical knowledge and practical skills
                'q2' => 'b'   // By practicing with real-world examples
            ]
        ];
        
        // Use the appropriate answer key or a default one
        $correctAnswers = $quizAnswers[$chapterId] ?? $quizAnswers['chapter_structure'];
        
        $totalQuestions = count($correctAnswers);
        $correctCount = 0;
        
        foreach ($correctAnswers as $question => $correctAnswer) {
            if (isset($answers[$question]) && $answers[$question] === $correctAnswer) {
                $correctCount++;
            }
        }
        
        // Calculate percentage score
        return $totalQuestions > 0 ? round(($correctCount / $totalQuestions) * 100) : 0;
    }
    
    public function getQuiz($chapterId) {
        try {
            // First check if this is a valid chapter ID
            $chapter = $this->pdo->prepare("SELECT c.lesson_id, c.title, l.filename 
                                        FROM chapters c 
                                        JOIN lessons l ON c.lesson_id = l.id 
                                        WHERE c.chapter_id = ?");
            $chapter->execute([$chapterId]);
            $chapterData = $chapter->fetch();
            
            if (!$chapterData) {
                // If chapter not found, return a default quiz
                echo $this->generateDefaultQuiz($chapterId, null);
                exit;
            }
            
            $lessonId = $chapterData['lesson_id'];
            $lessonFilename = $chapterData['filename'];
            $chapterTitle = $chapterData['title'];
            
            // Make sure the lessons directory exists
            if (!is_dir(LESSONS_PATH)) {
                mkdir(LESSONS_PATH, 0755, true);
            }
            
            // Create lesson directory if it doesn't exist
            $lessonDir = LESSONS_PATH . '/' . $lessonFilename;
            if (!is_dir($lessonDir)) {
                mkdir($lessonDir, 0755, true);
            }
            
            // First check if it's a special quiz in the lesson_template directory
            $templateQuizPath = LESSONS_PATH . '/lesson_template/' . $chapterId . '_quiz.php';
            
            // Check if quiz file exists in the lesson directory or template directory
            $quizPath = $lessonDir . '/' . $chapterId . '_quiz.php';
            
            if (file_exists($templateQuizPath)) {
                // Use the template quiz if it exists
                ob_start();
                include $templateQuizPath;
                $html = ob_get_clean();
                echo $html;
                exit;
            } else if (file_exists($quizPath)) {
                // Use the lesson-specific quiz if it exists
                ob_start();
                include $quizPath;
                $html = ob_get_clean();
                echo $html;
                exit;
            } else {
                // Create a default quiz if one doesn't exist
                echo $this->generateDefaultQuiz($chapterId, $lessonId, $chapterTitle);
                exit;
            }
        } catch (Exception $e) {
            // Log the error
            error_log('Error in getQuiz: ' . $e->getMessage());
            
            // Return a simple quiz in case of error
            echo $this->generateDefaultQuiz($chapterId, null);
            exit;
        }
    }
    
    private function generateDefaultQuiz($chapterId, $lessonId, $chapterTitle = null) {
        // If chapter title wasn't provided, try to get it from the database
        if ($chapterTitle === null && $lessonId !== null) {
            $chapterQuery = $this->pdo->prepare("SELECT title FROM chapters WHERE chapter_id = ? AND lesson_id = ?");
            $chapterQuery->execute([$chapterId, $lessonId]);
            $chapterTitle = $chapterQuery->fetchColumn() ?: 'Chapter Quiz';
        } else if ($chapterTitle === null) {
            $chapterTitle = 'Chapter Quiz';
        }
        
        // Create a default quiz with exactly 2 questions
        $html = <<<HTML
        <div class="p-4">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{$chapterTitle} Quiz</h3>
            <form onsubmit="return submitQuiz(this)">
                <input type="hidden" name="chapter_id" value="{$chapterId}">
                
                <div class="space-y-4 mb-6">
                    <div class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow">
                        <p class="font-medium text-gray-900 dark:text-white mb-2">1. Which of the following best describes the purpose of this chapter?</p>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="radio" name="q1" value="a" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300" required>
                                <span class="ml-2 text-gray-700 dark:text-gray-300">To provide theoretical knowledge</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="q1" value="b" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                <span class="ml-2 text-gray-700 dark:text-gray-300">To develop practical skills</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="q1" value="c" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                <span class="ml-2 text-gray-700 dark:text-gray-300">Both theoretical knowledge and practical skills</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow">
                        <p class="font-medium text-gray-900 dark:text-white mb-2">2. What is the best way to apply what you've learned in this chapter?</p>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="radio" name="q2" value="a" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300" required>
                                <span class="ml-2 text-gray-700 dark:text-gray-300">By memorizing the key concepts</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="q2" value="b" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                <span class="ml-2 text-gray-700 dark:text-gray-300">By practicing with real-world examples</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="q2" value="c" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                <span class="ml-2 text-gray-700 dark:text-gray-300">By teaching the concepts to someone else</span>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 dark:focus:ring-indigo-400">
                        Submit Quiz
                    </button>
                </div>
            </form>
        </div>
        HTML;
        
        return $html;
    }
    
    /**
     * Save lesson feedback submitted by the user
     */
    public function saveFeedback() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'User not logged in']);
            exit;
        }
        
        // Get feedback data
        $lessonId = $_POST['lesson_id'] ?? null;
        $rating = $_POST['rating'] ?? null;
        $comments = $_POST['comments'] ?? '';
        
        // Validate input
        if (!$lessonId || !$rating) {
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            exit;
        }
        
        // Sanitize inputs
        $lessonId = filter_var($lessonId, FILTER_SANITIZE_NUMBER_INT);
        $rating = filter_var($rating, FILTER_SANITIZE_STRING);
        $comments = filter_var($comments, FILTER_SANITIZE_STRING);
        
        try {
            // Check if feedback already exists for this user and lesson
            $checkStmt = $this->pdo->prepare("SELECT id FROM lesson_feedback WHERE user_id = ? AND lesson_id = ?");
            $checkStmt->execute([$_SESSION['user_id'], $lessonId]);
            $existingFeedback = $checkStmt->fetch();
            
            if ($existingFeedback) {
                // Update existing feedback
                $stmt = $this->pdo->prepare("UPDATE lesson_feedback SET rating = ?, comments = ?, updated_at = NOW() WHERE id = ?");
                $success = $stmt->execute([$rating, $comments, $existingFeedback['id']]);
            } else {
                // Insert new feedback
                $stmt = $this->pdo->prepare("INSERT INTO lesson_feedback (user_id, lesson_id, rating, comments, created_at) VALUES (?, ?, ?, ?, NOW())");
                $success = $stmt->execute([$_SESSION['user_id'], $lessonId, $rating, $comments]);
            }
            
            if ($success) {
                // Log the feedback activity
                $activityLogger = new ActivityLogger();
                $activityLogger->log(
                    $_SESSION['username'],
                    'lesson_feedback',
                    $lessonId,
                    'Submitted feedback for lesson'
                );
                
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to save feedback']);
            }
        } catch (Exception $e) {
            error_log('Error saving feedback: ' . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'An error occurred']);
        }
        
        exit;
    }
    
    public function generateCertificate($lessonId) {
        // Check if user has completed all chapters
        $progress = $this->pdo->prepare("
            SELECT COUNT(DISTINCT c.chapter_id) as total_chapters,
                   COUNT(DISTINCT CASE WHEN p.completed = 1 THEN p.chapter_id END) as completed_chapters
            FROM chapters c
            LEFT JOIN progress p ON c.lesson_id = p.lesson_id 
                AND c.chapter_id = p.chapter_id 
                AND p.user_id = ?
            WHERE c.lesson_id = ?
        ");
        $progress->execute([$_SESSION['user_id'], $lessonId]);
        $result = $progress->fetch();
        
        if ($result['total_chapters'] != $result['completed_chapters']) {
            $this->flash('You must complete all chapters to generate a certificate', 'error');
            $this->redirect("/lesson/{$lessonId}");
        }
        
        // Get lesson and user info
        $lesson = $this->lesson->getById($lessonId);
        $user = $this->user->getById($_SESSION['user_id']);
        
        // Get certificate template
        $template = $this->pdo->query("
            SELECT setting_value FROM settings WHERE setting_key = 'certificate_template'
        ")->fetchColumn();
        
        // Generate certificate
        require_once APP_PATH . '/app/utils/CertificateGenerator.php';
        $generator = new CertificateGenerator();
        $certificate = $generator->generate([
            'template' => $template,
            'user_name' => $user['username'],
            'lesson_title' => $lesson['title'],
            'completion_date' => date('F j, Y'),
            'certificate_id' => uniqid()
        ]);
        
        // Output certificate
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="certificate.pdf"');
        echo $certificate;
        exit;
    }
}
