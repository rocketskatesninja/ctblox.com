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
    <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white flex items-center">
                <svg class="h-5 w-5 text-indigo-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                </svg>
                Lesson Progress
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                Overview of student progress across all lessons
            </p>
        </div>
        <div class="border-t border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Lesson
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Progress
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Students
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Details
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <?php foreach ($allLessons as $lesson): ?>
                            <?php
                            // Count students who have started or completed this lesson
                            $studentsStarted = 0;
                            $studentsCompleted = 0;
                            $studentsInProgress = 0;
                            
                            // Get total chapters for this lesson
                            $stmt = $pdo->prepare("SELECT COUNT(DISTINCT chapter_id) FROM chapters WHERE lesson_id = ?");
                            $stmt->execute([$lesson['id']]);
                            $totalChapters = $stmt->fetchColumn();
                            
                            foreach ($students as $student) {
                                if (isset($student['progress'][$lesson['title']])) {
                                    $studentsStarted++;
                                    
                                    // Count completed chapters for this student
                                    $stmt = $pdo->prepare("SELECT COUNT(DISTINCT chapter_id) FROM progress WHERE user_id = ? AND lesson_id = ? AND completed = 1");
                                    $stmt->execute([$student['id'], $lesson['id']]);
                                    $completedChapters = $stmt->fetchColumn();
                                    
                                    // Store chapter progress in student's progress array for later use
                                    $student['progress'][$lesson['title']]['completed_chapters'] = $completedChapters;
                                    $student['progress'][$lesson['title']]['total_chapters'] = $totalChapters;
                                    
                                    if ($completedChapters == $totalChapters) {
                                        $studentsCompleted++;
                                    } else if ($completedChapters > 0) {
                                        $studentsInProgress++;
                                    }
                                }
                            }
                            
                            // Calculate percentage of students who completed the entire lesson
                            $completionPercentage = count($students) > 0 ? round(($studentsCompleted / count($students)) * 100) : 0;
                            ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        <?= $this->sanitize($lesson['title']) ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-full max-w-[150px] bg-gray-200 dark:bg-gray-600 rounded-full h-2.5 mr-2">
                                            <div class="bg-<?= $completionPercentage >= 80 ? 'green' : ($completionPercentage >= 40 ? 'yellow' : 'red') ?>-500 h-2.5 rounded-full" style="width: <?= $completionPercentage ?>%"></div>
                                        </div>
                                        <span class="text-sm text-gray-500 dark:text-gray-400"><?= $studentsCompleted ?>/<?= count($students) ?></span>
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        Students completed lesson
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex space-x-2">
                                        <div class="px-2 py-1 text-xs rounded-full bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100">
                                            <?= $studentsCompleted ?> completed
                                        </div>
                                        <div class="px-2 py-1 text-xs rounded-full bg-yellow-100 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-100">
                                            <?= $studentsInProgress ?> in progress
                                        </div>
                                        <div class="px-2 py-1 text-xs rounded-full bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                            <?= count($students) - $studentsStarted ?> not started
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <button type="button" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium"
                                            onclick="toggleStudentDetails('lesson-<?= md5($lesson['title']) ?>')">
                                        Show Students
                                    </button>
                                </td>
                            </tr>
                            <tr id="lesson-<?= md5($lesson['title']) ?>" class="hidden bg-gray-50 dark:bg-gray-900">
                                <td colspan="4" class="px-6 py-4">
                                    <?php if ($studentsStarted > 0): ?>
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                            <?php foreach ($students as $student): ?>
                                                <?php if (isset($student['progress'][$lesson['title']])): ?>
                                                    <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm space-y-3">
                                                        <div class="flex items-center justify-between">
                                                            <div class="flex items-center space-x-3">
                                                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-700 flex items-center justify-center">
                                                                    <span class="text-indigo-800 dark:text-indigo-100 font-medium text-sm">
                                                                        <?= strtoupper(substr($student['username'], 0, 2)) ?>
                                                                    </span>
                                                                </div>
                                                                <div>
                                                                    <a href="/coach/student/<?= $student['id'] ?>" class="text-sm font-medium text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                                        <?= $this->sanitize($student['username']) ?>
                                                                    </a>
                                                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                                                        Last active: <?= isset($student['progress'][$lesson['title']]['last_activity']) ? date('M j, Y', strtotime($student['progress'][$lesson['title']]['last_activity'])) : 'Never' ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="text-right">
                                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                                    <?= $student['progress'][$lesson['title']]['completed_chapters'] ?>/<?= $student['progress'][$lesson['title']]['total_chapters'] ?>
                                                                </div>
                                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                                    chapters completed
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                                            <?php
                                                            $progressPercentage = ($student['progress'][$lesson['title']]['completed_chapters'] / $student['progress'][$lesson['title']]['total_chapters']) * 100;
                                                            $progressColorClass = 'bg-indigo-600 dark:bg-indigo-500';
                                                            if ($progressPercentage < 30) {
                                                                $progressColorClass = 'bg-red-500 dark:bg-red-400';
                                                            } elseif ($progressPercentage < 70) {
                                                                $progressColorClass = 'bg-yellow-500 dark:bg-yellow-400';
                                                            } elseif ($progressPercentage === 100) {
                                                                $progressColorClass = 'bg-green-500 dark:bg-green-400';
                                                            }
                                                            ?>
                                                            <div class="<?= $progressColorClass ?> h-2 rounded-full transition-all duration-300" style="width: <?= $progressPercentage ?>%"></div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-center py-4">
                                            <p class="text-sm text-gray-500 dark:text-gray-400 italic">No students have started this lesson yet</p>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script>
    function toggleStudentDetails(id) {
        const detailsRow = document.getElementById(id);
        if (detailsRow) {
            detailsRow.classList.toggle('hidden');
        }
    }
    </script>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
