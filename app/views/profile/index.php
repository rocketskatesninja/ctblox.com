<?php
require_once __DIR__ . '/../../includes/header.php';
$title = 'Your Profile';
?>

<div class="max-w-7xl mx-auto py-2 sm:px-6 lg:px-8">
    <div class="mx-auto" style="max-width: 60%;">
            <?php if (isset($_SESSION['flash_message'])): ?>
                <div class="mb-4 px-4 py-3 rounded-md <?= $_SESSION['flash_type'] === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                    <?= $_SESSION['flash_message'] ?>
                </div>
            <?php endif; ?>
            
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
                <div class="px-4 py-5 sm:px-6 bg-gray-50">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Personal Information</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Update your name, email, and bio</p>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <form action="/profile/update" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                        
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                                <input type="text" name="username" id="username" value="<?= htmlspecialchars($user['username']) ?>" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md bg-gray-100 h-10 px-3" disabled>
                                <p class="mt-1 text-xs text-gray-500">Username cannot be changed</p>
                            </div>
                            
                            <div class="col-span-6 sm:col-span-3">
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="name" id="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md h-10 px-3">
                                <?php if (isset($_SESSION['form_errors']['name'])): ?>
                                    <p class="mt-1 text-sm text-red-600"><?= $_SESSION['form_errors']['name'] ?></p>
                                <?php endif; ?>
                            </div>
                            
                            <div class="col-span-6">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                                <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md h-10 px-3">
                                <?php if (isset($_SESSION['form_errors']['email'])): ?>
                                    <p class="mt-1 text-sm text-red-600"><?= $_SESSION['form_errors']['email'] ?></p>
                                <?php endif; ?>
                            </div>
                            
                            <div class="col-span-6">
                                <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                                <div class="mt-1">
                                    <textarea id="bio" name="bio" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md px-3 py-2"><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">Brief description about yourself (optional).</p>
                            </div>
                        </div>
                        
                        <div class="mt-6 px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Save Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
                <div class="px-4 py-5 sm:px-6 bg-gray-50">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Change Password</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Update your password securely</p>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    
                    <form action="/profile/change-password" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                        
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-4">
                                <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                                <input type="password" name="current_password" id="current_password" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md h-10 px-3">
                                <?php if (isset($_SESSION['password_errors']['current_password'])): ?>
                                    <p class="mt-1 text-sm text-red-600"><?= $_SESSION['password_errors']['current_password'] ?></p>
                                <?php endif; ?>
                            </div>
                            
                            <div class="col-span-6 sm:col-span-4">
                                <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                                <input type="password" name="new_password" id="new_password" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md h-10 px-3">
                                <?php if (isset($_SESSION['password_errors']['new_password'])): ?>
                                    <p class="mt-1 text-sm text-red-600"><?= $_SESSION['password_errors']['new_password'] ?></p>
                                <?php endif; ?>
                            </div>
                            
                            <div class="col-span-6 sm:col-span-4">
                                <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md h-10 px-3">
                                <?php if (isset($_SESSION['password_errors']['confirm_password'])): ?>
                                    <p class="mt-1 text-sm text-red-600"><?= $_SESSION['password_errors']['confirm_password'] ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="mt-6 px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Change Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <?php if (isset($user['is_coach']) && $user['is_coach']): ?>
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
                <div class="px-4 py-5 sm:px-6 bg-gray-50">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Coach Information</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">View your assigned students and their progress</p>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6">
                            <label class="block text-sm font-medium text-gray-700">Assigned Students</label>
                            <div class="mt-2">
                                <?php 
                                $students = (new User())->getStudents($user['id']);
                                if (empty($students)): 
                                ?>
                                    <p class="text-sm text-gray-500">No students assigned yet.</p>
                                <?php else: ?>
                                    <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                                        <?php foreach ($students as $student): ?>
                                            <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                                <div class="w-0 flex-1 flex items-center">
                                                    <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="ml-2 flex-1 w-0 truncate"><?= htmlspecialchars($student['name']) ?> (<?= htmlspecialchars($student['username']) ?>)</span>
                                                </div>
                                                <div class="ml-4 flex-shrink-0">
                                                    <a href="/coach/student/<?= $student['id'] ?>" class="font-medium text-indigo-600 hover:text-indigo-500">View Progress</a>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if (isset($user['is_admin']) && $user['is_admin']): ?>
            <div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Admin Options</h3>
                    
                    <div class="grid grid-cols-1 gap-4">
                        <a href="/admin/dashboard" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-5 w-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            Go to Admin Dashboard
                        </a>
                        
                        <a href="/admin/users" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-5 w-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v1h8v-1zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-1a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v1h-3zM4.75 12.094A5.973 5.973 0 004 15v1H1v-1a3 3 0 013.75-2.906z" />
                            </svg>
                            Manage Users
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
    </div>
</div>

<?php 
// Clear form errors and data after displaying them
unset($_SESSION['form_errors']);
unset($_SESSION['form_data']);
unset($_SESSION['password_errors']);

require_once __DIR__ . '/../../includes/footer.php'; 
?>
