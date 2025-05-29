<?php $title = $lesson['title']; ?>
<?php require_once __DIR__ . '/../../includes/header.php'; ?>

<!-- Add meta tags for the quiz system -->
<meta name="lesson-id" content="<?= $lesson['id'] ?>">
<meta name="csrf-token" content="<?= $csrf_token ?>">


<!-- Include the standardized quiz system -->
<script src="/js/quiz-system.js" id="quiz-system-script" data-loaded="true"></script>

<!-- Override dark backgrounds in lesson content when in light mode -->
<style>
    /* Comprehensive solution to fix all dark backgrounds in lesson content */
    
    /* Force light background on the main content area */
    :root:not(.dark) main,
    :root:not(.dark) .prose,
    :root:not(.dark) .chapter-content,
    :root:not(.dark) .lesson-chapter,
    :root:not(.dark) [class*="bg-gray-"],
    :root:not(.dark) [class*="dark:bg-gray-"] {
        background-color: #ffffff !important;
        color: #1f2937 !important;
    }
    
    /* Override all background colors in lesson content */
    :root:not(.dark) * {
        --tw-bg-opacity: 1 !important;
    }
    
    /* Target specific dark backgrounds */
    :root:not(.dark) .bg-gray-700,
    :root:not(.dark) .bg-gray-800,
    :root:not(.dark) .bg-gray-900,
    :root:not(.dark) .dark\:bg-gray-700,
    :root:not(.dark) .dark\:bg-gray-800,
    :root:not(.dark) .dark\:bg-gray-900 {
        background-color: #f9fafb !important;
    }
    
    /* Fix colored boxes in light mode */
    :root:not(.dark) .bg-blue-900,
    :root:not(.dark) .dark\:bg-blue-900 {
        background-color: #eff6ff !important;
    }
    
    :root:not(.dark) .bg-green-900,
    :root:not(.dark) .dark\:bg-green-900 {
        background-color: #ecfdf5 !important;
    }
    
    :root:not(.dark) .bg-yellow-900,
    :root:not(.dark) .dark\:bg-yellow-900 {
        background-color: #fffbeb !important;
    }
    
    :root:not(.dark) .bg-red-900,
    :root:not(.dark) .dark\:bg-red-900 {
        background-color: #fef2f2 !important;
    }
    
    /* Fix all text colors in light mode */
    :root:not(.dark) h1,
    :root:not(.dark) h2,
    :root:not(.dark) h3,
    :root:not(.dark) h4,
    :root:not(.dark) h5,
    :root:not(.dark) h6,
    :root:not(.dark) strong,
    :root:not(.dark) .text-gray-900,
    :root:not(.dark) .dark\:text-white {
        color: #111827 !important;
    }
    
    :root:not(.dark) p,
    :root:not(.dark) li,
    :root:not(.dark) span,
    :root:not(.dark) .text-gray-500,
    :root:not(.dark) .dark\:text-gray-400 {
        color: #374151 !important;
    }
    
    /* Fix specific text colors */
    :root:not(.dark) .text-white,
    :root:not(.dark) .dark\:text-white {
        color: #111827 !important;
    }
    
    /* Override any inline styles */
    :root:not(.dark) [style*="background-color"] {
        background-color: #ffffff !important;
    }
    
    :root:not(.dark) [style*="color: white"],
    :root:not(.dark) [style*="color:#fff"],
    :root:not(.dark) [style*="color: #fff"] {
        color: #111827 !important;
    }
    
    /* Ensure proper contrast for links */
    :root:not(.dark) a,
    :root:not(.dark) .text-blue-500,
    :root:not(.dark) .text-indigo-500,
    :root:not(.dark) .dark\:text-blue-400,
    :root:not(.dark) .dark\:text-indigo-400 {
        color: #2563eb !important;
    }
</style>

