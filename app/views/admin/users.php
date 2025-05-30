<?php
require_once __DIR__ . '/../../includes/header.php';
$title = 'Manage Users';
?>

<div class="space-y-6">
    <div class="bg-white shadow sm:rounded-lg overflow-hidden" x-data="{ formOpen: false }">
        <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-200 flex justify-between items-center cursor-pointer" @click="formOpen = !formOpen">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 flex items-center">
                    <svg class="h-5 w-5 text-indigo-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                    </svg>
                    Create New User
                </h3>
                <p class="mt-1 text-sm text-gray-500">Add a new user to the CTBlox Training Platform</p>
            </div>
            <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transform transition-transform duration-200" :class="{'rotate-180': formOpen}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
        </div>
        <div class="px-4 py-5 sm:p-6" x-show="formOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2">
            <form action="/admin/users" method="POST">
                <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= $csrf_token ?>">
                <input type="hidden" name="action" value="create">
                
                <div class="grid grid-cols-1 gap-y-6 gap-x-6 sm:grid-cols-6">
                    <div class="sm:col-span-6 md:col-span-2">
                        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                        <div class="mt-1">
                            <input type="text" name="username" id="username" required 
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md h-10 px-3">
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Username must be unique</p>
                    </div>

                    <div class="sm:col-span-6 md:col-span-2">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <div class="mt-1">
                            <input type="email" name="email" id="email" required
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md h-10 px-3">
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Used for account recovery</p>
                    </div>

                    <div class="sm:col-span-6 md:col-span-2">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="mt-1 relative">
                            <input type="password" name="password" id="password" required
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md h-10 px-3 pr-10">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <button type="button" id="togglePassword" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="button" id="generatePassword" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                </svg>
                                Generate Random Password
                            </button>
                        </div>
                    </div>

                    <div class="sm:col-span-6 border-t border-gray-200 pt-5">
                        <h4 class="text-sm font-medium text-gray-900 mb-4">Additional User Roles</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" name="is_admin" id="is_admin"
                                               class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="is_admin" class="font-medium text-gray-900">Administrator</label>
                                        <p class="text-gray-500">Can manage users, lessons, and system settings</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" name="is_coach" id="is_coach"
                                               class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="is_coach" class="font-medium text-gray-900">Coach</label>
                                        <p class="text-gray-500">Can monitor and assist assigned students</p>
                                    </div>
                                </div>
                                
                
                            </div>
                            
                            <div>
                                <label for="coach_id" class="block text-sm font-medium text-gray-700">Assign Coach (optional)</label>
                                <div class="mt-1">
                                    <select name="coach_id" id="coach_id"
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full max-w-xs sm:text-sm border-gray-300 rounded-md h-10 px-3">
                                        <option value="">-- No coach assigned --</option>
                                        <?php foreach ($coaches as $coach): ?>
                                            <option value="<?= $coach['id'] ?>"><?= $this->sanitize($coach['username']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Select a coach for this user</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 pt-5 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="flex items-center h-5">
                                <input type="checkbox" name="send_welcome_email" id="send_welcome_email" checked
                                       class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="send_welcome_email" class="font-medium text-gray-900">Send Welcome Email</label>
                                <p class="text-xs text-gray-500">Email login credentials to the new user</p>
                            </div>
                        </div>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Create User
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4 md:mb-0 flex items-center">
                    <svg class="h-5 w-5 text-indigo-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v1h8v-1zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-1a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v1h-3zM4.75 12.094A5.973 5.973 0 004 15v1H1v-1a3 3 0 013.75-2.906z" />
                    </svg>
                    User Management
                </h3>
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                    <!-- Search Bar -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" id="user-search" placeholder="Search users..." 
                               class="pl-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md h-10 py-2"
                               style="padding-left: 40px;">
                    </div>
                    
                    <!-- Role Filter -->
                    <div>
                        <select id="role-filter" class="block w-full px-3 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md h-10">
                            <option value="all">All Roles</option>
                            <option value="admin">Administrators</option>
                            <option value="coach">Coaches</option>
                            <option value="student">Students</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Username
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Role
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Coach
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Created
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Last Login
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <?php if (!$user['is_admin'] && !$user['is_coach']): ?>
                                        <a href="/coach/student/<?= $user['id'] ?>" class="text-indigo-600 hover:text-indigo-900">
                                            <?= $this->sanitize($user['username']) ?>
                                        </a>
                                    <?php else: ?>
                                        <?= $this->sanitize($user['username']) ?>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <a href="mailto:<?= $this->sanitize($user['email']) ?>" class="text-indigo-600 hover:text-indigo-900">
                                        <?= $this->sanitize($user['email']) ?>
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="space-x-1">
                                        <?php if ($user['is_admin']): ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                Admin
                                            </span>
                                        <?php endif; ?>
                                        <?php if ($user['is_coach']): ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Coach
                                            </span>
                                        <?php endif; ?>
                                        <?php if (!$user['is_admin'] && !$user['is_coach']): ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Student
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php if ($user['coach_id']): ?>
                                        <span class="text-sm text-gray-700"><?= $this->sanitize($user['coach_name']) ?></span>
                                    <?php else: ?>
                                        <span class="text-sm text-gray-400">None</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= $user['created_at'] ? date('F j, Y', strtotime($user['created_at'])) : 'Unknown' ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= $user['last_login'] ? date('F j, Y g:i A', strtotime($user['last_login'])) : 'Never' ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex space-x-2">
                                        <button type="button" 
                                                onclick="editUser(<?= htmlspecialchars(json_encode($user), ENT_QUOTES, 'UTF-8') ?>)"
                                                class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Edit
                                        </button>
                                        <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                            <form action="/admin/users" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= $csrf_token ?>">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                                <button type="submit" class="inline-flex items-center px-2.5 py-1.5 border border-red-300 shadow-sm text-xs font-medium rounded text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                    Delete
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div id="editUserModal"
     x-data="{ open: false, user: null }" 
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
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div x-show="open" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl md:max-w-2xl sm:w-full sm:p-6">
            <form action="/admin/users" method="POST">
                <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= $csrf_token ?>">
                <input type="hidden" name="action" value="update">
                <input type="hidden" id="edit-user-id" name="user_id">
                
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                        Edit User: <span id="edit-username-display" class="font-semibold"></span>
                    </h3>
                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4">
                        <div class="w-full mb-4">
                            <label for="edit-email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <div class="mt-1">
                                <input type="email" name="email" id="edit-email" required
                                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md h-10 px-3">
                            </div>
                        </div>

                        <div class="w-full">
                            <label for="edit-password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Password</label>
                            <div class="mt-1 relative">
                                <input type="password" name="password" id="edit-password"
                                       placeholder="Leave blank to keep existing password"
                                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md h-10 px-3 pr-12">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-2">
                                    <button type="button" id="toggleEditPassword" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="button" id="generateEditPassword" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 dark:border-gray-600 shadow-sm text-xs font-medium rounded text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                    Generate Random Password
                                </button>
                            </div>
                        </div>

                        <div class="w-full border-t border-gray-200 dark:border-gray-700 pt-4 mt-4">
                            <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-4">User Role</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-4">
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input type="checkbox" name="is_admin" id="edit-is-admin"
                                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="edit-is-admin" class="font-medium text-gray-900 dark:text-white">Administrator</label>
                                            <p class="text-gray-500 dark:text-gray-400">Can manage users, lessons, and system settings</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input type="checkbox" name="is_coach" id="edit-is-coach"
                                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="edit-is-coach" class="font-medium text-gray-900 dark:text-white">Coach</label>
                                            <p class="text-gray-500 dark:text-gray-400">Can monitor and assist assigned students</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="edit-coach-id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Assign Coach (optional)</label>
                                    <div class="mt-1">
                                        <select name="coach_id" id="edit-coach-id"
                                               class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full max-w-xs sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md h-10 px-3">
                                            <option value="">-- No coach assigned --</option>
                                            <?php foreach ($coaches as $coach): ?>
                                                <option value="<?= $coach['id'] ?>">
                                                    <?= $this->sanitize($coach['username']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Select a coach for this user</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 sm:col-start-2 sm:text-sm">
                        Save Changes
                    </button>
                    <button type="button" 
                            @click="open = false" 
                            onclick="closeEditModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 sm:mt-0 sm:col-start-1 sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Manual modal styles for fallback when Alpine.js isn't initialized */
body.modal-open {
    overflow: hidden;
}

/* Manual fallback styles for the modal */
#editUserModal.manual-modal {
    display: flex !important;
    align-items: center;
    justify-content: center;
    z-index: 50;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow-y: auto;
}

#editUserModal.manual-modal .modal-content {
    background-color: white;
    border-radius: 0.5rem;
    padding: 1.5rem;
    width: 100%;
    max-width: 32rem;
    margin: 2rem auto;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    position: relative;
    z-index: 60;
}

