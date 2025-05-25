<?php $title = 'Dashboard'; ?>
<?php require_once __DIR__ . '/../../includes/header.php'; ?>

<div class="space-y-6">
    <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                Welcome back, <?= $this->sanitize($_SESSION['username']) ?>!
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                Continue your learning journey or start a new lesson.
            </p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white flex items-center">
                <svg class="h-5 w-5 text-indigo-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                </svg>
                Available Lessons
            </h3>
        </div>
        <div class="border-t border-gray-200 dark:border-gray-700">
            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                <?php foreach ($lessons as $lesson): ?>
                    <li>
                        <a href="/lesson/<?= $lesson['id'] ?>" class="block hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <?php if ($lesson['completed_chapters'] === $lesson['total_chapters']): ?>
                                                <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-green-100 dark:bg-green-900">
                                                    <svg class="h-6 w-6 text-green-600 dark:text-green-300" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                </span>
                                            <?php elseif ($lesson['completed_chapters'] > 0): ?>
                                                <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900">
                                                    <svg class="h-6 w-6 text-blue-600 dark:text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                </span>
                                            <?php else: ?>
                                                <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-gray-100 dark:bg-gray-700">
                                                    <svg class="h-6 w-6 text-gray-600 dark:text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"/>
                                                    </svg>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-indigo-600 dark:text-indigo-400"><?= $this->sanitize($lesson['title']) ?></div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                <?= $this->sanitize(substr($lesson['description'], 0, 100)) ?><?= strlen($lesson['description']) > 100 ? '...' : '' ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex items-center">
                                            <!-- Progress indicator -->
                                            <?php if ($lesson['total_chapters'] > 0): ?>
                                                <div class="ml-2 flex items-center">
                                                    <div class="mr-3 relative">
                                                        <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-gray-200 dark:border-gray-600 flex items-center justify-center">
                                                            <div class="absolute inset-0 flex items-center justify-center">
                                                                <svg class="w-14 h-14" viewBox="0 0 36 36">
                                                                    <path
                                                                        d="M18 2.0845
                                                                        a 15.9155 15.9155 0 0 1 0 31.831
                                                                        a 15.9155 15.9155 0 0 1 0 -31.831"
                                                                        fill="none"
                                                                        stroke="#E5E7EB"
                                                                        stroke-width="2"
                                                                        class="dark:stroke-gray-600"
                                                                    />
                                                                    <path
                                                                        d="M18 2.0845
                                                                        a 15.9155 15.9155 0 0 1 0 31.831
                                                                        a 15.9155 15.9155 0 0 1 0 -31.831"
                                                                        fill="none"
                                                                        stroke="#4F46E5"
                                                                        stroke-width="2"
                                                                        stroke-dasharray="<?= 100 * ($lesson['completed_chapters'] / $lesson['total_chapters']) ?>, 100"
                                                                        class="dark:stroke-indigo-400"
                                                                    />
                                                                </svg>
                                                                <div class="absolute text-xs font-semibold text-indigo-600 dark:text-indigo-400">
                                                                    <?= round(100 * ($lesson['completed_chapters'] / $lesson['total_chapters'])) ?>%
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <span class="text-sm font-medium text-gray-900 dark:text-white">
                                                            <?= $lesson['completed_chapters'] ?>/<?= $lesson['total_chapters'] ?>
                                                        </span>
                                                        <span class="ml-1 text-sm text-gray-500 dark:text-gray-400">chapters</span>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
                <?php if (empty($lessons)): ?>
                    <li class="px-4 py-5 sm:px-6">
                        <p class="text-sm text-gray-500 dark:text-gray-400">No lessons available at the moment.</p>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <?php if (!empty($progress)): ?>
        <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white flex items-center">
                    <svg class="h-5 w-5 text-indigo-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                    </svg>
                    Recent Progress
                </h3>
            </div>
            <div class="border-t border-gray-200 dark:border-gray-700">
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    <?php foreach ($progress as $item): ?>
                        <li class="px-4 py-4 sm:px-6 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-indigo-600 dark:text-indigo-400">
                                        <?= $this->sanitize($item['title']) ?>
                                    </p>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        Chapter: <?= $this->sanitize($item['chapter_id']) ?>
                                    </p>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        <?= date('F j, Y g:i a', strtotime($item['completed_at'])) ?>
                                    </p>
                                </div>
                                <div class="flex items-center">
                                    <?php if ($item['quiz_score']): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300">
                                            Quiz Score: <?= $item['quiz_score'] ?>%
                                        </span>
                                    <?php endif; ?>
                                    <?php if ($item['completed']): ?>
                                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300">
                                            Completed
                                        </span>
                                    <?php else: ?>
                                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-300">
                                            In Progress
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
</div>
