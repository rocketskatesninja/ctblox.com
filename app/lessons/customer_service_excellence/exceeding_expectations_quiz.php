<div class="p-4">
    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Exceeding Expectations Quiz</h3>
    <form onsubmit="return submitQuiz(this)">
        <input type="hidden" name="chapter_id" value="exceeding_expectations">
        
        <div class="space-y-4 mb-6">
            <div class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow">
                <p class="font-medium text-gray-900 dark:text-white mb-2">1. According to the chapter, what is the relationship between customer satisfaction and expectations?</p>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="radio" name="q1" value="a" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300" required>
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Customer satisfaction is determined by the gap between what customers expect and what they actually experience</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="q1" value="b" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Customer satisfaction is based solely on the quality of the product or service</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="q1" value="c" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Customer satisfaction is unrelated to customer expectations</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="q1" value="d" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Customer satisfaction is determined by price alone</span>
                    </label>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow">
                <p class="font-medium text-gray-900 dark:text-white mb-2">2. What strategy involves setting realistic expectations and then delivering more than promised?</p>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="radio" name="q2" value="a" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300" required>
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Creating memorable moments</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="q2" value="b" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Under-promising and over-delivering</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="q2" value="c" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Personalizing the experience</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="q2" value="d" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Adding unexpected value</span>
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