.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 40;
}

#editUserModal:not([x-cloak])::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: -1;
}
</style>

<script>
// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Setup password controls for create form
    setupPasswordControls();
    
    // Setup role dependencies for create form
    setupRoleFieldDependencies();
});

// Generate random password
function generateRandomPassword() {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*';
    let password = '';
    const length = Math.floor(Math.random() * 3) + 10; // 10-12 characters
    
    for (let i = 0; i < length; i++) {
        password += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    
    return password;
}

// Toggle password visibility
function togglePasswordVisibility(passwordInput, toggleBtn) {
    if (!passwordInput || !toggleBtn) return;
    
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    
    // Change the icon based on visibility
    if (type === 'text') {
        // Show "hide password" icon
        toggleBtn.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
            </svg>
        `;
    } else {
        // Show "show password" icon
        toggleBtn.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
        `;
    }
}

// Generate and set password
function generateAndSetPassword(passwordInput, toggleBtn) {
    if (!passwordInput) return;
    
    const password = generateRandomPassword();
    passwordInput.value = password;
    
    // Show the password
    passwordInput.setAttribute('type', 'text');
    
    // Update the toggle button icon if it exists
    if (toggleBtn) {
        toggleBtn.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
            </svg>
        `;
    }
}

// Setup password controls for create form
function setupPasswordControls() {
    // Get elements
    const passwordInput = document.getElementById('password');
    const togglePasswordBtn = document.getElementById('togglePassword');
    const generatePasswordBtn = document.getElementById('generatePassword');
    
    // Setup toggle password button
    if (togglePasswordBtn && passwordInput) {
        togglePasswordBtn.onclick = function(e) {
            e.preventDefault();
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Update icon based on password visibility
            if (type === 'text') {
                // Show "hide password" icon
                this.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                `;
            } else {
                // Show "show password" icon
                this.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                `;
            }
        };
    }
    
    // Setup generate password button
    if (generatePasswordBtn && passwordInput) {
        generatePasswordBtn.onclick = function(e) {
            e.preventDefault();
            const password = generateRandomPassword();
            passwordInput.value = password;
            
            // Show the password
            passwordInput.setAttribute('type', 'text');
            
            // Update the toggle button icon if it exists
            if (togglePasswordBtn) {
                togglePasswordBtn.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                `;
            }
        };
    }
}