<div class="flex h-screen overflow-hidden bg-white dark:bg-gray-900" x-data="{ sidebarOpen: true }">
    <!-- Sidebar -->
    <div x-show="sidebarOpen" 
         class="md:flex md:flex-shrink-0">
        <div class="flex flex-col w-64">
            <div class="flex flex-col h-0 flex-1">
                <div class="flex items-center h-16 flex-shrink-0 px-4 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                        <?= $this->sanitize($lesson['title']) ?>
                    </h2>
                </div>
                <div class="flex-1 flex flex-col overflow-y-auto">
                    <nav class="flex-1 px-2 py-4 bg-white dark:bg-gray-800 space-y-1">
                        <?php 
                        $allPreviousCompleted = true; // Track if all previous chapters are completed
                        foreach ($lesson['chapters'] as $index => $chapter): 
                            $isCompleted = isset($progress[$chapter['id']]) && $progress[$chapter['id']];
                            $hasQuiz = isset($quizResults[$chapter['id']]);
                            $isDisabled = !$allPreviousCompleted && !$isCompleted;
                            
                            // If current chapter is not completed, future chapters will be disabled
                            if (!$isCompleted && $allPreviousCompleted) {
                                $allPreviousCompleted = false;
                            }
                        ?>
                            <?php if ($isDisabled): ?>
                                <div class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-400 dark:text-gray-600 cursor-not-allowed">
                                    <span class="truncate"><?= $this->sanitize($chapter['title']) ?></span>
                                    <span class="ml-auto inline-block">
                                        <svg class="h-5 w-5 text-gray-400 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </span>
                                </div>
                            <?php else: ?>
                                <a href="#<?= $chapter['id'] ?>" 
                                   data-chapter="<?= $chapter['id'] ?>"
                                   class="chapter-link group flex items-center px-2 py-2 text-sm font-medium rounded-md <?= $isCompleted ? 'text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' ?>">
                                    <span class="truncate"><?= $this->sanitize($chapter['title']) ?></span>
                                    <?php if ($isCompleted): ?>
                                        <span class="ml-auto inline-block">
                                            <svg class="h-5 w-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                        </span>
                                    <?php endif; ?>
                                    <?php if ($hasQuiz): ?>
                                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300">
                                            <?= $quizResults[$chapter['id']] ?>%
                                        </span>
                                    <?php endif; ?>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Content area -->
    <div class="flex flex-col w-0 flex-1 overflow-hidden">
        <div class="relative z-10 flex-shrink-0 flex h-16 bg-white dark:bg-gray-800 shadow">
            <button @click="sidebarOpen = !sidebarOpen" class="px-4 border-r border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 dark:focus:ring-indigo-400 md:hidden">
                <span class="sr-only">Open sidebar</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                </svg>
            </button>
            <div class="flex-1 px-4 flex justify-between">
                <div class="flex-1 flex">
                    <div class="w-full flex md:ml-0">
                        <div class="relative w-full flex items-center">
                            <div class="absolute left-3 top-0 bottom-0 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <input id="search" 
                                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md leading-5 bg-white dark:bg-gray-700 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 sm:text-sm h-10" 
                                   style="padding-left: 40px;" 
                                   placeholder="Search lesson..." 
                                   type="search">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <main class="flex-1 relative overflow-y-auto focus:outline-none">
            <div class="py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                    <div class="pb-5 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <h1 class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl sm:truncate">
                                <?= $this->sanitize($lesson['title']) ?>
                            </h1>
                            <div class="flex">
                                <?php if ($lesson['author']): ?>
                                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                        Author: <?= $this->sanitize($lesson['author']) ?>
                                    </span>
                                <?php endif; ?>
                                <span class="ml-3 inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                    Version <?= $this->sanitize($lesson['version']) ?>
                                </span>
                            </div>
                        </div>
                        <p class="mt-2 max-w-4xl text-sm text-gray-500 dark:text-gray-400">
                            <?= $this->sanitize($lesson['description']) ?>
                        </p>
                    </div>

                    <div class="py-4">
                        <?php 
                        $allPreviousCompleted = true; // Track if all previous chapters are completed
                        foreach ($lesson['chapters'] as $index => $chapter): 
                            $isCompleted = isset($progress[$chapter['id']]) && $progress[$chapter['id']];
                            $isDisabled = !$allPreviousCompleted && !$isCompleted;
                            
                            // If current chapter is not completed, future chapters will be disabled
                            if (!$isCompleted && $allPreviousCompleted) {
                                $allPreviousCompleted = false;
                            }
                            
                            // Get the next chapter ID for auto-scrolling
                            $nextChapterId = isset($lesson['chapters'][$index + 1]) ? $lesson['chapters'][$index + 1]['id'] : null;
                        ?>
                            <?php if ($index > 0): ?>
                                <hr class="my-12 border-t-2 border-gray-200 dark:border-gray-700">
                            <?php endif; ?>
                            <div id="<?= $chapter['id'] ?>" class="chapter-content mb-16 <?= $isDisabled ? 'opacity-50' : '' ?>">
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                                    <?php if ($isDisabled): ?>
                                        <svg class="h-5 w-5 text-gray-400 dark:text-gray-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                        </svg>
                                    <?php endif; ?>
                                    <?= $this->sanitize($chapter['title']) ?>
                                </h2>
                                
                                <div class="prose dark:prose-invert max-w-none <?= $isDisabled ? 'blur-sm pointer-events-none' : '' ?>">
                                    <?php if (!$isDisabled): ?>
                                        <?php include LESSONS_PATH . '/' . $lesson['filename'] . '/' . $chapter['id'] . '.php'; ?>
                                    <?php else: ?>
                                        <div class="text-center py-10">
                                            <p class="text-gray-500 dark:text-gray-400">Complete previous chapters to unlock this content.</p>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Quiz section moved to chapter completion flow -->

                                <!-- Chapter subsection navigation -->
                                <div class="mb-8" id="chapter-subsections">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Chapter Sections</h3>
                                    <div class="subsection-links space-y-2"></div>
                                </div>
                                
                                <div class="mt-6">
                                    <?php if (!$isDisabled): ?>
                                        <?php if (isset($progress[$chapter['id']]) && $progress[$chapter['id']]): ?>
                                            <div class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 dark:bg-green-700">
                                                <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                Completed
                                            </div>
                                        <?php elseif (isset($quizResults[$chapter['id']])): ?>
                                            <?php if ($quizResults[$chapter['id']] >= 80): ?>
                                                <form action="/lesson/progress" method="POST" class="inline-block complete-form" data-next-chapter="<?= $nextChapterId ?>">
                                                    <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= $csrf_token ?>">
                                                    <input type="hidden" name="lesson_id" value="<?= $lesson['id'] ?>">
                                                    <input type="hidden" name="chapter_id" value="<?= $chapter['id'] ?>">
                                                    <input type="hidden" name="completed" value="1">
                                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 dark:focus:ring-indigo-400">
                                                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                        Mark as Complete
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <div class="text-sm text-red-600 dark:text-red-400 mb-2">You need to score at least 80% on the quiz to complete this chapter.</div>
                                                <button type="button" 
                                                        onclick="startQuiz('<?= $chapter['id'] ?>')"
                                                        class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 dark:focus:ring-indigo-400">
                                                    Retake Quiz
                                                </button>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-2">Complete the quiz to unlock this chapter.</div>
                                            <button type="button" 
                                                    onclick="startQuiz('<?= $chapter['id'] ?>')"
                                                    class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 dark:focus:ring-indigo-400">
                                                Take Quiz
                                            </button>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <div class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md shadow-sm text-gray-400 dark:text-gray-500 bg-gray-100 dark:bg-gray-800 cursor-not-allowed">
                                            <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                            </svg>
                                            Complete Previous Chapters First
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <?php if ($allChaptersCompleted): ?>
                        <!-- Lesson Feedback Form -->
                        <hr class="my-12 border-t-2 border-gray-200 dark:border-gray-700">
                        <div id="lesson-feedback-section" class="mb-16">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Lesson Feedback</h2>
                            <?php 
                            // Include the feedback form template
                            $lessonId = $lesson['id'];
                            include __DIR__ . '/../../templates/feedback_form.php';
                            ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Quiz Modal -->
