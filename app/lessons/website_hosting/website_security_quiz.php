<div class="quiz-container">
    <h2 class="text-2xl font-bold mb-4">Website Security Quiz</h2>
    <p class="mb-6">Test your knowledge of website security concepts and best practices.</p>
    
    <form id="quiz-form" class="space-y-6">
        <div class="quiz-question bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
            <p class="font-medium text-lg mb-3">1. Which of the following is a common website security threat that involves injecting malicious code into database queries?</p>
            <div class="space-y-2">
                <label class="flex items-start">
                    <input type="radio" name="q1" value="a" class="mt-1 mr-2">
                    <span>Cross-Site Scripting (XSS)</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q1" value="b" class="mt-1 mr-2">
                    <span>SQL Injection</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q1" value="c" class="mt-1 mr-2">
                    <span>Phishing</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q1" value="d" class="mt-1 mr-2">
                    <span>Brute Force Attack</span>
                </label>
            </div>
            <div class="answer-feedback hidden mt-3 p-3 rounded-lg"></div>
        </div>

        <div class="quiz-question bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
            <p class="font-medium text-lg mb-3">2. Why is it important to keep your website's software updated?</p>
            <div class="space-y-2">
                <label class="flex items-start">
                    <input type="radio" name="q2" value="a" class="mt-1 mr-2">
                    <span>To access new features only</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q2" value="b" class="mt-1 mr-2">
                    <span>To improve website speed only</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q2" value="c" class="mt-1 mr-2">
                    <span>Because many security breaches occur through known vulnerabilities that have been patched in newer versions</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q2" value="d" class="mt-1 mr-2">
                    <span>To comply with hosting provider requirements only</span>
                </label>
            </div>
            <div class="answer-feedback hidden mt-3 p-3 rounded-lg"></div>
        </div>

        <div class="quiz-question bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
            <p class="font-medium text-lg mb-3">3. What is two-factor authentication (2FA)?</p>
            <div class="space-y-2">
                <label class="flex items-start">
                    <input type="radio" name="q3" value="a" class="mt-1 mr-2">
                    <span>Using two different passwords for the same account</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q3" value="b" class="mt-1 mr-2">
                    <span>Having two administrators approve all changes</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q3" value="c" class="mt-1 mr-2">
                    <span>Requiring a second verification method (like a code sent to your phone) in addition to your password</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q3" value="d" class="mt-1 mr-2">
                    <span>Logging in from two different devices simultaneously</span>
                </label>
            </div>
            <div class="answer-feedback hidden mt-3 p-3 rounded-lg"></div>
        </div>

        <div class="quiz-question bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
            <p class="font-medium text-lg mb-3">4. What does SSL/TLS encryption do for your website?</p>
            <div class="space-y-2">
                <label class="flex items-start">
                    <input type="radio" name="q4" value="a" class="mt-1 mr-2">
                    <span>Encrypts the connection between visitors' browsers and your website</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q4" value="b" class="mt-1 mr-2">
                    <span>Encrypts your database only</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q4" value="c" class="mt-1 mr-2">
                    <span>Blocks all malicious traffic automatically</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q4" value="d" class="mt-1 mr-2">
                    <span>Prevents unauthorized admin access</span>
                </label>
            </div>
            <div class="answer-feedback hidden mt-3 p-3 rounded-lg"></div>
        </div>

        <div class="quiz-question bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
            <p class="font-medium text-lg mb-3">5. What is a Web Application Firewall (WAF)?</p>
            <div class="space-y-2">
                <label class="flex items-start">
                    <input type="radio" name="q5" value="a" class="mt-1 mr-2">
                    <span>A physical device that protects your server hardware</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q5" value="b" class="mt-1 mr-2">
                    <span>A tool that filters and monitors HTTP traffic between a web application and the Internet</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q5" value="c" class="mt-1 mr-2">
                    <span>A backup system for your website files</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q5" value="d" class="mt-1 mr-2">
                    <span>Software that speeds up your website loading time</span>
                </label>
            </div>
            <div class="answer-feedback hidden mt-3 p-3 rounded-lg"></div>
        </div>

        <div class="quiz-question bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
            <p class="font-medium text-lg mb-3">6. Which of the following is a best practice for website backups?</p>
            <div class="space-y-2">
                <label class="flex items-start">
                    <input type="radio" name="q6" value="a" class="mt-1 mr-2">
                    <span>Store all backups only on your web server</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q6" value="b" class="mt-1 mr-2">
                    <span>Back up only your website files, not databases</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q6" value="c" class="mt-1 mr-2">
                    <span>Keep only the most recent backup</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q6" value="d" class="mt-1 mr-2">
                    <span>Store backups in multiple locations and test restoring from them periodically</span>
                </label>
            </div>
            <div class="answer-feedback hidden mt-3 p-3 rounded-lg"></div>
        </div>

        <div class="quiz-question bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
            <p class="font-medium text-lg mb-3">7. What is a DDoS attack?</p>
            <div class="space-y-2">
                <label class="flex items-start">
                    <input type="radio" name="q7" value="a" class="mt-1 mr-2">
                    <span>An attack that steals customer credit card information</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q7" value="b" class="mt-1 mr-2">
                    <span>An attack that overwhelms your server with traffic from multiple sources</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q7" value="c" class="mt-1 mr-2">
                    <span>An attack that changes your website content without permission</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q7" value="d" class="mt-1 mr-2">
                    <span>An attack that deletes your website database</span>
                </label>
            </div>
            <div class="answer-feedback hidden mt-3 p-3 rounded-lg"></div>
        </div>

        <div class="quiz-question bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
            <p class="font-medium text-lg mb-3">8. What should be your first step if your website is compromised?</p>
            <div class="space-y-2">
                <label class="flex items-start">
                    <input type="radio" name="q8" value="a" class="mt-1 mr-2">
                    <span>Immediately notify all customers</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q8" value="b" class="mt-1 mr-2">
                    <span>Change your hosting provider</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q8" value="c" class="mt-1 mr-2">
                    <span>Isolate the problem (take the site offline if necessary)</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q8" value="d" class="mt-1 mr-2">
                    <span>Rebuild the entire website from scratch</span>
                </label>
            </div>
            <div class="answer-feedback hidden mt-3 p-3 rounded-lg"></div>
        </div>

        <div class="quiz-question bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
            <p class="font-medium text-lg mb-3">9. Which of the following is NOT a recommended WordPress security measure?</p>
            <div class="space-y-2">
                <label class="flex items-start">
                    <input type="radio" name="q9" value="a" class="mt-1 mr-2">
                    <span>Using security plugins like Wordfence or Sucuri</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q9" value="b" class="mt-1 mr-2">
                    <span>Limiting login attempts</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q9" value="c" class="mt-1 mr-2">
                    <span>Keeping the default "admin" username</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q9" value="d" class="mt-1 mr-2">
                    <span>Removing inactive themes and plugins</span>
                </label>
            </div>
            <div class="answer-feedback hidden mt-3 p-3 rounded-lg"></div>
        </div>

        <div class="quiz-question bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
            <p class="font-medium text-lg mb-3">10. What regulations might require specific security measures and breach notifications for websites that collect personal data?</p>
            <div class="space-y-2">
                <label class="flex items-start">
                    <input type="radio" name="q10" value="a" class="mt-1 mr-2">
                    <span>GDPR and CCPA</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q10" value="b" class="mt-1 mr-2">
                    <span>HTML and CSS</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q10" value="c" class="mt-1 mr-2">
                    <span>HTTP and HTTPS</span>
                </label>
                <label class="flex items-start">
                    <input type="radio" name="q10" value="d" class="mt-1 mr-2">
                    <span>FTP and SFTP</span>
                </label>
            </div>
            <div class="answer-feedback hidden mt-3 p-3 rounded-lg"></div>
        </div>

        <button type="submit" class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition duration-200">Submit Answers</button>
    </form>

    <div id="quiz-results" class="mt-6 hidden">
        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
            <h3 class="text-xl font-bold mb-2">Quiz Results</h3>
            <p class="score-display mb-4">You scored: <span id="score">0</span> out of 10</p>
            <div id="pass-message" class="hidden p-3 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-lg mb-4">
                Congratulations! You've passed this quiz.
            </div>
            <div id="fail-message" class="hidden p-3 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 rounded-lg mb-4">
                You didn't pass this time. Review the chapter and try again.
            </div>
            <button id="retry-button" class="py-2 px-4 bg-gray-600 hover:bg-gray-700 text-white font-bold rounded-lg transition duration-200">Retry Quiz</button>
            <button id="review-button" class="ml-2 py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition duration-200">Review Answers</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const quizForm = document.getElementById('quiz-form');
    const quizResults = document.getElementById('quiz-results');
    const scoreDisplay = document.getElementById('score');
    const passMessage = document.getElementById('pass-message');
    const failMessage = document.getElementById('fail-message');
    const retryButton = document.getElementById('retry-button');
    const reviewButton = document.getElementById('review-button');
    
    const correctAnswers = {
        q1: 'b', // SQL Injection
        q2: 'c', // Because many security breaches occur through known vulnerabilities that have been patched in newer versions
        q3: 'c', // Requiring a second verification method (like a code sent to your phone) in addition to your password
        q4: 'a', // Encrypts the connection between visitors' browsers and your website
        q5: 'b', // A tool that filters and monitors HTTP traffic between a web application and the Internet
        q6: 'd', // Store backups in multiple locations and test restoring from them periodically
        q7: 'b', // An attack that overwhelms your server with traffic from multiple sources
        q8: 'c', // Isolate the problem (take the site offline if necessary)
        q9: 'c', // Keeping the default "admin" username
        q10: 'a' // GDPR and CCPA
    };
    
    const feedbackMessages = {
        q1: {
            correct: "Correct! SQL Injection involves inserting malicious SQL code into database queries to gain unauthorized access to data.",
            incorrect: "Incorrect. SQL Injection involves inserting malicious SQL code into database queries to gain unauthorized access to data."
        },
        q2: {
            correct: "Correct! Many security breaches occur through known vulnerabilities that have been patched in newer versions. Hackers specifically target outdated software.",
            incorrect: "Incorrect. Many security breaches occur through known vulnerabilities that have been patched in newer versions. Hackers specifically target outdated software."
        },
        q3: {
            correct: "Correct! Two-factor authentication adds an extra layer of security by requiring a second verification method in addition to your password.",
            incorrect: "Incorrect. Two-factor authentication adds an extra layer of security by requiring a second verification method (like a code sent to your phone) in addition to your password."
        },
        q4: {
            correct: "Correct! SSL/TLS encrypts the connection between visitors' browsers and your website, protecting data during transmission.",
            incorrect: "Incorrect. SSL/TLS encrypts the connection between visitors' browsers and your website, protecting data during transmission."
        },
        q5: {
            correct: "Correct! A Web Application Firewall (WAF) filters and monitors HTTP traffic between a web application and the Internet, blocking malicious traffic.",
            incorrect: "Incorrect. A Web Application Firewall (WAF) filters and monitors HTTP traffic between a web application and the Internet, blocking malicious traffic."
        },
        q6: {
            correct: "Correct! Storing backups in multiple locations and testing restores periodically ensures you can recover from various disaster scenarios.",
            incorrect: "Incorrect. Storing backups in multiple locations and testing restores periodically ensures you can recover from various disaster scenarios."
        },
        q7: {
            correct: "Correct! A DDoS (Distributed Denial of Service) attack overwhelms your server with traffic from multiple sources, making your website unavailable.",
            incorrect: "Incorrect. A DDoS (Distributed Denial of Service) attack overwhelms your server with traffic from multiple sources, making your website unavailable."
        },
        q8: {
            correct: "Correct! The first step should be to isolate the problem, which may include taking the site offline to prevent further damage.",
            incorrect: "Incorrect. The first step should be to isolate the problem, which may include taking the site offline to prevent further damage."
        },
        q9: {
            correct: "Correct! Keeping the default 'admin' username is NOT recommended as it makes it easier for attackers to guess one half of your login credentials.",
            incorrect: "Incorrect. Keeping the default 'admin' username is NOT recommended as it makes it easier for attackers to guess one half of your login credentials."
        },
        q10: {
            correct: "Correct! GDPR (General Data Protection Regulation) in Europe and CCPA (California Consumer Privacy Act) are regulations that require specific security measures and breach notifications.",
            incorrect: "Incorrect. GDPR (General Data Protection Regulation) in Europe and CCPA (California Consumer Privacy Act) are regulations that require specific security measures and breach notifications."
        }
    };
    
    quizForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        let score = 0;
        const questions = document.querySelectorAll('.quiz-question');
        
        questions.forEach((question, index) => {
            const questionNumber = index + 1;
            const selectedAnswer = document.querySelector(`input[name="q${questionNumber}"]:checked`);
            const feedbackDiv = question.querySelector('.answer-feedback');
            
            if (selectedAnswer) {
                if (selectedAnswer.value === correctAnswers[`q${questionNumber}`]) {
                    score++;
                    feedbackDiv.textContent = feedbackMessages[`q${questionNumber}`].correct;
                    feedbackDiv.classList.add('bg-green-100', 'dark:bg-green-900', 'text-green-700', 'dark:text-green-300');
                } else {
                    feedbackDiv.textContent = feedbackMessages[`q${questionNumber}`].incorrect;
                    feedbackDiv.classList.add('bg-red-100', 'dark:bg-red-900', 'text-red-700', 'dark:text-red-300');
                }
                feedbackDiv.classList.remove('hidden');
            }
        });
        
        scoreDisplay.textContent = score;
        
        if (score >= 7) {
            passMessage.classList.remove('hidden');
            failMessage.classList.add('hidden');
        } else {
            passMessage.classList.add('hidden');
            failMessage.classList.remove('hidden');
        }
        
        quizForm.classList.add('hidden');
        quizResults.classList.remove('hidden');
        
        // Send result to server
        const lessonId = 'website_hosting';
        const chapterId = 'website_security';
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/app/controllers/quiz_controller.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(`action=submit_result&lesson_id=${lessonId}&chapter_id=${chapterId}&score=${score}&total=10`);
    });
    
    retryButton.addEventListener('click', function() {
        // Reset the form
        quizForm.reset();
        
        // Hide all feedback
        const feedbackDivs = document.querySelectorAll('.answer-feedback');
        feedbackDivs.forEach(div => {
            div.classList.add('hidden');
            div.classList.remove(
                'bg-green-100', 'dark:bg-green-900', 'text-green-700', 'dark:text-green-300',
                'bg-red-100', 'dark:bg-red-900', 'text-red-700', 'dark:text-red-300'
            );
        });
        
        // Show the form again
        quizForm.classList.remove('hidden');
        quizResults.classList.add('hidden');
    });
    
    reviewButton.addEventListener('click', function() {
        quizForm.classList.remove('hidden');
        // Keep results visible for reference
    });
});
</script>