// Setup password controls for edit form
function setupEditPasswordControls() {
    const toggleEditPasswordBtn = document.getElementById('toggleEditPassword');
    const editPasswordInput = document.getElementById('edit-password');
    const generateEditPasswordBtn = document.getElementById('generateEditPassword');
    
    if (toggleEditPasswordBtn && editPasswordInput) {
        // Remove existing event listeners by cloning
        const newToggleBtn = toggleEditPasswordBtn.cloneNode(true);
        toggleEditPasswordBtn.parentNode.replaceChild(newToggleBtn, toggleEditPasswordBtn);
        
        // Add new event listener
        newToggleBtn.addEventListener('click', function() {
            togglePasswordVisibility(editPasswordInput, this);
        });
    }
    
    if (generateEditPasswordBtn && editPasswordInput) {
        // Remove existing event listeners by cloning
        const newGenerateBtn = generateEditPasswordBtn.cloneNode(true);
        generateEditPasswordBtn.parentNode.replaceChild(newGenerateBtn, generateEditPasswordBtn);
        
        // Add new event listener
        newGenerateBtn.addEventListener('click', function() {
            generateAndSetPassword(editPasswordInput, document.getElementById('toggleEditPassword'));
        });
    }
}

// Setup role dependencies for create form
function setupRoleFieldDependencies() {
    const isAdminCheckbox = document.getElementById('is_admin');
    const isCoachCheckbox = document.getElementById('is_coach');
    const coachSelect = document.getElementById('coach_id');
    
    if (!isAdminCheckbox || !isCoachCheckbox || !coachSelect) return;
    
    // Function to update field states
    function updateFieldStates() {
        const isAdmin = isAdminCheckbox.checked;
        const isCoach = isCoachCheckbox.checked;
        const hasCoach = coachSelect.value !== '';
        
        // If user is an admin or a coach, they cannot have a coach
        if (isAdmin || isCoach) {
            coachSelect.disabled = true;
            coachSelect.value = '';
            coachSelect.parentElement.classList.add('opacity-50');
        } else {
            coachSelect.disabled = false;
            coachSelect.parentElement.classList.remove('opacity-50');
        }
        
        // If user has a coach assigned, they cannot be an admin or coach
        if (hasCoach) {
            isAdminCheckbox.disabled = true;
            isCoachCheckbox.disabled = true;
            isAdminCheckbox.checked = false;
            isCoachCheckbox.checked = false;
            isAdminCheckbox.closest('.flex.items-start').classList.add('opacity-50');
            isCoachCheckbox.closest('.flex.items-start').classList.add('opacity-50');
        } else {
            isAdminCheckbox.disabled = false;
            isCoachCheckbox.disabled = false;
            isAdminCheckbox.closest('.flex.items-start').classList.remove('opacity-50');
            isCoachCheckbox.closest('.flex.items-start').classList.remove('opacity-50');
        }
    }
    
    // Set up event listeners
    isAdminCheckbox.addEventListener('change', updateFieldStates);
    isCoachCheckbox.addEventListener('change', updateFieldStates);
    coachSelect.addEventListener('change', updateFieldStates);
    
    // Initial update
    updateFieldStates();
}

