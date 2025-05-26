<div class="lesson-chapter">
    <h2 class="text-2xl font-bold mb-4">Quiz Implementation</h2>
    
    <div class="mb-6">
        <p class="mb-3">Effective quizzes are essential for assessing learner understanding and reinforcing key concepts. This chapter covers best practices for implementing quizzes in the CTBlox platform.</p>
    </div>
    
    <div class="mb-6">
        <h3 class="text-xl font-bold mb-2">Quiz Structure</h3>
        <p class="mb-3">Each quiz should follow a consistent structure:</p>
        
        <ul class="list-disc pl-6 space-y-2 mb-4">
            <li><strong>Clear Instructions:</strong> Provide clear instructions at the beginning of the quiz</li>
            <li><strong>Consistent Question Format:</strong> Use a consistent format for all questions</li>
            <li><strong>Multiple Choice Options:</strong> Provide 3-4 options for each question</li>
            <li><strong>Immediate Feedback:</strong> Show results immediately after submission</li>
            <li><strong>Server Submission:</strong> Send results to the server for tracking progress</li>
        </ul>
    </div>
    
    <div class="mb-6">
        <h3 class="text-xl font-bold mb-2">Question Types</h3>
        <p class="mb-3">The CTBlox platform supports multiple question types:</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-6">
            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
                <h4 class="font-bold text-lg text-indigo-600 dark:text-indigo-400 mb-2">Multiple Choice</h4>
                <p>Questions with a single correct answer from several options. These are the most common question type.</p>
            </div>
            
            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
                <h4 class="font-bold text-lg text-indigo-600 dark:text-indigo-400 mb-2">True/False</h4>
                <p>Simple questions with only two possible answers: true or false.</p>
            </div>
            
            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
                <h4 class="font-bold text-lg text-indigo-600 dark:text-indigo-400 mb-2">Matching</h4>
                <p>Questions that require matching items from two different lists.</p>
            </div>
            
            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
                <h4 class="font-bold text-lg text-indigo-600 dark:text-indigo-400 mb-2">Fill in the Blank</h4>
                <p>Questions where learners must provide a specific word or phrase.</p>
            </div>
        </div>
    </div>
    
    <div class="mb-6">
        <h3 class="text-xl font-bold mb-2">Quiz Implementation</h3>
        <p class="mb-3">To implement a quiz, follow these steps:</p>
        
        <ol class="list-decimal pl-6 space-y-2 mb-4">
            <li>Create a separate PHP file for each chapter quiz (e.g., <code>chapter_name_quiz.php</code>)</li>
            <li>Use the standard HTML structure with proper form elements</li>
            <li>Implement JavaScript for client-side validation and scoring</li>
            <li>Ensure the quiz submits results to the server via AJAX</li>
            <li>Display feedback to the learner after submission</li>
        </ol>
        
        <p class="mb-3">The quiz implementation example in this lesson demonstrates these principles in action.</p>
    </div>
    
    <div class="mt-8 p-4 bg-blue-50 dark:bg-blue-900 rounded-lg">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-6 w-6 text-blue-600 dark:text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">Quiz Best Practice</h3>
                <div class="mt-1 text-sm text-blue-700 dark:text-blue-300">
                    <p>Always test your quizzes thoroughly to ensure they function correctly. Check that the correct answers are properly marked and that the scoring logic works as expected.</p>
                </div>
            </div>
        </div>
    </div>
</div>