<div id="quiz-modal" 
     x-data="{ 
         open: false, 
         currentQuiz: null,
         init() {
             document.addEventListener('open-quiz-modal', (event) => {
                 this.currentQuiz = event.detail.chapterId;
                 this.open = true;
             });
         }
     }" 
     x-show="open" 
     class="fixed z-10 inset-0 overflow-y-auto" 
     x-cloak>
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="open" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 transition-opacity" 
             aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 dark:bg-gray-800 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div x-show="open" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <div class="absolute top-0 right-0 pt-4 pr-4">
                <button type="button" @click="open = false" class="bg-white dark:bg-gray-800 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-indigo-400">
                    <span class="sr-only">Close</span>
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="sm:flex sm:items-start">
                <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                        Quiz
                    </h3>
                    <div class="mt-4">
                        <div id="quiz-content" class="dark:text-white"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function startQuiz(chapterId) {
    // Use a custom event to trigger Alpine.js state change
    // This avoids direct manipulation of Alpine.js internals
    document.dispatchEvent(new CustomEvent('open-quiz-modal', {
        detail: { chapterId: chapterId }
    }));
    
    // Load quiz content
    fetch(`/lesson/quiz/${chapterId}`)
        .then(response => response.text())
        .then(html => {
            const quizContentDiv = document.getElementById('quiz-content');
            quizContentDiv.innerHTML = html;
            const quizForm = quizContentDiv.querySelector('form'); // Assumes there's one form
            
            if (!quizForm) {
                console.error('Quiz form not found in loaded content for chapter ' + chapterId);
                return;
            }
            
            console.log('Quiz form loaded successfully for chapter ' + chapterId);
            
            // Add necessary attributes to the form for the quiz system
            quizForm.setAttribute('data-quiz-id', chapterId);
            quizForm.setAttribute('data-chapter-id', chapterId);
            
            // Get the quiz questions and answers
            const questions = quizForm.querySelectorAll('.quiz-question');
            const answers = {};
            
            // Extract correct answers from hidden fields
            questions.forEach(question => {
                const questionId = question.getAttribute('data-question-id');
                const correctAnswer = question.querySelector('input[name="correct_answer"]')?.value;
                if (questionId && correctAnswer) {
                    answers[questionId] = correctAnswer;
                }
            });
            
            // Add a direct submit handler to the form
            quizForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Process the quiz directly
                let score = 0;
                const totalQuestions = questions.length;
                
                // Check answers
                questions.forEach(question => {
                    const questionId = question.getAttribute('data-question-id');
                    const selectedInput = question.querySelector(`input[name="question${questionId}"]:checked`);
                    const correctAnswer = answers[questionId];
                    
                    if (selectedInput && selectedInput.value === correctAnswer) {
                        score++;
                    }
                });
                
                // Calculate percentage
                const percentage = Math.round((score / totalQuestions) * 100);
                
                // Submit to server
                const formData = new FormData(quizForm);
                formData.append('<?= CSRF_TOKEN_NAME ?>', '<?= $csrf_token ?>');
                formData.append('lesson_id', '<?= $lesson['id'] ?>');
                formData.append('chapter_id', chapterId);
                
                // Add X-Requested-With header to ensure isAjax() returns true on the server
                fetch('/lesson/quiz', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show a success message before reloading
                        const score = data.score || 0;
                        
                        if (data.passed) {
                            alert(`Congratulations! Your score: ${score}%. You have passed this quiz and the chapter has been marked as complete.`);
                        } else {
                            alert(`Quiz submitted. Your score: ${score}%. You need to score at least 80% to pass and unlock the next chapter.`);
                        }
                        
                        // Close the modal
                        document.querySelector('#quiz-modal button[type="button"]').click();
                        
                        // Reload the page to update the UI
                        setTimeout(() => location.reload(), 500);
                    } else {
                        alert('Error saving quiz result: ' + (data.error || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Quiz submission error:', error);
                    alert('There was a problem submitting your quiz. Please try again.');
                });
            });
        })
        .catch(error => {
            console.error('Error loading quiz:', error);
            document.getElementById('quiz-content').innerHTML = '<div class="text-red-600 p-4">Error loading quiz. Please try again.</div>';
        });
}