// Setup role dependencies for edit form
function setupEditRoleFieldDependencies() {
    const isAdminCheckbox = document.getElementById('edit-is-admin');
    const isCoachCheckbox = document.getElementById('edit-is-coach');
    const coachSelect = document.getElementById('edit-coach-id');
    
    if (!isAdminCheckbox || !isCoachCheckbox || !coachSelect) return;
    
    // Function to update field states
    function updateFieldStates() {
        const isAdmin = isAdminCheckbox.checked;
        const isCoach = isCoachCheckbox.checked;
        const hasCoach = coachSelect.value !== '';
        
        // If user is an admin, they cannot have a coach
        if (isAdmin) {
            coachSelect.disabled = true;
            coachSelect.value = '';
            coachSelect.parentElement.classList.add('opacity-50');
        } else {
            coachSelect.disabled = false;
            coachSelect.parentElement.classList.remove('opacity-50');
        }
        
        // If user has a coach assigned, they cannot be an admin or coach
        if (hasCoach) {
            isAdminCheckbox.disabled = true;
            isCoachCheckbox.disabled = true;
            isAdminCheckbox.checked = false;
            isCoachCheckbox.checked = false;
            isAdminCheckbox.closest('.flex.items-start').classList.add('opacity-50');
            isCoachCheckbox.closest('.flex.items-start').classList.add('opacity-50');
        } else {
            isAdminCheckbox.disabled = false;
            isCoachCheckbox.disabled = false;
            isAdminCheckbox.closest('.flex.items-start').classList.remove('opacity-50');
            isCoachCheckbox.closest('.flex.items-start').classList.remove('opacity-50');
        }
    }
    
    // Set up event listeners
    isAdminCheckbox.addEventListener('change', updateFieldStates);
    isCoachCheckbox.addEventListener('change', updateFieldStates);
    coachSelect.addEventListener('change', updateFieldStates);
    
    // Initial update
    updateFieldStates();
}

