<?php $title = 'Dashboard'; ?>
<?php require_once __DIR__ . '/../../includes/header.php'; ?>

<div class="space-y-6 bg-gray-50">
    <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                <?php
                // Get user's name from database if available
                $stmt = $this->pdo->prepare("SELECT name FROM users WHERE id = ?");
                $stmt->execute([$_SESSION['user_id']]);
                $userData = $stmt->fetch();
                $displayName = (!empty($userData['name'])) ? $userData['name'] : $_SESSION['username'];
                ?>
                Welcome back, <?= $this->sanitize($displayName) ?>!
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                Continue your learning journey or start a new lesson.
            </p>
        </div>
        <div class="border-t border-gray-200 dark:border-gray-700 px-4 py-5 sm:px-6">
            <!-- Progress Overview Section -->
            <div class="mb-6">
                <h4 class="text-base font-medium text-gray-900 dark:text-white mb-3">Progress Overview</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Chapter Progress -->
                    <div class="bg-white dark:bg-gray-700 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h5 class="text-sm font-medium text-gray-600">Chapter Progress</h5>
                            <?php 
                            // Calculate chapter progress directly in the view
                            $completed_chapters = 0;
                            $total_chapters = 0;
                            
                            // Query to get chapter progress
                            $chapterStmt = $this->pdo->prepare("
                                SELECT 
                                    COUNT(DISTINCT c.chapter_id) as total_chapters,
                                    COUNT(DISTINCT CASE WHEN p.completed = 1 THEN p.chapter_id END) as completed_chapters
                                FROM chapters c
                                JOIN lessons l ON c.lesson_id = l.id
                                JOIN lesson_assignments la ON l.id = la.lesson_id AND la.user_id = ?
                                LEFT JOIN progress p ON c.lesson_id = p.lesson_id AND c.chapter_id = p.chapter_id AND p.user_id = ?
                            ");
                            $chapterStmt->execute([$_SESSION['user_id'], $_SESSION['user_id']]);
                            $chapterData = $chapterStmt->fetch();
                            
                            $completed_chapters = $chapterData['completed_chapters'];
                            $total_chapters = $chapterData['total_chapters'];
                            $chapter_percentage = ($total_chapters > 0) ? round(($completed_chapters / $total_chapters) * 100) : 0;
                            ?>
                            <span class="text-sm font-medium text-indigo-600"><?= $chapter_percentage ?>%</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2 mb-2">
                            <div class="bg-indigo-500 h-2 rounded-full" style="width: <?= $chapter_percentage ?>%"></div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500">
                            <span><?= $completed_chapters ?> completed</span>
                            <span><?= $total_chapters ?> total</span>
                        </div>
                    </div>
                    
                    <!-- Lesson Progress -->
                    <div class="bg-white dark:bg-gray-700 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h5 class="text-sm font-medium text-gray-600">Lesson Progress</h5>
                            <?php 
                            // Calculate lesson progress directly in the view
                            $completed_lessons = 0;
                            $total_lessons = 0;
                            
                            // Query to get lesson progress
                            $lessonStmt = $this->pdo->prepare("
                                SELECT 
                                    COUNT(DISTINCT l.id) as total_lessons,
                                    SUM(CASE WHEN (
                                        SELECT COUNT(*) FROM chapters c WHERE c.lesson_id = l.id
                                    ) = (
                                        SELECT COUNT(*) FROM progress p 
                                        WHERE p.lesson_id = l.id AND p.user_id = ? AND p.completed = 1
                                    ) THEN 1 ELSE 0 END) as completed_lessons
                                FROM lessons l
                                JOIN lesson_assignments la ON l.id = la.lesson_id
                                WHERE la.user_id = ?
                            ");
                            $lessonStmt->execute([$_SESSION['user_id'], $_SESSION['user_id']]);
                            $lessonData = $lessonStmt->fetch();
                            
                            $completed_lessons = $lessonData['completed_lessons'];
                            $total_lessons = $lessonData['total_lessons'];
                            $lesson_percentage = ($total_lessons > 0) ? round(($completed_lessons / $total_lessons) * 100) : 0;
                            ?>
                            <span class="text-sm font-medium text-green-600"><?= $lesson_percentage ?>%</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2 mb-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: <?= $lesson_percentage ?>%"></div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500">
                            <span><?= $completed_lessons ?> completed</span>
                            <span><?= $total_lessons ?> total</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Statistics Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Chapters Completed -->
                <div class="bg-white rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-indigo-100 rounded-md p-2">
                            <svg class="h-6 w-6 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-gray-600">Chapters Completed</h4>
                            <p class="mt-1 text-2xl font-semibold text-indigo-500"><?= $completed_chapters ?></p>
                        </div>
                    </div>
                </div>
                
                <!-- Lessons Completed -->
                <div class="bg-white rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-100 rounded-md p-2">
                            <svg class="h-6 w-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-gray-600">Lessons Completed</h4>
                            <p class="mt-1 text-2xl font-semibold text-green-500"><?= $completed_lessons ?></p>
                        </div>
                    </div>
                </div>
                
                <!-- Quizzes Taken -->
                <div class="bg-white rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-100 rounded-md p-2">
                            <svg class="h-6 w-6 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-gray-600">Quizzes Taken</h4>
                            <?php
                            // Get quizzes taken directly
                            $quizStmt = $this->pdo->prepare("SELECT COUNT(*) FROM quiz_results WHERE user_id = ?");
                            $quizStmt->execute([$_SESSION['user_id']]);
                            $quizzes_taken = $quizStmt->fetchColumn();
                            ?>
                            <p class="mt-1 text-2xl font-semibold text-blue-500"><?= $quizzes_taken ?></p>
                        </div>
                    </div>
                </div>
                
                <!-- Average Quiz Score -->
                <div class="bg-white rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-100 rounded-md p-2">
                            <svg class="h-6 w-6 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-gray-600">Average Quiz Score</h4>
                            <?php
                            // Get average quiz score directly
                            $scoreStmt = $this->pdo->prepare("SELECT AVG(score) FROM quiz_results WHERE user_id = ?");
                            $scoreStmt->execute([$_SESSION['user_id']]);
                            $avg_score = $scoreStmt->fetchColumn();
                            $avg_score = $avg_score ? round($avg_score) : 0;
                            ?>
                            <p class="mt-1 text-2xl font-semibold text-purple-500"><?= $avg_score ?>%</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Last Activity -->
            <?php if ($stats['last_activity_date']): ?>
            <div class="mt-4 text-sm text-gray-500 dark:text-gray-400 flex items-center">
                <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                </svg>
                Last activity: <?= date('F j, Y g:i a', strtotime($stats['last_activity_date'])) ?>
            </div>
            <?php endif; ?>
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
                                                <?= $this->sanitize(substr($lesson['custom_summary'], 0, 120)) ?><?= strlen($lesson['custom_summary']) > 120 ? '...' : '' ?>
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