// DISABLED: This function was causing duplicate quiz submissions
// Using the external quiz-system.js instead
/*
function submitQuiz(form, chapterId) {
    const formData = new FormData(form);
    formData.append('<?= CSRF_TOKEN_NAME ?>', '<?= $csrf_token ?>');
    formData.append('lesson_id', '<?= $lesson['id'] ?>');
    formData.append('chapter_id', chapterId); // Add chapter_id
    
    // Add X-Requested-With header to ensure isAjax() returns true on the server
    fetch('/lesson/quiz', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => {
        // Check if the response is valid JSON
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            return response.json();
        } else {
            // If not JSON, throw an error that will be caught below
            throw new Error('Server returned an invalid response format');
        }
    })
    .then(data => {
        if (data.success) {
            // Show a success message before reloading
            const score = data.score || 0;
            const passed = data.passed ? 'passed' : 'failed';
            
            if (data.passed) {
                alert(`Congratulations! Your score: ${score}%. You have passed this quiz and the chapter has been marked as complete.`);
            } else {
                alert(`Quiz submitted. Your score: ${score}%. You need to score at least 80% to pass and unlock the next chapter.`);
            }
            
            // Reload the page to update the UI
            setTimeout(() => location.reload(), 500);
        } else {
            alert('Error saving quiz result: ' + (data.error || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Quiz submission error:', error);
        alert('There was a problem submitting your quiz. Please try again.');
    });
    
    return false;
}
*/

