<div class="quiz-container" data-quiz-id="database_error_quiz">
    <h2 class="text-xl font-bold mb-4">Database Connection Error Quiz</h2>
    <p class="mb-6">Test your understanding of WordPress database connection errors and how to fix them.</p>
    
    <form class="space-y-6 quiz-form">
        <!-- Question 1 -->
        <div class="quiz-question" data-question-id="1">
            <fieldset>
                <legend class="text-base font-medium text-gray-900 dark:text-white mb-2">
                    What does the "Error Establishing a Database Connection" message indicate?
                </legend>
                <div class="mt-2 space-y-2">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="q1-a" name="question1" type="radio" value="A" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="q1-a" class="font-medium text-gray-700 dark:text-gray-300">WordPress cannot connect to your database</label>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="q1-b" name="question1" type="radio" value="B" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="q1-b" class="font-medium text-gray-700 dark:text-gray-300">Your website has been hacked</label>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="q1-c" name="question1" type="radio" value="C" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="q1-c" class="font-medium text-gray-700 dark:text-gray-300">Your WordPress installation is corrupted</label>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="q1-d" name="question1" type="radio" value="D" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="q1-d" class="font-medium text-gray-700 dark:text-gray-300">Your theme has a critical error</label>
                        </div>
                    </div>
                </div>
            </fieldset>
            <div class="answer-feedback hidden mt-2"></div>
        </div>
        
        <!-- Question 2 -->
        <div class="quiz-question" data-question-id="2">
            <fieldset>
                <legend class="text-base font-medium text-gray-900 dark:text-white mb-2">
                    Where are WordPress database credentials stored?
                </legend>
                <div class="mt-2 space-y-2">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="q2-a" name="question2" type="radio" value="A" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="q2-a" class="font-medium text-gray-700 dark:text-gray-300">In the .htaccess file</label>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="q2-b" name="question2" type="radio" value="B" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="q2-b" class="font-medium text-gray-700 dark:text-gray-300">In the wp-config.php file</label>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="q2-c" name="question2" type="radio" value="C" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="q2-c" class="font-medium text-gray-700 dark:text-gray-300">In the functions.php file</label>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="q2-d" name="question2" type="radio" value="D" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="q2-d" class="font-medium text-gray-700 dark:text-gray-300">In the wp-settings.php file</label>
                        </div>
                    </div>
                </div>
            </fieldset>
            <div class="answer-feedback hidden mt-2"></div>
        </div>
        
        <!-- Question 3 -->
        <div class="quiz-question" data-question-id="3">
            <fieldset>
                <legend class="text-base font-medium text-gray-900 dark:text-white mb-2">
                    What line should you add to wp-config.php to enable the database repair tool?
                </legend>
                <div class="mt-2 space-y-2">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="q3-a" name="question3" type="radio" value="A" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="q3-a" class="font-medium text-gray-700 dark:text-gray-300">define('WP_ALLOW_REPAIR', true);</label>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="q3-b" name="question3" type="radio" value="B" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="q3-b" class="font-medium text-gray-700 dark:text-gray-300">define('DB_REPAIR', true);</label>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="q3-c" name="question3" type="radio" value="C" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="q3-c" class="font-medium text-gray-700 dark:text-gray-300">define('WP_DEBUG', true);</label>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="q3-d" name="question3" type="radio" value="D" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="q3-d" class="font-medium text-gray-700 dark:text-gray-300">define('REPAIR_DATABASE', true);</label>
                        </div>
                    </div>
                </div>
            </fieldset>
            <div class="answer-feedback hidden mt-2"></div>
        </div>
        
        <!-- Question 4 -->
        <div class="quiz-question" data-question-id="4">
            <fieldset>
                <legend class="text-base font-medium text-gray-900 dark:text-white mb-2">
                    What URL do you visit to access the WordPress database repair tool?
                </legend>
                <div class="mt-2 space-y-2">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="q4-a" name="question4" type="radio" value="A" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="q4-a" class="font-medium text-gray-700 dark:text-gray-300">yourdomain.com/wp-admin/maint/repair.php</label>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="q4-b" name="question4" type="radio" value="B" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="q4-b" class="font-medium text-gray-700 dark:text-gray-300">yourdomain.com/wp-admin/tools.php</label>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="q4-c" name="question4" type="radio" value="C" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="q4-c" class="font-medium text-gray-700 dark:text-gray-300">yourdomain.com/wp-admin/db-repair.php</label>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="q4-d" name="question4" type="radio" value="D" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="q4-d" class="font-medium text-gray-700 dark:text-gray-300">yourdomain.com/wp-admin/options.php</label>
                        </div>
                    </div>
                </div>
            </fieldset>
            <div class="answer-feedback hidden mt-2"></div>
        </div>
        
        <!-- Question 5 -->
        <div class="quiz-question" data-question-id="5">
            <fieldset>
                <legend class="text-base font-medium text-gray-900 dark:text-white mb-2">
                    What should you do if you suspect malware is causing database connection issues?
                </legend>
                <div class="mt-2 space-y-2">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="q5-a" name="question5" type="radio" value="A" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="q5-a" class="font-medium text-gray-700 dark:text-gray-300">Immediately delete all WordPress files</label>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="q5-b" name="question5" type="radio" value="B" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="q5-b" class="font-medium text-gray-700 dark:text-gray-300">Change your database password only</label>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="q5-c" name="question5" type="radio" value="C" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="q5-c" class="font-medium text-gray-700 dark:text-gray-300">Scan your WordPress installation with a security plugin</label>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="q5-d" name="question5" type="radio" value="D" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="q5-d" class="font-medium text-gray-700 dark:text-gray-300">Ignore it and hope it resolves itself</label>
                        </div>
                    </div>
                </div>
            </fieldset>
            <div class="answer-feedback hidden mt-2"></div>
        </div>
        
        <div class="pt-5">
            <div class="flex justify-end">
                <button type="submit" class="submit-quiz ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Submit Answers
                </button>
            </div>
        </div>
    </form>
    
    <div class="quiz-results hidden mt-6">
        <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Quiz Results</h3>
                <div class="mt-2 max-w-xl text-sm text-gray-500 dark:text-gray-400">
                    <p class="results-message"></p>
                </div>
                <div class="mt-3 text-sm">
                    <button type="button" class="retake-quiz font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                        Retake Quiz
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quiz answers
    const quizAnswers = {
        "1": "A", // WordPress cannot connect to your database
        "2": "B", // In the wp-config.php file
        "3": "A", // define('WP_ALLOW_REPAIR', true);
        "4": "A", // yourdomain.com/wp-admin/maint/repair.php
        "5": "C"  // Scan your WordPress installation with a security plugin
    };
    
    // Initialize the quiz using the standardized quiz system
    if (typeof initQuiz === 'function') {
        initQuiz('database_error_quiz', quizAnswers);
    } else {
        console.error('Quiz system not loaded. Please refresh the page.');
    }
});
</script>