// These functions need to be defined in the main file for direct access from HTML
function editUser(user) {
    console.log('Opening edit modal for user:', user);
    
    // Find the modal element
    const modalEl = document.getElementById('editUserModal');
    if (!modalEl) {
        console.error('Edit user modal not found');
        return;
    }
    
    // Manually set the form values
    document.getElementById('edit-user-id').value = user.id;
    document.getElementById('edit-email').value = user.email;
    document.getElementById('edit-is-admin').checked = user.is_admin == 1;
    document.getElementById('edit-is-coach').checked = user.is_coach == 1;
    
    // Determine user role for the title
    let userRole = 'Student';
    if (user.is_admin == 1) {
        userRole = 'Administrator';
    } else if (user.is_coach == 1) {
        userRole = 'Coach';
    }
    
    // Set the username and role in the title
    document.getElementById('edit-username-display').textContent = user.username;
    
    // Update the modal title to include the role
    const modalTitle = document.getElementById('modal-title');
    if (modalTitle) {
        modalTitle.innerHTML = `Edit ${userRole}: <span id="edit-username-display" class="font-semibold">${user.username}</span>`;
    }
    
    // Handle coach selection
    const coachSelect = document.getElementById('edit-coach-id');
    if (coachSelect) {
        // Reset the select first
        coachSelect.value = '';
        
        // If user has a coach_id, select it in the dropdown
        if (user.coach_id) {
            // Find the option with the matching value and select it
            const option = coachSelect.querySelector(`option[value="${user.coach_id}"]`);
            if (option) {
                coachSelect.value = user.coach_id;
                console.log('Selected coach:', option.textContent, 'with ID:', user.coach_id);
            } else {
                console.warn('Coach option not found for ID:', user.coach_id);
            }
        }
    }
    
    // Initialize the role dependencies after setting the coach
    setupEditRoleFieldDependencies();
    
    // Create a completely new modal from scratch
    // First, let's remove any existing modal backdrop
    let existingBackdrop = document.querySelector('.modal-backdrop');
    if (existingBackdrop) {
        document.body.removeChild(existingBackdrop);
    }
    
    // Check if dark mode is enabled
    const isDarkMode = document.documentElement.classList.contains('dark');
    
    // Create a new modal container
    const modalContainer = document.createElement('div');
    modalContainer.id = 'manual-edit-modal';
    modalContainer.style.position = 'fixed';
    modalContainer.style.zIndex = '1050';
    modalContainer.style.top = '0';
    modalContainer.style.left = '0';
    modalContainer.style.width = '100%';
    modalContainer.style.height = '100%';
    modalContainer.style.overflow = 'auto';
    modalContainer.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
    modalContainer.style.display = 'flex';
    modalContainer.style.alignItems = 'center';
    modalContainer.style.justifyContent = 'center';
    
    // Create modal content with dark mode support
    const modalContent = document.createElement('div');
    if (isDarkMode) {
        modalContent.style.backgroundColor = '#1f2937'; // Dark background
        modalContent.style.color = '#f3f4f6'; // Light text
        modalContent.classList.add('dark');
    } else {
        modalContent.style.backgroundColor = '#ffffff'; // Light background
        modalContent.style.color = '#111827'; // Dark text
    }
    modalContent.style.borderRadius = '8px';
    modalContent.style.padding = '20px';
    modalContent.style.width = '90%';
    modalContent.style.maxWidth = '600px';
    modalContent.style.maxHeight = '90vh';
    modalContent.style.overflowY = 'auto';
    modalContent.style.boxShadow = isDarkMode ? 
        '0 4px 6px rgba(255, 255, 255, 0.1)' : 
        '0 4px 6px rgba(0, 0, 0, 0.1)';
    
    // Get the form from the original modal
    const originalForm = modalEl.querySelector('form');
    if (!originalForm) {
        console.error('Form not found in modal');
        return;
    }
    
    // Clone the form
    const formClone = originalForm.cloneNode(true);
    
    // Ensure the coach selection is properly transferred to the cloned form
    if (user.coach_id) {
        const clonedCoachSelect = formClone.querySelector('#edit-coach-id');
        if (clonedCoachSelect) {
            clonedCoachSelect.value = user.coach_id;
            console.log('Setting coach ID in cloned form:', user.coach_id);
        }
    }
    
    // Apply appropriate styles based on mode
    // Style form inputs
    const inputs = formClone.querySelectorAll('input[type="text"], input[type="email"], input[type="password"], select');
    inputs.forEach(input => {
        if (isDarkMode) {
            input.style.backgroundColor = '#374151';
            input.style.borderColor = '#4b5563';
            input.style.color = '#f3f4f6';
        } else {
            input.style.backgroundColor = '#ffffff';
            input.style.borderColor = '#d1d5db';
            input.style.color = '#111827';
        }
    });
    
    // Style labels
    const labels = formClone.querySelectorAll('label');
    labels.forEach(label => {
        if (isDarkMode) {
            label.style.color = '#f3f4f6';
        } else {
            label.style.color = '#374151';
        }
    });
    
    // Style headings
    const headings = formClone.querySelectorAll('h3, h4');
    headings.forEach(heading => {
        if (isDarkMode) {
            heading.style.color = '#f3f4f6';
        } else {
            heading.style.color = '#111827';
        }
    });
    
    // Style buttons
    const buttons = formClone.querySelectorAll('button:not([type="submit"])');
    buttons.forEach(button => {
        if (!button.classList.contains('bg-indigo-600')) {
            if (isDarkMode) {
                button.style.backgroundColor = '#374151';
                button.style.borderColor = '#4b5563';
                button.style.color = '#f3f4f6';
            } else {
                button.style.backgroundColor = '#f9fafb';
                button.style.borderColor = '#d1d5db';
                button.style.color = '#111827';
            }
        }
    });
    
    // Style any dividers/borders
    const dividers = formClone.querySelectorAll('.border-t, .border-b, .border-l, .border-r, [class*="border"]');
    dividers.forEach(divider => {
        if (isDarkMode) {
            divider.style.borderColor = '#4b5563';
        } else {
            divider.style.borderColor = '#e5e7eb';
        }
    });
    
    // Add content to the modal
    modalContent.appendChild(formClone);
    modalContainer.appendChild(modalContent);
    
    // Add the modal to the body
    document.body.appendChild(modalContainer);
    
    // Prevent scrolling on the body
    document.body.style.overflow = 'hidden';
    
    // Setup the edit form controls
    // We need to find the elements in our cloned form
    const clonedPasswordInput = formClone.querySelector('#edit-password');
    const clonedToggleBtn = formClone.querySelector('#toggleEditPassword');
    const clonedGenerateBtn = formClone.querySelector('#generateEditPassword');
    
    if (clonedToggleBtn && clonedPasswordInput) {
        clonedToggleBtn.addEventListener('click', function() {
            togglePasswordVisibility(clonedPasswordInput, this);
        });
    }
    
    if (clonedGenerateBtn && clonedPasswordInput) {
        clonedGenerateBtn.addEventListener('click', function() {
            generateAndSetPassword(clonedPasswordInput, clonedToggleBtn);
        });
    }
    
    // Setup role dependencies
    const clonedIsAdminCheckbox = formClone.querySelector('#edit-is-admin');
    const clonedIsCoachCheckbox = formClone.querySelector('#edit-is-coach');
    const clonedCoachSelect = formClone.querySelector('#edit-coach-id');
    
    if (clonedIsAdminCheckbox && clonedIsCoachCheckbox && clonedCoachSelect) {
        // Function to update field states
        function updateFieldStates() {
            const isAdmin = clonedIsAdminCheckbox.checked;
            const isCoach = clonedIsCoachCheckbox.checked;
            const hasCoach = clonedCoachSelect.value !== '';
            
            // If user is an admin or a coach, they cannot have a coach
            if (isAdmin || isCoach) {
                clonedCoachSelect.disabled = true;
                clonedCoachSelect.value = '';
                clonedCoachSelect.parentElement.classList.add('opacity-50');
            } else {
                clonedCoachSelect.disabled = false;
                clonedCoachSelect.parentElement.classList.remove('opacity-50');
            }
            
            // If user has a coach assigned, they cannot be an admin or coach
            if (hasCoach) {
                clonedIsAdminCheckbox.disabled = true;
                clonedIsCoachCheckbox.disabled = true;
                clonedIsAdminCheckbox.checked = false;
                clonedIsCoachCheckbox.checked = false;
                clonedIsAdminCheckbox.closest('.flex.items-start').classList.add('opacity-50');
                clonedIsCoachCheckbox.closest('.flex.items-start').classList.add('opacity-50');
            } else {
                clonedIsAdminCheckbox.disabled = false;
                clonedIsCoachCheckbox.disabled = false;
                clonedIsAdminCheckbox.closest('.flex.items-start').classList.remove('opacity-50');
                clonedIsCoachCheckbox.closest('.flex.items-start').classList.remove('opacity-50');
            }
        }
        
        // Set up event listeners
        clonedIsAdminCheckbox.addEventListener('change', updateFieldStates);
        clonedIsCoachCheckbox.addEventListener('change', updateFieldStates);
        clonedCoachSelect.addEventListener('change', updateFieldStates);
        
        // Initial update
        updateFieldStates();
    }
}