// Placeholder function to prevent errors if called
function submitQuiz(form, chapterId) {
    console.log('Legacy submitQuiz function called but disabled to prevent duplicate submissions');
    return false;
}

// Simple search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    if (!searchInput) {
        console.error('Search input not found');
        return;
    }
    
    searchInput.addEventListener('input', function() {
        const searchText = this.value.toLowerCase().trim();
        const contentContainers = document.querySelectorAll('.chapter-content');
        
        if (!contentContainers || contentContainers.length === 0) {
            console.error('Content containers not found');
            return;
        }
        
        console.log('Search text:', searchText);
        console.log('Found', contentContainers.length, 'chapter content containers');
        
        // First clear any existing highlights
        const existingHighlights = document.querySelectorAll('mark');
        existingHighlights.forEach(highlight => {
            const parent = highlight.parentNode;
            parent.replaceChild(document.createTextNode(highlight.textContent), highlight);
            parent.normalize(); // Merge adjacent text nodes
        });
        
        if (!searchText) return; // Exit if search is empty
        
        // Search all chapter content containers
        contentContainers.forEach(container => {
            findAndHighlightText(container, searchText);
        });
        
        // Log search results
        setTimeout(() => {
            const highlights = document.querySelectorAll('mark');
            console.log('Found', highlights.length, 'matches for', searchText);
        }, 100);
    });
});

