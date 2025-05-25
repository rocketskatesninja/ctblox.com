<div class="p-4">
    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Emotional Intelligence Quiz</h3>
    <form onsubmit="return submitQuiz(this)">
        <input type="hidden" name="chapter_id" value="emotional_intelligence">
        
        <div class="space-y-4 mb-6">
            <div class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow">
                <p class="font-medium text-gray-900 dark:text-white mb-2">1. Which of the following is NOT one of the four components of emotional intelligence discussed in the chapter?</p>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="radio" name="q1" value="a" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300" required>
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Self-Awareness</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="q1" value="b" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Self-Management</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="q1" value="c" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Self-Promotion</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="q1" value="d" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Relationship Management</span>
                    </label>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow">
                <p class="font-medium text-gray-900 dark:text-white mb-2">2. According to the chapter, what is the difference between sympathy and empathy?</p>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="radio" name="q2" value="a" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300" required>
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Sympathy is feeling pity for someone, while empathy is understanding and sharing their feelings</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="q2" value="b" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Sympathy is more intense than empathy</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="q2" value="c" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Sympathy and empathy are different words for the same concept</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="q2" value="d" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Empathy is feeling sorry for someone, while sympathy is understanding their perspective</span>
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
