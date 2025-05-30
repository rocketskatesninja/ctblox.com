<?php
require_once __DIR__ . '/../includes/header.php';
$title = 'Dashboard';
// Initialize chapters array if not set
if (!isset($chapters)) {
    $chapters = [];
}
?>

<div class="space-y-6">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Welcome back, <?= htmlspecialchars($_SESSION['name'] ?? $_SESSION['username']) ?>!
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Continue your learning journey or start a new lesson.</p>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Progress Overview
            </h3>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                <!-- Chapter Progress -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <h4 class="text-sm font-medium text-gray-700">Chapter Progress</h4>
                        <span class="text-sm text-gray-500"><?= $stats['chapter_percentage'] ?? 0 ?>%</span>
                    </div>
                    <div class="bg-gray-200 rounded-full h-2.5 mb-1">
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: <?= $stats['chapter_percentage'] ?? 0 ?>%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500">
                        <span><?= $stats['completed_chapters'] ?? 0 ?> completed</span>
                        <span><?= $stats['total_chapters'] ?? 0 ?> total</span>
                    </div>
                </div>

                <!-- Lesson Progress -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <h4 class="text-sm font-medium text-gray-700">Lesson Progress</h4>
                        <span class="text-sm text-gray-500"><?= $stats['lesson_percentage'] ?? 0 ?>%</span>
                    </div>
                    <div class="bg-gray-200 rounded-full h-2.5 mb-1">
                        <div class="bg-green-600 h-2.5 rounded-full" style="width: <?= $stats['lesson_percentage'] ?? 0 ?>%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500">
                        <span><?= $stats['completed_lessons'] ?? 0 ?> completed</span>
                        <span><?= $stats['total_lessons'] ?? 0 ?> total</span>
                    </div>
                </div>
            </div>

            <!-- Stat Cards -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-4 mt-6">
                <!-- Chapters Completed -->
                <div class="bg-gray-50 overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6 flex items-center">
                        <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                            <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Chapters Completed</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900"><?= $stats['completed_chapters'] ?? 0 ?></div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Lessons Completed -->
                <div class="bg-gray-50 overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6 flex items-center">
                        <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                            <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Lessons Completed</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900"><?= $stats['completed_lessons'] ?? 0 ?></div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Quizzes Taken -->
                <div class="bg-gray-50 overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6 flex items-center">
                        <div class="flex-shrink-0 bg-purple-100 rounded-md p-3">
                            <svg class="h-6 w-6 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Quizzes Taken</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900"><?= $stats['quizzes_taken'] ?? 0 ?></div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Average Quiz Score -->
                <div class="bg-gray-50 overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6 flex items-center">
                        <div class="flex-shrink-0 bg-indigo-100 rounded-md p-3">
                            <svg class="h-6 w-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Average Quiz Score</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900"><?= $stats['average_score'] ?? 0 ?>%</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Available Lessons
            </h3>
        </div>
        <div class="border-t border-gray-200">
            <?php if (!empty($lessons)): ?>
                <ul class="divide-y divide-gray-200">
                    <?php foreach ($lessons as $lesson): ?>
                        <li class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">
                                            <?= $this->sanitize($lesson['title']) ?>
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            <?= $this->sanitize($lesson['description']) ?>
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <a href="/lesson/<?= $lesson['id'] ?>" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                        <?= isset($lesson['completed']) && $lesson['completed'] ? 'Review' : 'Start' ?>
                                    </a>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <div class="px-4 py-5 sm:p-6 text-center">
                    <p class="text-sm text-gray-500">No lessons available at this time.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