function findAndHighlightText(container, searchText) {
    // Get all text nodes in the container
    const textNodes = [];
    const walk = document.createTreeWalker(
        container,
        NodeFilter.SHOW_TEXT,
        { acceptNode: node => {
            // Skip script and style tags
            const parent = node.parentNode;
            if (parent.tagName === 'SCRIPT' || parent.tagName === 'STYLE') {
                return NodeFilter.FILTER_REJECT;
            }
            return NodeFilter.FILTER_ACCEPT;
        }},
        false
    );
    
    let node;
    while (node = walk.nextNode()) {
        // Only process nodes that contain the search text
        if (node.textContent.toLowerCase().indexOf(searchText) > -1) {
            textNodes.push(node);
        }
    }
    
    // Process each text node
    textNodes.forEach(textNode => {
        const text = textNode.textContent;
        const parent = textNode.parentNode;
        
        // Create a temporary element
        const temp = document.createElement('div');
        
        // Replace all occurrences of the search text with marked version
        temp.innerHTML = text.replace(new RegExp(escapeRegExp(searchText), 'gi'), match => {
            return `<mark>${match}</mark>`;
        });
        
        // Create a fragment to hold the new nodes
        const fragment = document.createDocumentFragment();
        while (temp.firstChild) {
            fragment.appendChild(temp.firstChild);
        }
        
        // Replace the original text node with the fragment
        parent.replaceChild(fragment, textNode);
    });
}

// Helper function to escape special characters in search text for regex
function escapeRegExp(string) {
    return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}