function closeEditModal() {
    console.log('Closing edit modal');
    
    // Find our manual modal
    const manualModal = document.getElementById('manual-edit-modal');
    if (manualModal) {
        // Remove it from the DOM
        document.body.removeChild(manualModal);
    }
    
    // Restore body scrolling
    document.body.style.overflow = '';
    
    // Clear any form data for security
    const passwordField = document.getElementById('edit-password');
    if (passwordField) {
        passwordField.value = '';
    }
}

// Setup for the create user form
function setupCreateForm() {
    
    if (!isAdminCheckbox || !isCoachCheckbox || !coachSelect) return;
    
    // Function to update field states
    function updateFieldStates() {
        const isAdmin = isAdminCheckbox.checked;
        const isCoach = isCoachCheckbox.checked;
        const hasCoach = coachSelect.value !== '';
        
        // If user is an admin, they cannot have a coach
        if (isAdmin) {
            coachSelect.disabled = true;
            coachSelect.value = '';
            coachSelect.parentElement.classList.add('opacity-50');
        } else {
            coachSelect.disabled = false;
            coachSelect.parentElement.classList.remove('opacity-50');
        }
        
        // If user has a coach assigned, they cannot be an admin or coach
        if (hasCoach) {
            isAdminCheckbox.disabled = true;
            isCoachCheckbox.disabled = true;
            isAdminCheckbox.checked = false;
            isCoachCheckbox.checked = false;
            isAdminCheckbox.closest('.flex.items-start').classList.add('opacity-50');
            isCoachCheckbox.closest('.flex.items-start').classList.add('opacity-50');
        } else {
            isAdminCheckbox.disabled = false;
            isCoachCheckbox.disabled = false;
            isAdminCheckbox.closest('.flex.items-start').classList.remove('opacity-50');
            isCoachCheckbox.closest('.flex.items-start').classList.remove('opacity-50');
        }
    }
    
    // Set up event listeners
    isAdminCheckbox.addEventListener('change', updateFieldStates);
    isCoachCheckbox.addEventListener('change', updateFieldStates);
    coachSelect.addEventListener('change', updateFieldStates);
    
    // Initial update
    updateFieldStates();
}

