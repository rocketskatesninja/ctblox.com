<?php
class LessonController extends Controller {
    public function __construct() {
        parent::__construct();
        $this->requireStudent();
    }
    
    public function viewLesson($id) {
        $lesson = $this->lesson->getById($id);
        if (!$lesson || !$lesson['active']) {
            $this->flash('Lesson not found or inactive', 'error');
            $this->redirect('/dashboard');
        }
        
        // Get user's progress for this lesson
        $progress = $this->pdo->prepare("
            SELECT chapter_id, completed
            FROM progress
            WHERE user_id = ? AND lesson_id = ? AND completed = 1
        ");
        $progress->execute([$_SESSION['user_id'], $id]);
        $progressData = $progress->fetchAll(PDO::FETCH_ASSOC);
        
        // Convert to key-value format for easier access in the view
        $progress = [];
        foreach ($progressData as $item) {
            $progress[$item['chapter_id']] = $item['completed'];
        }
        
        // Get quiz results
        $quizResults = $this->pdo->prepare("
            SELECT chapter_id, score
            FROM quiz_results
            WHERE user_id = ? AND lesson_id = ?
        ");
        $quizResults->execute([$_SESSION['user_id'], $id]);
        $quizResultsData = $quizResults->fetchAll(PDO::FETCH_ASSOC);
        
        // Convert to key-value format for easier access in the view
        $quizResults = [];
        foreach ($quizResultsData as $item) {
            $quizResults[$item['chapter_id']] = $item['score'];
        }
        
        return $this->view('lessons/view', [
            'lesson' => $lesson,
            'progress' => $progress,
            'quizResults' => $quizResults,
            'csrf_token' => $this->generateCsrfToken()
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
        
        if (!$this->isAjax()) {
            echo json_encode(['error' => 'Only AJAX requests are allowed']);
            exit;
        }
        
        try {
            $this->checkCsrfToken();
            
            $lessonId = $_POST['lesson_id'] ?? null;
            $chapterId = $_POST['chapter_id'] ?? null;
            
            if (!$lessonId || !$chapterId) {
                echo json_encode(['error' => 'Invalid parameters']);
                exit;
            }
            
            // Calculate score based on submitted answers
            // For the default quiz, we'll use a simple scoring system
            // In a real implementation, you would load correct answers from a database
            $score = $this->calculateQuizScore($_POST);
            $passed = $score >= 80;
            
            if ($this->lesson->saveQuizResult($_SESSION['user_id'], $lessonId, $chapterId, $score)) {
                // If the student passed the quiz, automatically mark the chapter as complete
                if ($passed) {
                    $this->lesson->updateProgress($_SESSION['user_id'], $lessonId, $chapterId, true);
                }
                
                echo json_encode([
                    'success' => true,
                    'score' => $score,
                    'passed' => $passed,
                    'autoCompleted' => $passed
                ]);
            } else {
                echo json_encode(['error' => 'Error saving quiz result']);
            }
        } catch (Exception $e) {
            error_log('Error in saveQuizResult: ' . $e->getMessage());
            echo json_encode(['error' => 'An unexpected error occurred']);
        }
        exit;
    }
    
    private function calculateQuizScore($answers) {
        // For our default quiz, define the correct answers
        // In a real implementation, you would load correct answers from a database
        $correctAnswers = [
            'q1' => 'c',  // Both theoretical knowledge and practical skills
            'q2' => 'b'   // By practicing with real-world examples
        ];
        
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
            
            // Check if quiz file exists
            $quizPath = $lessonDir . '/' . $chapterId . '_quiz.php';
            
            if (!file_exists($quizPath)) {
                // Create a default quiz if one doesn't exist
                echo $this->generateDefaultQuiz($chapterId, $lessonId, $chapterTitle);
                exit;
            } else {
                // Include the quiz file and capture its output
                ob_start();
                include $quizPath;
                $html = ob_get_clean();
                echo $html;
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