// Auto-scroll functionality for Mark as Complete buttons and automatic scrolling past completed sections
document.addEventListener('DOMContentLoaded', function() {
    // Handle form submissions for Mark as Complete buttons
    const completeForms = document.querySelectorAll('.complete-form');
    
    completeForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            // Get the next chapter ID from the data attribute
            const nextChapterId = this.getAttribute('data-next-chapter');
            
            // Store the next chapter ID in localStorage to use after page reload
            if (nextChapterId) {
                localStorage.setItem('scrollToChapter', nextChapterId);
            }
        });
    });
    
    // Function to find the first incomplete chapter
    function findFirstIncompleteChapter() {
        const chapters = document.querySelectorAll('.chapter-content');
        let firstIncomplete = null;
        
        for (const chapter of chapters) {
            // Check if this chapter is not completed (doesn't have the completed indicator)
            const completedIndicator = chapter.querySelector('.bg-green-600, .bg-green-700');
            if (!completedIndicator) {
                firstIncomplete = chapter;
                break;
            }
        }
        
        return firstIncomplete;
    }
    
    // Remove any stored scroll position from localStorage
    if (localStorage.getItem('scrollToChapter')) {
        localStorage.removeItem('scrollToChapter');
    }
    
    // No auto-scrolling - let users control their own navigation
    
    // Process chapter subsections
    const chapterContents = document.querySelectorAll('.chapter-content');
    
    chapterContents.forEach(chapterContent => {
        const subsectionContainer = chapterContent.querySelector('#chapter-subsections');
        if (!subsectionContainer) return;
        
        const subsectionLinksContainer = subsectionContainer.querySelector('.subsection-links');
        
        // Find all h3 elements within the chapter content
        const subsections = chapterContent.querySelectorAll('h3');
        
        if (subsections.length > 0) {
            // Show the subsection navigation
            subsectionContainer.style.display = 'block';
            
            // Create navigation links for each subsection
            subsections.forEach((subsection, index) => {
                // Add an ID to the subsection if it doesn't have one
                if (!subsection.id) {
                    const subsectionId = 'subsection-' + Math.random().toString(36).substr(2, 9);
                    subsection.id = subsectionId;
                }
                
                // Create a link to the subsection
                const link = document.createElement('a');
                link.href = '#' + subsection.id;
                link.className = 'block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white';
                link.textContent = subsection.textContent;
                
                // Add the link to the subsection navigation
                const linkContainer = document.createElement('div');
                linkContainer.appendChild(link);
                subsectionLinksContainer.appendChild(linkContainer);
            });
        } else {
            // Hide the subsection navigation if there are no subsections
            subsectionContainer.style.display = 'none';
        }
    });
    
    // Check if we're using the standardized quiz system
    // Check if the quiz system is already loaded to prevent double initialization
    const quizSystemLoaded = document.getElementById('quiz-system-script')?.getAttribute('data-loaded') === 'true';
    
    if (!quizSystemLoaded && typeof window.initQuiz !== 'function') {
        console.log('Using fallback quiz initialization');
        // Fallback quiz initialization for backward compatibility
        window.initQuiz = function(quizId, answers) {
            const quizContainer = document.querySelector(`[data-quiz-id="${quizId}"]`);
            if (!quizContainer) {
                console.error(`Quiz container with ID ${quizId} not found`);
                return;
            }
            
            const form = quizContainer.querySelector('form');
            const questions = quizContainer.querySelectorAll('.quiz-question');
            const results = quizContainer.querySelector('.quiz-results');
            
            if (!form || !questions.length || !results) {
                console.error(`Quiz ${quizId} is missing required elements`);
                return;
            }
            
            const resultsMessage = results.querySelector('.results-message');
            
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                let score = 0;
                let totalQuestions = questions.length;
                let unansweredQuestions = 0;
                
                // Process each question
                questions.forEach(question => {
                    const questionId = question.dataset.questionId;
                    const selectedOption = form.querySelector(`input[name="question${questionId}"]:checked`);
                    const feedback = question.querySelector('.answer-feedback');
                    
                    if (!feedback) {
                        console.error(`Feedback element not found for question ${questionId}`);
                        return;
                    }
                    
                    feedback.classList.remove('hidden', 'text-green-600', 'text-red-600');
                    
                    if (!selectedOption) {
                        feedback.textContent = 'Please select an answer.';
                        feedback.classList.add('text-red-600');
                        unansweredQuestions++;
                        return;
                    }
                    
                    const userAnswer = selectedOption.value;
                    const correctAnswer = answers[questionId];
                    
                    if (userAnswer === correctAnswer) {
                        feedback.textContent = 'Correct!';
                        feedback.classList.add('text-green-600');
                        score++;
                    } else {
                        feedback.textContent = 'Incorrect. Please try again.';
                        feedback.classList.add('text-red-600');
                    }
                    
                    feedback.classList.remove('hidden');
                });
                
                // If there are unanswered questions, don't show results yet
                if (unansweredQuestions > 0) {
                    return;
                }
                
                // Calculate percentage
                const percentage = Math.round((score / totalQuestions) * 100);
                
                // Show results
                let message = `You scored ${score} out of ${totalQuestions} (${percentage}%).`;
                
                if (percentage >= 80) {
                    message += ' Great job! You have a good understanding of this topic.';
                } else if (percentage >= 60) {
                    message += ' Good effort! Review the material and try again to improve your score.';
                } else {
                    message += ' You might want to review the chapter material before trying again.';
                }
                
                resultsMessage.textContent = message;
                form.classList.add('hidden');
                results.classList.remove('hidden');
                
                // Submit quiz result to server using the existing submitQuiz function
                const formData = new FormData();
                formData.append('quiz_id', quizId);
                formData.append('score', score);
                formData.append('total', totalQuestions);
                formData.append('percentage', percentage);
                
                // Create a form element to pass to the submitQuiz function
                const tempForm = document.createElement('form');
                tempForm.method = 'POST';
                tempForm.action = '/lesson/quiz';
                
                // Add the form data to the temp form
                for (const [key, value] of formData.entries()) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = value;
                    tempForm.appendChild(input);
                }
                
                // Submit the quiz
                submitQuiz(tempForm);
            });
            
            // Retake quiz button
            const retakeButton = results.querySelector('.retake-quiz');
            if (retakeButton) {
                retakeButton.addEventListener('click', function() {
                    // Reset form
                    form.reset();
                    
                    // Hide all feedback
                    questions.forEach(question => {
                        const feedback = question.querySelector('.answer-feedback');
                        if (feedback) {
                            feedback.textContent = '';
                            feedback.classList.add('hidden');
                        }
                    });
                    
                    // Show form, hide results
                    form.classList.remove('hidden');
                    results.classList.add('hidden');
                });
            }
            
            console.log(`Quiz ${quizId} initialized successfully with ${questions.length} questions`);
        };
    }
});
</script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
