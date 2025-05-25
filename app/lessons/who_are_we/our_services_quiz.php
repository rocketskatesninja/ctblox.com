<?php
// Quiz for the "Our Services" chapter
?>

<div class="quiz-container" data-chapter="our_services">
    <h3 class="text-xl font-bold mb-4">Our Services Quiz</h3>
    
    <form id="quiz-form" class="space-y-6" onsubmit="return submitQuiz(this)">
        <input type="hidden" name="chapter_id" value="our_services">
        
        <div class="quiz-question">
            <p class="font-medium mb-2">1. What are the three main service areas provided by Corporate Tools?</p>
            <div class="space-y-2">
                <label class="flex items-start">
                    <input type="radio" name="q1" value="a" class="mt-1 mr-2" required>
                    <span>Legal, Accounting, and Marketing</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q1" value="b" class="mt-1 mr-2">
                    <span>Software Solutions, Logistics, and Customer Service</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q1" value="c" class="mt-1 mr-2">
                    <span>Hardware, Software, and Consulting</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q1" value="d" class="mt-1 mr-2">
                    <span>Training, Development, and Support</span>
                </label>
            </div>
        </div>
        
        <div class="quiz-question">
            <p class="font-medium mb-2">2. What is a key feature of Corporate Tools' software solutions?</p>
            <div class="space-y-2">
                <label class="flex items-start">
                    <input type="radio" name="q2" value="a" class="mt-1 mr-2" required>
                    <span>Social media integration</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q2" value="b" class="mt-1 mr-2">
                    <span>Mobile app development</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q2" value="c" class="mt-1 mr-2">
                    <span>Document automation</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q2" value="d" class="mt-1 mr-2">
                    <span>Website hosting</span>
                </label>
            </div>
        </div>
        
        <div class="quiz-question">
            <p class="font-medium mb-2">3. What sets Corporate Tools apart from other solutions?</p>
            <div class="space-y-2">
                <label class="flex items-start">
                    <input type="radio" name="q3" value="a" class="mt-1 mr-2" required>
                    <span>Lowest prices in the industry</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q3" value="b" class="mt-1 mr-2">
                    <span>Exclusive partnerships with government agencies</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q3" value="c" class="mt-1 mr-2">
                    <span>The combination of powerful software with expert human support</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q3" value="d" class="mt-1 mr-2">
                    <span>The ability to offer services only in the United States</span>
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
                <li>1. Software Solutions, Logistics, and Customer Service</li>
                <li>2. Document automation</li>
                <li>3. The combination of powerful software with expert human support</li>
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
