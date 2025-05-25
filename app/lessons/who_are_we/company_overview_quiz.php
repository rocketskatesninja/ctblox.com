<?php
// Quiz for the "Company Overview" chapter
?>

<div class="quiz-container" data-chapter="company_overview">
    <h3 class="text-xl font-bold mb-4">Company Overview Quiz</h3>
    
    <form id="quiz-form" class="space-y-6" onsubmit="return submitQuiz(this)">
        <input type="hidden" name="chapter_id" value="company_overview">
        
        <div class="quiz-question">
            <p class="font-medium mb-2">1. How many employees does Corporate Tools have?</p>
            <div class="space-y-2">
                <label class="flex items-start">
                    <input type="radio" name="q1" value="a" class="mt-1 mr-2" required>
                    <span>Around 100 employees</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q1" value="b" class="mt-1 mr-2">
                    <span>Over 1000 employees</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q1" value="c" class="mt-1 mr-2">
                    <span>Exactly 500 employees</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q1" value="d" class="mt-1 mr-2">
                    <span>Less than 50 employees</span>
                </label>
            </div>
        </div>
        
        <div class="quiz-question">
            <p class="font-medium mb-2">2. What is Corporate Tools' primary mission?</p>
            <div class="space-y-2">
                <label class="flex items-start">
                    <input type="radio" name="q2" value="a" class="mt-1 mr-2" required>
                    <span>To maximize profits for shareholders</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q2" value="b" class="mt-1 mr-2">
                    <span>To make starting, running, and organizing businesses easier</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q2" value="c" class="mt-1 mr-2">
                    <span>To provide legal representation for businesses</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q2" value="d" class="mt-1 mr-2">
                    <span>To offer accounting services to small businesses</span>
                </label>
            </div>
        </div>
        
        <div class="mt-6">
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 dark:focus:ring-indigo-400">
                Submit Answers
            </button>
        </div>
    </form>
    
    <div id="quiz-results" class="hidden mt-6 p-4 rounded-md">
        <p class="text-lg font-medium">Your Score: <span id="score">0</span>/4</p>
        <p class="mt-2">Correct answers:</p>
        <ul class="list-disc pl-5 mt-1">
            <li>Question 1: Over 1000 employees</li>
            <li>Question 2: Healthcare providers</li>
            <li>Question 3: Privately held, debt-free company</li>
            <li>Question 4: To make starting, running, and organizing businesses easier</li>
        </ul>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const quizForm = document.getElementById('quiz-form');
    const quizResults = document.getElementById('quiz-results');
    const scoreElement = document.getElementById('score');
    
    const correctAnswers = {
        q1: 'b',
        q2: 'c',
        q3: 'd',
        q4: 'b'
    };
    
    quizForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        let score = 0;
        const formData = new FormData(quizForm);
        
        // Check answers and provide feedback
        for (const [question, answer] of formData.entries()) {
            const feedbackElement = document.querySelector(`[name="${question}"]`).closest('.quiz-question').querySelector('.answer-feedback');
            
            if (answer === correctAnswers[question]) {
                score++;
                feedbackElement.textContent = 'Correct!';
                feedbackElement.classList.remove('hidden', 'text-red-600', 'dark:text-red-400');
                feedbackElement.classList.add('text-green-600', 'dark:text-green-400');
            } else {
                feedbackElement.textContent = 'Incorrect';
                feedbackElement.classList.remove('hidden', 'text-green-600', 'dark:text-green-400');
                feedbackElement.classList.add('text-red-600', 'dark:text-red-400');
            }
            
            feedbackElement.classList.remove('hidden');
        }
        
        // Update and show results
        scoreElement.textContent = score;
        quizResults.classList.remove('hidden');
        
        if (score === 4) {
            quizResults.classList.add('bg-green-100', 'dark:bg-green-900');
        } else {
            quizResults.classList.add('bg-yellow-100', 'dark:bg-yellow-900');
        }
        
        // Send result to server (you would implement this)
        // saveQuizResult(chapterId, score);
    });
});
</script>
