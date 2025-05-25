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
                Your Progress
            </h3>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Total Lessons</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"><?= $stats['total_lessons'] ?? 0 ?></dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Completed Lessons</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"><?= $stats['completed_lessons'] ?? 0 ?></dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Average Score</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"><?= $stats['average_score'] ?? '0%' ?></dd>
                </div>
            </dl>
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
