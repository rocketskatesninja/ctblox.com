<?php
require_once __DIR__ . '/../../includes/header.php';
$title = 'Admin Dashboard';
?>

<div class="space-y-6">
    <!-- Top row with System Overview and Recent Activity side by side -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <!-- System Overview -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    System Overview
                </h3>
                <span class="text-xs text-gray-500">Last updated: <?= date('M j, Y', strtotime($stats['last_update'])) ?></span>
            </div>
            <div class="border-t border-gray-200">
                <!-- User Statistics -->
                <div class="px-4 py-3 sm:px-6">
                    <h4 class="text-sm font-medium text-gray-900 mb-2 flex items-center">
                        <svg class="h-4 w-4 text-indigo-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v1h8v-1zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-1a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v1h-3zM4.75 12.094A5.973 5.973 0 004 15v1H1v-1a3 3 0 013.75-2.906z" />
                        </svg>
                        User Statistics
                    </h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-indigo-50 dark:bg-gray-700 rounded-lg p-3 text-center">
                            <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400"><?= $stats['total_users'] ?></div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Total Users</div>
                        </div>
                        <div class="bg-green-50 dark:bg-gray-700 rounded-lg p-3 text-center">
                            <div class="text-2xl font-bold text-green-600 dark:text-green-400"><?= $stats['active_users'] ?></div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Active Users</div>
                        </div>
                        <div class="bg-purple-50 dark:bg-gray-700 rounded-lg p-3 text-center">
                            <div class="text-2xl font-bold text-purple-600 dark:text-purple-400"><?= $stats['logins_today'] ?></div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Logins Today</div>
                        </div>
                        <div class="bg-blue-50 dark:bg-gray-700 rounded-lg p-3 text-center">
                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400"><?= $stats['completion_rate'] ?>%</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Completion Rate</div>
                        </div>
                    </div>
                </div>
                
                <!-- User Breakdown -->
                <div class="px-4 py-3 sm:px-6 border-t border-gray-200">
                    <h4 class="text-sm font-medium text-gray-900 mb-2 flex items-center">
                        <svg class="h-4 w-4 text-indigo-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                        User Breakdown
                    </h4>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-yellow-50 dark:bg-gray-700 rounded-lg p-3 text-center">
                            <div class="text-xl font-bold text-yellow-600 dark:text-yellow-400"><?= $stats['admin_users'] ?></div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Administrators</div>
                        </div>
                        <div class="bg-teal-50 dark:bg-gray-700 rounded-lg p-3 text-center">
                            <div class="text-xl font-bold text-teal-600 dark:text-teal-400"><?= $stats['coach_users'] ?></div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Coaches</div>
                        </div>
                        <div class="bg-pink-50 dark:bg-gray-700 rounded-lg p-3 text-center">
                            <div class="text-xl font-bold text-pink-600 dark:text-pink-400"><?= $stats['student_users'] ?></div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Students</div>
                        </div>
                    </div>
                </div>
                
                <!-- Course Statistics -->
                <div class="px-4 py-3 sm:px-6 border-t border-gray-200">
                    <h4 class="text-sm font-medium text-gray-900 mb-2 flex items-center">
                        <svg class="h-4 w-4 text-indigo-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                        </svg>
                        Course Statistics
                    </h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-orange-50 rounded-lg p-3 text-center">
                            <div class="text-xl font-bold text-orange-600"><?= $stats['total_lessons'] ?></div>
                            <div class="text-xs text-gray-500">Total Lessons</div>
                        </div>
                        <div class="bg-emerald-50 rounded-lg p-3 text-center">
                            <div class="text-xl font-bold text-emerald-600"><?= $stats['completed_lessons'] ?></div>
                            <div class="text-xs text-gray-500">Completed Lessons</div>
                        </div>
                    </div>
                </div>
                
                <!-- System Information -->
                <div class="px-4 py-3 sm:px-6 border-t border-gray-200">
                    <h4 class="text-sm font-medium text-gray-900 mb-2 flex items-center">
                        <svg class="h-4 w-4 text-indigo-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm3.293 1.293a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 01-1.414-1.414L7.586 10 5.293 7.707a1 1 0 010-1.414zM11 12a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                        </svg>
                        System Information
                    </h4>
                    <div class="text-sm text-gray-600 flex items-center justify-between">
                        <span>Database Size:</span>
                        <span class="font-medium"><?= $stats['database_size'] ?> MB</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg h-full flex flex-col">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Recent Activity
                </h3>
                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full"><?= count($recentActivity) ?> activities</span>
            </div>
            <div class="border-t border-gray-200 flex-grow">
                <div class="h-full flex flex-col">
                    <ul class="divide-y divide-gray-200 overflow-y-auto" style="max-height: 400px; height: 400px;">
                        <?php if (empty($recentActivity)): ?>
                            <li class="px-4 py-5 sm:px-6 flex items-center justify-center h-full">
                                <div class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-500">No recent activity</p>
                                </div>
                            </li>
                        <?php else: ?>
                            <?php foreach ($recentActivity as $activity): ?>
                                <li class="px-4 py-4 sm:px-6 hover:bg-gray-50 transition duration-150">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <?php 
                                            // Determine icon based on activity type
                                            switch ($activity['activity_type']) {
                                                case 'completed_lesson':
                                                    $bgColor = 'bg-green-100';
                                                    $textColor = 'text-green-600';
                                                    $icon = '<path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>';
                                                    break;
                                                case 'user_deleted':
                                                    $bgColor = 'bg-red-100';
                                                    $textColor = 'text-red-600';
                                                    $icon = '<path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>';
                                                    break;
                                                case 'new_user':
                                                    $bgColor = 'bg-blue-100';
                                                    $textColor = 'text-blue-600';
                                                    $icon = '<path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />';
                                                    break;
                                                case 'login':
                                                    $bgColor = 'bg-purple-100';
                                                    $textColor = 'text-purple-600';
                                                    $icon = '<path d="M10 2a5 5 0 00-5 5v2a2 2 0 00-2 2v5a2 2 0 002 2h10a2 2 0 002-2v-5a2 2 0 00-2-2H7V7a3 3 0 015.905-.75 1 1 0 001.937-.5A5.002 5.002 0 0010 2z" />';
                                                    break;
                                                default:
                                                    $bgColor = 'bg-gray-100';
                                                    $textColor = 'text-gray-600';
                                                    $icon = '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />';
                                            }
                                            ?>
                                            <span class="inline-flex items-center justify-center h-8 w-8 rounded-full <?= $bgColor ?>">
                                                <svg class="h-5 w-5 <?= $textColor ?>" fill="currentColor" viewBox="0 0 20 20">
                                                    <?= $icon ?>
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="ml-4 flex-grow">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">
                                                        <?= htmlspecialchars($activity['username']) ?>
                                                    </p>
                                                    <p class="text-sm text-gray-500">
                                                        <?php 
                                                        // Format the activity description based on type
                                                        switch ($activity['activity_type']) {
                                                            case 'completed_lesson':
                                                                echo 'Completed lesson: ' . htmlspecialchars($activity['description'] ?? '');
                                                                break;
                                                            case 'user_deleted':
                                                                echo htmlspecialchars($activity['description'] ?? 'Deleted a user');
                                                                break;
                                                            case 'new_user':
                                                                echo 'New user registration';
                                                                if (!empty($activity['target_username'])) {
                                                                    echo ': ' . htmlspecialchars($activity['target_username']);
                                                                }
                                                                break;
                                                            case 'login':
                                                                echo htmlspecialchars($activity['description'] ?? 'Logged in');
                                                                if (!empty($activity['ip_address'])) {
                                                                    echo ' <span class="text-xs font-mono bg-gray-100 dark:bg-gray-700 px-1 py-0.5 rounded">' . htmlspecialchars($activity['ip_address']) . '</span>';
                                                                }
                                                                break;
                                                            default:
                                                                echo htmlspecialchars($activity['description'] ?? $activity['activity_type']);
                                                        }
                                                        ?>
                                                    </p>
                                                </div>
                                                <p class="text-xs text-gray-500">
                                                    <?= date('M j, g:i a', strtotime($activity['activity_date'])) ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                    <div class="border-t border-gray-200 px-4 py-3 bg-gray-50 flex justify-between items-center">
                        <form action="/admin/clear-activity-log" method="POST" onsubmit="return confirm('Are you sure you want to clear all activity logs? This action cannot be undone.')">
                            <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= $csrf_token ?>">
                            <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-800">
                                <svg class="-ml-0.5 mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Clear Log
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        <!-- Quick Actions -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg h-full flex flex-col">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900 flex items-center">
                    <svg class="h-5 w-5 text-indigo-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd" />
                    </svg>
                    Quick Actions
                </h3>
            </div>
            <div class="border-t border-gray-200 flex-grow">
                <div class="p-4 grid grid-cols-1 gap-3 h-full">
                    <a href="/admin/users" class="group relative bg-white hover:bg-indigo-50 rounded-lg border border-gray-200 p-4 flex items-center transition duration-150 ease-in-out">
                        <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-md bg-indigo-100 text-indigo-600 sm:h-12 sm:w-12">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v1h8v-1zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-1a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v1h-3zM4.75 12.094A5.973 5.973 0 004 15v1H1v-1a3 3 0 013.75-2.906z" />
                            </svg>
                        </div>
                        <div class="ml-4 flex-grow">
                            <h4 class="text-lg font-medium text-gray-900 group-hover:text-indigo-600 transition duration-150 ease-in-out">Manage Users</h4>
                            <p class="text-sm text-gray-500">Add, edit, or remove user accounts</p>
                        </div>
                        <div class="flex-shrink-0 self-center ml-2">
                            <svg class="h-5 w-5 text-gray-400 group-hover:text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </a>
                    
                    <a href="/admin/lessons" class="group relative bg-white hover:bg-indigo-50 rounded-lg border border-gray-200 p-4 flex items-center transition duration-150 ease-in-out">
                        <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-md bg-emerald-100 text-emerald-600 sm:h-12 sm:w-12">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                            </svg>
                        </div>
                        <div class="ml-4 flex-grow">
                            <h4 class="text-lg font-medium text-gray-900 group-hover:text-indigo-600 transition duration-150 ease-in-out">Manage Lessons</h4>
                            <p class="text-sm text-gray-500">Create and organize training content</p>
                        </div>
                        <div class="flex-shrink-0 self-center ml-2">
                            <svg class="h-5 w-5 text-gray-400 group-hover:text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </a>
                    
                    <a href="/admin/settings" class="group relative bg-white hover:bg-indigo-50 rounded-lg border border-gray-200 p-4 flex items-center transition duration-150 ease-in-out">
                        <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-md bg-blue-100 text-blue-600 sm:h-12 sm:w-12">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-4 flex-grow">
                            <h4 class="text-lg font-medium text-gray-900 group-hover:text-indigo-600 transition duration-150 ease-in-out">System Settings</h4>
                            <p class="text-sm text-gray-500">Configure platform preferences</p>
                        </div>
                        <div class="flex-shrink-0 self-center ml-2">
                            <svg class="h-5 w-5 text-gray-400 group-hover:text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- System Status -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg h-full flex flex-col">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900 flex items-center">
                    <svg class="h-5 w-5 text-indigo-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm3.293 1.293a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 01-1.414-1.414L7.586 10 5.293 7.707a1 1 0 010-1.414zM11 12a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                    </svg>
                    System Status
                </h3>
                <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full font-medium">All Systems Operational</span>
            </div>
            <div class="border-t border-gray-200 flex-grow">
                <div class="px-4 py-5 sm:p-6">
                    <div class="space-y-6">
                        <div class="bg-white p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8 rounded-md bg-blue-100 flex items-center justify-center">
                                        <svg class="h-5 w-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm3.293 1.293a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 01-1.414-1.414L7.586 10 5.293 7.707a1 1 0 010-1.414zM11 12a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <h4 class="ml-3 text-sm font-medium text-gray-900">Database</h4>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Connected
                                </span>
                            </div>
                            <div class="ml-11">
                                <div class="flex items-center justify-between text-xs text-gray-500 mb-1">
                                    <span>Performance</span>
                                    <span>100%</span>
                                </div>
                                <div class="bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-2 bg-green-500 rounded-full" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8 rounded-md bg-indigo-100 flex items-center justify-center">
                                        <svg class="h-5 w-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <h4 class="ml-3 text-sm font-medium text-gray-900">File System</h4>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Writable
                                </span>
                            </div>
                            <div class="ml-11">
                                <div class="flex items-center justify-between text-xs text-gray-500 mb-1">
                                    <span>Access</span>
                                    <span>100%</span>
                                </div>
                                <div class="bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-2 bg-green-500 rounded-full" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8 rounded-md bg-purple-100 flex items-center justify-center">
                                        <svg class="h-5 w-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-2 0c0 .993-.241 1.929-.668 2.754l-1.524-1.525a3.997 3.997 0 00.078-2.183l1.562-1.562C15.802 8.249 16 9.1 16 10zm-5.165 3.913l1.58 1.58A5.98 5.98 0 0110 16a5.976 5.976 0 01-2.516-.552l1.562-1.562a4.006 4.006 0 001.789.027zm-4.677-2.796a4.002 4.002 0 01-.041-2.08l-.08.08-1.53-1.533A5.98 5.98 0 004 10c0 .954.223 1.856.619 2.657l1.54-1.54zm1.088-6.45A5.974 5.974 0 0110 4c.954 0 1.856.223 2.657.619l-1.54 1.54a4.002 4.002 0 00-2.346.033L7.246 4.668zM12 10a2 2 0 11-4 0 2 2 0 014 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <h4 class="ml-3 text-sm font-medium text-gray-900">Session Handler</h4>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Active
                                </span>
                            </div>
                            <div class="ml-11">
                                <div class="flex items-center justify-between text-xs text-gray-500 mb-1">
                                    <span>Reliability</span>
                                    <span>100%</span>
                                </div>
                                <div class="bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-2 bg-green-500 rounded-full" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
