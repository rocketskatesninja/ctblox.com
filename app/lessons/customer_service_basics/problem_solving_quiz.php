<?php
// Quiz for the "Problem Solving" chapter
?>

<div class="quiz-container" data-chapter="problem_solving">
    <h3 class="text-xl font-bold mb-4">Problem Solving Quiz</h3>
    
    <form id="quiz-form" class="space-y-6">
        <div class="quiz-question">
            <p class="font-medium mb-2">1. What is the "Service Recovery Paradox"?</p>
            <div class="space-y-2">
                <label class="flex items-start">
                    <input type="radio" name="q1" value="a" class="mt-1 mr-2">
                    <span>Customers whose problems are resolved quickly often become more loyal than those who never had problems.</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q1" value="b" class="mt-1 mr-2">
                    <span>Customers always remember negative experiences more than positive ones.</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q1" value="c" class="mt-1 mr-2">
                    <span>The more problems a customer experiences, the less likely they are to return.</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q1" value="d" class="mt-1 mr-2">
                    <span>Customer service representatives should avoid solving problems directly.</span>
                </label>
            </div>
            <div class="answer-feedback hidden mt-2"></div>
        </div>
        
        <div class="quiz-question">
            <p class="font-medium mb-2">2. What does the "E" stand for in the HEARD problem-solving framework?</p>
            <div class="space-y-2">
                <label class="flex items-start">
                    <input type="radio" name="q2" value="a" class="mt-1 mr-2">
                    <span>Explain</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q2" value="b" class="mt-1 mr-2">
                    <span>Empathize</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q2" value="c" class="mt-1 mr-2">
                    <span>Evaluate</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q2" value="d" class="mt-1 mr-2">
                    <span>Engage</span>
                </label>
            </div>
            <div class="answer-feedback hidden mt-2"></div>
        </div>
        
        <div class="quiz-question">
            <p class="font-medium mb-2">3. When dealing with an upset customer, which of the following is the BEST approach?</p>
            <div class="space-y-2">
                <label class="flex items-start">
                    <input type="radio" name="q3" value="a" class="mt-1 mr-2">
                    <span>Explain company policies firmly so they understand the rules</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q3" value="b" class="mt-1 mr-2">
                    <span>Ask them to calm down before you can help them</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q3" value="c" class="mt-1 mr-2">
                    <span>Stay calm, let them express their frustration, and focus on solutions</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q3" value="d" class="mt-1 mr-2">
                    <span>Immediately transfer them to a supervisor</span>
                </label>
            </div>
            <div class="answer-feedback hidden mt-2"></div>
        </div>
        
        <div class="quiz-question">
            <p class="font-medium mb-2">4. Which of the following is a key step in critical thinking for problem-solving?</p>
            <div class="space-y-2">
                <label class="flex items-start">
                    <input type="radio" name="q4" value="a" class="mt-1 mr-2">
                    <span>Always follow standard procedures without deviation</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q4" value="b" class="mt-1 mr-2">
                    <span>Identify the real problem behind the symptoms</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q4" value="c" class="mt-1 mr-2">
                    <span>Implement the first solution that comes to mind</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q4" value="d" class="mt-1 mr-2">
                    <span>Avoid asking additional questions to save time</span>
                </label>
            </div>
            <div class="answer-feedback hidden mt-2"></div>
        </div>
        
        <div class="quiz-question">
            <p class="font-medium mb-2">5. What should you do when you don't know the answer to a customer's question?</p>
            <div class="space-y-2">
                <label class="flex items-start">
                    <input type="radio" name="q5" value="a" class="mt-1 mr-2">
                    <span>Make up an answer to appear knowledgeable</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q5" value="b" class="mt-1 mr-2">
                    <span>Tell them to contact someone else</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q5" value="c" class="mt-1 mr-2">
                    <span>Be honest, assure them you'll find the information, and follow up as promised</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q5" value="d" class="mt-1 mr-2">
                    <span>Change the subject to something you know more about</span>
                </label>
            </div>
            <div class="answer-feedback hidden mt-2"></div>
        </div>
        
        <div class="mt-6">
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 dark:focus:ring-indigo-400">
                Submit Answers
            </button>
        </div>
    </form>
    
    <div id="quiz-results" class="hidden mt-6 p-4 rounded-md">
        <p class="text-lg font-medium">Your Score: <span id="score">0</span>/5</p>
        <p class="mt-2">Correct answers:</p>
        <ul class="list-disc pl-5 mt-1">
            <li>Question 1: Customers whose problems are resolved quickly often become more loyal than those who never had problems.</li>
            <li>Question 2: Empathize</li>
            <li>Question 3: Stay calm, let them express their frustration, and focus on solutions</li>
            <li>Question 4: Identify the real problem behind the symptoms</li>
            <li>Question 5: Be honest, assure them you'll find the information, and follow up as promised</li>
        </ul>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const quizForm = document.getElementById('quiz-form');
    const quizResults = document.getElementById('quiz-results');
    const scoreElement = document.getElementById('score');
    
    const correctAnswers = {
        q1: 'a',
        q2: 'b',
        q3: 'c',
        q4: 'b',
        q5: 'c'
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
        
        if (score === 5) {
            quizResults.classList.add('bg-green-100', 'dark:bg-green-900');
        } else if (score >= 3) {
            quizResults.classList.add('bg-yellow-100', 'dark:bg-yellow-900');
        } else {
            quizResults.classList.add('bg-red-100', 'dark:bg-red-900');
        }
        
        // Send result to server (you would implement this)
        // saveQuizResult(chapterId, score);
    });
});
</script>
