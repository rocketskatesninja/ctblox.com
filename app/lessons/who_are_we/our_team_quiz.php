<?php
// Quiz for the "Our Team" chapter
?>

<div class="quiz-container" data-chapter="our_team">
    <h3 class="text-xl font-bold mb-4">Our Team Quiz</h3>
    
    <form id="quiz-form" class="space-y-6" onsubmit="return submitQuiz(this)">
        <input type="hidden" name="chapter_id" value="our_team">
        
        <div class="quiz-question">
            <p class="font-medium mb-2">1. Where are many of Corporate Tools' team members based?</p>
            <div class="space-y-2">
                <label class="flex items-start">
                    <input type="radio" name="q1" value="a" class="mt-1 mr-2" required>
                    <span>New York City, New York</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q1" value="b" class="mt-1 mr-2">
                    <span>Post Falls, Idaho and surrounding areas</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q1" value="c" class="mt-1 mr-2">
                    <span>San Francisco, California</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q1" value="d" class="mt-1 mr-2">
                    <span>Austin, Texas</span>
                </label>
            </div>
        </div>
        
        <div class="quiz-question">
            <p class="font-medium mb-2">2. Which of the following work arrangements does Corporate Tools offer?</p>
            <div class="space-y-2">
                <label class="flex items-start">
                    <input type="radio" name="q2" value="a" class="mt-1 mr-2" required>
                    <span>Only on-site positions</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q2" value="b" class="mt-1 mr-2">
                    <span>Only remote positions</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q2" value="c" class="mt-1 mr-2">
                    <span>On-site, hybrid, and fully remote positions</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q2" value="d" class="mt-1 mr-2">
                    <span>Seasonal positions only</span>
                </label>
            </div>
        </div>
        
        <div class="quiz-question">
            <p class="font-medium mb-2">3. What is the primary role of the Client Experience Team?</p>
            <div class="space-y-2">
                <label class="flex items-start">
                    <input type="radio" name="q3" value="a" class="mt-1 mr-2" required>
                    <span>To develop new software features</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q3" value="b" class="mt-1 mr-2">
                    <span>To manage the company's finances</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q3" value="c" class="mt-1 mr-2">
                    <span>To ensure that every interaction with Corporate Tools exceeds expectations</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q3" value="d" class="mt-1 mr-2">
                    <span>To handle legal compliance matters</span>
                </label>
            </div>
        </div>
        
        <div class="mt-6">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Submit Answers
            </button>
        </div>
    </form>
    
    <div id="quiz-results" class="mt-6 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg hidden">
        <h4 class="font-bold text-lg mb-2">Your Results</h4>
        <p>You scored <span id="score" class="font-bold">0</span> out of 3</p>
        
        <div class="mt-4">
            <h5 class="font-semibold mb-2">Correct Answers:</h5>
            <ul class="list-disc pl-5 space-y-1">
                <li>1. Post Falls, Idaho and surrounding areas</li>
                <li>2. On-site, hybrid, and fully remote positions</li>
                <li>3. To ensure that every interaction with Corporate Tools exceeds expectations</li>
            </ul>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const quizForm = document.getElementById('quiz-form');
    const quizResults = document.getElementById('quiz-results');
    const scoreElement = document.getElementById('score');
    
    window.submitQuiz = function(form) {
        // Get all the answers
        const answers = {
            q1: form.q1.value,
            q2: form.q2.value,
            q3: form.q3.value
        };
        
        // Correct answers
        const correctAnswers = {
            q1: 'b',
            q2: 'c',
            q3: 'c'
        };
        
        // Calculate score
        let score = 0;
        for (const question in answers) {
            if (answers[question] === correctAnswers[question]) {
                score++;
            }
        }
        
        // Display results
        scoreElement.textContent = score;
        quizResults.classList.remove('hidden');
        
        // Send result to server
        const chapterId = form.chapter_id.value;
        fetch('/lesson/quiz-result', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                chapter_id: chapterId,
                score: score,
                total: Object.keys(correctAnswers).length
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Quiz result saved:', data);
        })
        .catch(error => {
            console.error('Error saving quiz result:', error);
        });
        
        return false; // Prevent form submission
    };
});
</script>
