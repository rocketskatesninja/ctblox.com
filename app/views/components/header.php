<header class="bg-white shadow-sm">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ mobileMenuOpen: false }">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="text-2xl font-bold text-indigo-600">CTBlox</a>
                </div>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="/dashboard" class="<?= str_starts_with($_SERVER['REQUEST_URI'], '/dashboard') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Dashboard
                        </a>
                        <?php if ($_SESSION['is_admin']): ?>
                            <a href="/admin/dashboard" class="<?= str_starts_with($_SERVER['REQUEST_URI'], '/admin') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Admin
                            </a>
                        <?php endif; ?>
                        <a href="/dashboard/certificates" class="<?= str_starts_with($_SERVER['REQUEST_URI'], '/certificates') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Certificates
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    <div class="ml-3 relative" x-data="{ open: false }">
                        <div>
                            <button @click="open = !open" class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="user-menu-button">
                                <span class="sr-only">Open user menu</span>
                                <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-indigo-100">
                                    <span class="text-sm font-medium leading-none text-indigo-700">
                                        <?= strtoupper(substr($_SESSION['username'], 0, 1)) ?>
                                    </span>
                                </span>
                            </button>
                        </div>
                        <div x-show="open" 
                             @click.away="open = false"
                             class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                             role="menu">
                            <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Profile</a>
                            <a href="/logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Sign out</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                    <span class="sr-only">Open main menu</span>
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
        
        <div x-show="mobileMenuOpen" class="sm:hidden">
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="pt-2 pb-3 space-y-1">
                    <a href="/dashboard" class="<?= str_starts_with($_SERVER['REQUEST_URI'], '/dashboard') ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' ?> block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                        Dashboard
                    </a>
                    <?php if ($_SESSION['is_admin']): ?>
                        <a href="/admin/dashboard" class="<?= str_starts_with($_SERVER['REQUEST_URI'], '/admin') ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' ?> block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                            Admin
                        </a>
                    <?php endif; ?>
                    <a href="/dashboard/certificates" class="<?= str_starts_with($_SERVER['REQUEST_URI'], '/certificates') ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' ?> block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                        Certificates
                    </a>
                </div>
                <div class="pt-4 pb-3 border-t border-gray-200">
                    <div class="flex items-center px-4">
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-indigo-100">
                                <span class="text-sm font-medium leading-none text-indigo-700">
                                    <?= strtoupper(substr($_SESSION['username'], 0, 1)) ?>
                                </span>
                            </span>
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-gray-800"><?= $_SESSION['username'] ?></div>
                        </div>
                    </div>
                    <div class="mt-3 space-y-1">
                        <a href="/profile" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                            Profile
                        </a>
                        <a href="/logout" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                            Sign out
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </nav>
</header>
