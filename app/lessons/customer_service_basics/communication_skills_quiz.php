<?php
// Quiz for the "Communication Skills" chapter
?>

<div class="quiz-container" data-chapter="communication_skills">
    <h3 class="text-xl font-bold mb-4">Communication Skills Quiz</h3>
    
    <form id="quiz-form" class="space-y-6">
        <div class="quiz-question">
            <p class="font-medium mb-2">1. According to the communication equation, what percentage of meaning comes from the words we use?</p>
            <div class="space-y-2">
                <label class="flex items-start">
                    <input type="radio" name="q1" value="a" class="mt-1 mr-2">
                    <span>7%</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q1" value="b" class="mt-1 mr-2">
                    <span>38%</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q1" value="c" class="mt-1 mr-2">
                    <span>55%</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q1" value="d" class="mt-1 mr-2">
                    <span>100%</span>
                </label>
            </div>
            <div class="answer-feedback hidden mt-2"></div>
        </div>
        
        <div class="quiz-question">
            <p class="font-medium mb-2">2. Which of the following is NOT an element of active listening?</p>
            <div class="space-y-2">
                <label class="flex items-start">
                    <input type="radio" name="q2" value="a" class="mt-1 mr-2">
                    <span>Focusing completely on the customer</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q2" value="b" class="mt-1 mr-2">
                    <span>Asking clarifying questions</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q2" value="c" class="mt-1 mr-2">
                    <span>Finishing the customer's sentences to show understanding</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q2" value="d" class="mt-1 mr-2">
                    <span>Paraphrasing what the customer has said</span>
                </label>
            </div>
            <div class="answer-feedback hidden mt-2"></div>
        </div>
        
        <div class="quiz-question">
            <p class="font-medium mb-2">3. Which of the following is an example of positive language in customer service?</p>
            <div class="space-y-2">
                <label class="flex items-start">
                    <input type="radio" name="q3" value="a" class="mt-1 mr-2">
                    <span>"We can't process your return because you don't have a receipt."</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q3" value="b" class="mt-1 mr-2">
                    <span>"You'll have to wait until next week for a response."</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q3" value="c" class="mt-1 mr-2">
                    <span>"That's not our policy."</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q3" value="d" class="mt-1 mr-2">
                    <span>"Let me show you some alternative ways we can verify your purchase."</span>
                </label>
            </div>
            <div class="answer-feedback hidden mt-2"></div>
        </div>
        
        <div class="quiz-question">
            <p class="font-medium mb-2">4. Which of the following is a way to show empathy in customer service?</p>
            <div class="space-y-2">
                <label class="flex items-start">
                    <input type="radio" name="q4" value="a" class="mt-1 mr-2">
                    <span>"I understand why that would be frustrating."</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q4" value="b" class="mt-1 mr-2">
                    <span>"You need to calm down so we can resolve this."</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q4" value="c" class="mt-1 mr-2">
                    <span>"That's just our policy, there's nothing I can do."</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q4" value="d" class="mt-1 mr-2">
                    <span>"Other customers haven't had this problem."</span>
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
        <p class="text-lg font-medium">Your Score: <span id="score">0</span>/4</p>
        <p class="mt-2">Correct answers:</p>
        <ul class="list-disc pl-5 mt-1">
            <li>Question 1: 7%</li>
            <li>Question 2: Finishing the customer's sentences to show understanding</li>
            <li>Question 3: "Let me show you some alternative ways we can verify your purchase."</li>
            <li>Question 4: "I understand why that would be frustrating."</li>
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
        q2: 'c',
        q3: 'd',
        q4: 'a'
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