// Function to set up role-based field dependencies for edit form
function setupEditRoleFieldDependencies() {
    const isAdminCheckbox = document.getElementById('edit-is-admin');
    const isCoachCheckbox = document.getElementById('edit-is-coach');
    const coachSelect = document.getElementById('edit-coach-id');
    
    if (!isAdminCheckbox || !isCoachCheckbox || !coachSelect) return;
    
    // Function to update field states
    function updateFieldStates() {
        const isAdmin = isAdminCheckbox.checked;
        const isCoach = isCoachCheckbox.checked;
        const hasCoach = coachSelect.value !== '';
        
        // If user is an admin, they cannot have a coach
        if (isAdmin) {
            coachSelect.disabled = true;
            coachSelect.value = '';
            coachSelect.parentElement.classList.add('opacity-50');
        } else {
            coachSelect.disabled = false;
            coachSelect.parentElement.classList.remove('opacity-50');
        }
        
        // If user has a coach assigned, they cannot be an admin or coach
        if (hasCoach) {
            isAdminCheckbox.disabled = true;
            isCoachCheckbox.disabled = true;
            isAdminCheckbox.checked = false;
            isCoachCheckbox.checked = false;
            isAdminCheckbox.closest('.flex.items-start').classList.add('opacity-50');
            isCoachCheckbox.closest('.flex.items-start').classList.add('opacity-50');
        } else {
            isAdminCheckbox.disabled = false;
            isCoachCheckbox.disabled = false;
            isAdminCheckbox.closest('.flex.items-start').classList.remove('opacity-50');
            isCoachCheckbox.closest('.flex.items-start').classList.remove('opacity-50');
        }
    }
    
    // Set up event listeners
    isAdminCheckbox.addEventListener('change', updateFieldStates);
    isCoachCheckbox.addEventListener('change', updateFieldStates);
    coachSelect.addEventListener('change', updateFieldStates);
    
    // Initial update
    updateFieldStates();
}

