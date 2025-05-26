<?php
/**
 * Quiz template file
 * Usage: Include this file and pass the following variables:
 * - $chapterId: The ID of the chapter this quiz belongs to
 * - $quizTitle: The title of the quiz
 * - $questions: Array of questions, each containing:
 *   - question: The question text
 *   - answers: Array of possible answers
 *   - correctAnswer: The correct answer value
 */

// Ensure required variables are set
if (!isset($chapterId) || !isset($quizTitle) || !isset($questions)) {
    throw new Exception('Quiz template requires $chapterId, $quizTitle, and $questions to be set');
}
?>

<div class="quiz-container" data-chapter="<?= htmlspecialchars($chapterId) ?>">
    <h3 class="text-xl font-bold mb-4"><?= htmlspecialchars($quizTitle) ?></h3>
    
    <form id="<?= htmlspecialchars($chapterId) ?>-form" class="space-y-6" onsubmit="return submitQuiz(this);">
        <input type="hidden" name="chapter_id" value="<?= htmlspecialchars($chapterId) ?>">
        
        <?php foreach ($questions as $index => $q): ?>
            <div class="quiz-question">
                <p class="font-medium mb-2"><?= ($index + 1) . '. ' . htmlspecialchars($q['question']) ?></p>
                <div class="space-y-2">
                    <?php foreach ($q['answers'] as $value => $text): ?>
                        <label class="flex items-start">
                            <input type="radio" 
                                   name="q<?= ($index + 1) ?>" 
                                   value="<?= htmlspecialchars($value) ?>" 
                                   class="mt-1 mr-2" 
                                   required>
                            <span><?= htmlspecialchars($text) ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
        
        <div class="mt-6">
            <button type="submit" 
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 dark:focus:ring-indigo-400">
                Submit Answers
            </button>
        </div>
    </form>
    
    <div id="<?= htmlspecialchars($chapterId) ?>-results" class="hidden mt-6 p-4 rounded-md bg-gray-100 dark:bg-gray-800">
        <p class="text-lg font-medium">Your Score: <span id="<?= htmlspecialchars($chapterId) ?>-score">0</span>/<?= count($questions) ?></p>
        <p class="mt-2">Correct answers:</p>
        <ul class="list-disc pl-5 mt-1">
            <?php foreach ($questions as $index => $q): ?>
                <li>Question <?= $index + 1 ?>: <?= htmlspecialchars($q['answers'][$q['correctAnswer']]) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const formId = '<?= htmlspecialchars($chapterId) ?>-form';
    const quizForm = document.getElementById(formId);
    const resultsDiv = document.getElementById('<?= htmlspecialchars($chapterId) ?>-results');
    const scoreSpan = document.getElementById('<?= htmlspecialchars($chapterId) ?>-score');
    
    // Define correct answers
    const correctAnswers = <?= json_encode(array_map(function($q) { 
        return ['answer' => $q['correctAnswer'], 'explanation' => $q['explanation'] ?? null]; 
    }, $questions)) ?>;
    
    // Form validation function
    window.validateQuiz = function() {
        const numQuestions = <?= count($questions) ?>;
        for (let i = 1; i <= numQuestions; i++) {
            const answer = quizForm.querySelector(`input[name="q${i}"]:checked`)?.value;
            if (!answer) {
                alert('Please answer all questions before submitting.');
                return false;
            }
        }
        return true;
    };
    
    // Preview score function
    window.previewScore = function() {
        let score = 0;
        correctAnswers.forEach((correct, index) => {
            const answer = quizForm.querySelector(`input[name="q${index + 1}"]:checked`)?.value;
            if (answer === correct.answer) score++;
        });
        
        scoreSpan.textContent = score;
        resultsDiv.classList.remove('hidden');
    };
    
    // Add change events to radio buttons to preview score
    quizForm.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', previewScore);
    });
});</script>
