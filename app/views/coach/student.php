<?php
require_once __DIR__ . '/../../includes/header.php';
$title = 'Student Progress';
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="md:flex md:items-center md:justify-between mb-6">
        <div class="flex-1 min-w-0">
            <div class="flex items-center">
                <a href="/coach/dashboard" class="mr-2 text-indigo-600 hover:text-indigo-900">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    <?= $this->sanitize($student['name'] ?: $student['username']) ?>'s Progress
                </h2>
            </div>
            <p class="mt-1 text-sm text-gray-500">
                Detailed progress tracking and lesson management
            </p>
        </div>
    </div>

    <!-- Student Information Card -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6 flex justify-between">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 flex items-center">
                    <svg class="h-5 w-5 text-indigo-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                    Student Profile
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Personal details and progress overview.</p>
            </div>
            <div class="flex items-center">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?= $overallProgress['chapter_completion_percentage'] > 75 ? 'bg-green-100 text-green-800' : ($overallProgress['chapter_completion_percentage'] > 25 ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') ?>">
                    <?= $overallProgress['chapter_completion_percentage'] ?>% Complete
                </span>
            </div>
        </div>
        <div class="border-t border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-gray-200">
                <!-- Basic Info -->
                <div class="px-4 py-5 sm:p-6">
                    <h4 class="text-base font-medium text-gray-900 mb-3">Basic Information</h4>
                    <dl class="space-y-3">
                        <?php if ($student['name']): ?>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                            <dd class="mt-1 text-sm text-gray-900"><?= $this->sanitize($student['name']) ?></dd>
                        </div>
                        <?php endif; ?>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Username</dt>
                            <dd class="mt-1 text-sm text-gray-900"><?= $this->sanitize($student['username']) ?></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email Address</dt>
                            <dd class="mt-1 text-sm text-gray-900"><?= $this->sanitize($student['email']) ?></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Login</dt>
                            <dd class="mt-1 text-sm text-gray-900"><?= $student['last_login'] ? date('F j, Y g:i A', strtotime($student['last_login'])) : 'Never logged in' ?></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Account Created</dt>
                            <dd class="mt-1 text-sm text-gray-900"><?= date('F j, Y', strtotime($student['created_at'])) ?></dd>
                        </div>
                    </dl>
                </div>
                
                <!-- Progress Summary -->
                <div class="px-4 py-5 sm:p-6">
                    <h4 class="text-base font-medium text-gray-900 mb-3">Progress Summary</h4>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Overall Completion</dt>
                            <dd class="mt-1">
                                <div class="flex items-center">
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 mr-2">
                                        <div class="bg-<?= $overallProgress['chapter_completion_percentage'] > 75 ? 'green' : ($overallProgress['chapter_completion_percentage'] > 25 ? 'yellow' : 'gray') ?>-500 h-2.5 rounded-full" style="width: <?= $overallProgress['chapter_completion_percentage'] ?>%"></div>
                                    </div>
                                    <span class="text-sm text-gray-900"><?= $overallProgress['chapter_completion_percentage'] ?>%</span>
                                </div>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Chapters Completed</dt>
                            <dd class="mt-1 text-sm text-gray-900"><?= $overallProgress['completed_chapters'] ?> of <?= $overallProgress['total_chapters'] ?></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Lessons Completed</dt>
                            <dd class="mt-1 text-sm text-gray-900"><?= $overallProgress['completed_lessons'] ?> of <?= $overallProgress['total_lessons'] ?></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Lessons Assigned</dt>
                            <dd class="mt-1 text-sm text-gray-900"><?= count($assignedLessons) ?></dd>
                        </div>
                    </dl>
                </div>
                
                <!-- Certificates -->
                <div class="px-4 py-5 sm:p-6">
                    <h4 class="text-base font-medium text-gray-900 mb-3">Certificates</h4>
                    <?php if (empty($completedLessons)): ?>
                        <div class="text-center py-4">
                            <svg class="mx-auto h-10 w-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">No certificates earned yet</p>
                        </div>
                    <?php else: ?>
                        <ul class="divide-y divide-gray-200">
                            <?php foreach ($completedLessons as $lesson): ?>
                                <li class="py-2">
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900"><?= $this->sanitize($lesson['title']) ?></p>
                                            <p class="text-xs text-gray-500">
                                                Completed on <?= date('M j, Y', strtotime($lesson['completion_date'])) ?>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-indigo-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                </svg>
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Assigned Lessons & Progress</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Manage lessons and track chapter-by-chapter progress</p>
                </div>
            </div>
            <button type="button" onclick="document.getElementById('assignLessonModal').classList.remove('hidden')" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Assign New Lesson
            </button>
        </div>
        
        <?php if (empty($progress)): ?>
            <div class="px-4 py-12 text-center border-t border-gray-200">
                <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No progress yet</h3>
                <p class="mt-1 text-sm text-gray-500">
                    This student hasn't started any lessons yet.
                </p>
            </div>
        <?php else: ?>
            <div class="border-t border-gray-200">
                <?php
                // Group progress by lesson
                $lessonProgress = [];
                $lessonIds = [];
                foreach ($progress as $item) {
                    if (!isset($lessonProgress[$item['title']])) {
                        $lessonProgress[$item['title']] = [
                            'lesson_id' => $item['lesson_id'],
                            'chapters' => [],
                            'quiz_scores' => []
                        ];
                        $lessonIds[$item['title']] = $item['lesson_id'];
                    }
                    
                    $lessonProgress[$item['title']]['chapters'][] = [
                        'chapter_id' => $item['chapter_id'],
                        'completed' => $item['completed'],
                        'completed_at' => $item['completed_at']
                    ];
                    
                    if (!empty($item['quiz_score'])) {
                        $lessonProgress[$item['title']]['quiz_scores'][] = $item['quiz_score'];
                    }
                }
                ?>
                
                <div class="divide-y divide-gray-200">
                    <?php foreach ($lessonProgress as $lessonTitle => $data): ?>
                        <?php
                        // Calculate completion percentage
                        $completedChapters = array_filter($data['chapters'], function($chapter) {
                            return $chapter['completed'];
                        });
                        
                        $completionPercentage = count($data['chapters']) > 0 
                            ? round((count($completedChapters) / count($data['chapters'])) * 100) 
                            : 0;
                            
                        // Calculate average quiz score
                        $avgQuizScore = !empty($data['quiz_scores']) 
                            ? round(array_sum($data['quiz_scores']) / count($data['quiz_scores'])) 
                            : null;
                            
                        // Find last activity date
                        $lastActivity = null;
                        foreach ($completedChapters as $chapter) {
                            if ($chapter['completed_at'] && (!$lastActivity || strtotime($chapter['completed_at']) > strtotime($lastActivity))) {
                                $lastActivity = $chapter['completed_at'];
                            }
                        }
                        
                        // Determine status color
                        $statusColor = 'gray';
                        if ($completionPercentage > 0) {
                            $statusColor = $completionPercentage == 100 ? 'green' : 'yellow';
                        }
                        ?>
                        
                        <div class="px-4 py-5 sm:px-6">
                            <!-- Lesson Header with Progress Summary -->
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start">
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        <h4 class="text-lg font-medium text-gray-900 mb-1"><?= $this->sanitize($lessonTitle) ?></h4>
                                        <form id="unassignForm<?= $data['lesson_id'] ?>" action="/coach/unassign-lesson" method="post" class="hidden">
                                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                            <input type="hidden" name="student_id" value="<?= $student['id'] ?>">
                                            <input type="hidden" name="lesson_id" value="<?= $data['lesson_id'] ?>">
                                        </form>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-500 mb-3">
                                        <?php if ($lastActivity): ?>
                                            <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                            </svg>
                                            Last activity: <?= date('M j, Y', strtotime($lastActivity)) ?>
                                        <?php else: ?>
                                            <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                            </svg>
                                            No activity yet
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="flex flex-col sm:items-end space-y-2">
                                     <div class="flex items-center space-x-2">
                                        <button type="button" onclick="confirmUnassign(<?= $data['lesson_id'] ?>, '<?= addslashes($lessonTitle) ?>')" class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded text-red-700 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-red-500">
                                            <svg class="-ml-0.5 mr-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            Unassign
                                        </button>
                                        <?php if ($avgQuizScore !== null): ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <svg class="mr-1 h-3 w-3 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                                </svg>
                                                Quiz Avg: <?= $avgQuizScore ?>%
                                            </span>
                                        <?php endif; ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-<?= $statusColor ?>-100 text-<?= $statusColor ?>-800">
                                            <svg class="mr-1 h-3 w-3 text-<?= $statusColor ?>-500" fill="currentColor" viewBox="0 0 20 20">
                                                <?php if ($completionPercentage == 100): ?>
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                <?php elseif ($completionPercentage > 0): ?>
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                                <?php else: ?>
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                                <?php endif; ?>
                                            </svg>
                                            <?= $completionPercentage ?>% Complete
                                        </span>
                                    </div>
                                    <div class="w-full sm:w-32 bg-gray-200 rounded-full h-2">
                                        <div class="bg-<?= $statusColor ?>-500 h-2 rounded-full" style="width: <?= $completionPercentage ?>%"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Chapter Progress Cards -->
                            <div class="mt-4">
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h5 class="text-sm font-medium text-gray-700 mb-3 flex items-center">
                                        <svg class="mr-1.5 h-4 w-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
                                        </svg>
                                        Chapter Progress (<?= count($completedChapters) ?>/<?= count($data['chapters']) ?>)
                                    </h5>
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                        <?php foreach ($data['chapters'] as $index => $chapter): ?>
                                            <div class="bg-white rounded-md shadow-sm border <?= $chapter['completed'] ? 'border-green-200' : 'border-gray-200' ?> overflow-hidden">
                                                <div class="px-4 py-3 flex justify-between items-center <?= $chapter['completed'] ? 'bg-green-50' : 'bg-white' ?>">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-6 w-6 rounded-full flex items-center justify-center <?= $chapter['completed'] ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-500' ?>">
                                                            <?= $index + 1 ?>
                                                        </div>
                                                        <div class="ml-3">
                                                            <p class="text-sm font-medium text-gray-900"><?= $this->sanitize($chapter['chapter_id']) ?></p>
                                                        </div>
                                                    </div>
                                                    <?php if ($chapter['completed']): ?>
                                                        <div class="flex-shrink-0">
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                                <svg class="mr-1 h-3 w-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                                </svg>
                                                                Complete
                                                            </span>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="flex-shrink-0">
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                                                <svg class="mr-1 h-3 w-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                                                </svg>
                                                                Pending
                                                            </span>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <?php if ($chapter['completed'] && $chapter['completed_at']): ?>
                                                    <div class="border-t border-gray-200 px-4 py-2 text-xs text-gray-500">
                                                        Completed on <?= date('M j, Y', strtotime($chapter['completed_at'])) ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Assign Lesson Modal -->
<div id="assignLessonModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('assignLessonModal').classList.add('hidden')"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Assign Lesson to <?= $this->sanitize($student['username']) ?>
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Select a lesson to assign to this student. They will be able to access it from their dashboard.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <form action="/coach/assign-lesson" method="post">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <input type="hidden" name="student_id" value="<?= $student['id'] ?>">
                        
                        <div class="mb-4">
                            <label for="lesson_id" class="block text-sm font-medium text-gray-700">Lesson</label>
                            <select id="lesson_id" name="lesson_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">Select a lesson</option>
                                <?php foreach ($allLessons as $lesson): ?>
                                    <?php 
                                    // Check if this lesson is already assigned
                                    $isAssigned = false;
                                    foreach ($assignedLessons as $assignedLesson) {
                                        if ($assignedLesson['id'] == $lesson['id']) {
                                            $isAssigned = true;
                                            break;
                                        }
                                    }
                                    
                                    // Skip if already assigned
                                    if ($isAssigned) continue;
                                    ?>
                                    <option value="<?= $lesson['id'] ?>"><?= $this->sanitize($lesson['title']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    
                        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Assign Lesson
                            </button>
                            <button type="button" onclick="document.getElementById('assignLessonModal').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Unassign Confirmation Modal -->
<div id="unassignConfirmModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('unassignConfirmModal').classList.add('hidden')"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="unassign-modal-title">
                            Unassign Lesson
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500" id="unassign-modal-message">
                                Are you sure you want to unassign this lesson? This will delete all progress for this lesson.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <button type="button" id="confirmUnassignBtn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Unassign
                    </button>
                    <button type="button" onclick="document.getElementById('unassignConfirmModal').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to confirm unassigning a lesson
    function confirmUnassign(lessonId, lessonTitle) {
        // Update the modal message
        document.getElementById('unassign-modal-message').textContent = 
            `Are you sure you want to unassign "${lessonTitle}"? This will delete all progress for this lesson.`;
        
        // Set up the confirm button to submit the form
        document.getElementById('confirmUnassignBtn').onclick = function() {
            document.getElementById(`unassignForm${lessonId}`).submit();
        };
        
        // Show the modal
        document.getElementById('unassignConfirmModal').classList.remove('hidden');
    }
</script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