// Initialize everything when the DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Setup all password controls including toggle and generate
    setupPasswordControls();
    
    // Setup role field dependencies
    setupRoleFieldDependencies();
    
    // Setup edit form password controls
    const toggleEditPasswordBtn = document.getElementById('toggleEditPassword');
    const editPasswordInput = document.getElementById('edit-password');
    
    if (toggleEditPasswordBtn && editPasswordInput) {
        toggleEditPasswordBtn.addEventListener('click', function() {
            const type = editPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            editPasswordInput.setAttribute('type', type);
        });
    }
    
    // Setup password generator for edit form
    const generateEditPasswordBtn = document.getElementById('generateEditPassword');
    if (generateEditPasswordBtn && editPasswordInput) {
        generateEditPasswordBtn.addEventListener('click', function() {
            const length = 12;
            const charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+~`|}{[]\\:;?><,./-=';
            let password = '';
            for (let i = 0; i < length; i++) {
                const randomIndex = Math.floor(Math.random() * charset.length);
                password += charset[randomIndex];
            }
            editPasswordInput.value = password;
            editPasswordInput.setAttribute('type', 'text');
            setTimeout(() => {
                editPasswordInput.setAttribute('type', 'password');
            }, 3000);
        });
    }
    
    // Setup role field dependencies
    setupRoleFieldDependencies();
    setupEditRoleFieldDependencies();
    
    // Setup user search and filtering
    setupUserSearchAndFilters();
});

// Function to handle user search and filtering
function setupUserSearchAndFilters() {
    const searchInput = document.getElementById('user-search');
    const roleFilter = document.getElementById('role-filter');
    const userRows = document.querySelectorAll('table tbody tr');
    
    if (!searchInput || !roleFilter || userRows.length === 0) return;
    
    // Function to filter the table rows
    function filterUserTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const roleValue = roleFilter.value;
        
        userRows.forEach(row => {
            const username = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
            const email = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const roleCell = row.querySelector('td:nth-child(3)');
            
            // Check if the row matches the search term
            const matchesSearch = searchTerm === '' || 
                                 username.includes(searchTerm) || 
                                 email.includes(searchTerm);
            
            // Check if the row matches the selected role
            let matchesRole = true;
            if (roleValue !== 'all') {
                if (roleValue === 'admin') {
                    matchesRole = roleCell.textContent.includes('Admin');
                } else if (roleValue === 'coach') {
                    matchesRole = roleCell.textContent.includes('Coach');
                } else if (roleValue === 'student') {
                    matchesRole = roleCell.textContent.includes('Student');
                }
            }
            
            // Show or hide the row based on both filters
            row.style.display = matchesSearch && matchesRole ? '' : 'none';
        });
    }
    
    // Add event listeners
    searchInput.addEventListener('input', filterUserTable);
    roleFilter.addEventListener('change', filterUserTable);
}
</script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
