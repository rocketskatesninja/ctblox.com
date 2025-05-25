<div class="p-4">
    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Service Recovery Quiz</h3>
    <form onsubmit="return submitQuiz(this)">
        <input type="hidden" name="chapter_id" value="service_recovery">
        
        <div class="space-y-4 mb-6">
            <div class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow">
                <p class="font-medium text-gray-900 dark:text-white mb-2">1. What is the "service recovery paradox" described in the chapter?</p>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="radio" name="q1" value="a" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300" required>
                        <span class="ml-2 text-gray-700 dark:text-gray-300">The idea that service failures are inevitable in any business</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="q1" value="b" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">The phenomenon where customers who experience a service failure that is effectively resolved can become more loyal than customers who never experienced a problem</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="q1" value="c" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">The contradiction between what customers say they want and what actually satisfies them</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="q1" value="d" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">The challenge of recovering from service failures without spending too much money</span>
                    </label>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow">
                <p class="font-medium text-gray-900 dark:text-white mb-2">2. What does the "T" stand for in the LAST model for service recovery?</p>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="radio" name="q2" value="a" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300" required>
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Train</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="q2" value="b" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Test</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="q2" value="c" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Thank</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="q2" value="d" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Track</span>
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
