<?php
require_once __DIR__ . '/../../includes/header.php';
$title = 'Coach Dashboard';
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="md:flex md:items-center md:justify-between mb-6">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Coach Dashboard
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Manage and track your students' progress
            </p>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900 flex items-center">
                <svg class="h-5 w-5 text-indigo-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v1h8v-1zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-1a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v1h-3zM4.75 12.094A5.973 5.973 0 004 15v1H1v-1a3 3 0 013.75-2.906z" />
                </svg>
                My Students
            </h3>
            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">
                <?= count($students) ?> students assigned
            </span>
        </div>
        
        <?php if (empty($students)): ?>
            <div class="px-4 py-12 text-center border-t border-gray-200">
                <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No students assigned</h3>
                <p class="mt-1 text-sm text-gray-500">
                    You don't have any students assigned to you yet.
                </p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Student
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Overall Progress
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Last Activity
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($students as $student): ?>
                            <?php
                            // Get the overall progress data from the model
                            $progressData = $student['overall_progress'];
                            $overallPercentage = $progressData['chapter_completion_percentage'];
                            $totalCompletedChapters = $progressData['completed_chapters'];
                            $totalChapters = $progressData['total_chapters'];
                            
                            // Find the last activity
                            $lastActivity = null;
                            foreach ($student['progress'] as $lessonTitle => $progress) {
                                if ($progress['last_activity'] && (!$lastActivity || strtotime($progress['last_activity']) > strtotime($lastActivity))) {
                                    $lastActivity = $progress['last_activity'];
                                }
                            }
                            ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-700 flex items-center justify-center">
                                            <span class="text-indigo-800 dark:text-indigo-100 font-medium text-sm">
                                                <?= strtoupper(substr($student['username'], 0, 2)) ?>
                                            </span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                <a href="/coach/student/<?= $student['id'] ?>" class="text-indigo-600 hover:text-indigo-900">
                                                    <?= $this->sanitize($student['username']) ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <a href="mailto:<?= $this->sanitize($student['email']) ?>" class="text-gray-500 hover:text-indigo-600 dark:hover:text-indigo-400">
                                        <?= $this->sanitize($student['email']) ?>
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-full bg-gray-200 rounded-full h-2.5 mr-2 max-w-[150px]">
                                            <div class="bg-<?= $overallPercentage >= 80 ? 'green' : ($overallPercentage >= 40 ? 'yellow' : 'red') ?>-500 h-2.5 rounded-full" style="width: <?= $overallPercentage ?>%"></div>
                                        </div>
                                        <span class="text-sm text-gray-500"><?= $overallPercentage ?>%</span>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        <?= $totalCompletedChapters ?> of <?= $totalChapters ?> chapters completed
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php if ($lastActivity): ?>
                                        <?= date('F j, Y g:i A', strtotime($lastActivity)) ?>
                                    <?php else: ?>
                                        No activity yet
                                    <?php endif; ?>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <?php if (!empty($students)): ?>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 flex items-center">
                <svg class="h-5 w-5 text-indigo-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                </svg>
                Lesson Progress
            </h3>
        </div>
        <div class="border-t border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-4">
                <?php foreach ($allLessons as $lesson): ?>
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                        <h4 class="text-md font-medium text-gray-900 mb-2"><?= $this->sanitize($lesson['title']) ?></h4>
                        
                        <?php
                        // Count students who have started or completed this lesson
                        $studentsStarted = 0;
                        $studentsCompleted = 0;
                        
                        foreach ($students as $student) {
                            if (isset($student['progress'][$lesson['title']])) {
                                $studentsStarted++;
                                
                                if ($student['progress'][$lesson['title']]['completion_percentage'] == 100) {
                                    $studentsCompleted++;
                                }
                            }
                        }
                        ?>
                        
                        <div class="flex justify-between text-sm text-gray-500 mb-1">
                            <span>Started by <?= $studentsStarted ?> of <?= count($students) ?> students</span>
                            <span><?= $studentsCompleted ?> completed</span>
                        </div>
                        
                        <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
                            <div class="bg-indigo-500 h-2.5 rounded-full" style="width: <?= count($students) > 0 ? round(($studentsStarted / count($students)) * 100) : 0 ?>%"></div>
                        </div>
                        
                        <?php if ($studentsStarted > 0): ?>
                            <div class="space-y-2">
                                <?php foreach ($students as $student): ?>
                                    <?php if (isset($student['progress'][$lesson['title']])): ?>
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-6 w-6 rounded-full bg-gray-100 flex items-center justify-center text-xs">
                                                    <?= strtoupper(substr($student['username'], 0, 1)) ?>
                                                </div>
                                                <span class="ml-2 text-xs text-gray-600"><?= $this->sanitize($student['username']) ?></span>
                                            </div>
                                            <div class="flex items-center">
                                                <div class="w-20 bg-gray-200 rounded-full h-1.5 mr-2">
                                                    <div class="bg-<?= $student['progress'][$lesson['title']]['completion_percentage'] >= 80 ? 'green' : ($student['progress'][$lesson['title']]['completion_percentage'] >= 40 ? 'yellow' : 'red') ?>-500 h-1.5 rounded-full" style="width: <?= $student['progress'][$lesson['title']]['completion_percentage'] ?>%"></div>
                                                </div>
                                                <span class="text-xs text-gray-500"><?= $student['progress'][$lesson['title']]['completion_percentage'] ?>%</span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-sm text-gray-500 italic">No students have started this lesson yet</p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
