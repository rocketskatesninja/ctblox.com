<?php
require_once __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - ' . APP_NAME : APP_NAME ?></title>
    
    <!-- Prevent flash of light mode -->
    <script>
        // Immediately check for dark mode preference to prevent flash
        (function() {
            var savedDarkMode = localStorage.getItem('darkMode');
            var prefersDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            if (savedDarkMode === 'enabled' || (savedDarkMode === null && prefersDarkMode)) {
                // Remove light class and add dark class to html element
                document.documentElement.classList.remove('light');
                document.documentElement.classList.add('dark');
                
                // Add dark-mode class to body as soon as it exists
                document.addEventListener('DOMContentLoaded', function() {
                    document.body.classList.add('dark-mode');
                });
                
                // Apply critical dark mode styles immediately to prevent flash
                document.write('<style>' + 
                    'html.dark { color-scheme: dark; }' +
                    'html.dark body { background-color: #1a202c !important; color: #e2e8f0 !important; }' +
                    'html.dark .bg-white, html.dark nav, html.dark footer, html.dark .card, ' +
                    'html.dark .shadow, html.dark .bg-gray-50, html.dark .bg-gray-100, ' +
                    'html.dark [class*="bg-white"], html.dark header, html.dark aside, ' +
                    'html.dark .dropdown-menu, html.dark .modal-content { background-color: #2d3748 !important; }' +
                    'html.dark .text-gray-900, html.dark .text-gray-800, html.dark .text-gray-700, ' +
                    'html.dark h1, html.dark h2, html.dark h3, html.dark h4, html.dark h5, html.dark h6 { color: #e2e8f0 !important; }' +
                    'html.dark .border, html.dark .border-gray-200, html.dark .border-gray-300, ' +
                    'html.dark .border-t, html.dark .border-b, html.dark .border-l, html.dark .border-r { border-color: #4a5568 !important; }' +
                    'html.dark table th { background-color: #2d3748 !important; color: #e2e8f0 !important; }' +
                    'html.dark table td { border-color: #4a5568 !important; }' +
                    
                    /* Progress bar dark mode styles */
                    'html.dark .bg-gray-200 { background-color: #4a5568 !important; }' +
                    'html.dark .bg-green-500 { background-color: #48bb78 !important; }' +
                    'html.dark .bg-yellow-500 { background-color: #ecc94b !important; }' +
                    'html.dark .bg-red-500 { background-color: #f56565 !important; }' +
                    
                    /* Button and badge dark mode styles */
                    'html.dark .bg-red-50 { background-color: rgba(245, 101, 101, 0.2) !important; }' +
                    'html.dark .text-red-700 { color: #fc8181 !important; }' +
                    'html.dark .bg-red-100 { background-color: rgba(245, 101, 101, 0.3) !important; }' +
                    'html.dark .text-red-800 { color: #feb2b2 !important; }' +
                    
                    'html.dark .bg-green-50 { background-color: rgba(72, 187, 120, 0.2) !important; }' +
                    'html.dark .bg-green-100 { background-color: rgba(72, 187, 120, 0.3) !important; }' +
                    'html.dark .text-green-500 { color: #68d391 !important; }' +
                    'html.dark .text-green-800 { color: #9ae6b4 !important; }' +
                    
                    'html.dark .bg-blue-100 { background-color: rgba(66, 153, 225, 0.3) !important; }' +
                    'html.dark .text-blue-500 { color: #63b3ed !important; }' +
                    'html.dark .text-blue-800 { color: #90cdf4 !important; }' +
                    
                    'html.dark .bg-yellow-100 { background-color: rgba(236, 201, 75, 0.3) !important; }' +
                    'html.dark .text-yellow-500 { color: #f6e05e !important; }' +
                    'html.dark .text-yellow-800 { color: #faf089 !important; }' +
                    
                    'html.dark .bg-indigo-100 { background-color: rgba(102, 126, 234, 0.3) !important; }' +
                    'html.dark .text-indigo-500 { color: #7f9cf5 !important; }' +
                    'html.dark .text-indigo-800 { color: #a3bffa !important; }' +
                    'html.dark input, html.dark select, html.dark textarea { background-color: #2d3748 !important; color: #e2e8f0 !important; border-color: #4a5568 !important; }' +
                    'html.dark .bg-indigo-50, html.dark .bg-purple-50, html.dark .bg-blue-50, ' +
                    'html.dark .bg-green-50, html.dark .bg-emerald-50, html.dark .bg-orange-50 { background-color: #2d3748 !important; }' +
                '</style>');
            }
        })();
    </script>
    
    <!-- Tailwind CSS - Using CDN for development, would use compiled CSS in production -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Custom CSS for consistent form styling -->
    <link rel="stylesheet" href="/assets/css/custom.css">
    
    <!-- Custom styles -->
    <style>
        /* Add any custom styles here */
        [x-cloak] { display: none !important; }
        
        /* Add z-index to ensure menu appears on top */
        #user-dropdown-menu {
            z-index: 50;
        }
        
        /* Dark mode styles - Base */
        .dark-mode {
            background-color: #1a202c !important;
            color: #e2e8f0 !important;
        }
        
        .dark-mode body {
            background-color: #1a202c !important;
            color: #e2e8f0 !important;
        }
        
        /* Background colors */
        .dark-mode .bg-white,
        .dark-mode .bg-gray-50,
        .dark-mode div[class*="bg-white"],
        .dark-mode header,
        .dark-mode nav,
        .dark-mode aside,
        .dark-mode footer,
        .dark-mode .card,
        .dark-mode .modal-content,
        .dark-mode .dropdown-menu,
        .dark-mode .popover,
        .dark-mode .tooltip-inner,
        .dark-mode .toast,
        .dark-mode .alert {
            background-color: #2d3748 !important;
            color: #e2e8f0 !important;
        }
        
        .dark-mode .bg-gray-100,
        .dark-mode .bg-gray-200 {
            background-color: #1a202c !important;
        }
        
        /* Text colors */
        .dark-mode .text-black,
        .dark-mode .text-gray-900,
        .dark-mode .text-gray-800,
        .dark-mode h1, .dark-mode h2, .dark-mode h3, .dark-mode h4, .dark-mode h5, .dark-mode h6,
        .dark-mode th {
            color: #f7fafc !important;
        }
        
        .dark-mode .text-gray-700,
        .dark-mode .text-gray-600 {
            color: #e2e8f0 !important;
        }
        
        .dark-mode .text-gray-500,
        .dark-mode .text-gray-400 {
            color: #a0aec0 !important;
        }
        
        /* Border colors */
        .dark-mode .border,
        .dark-mode .border-gray-100,
        .dark-mode .border-gray-200,
        .dark-mode .border-gray-300,
        .dark-mode .border-gray-400,
        .dark-mode .border-t,
        .dark-mode .border-b,
        .dark-mode .border-l,
        .dark-mode .border-r,
        .dark-mode hr,
        .dark-mode table,
        .dark-mode td,
        .dark-mode th {
            border-color: #4a5568 !important;
        }
        
        /* Form elements */
        .dark-mode input,
        .dark-mode select,
        .dark-mode textarea,
        .dark-mode .form-control,
        .dark-mode .form-select,
        .dark-mode .form-check-input {
            background-color: #2d3748 !important;
            color: #e2e8f0 !important;
            border-color: #4a5568 !important;
        }
        
        .dark-mode input::placeholder,
        .dark-mode textarea::placeholder {
            color: #718096 !important;
        }
        
        .dark-mode input:focus,
        .dark-mode select:focus,
        .dark-mode textarea:focus {
            border-color: #5a67d8 !important;
            box-shadow: 0 0 0 2px rgba(90, 103, 216, 0.25) !important;
        }
        
        /* Buttons */
        .dark-mode .btn,
        .dark-mode button:not(.bg-indigo-600):not(.bg-red-600):not(.bg-green-600) {
            background-color: #2d3748 !important;
            color: #e2e8f0 !important;
            border-color: #4a5568 !important;
        }
        
        .dark-mode .btn:hover,
        .dark-mode button:not(.bg-indigo-600):not(.bg-red-600):not(.bg-green-600):hover {
            background-color: #4a5568 !important;
        }
        
        .dark-mode button.bg-indigo-600 {
            background-color: #5a67d8 !important;
        }
        
        .dark-mode button.bg-indigo-600:hover {
            background-color: #4c51bf !important;
        }
        
        .dark-mode button.bg-red-600 {
            background-color: #e53e3e !important;
        }
        
        .dark-mode button.bg-red-600:hover {
            background-color: #c53030 !important;
        }
        
        .dark-mode button.bg-green-600 {
            background-color: #38a169 !important;
        }
        
        .dark-mode button.bg-green-600:hover {
            background-color: #2f855a !important;
        }
        
        /* Tables */
        .dark-mode table {
            color: #e2e8f0 !important;
        }
        
        .dark-mode th {
            background-color: #2d3748 !important;
            color: #e2e8f0 !important;
        }
        
        .dark-mode tr:nth-child(odd) {
            background-color: #2d3748 !important;
        }
        
        .dark-mode tr:nth-child(even) {
            background-color: #374151 !important;
        }
        
        /* Links */
        .dark-mode a:not(.btn) {
            color: #63b3ed !important;
        }
        
        .dark-mode a:hover:not(.btn) {
            color: #90cdf4 !important;
            text-decoration: underline;
        }
        
        /* Cards and panels */
        .dark-mode .card,
        .dark-mode .panel {
            background-color: #2d3748 !important;
            border-color: #4a5568 !important;
        }
        
        .dark-mode .card-header,
        .dark-mode .panel-heading {
            background-color: #374151 !important;
            border-color: #4a5568 !important;
        }
        
        /* Shadows */
        .dark-mode .shadow,
        .dark-mode .shadow-sm,
        .dark-mode .shadow-md,
        .dark-mode .shadow-lg,
        .dark-mode .shadow-xl {
            --tw-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.4), 0 1px 2px 0 rgba(0, 0, 0, 0.24) !important;
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow) !important;
        }
        
        /* Navigation */
        .dark-mode nav {
            background-color: #2d3748 !important;
        }
        
        .dark-mode .nav-link {
            color: #e2e8f0 !important;
        }
        
        .dark-mode .nav-link:hover {
            color: #90cdf4 !important;
        }
        
        /* Dropdown menus */
        .dark-mode #user-dropdown-menu,
        .dark-mode .dropdown-menu {
            background-color: #2d3748 !important;
            border-color: #4a5568 !important;
        }
        
        .dark-mode .dropdown-item:hover {
            background-color: #4a5568 !important;
        }
        
        /* Footer */
        .dark-mode footer {
            background-color: #2d3748 !important;
            color: #e2e8f0 !important;
            border-top-color: #4a5568 !important;
        }
        
        /* Hover and focus states */
        .dark-mode a:hover,
        .dark-mode button:hover,
        .dark-mode .hover\:bg-gray-50:hover,
        .dark-mode .hover\:bg-gray-100:hover,
        .dark-mode .hover\:bg-gray-200:hover,
        .dark-mode tr:hover,
        .dark-mode .hover\:text-gray-900:hover {
            background-color: #4a5568 !important;
            color: #f7fafc !important;
        }
        
        .dark-mode .focus\:ring-indigo-500:focus,
        .dark-mode .focus\:border-indigo-500:focus,
        .dark-mode input:focus,
        .dark-mode select:focus,
        .dark-mode textarea:focus {
            border-color: #5a67d8 !important;
            box-shadow: 0 0 0 3px rgba(90, 103, 216, 0.35) !important;
        }
        
        /* Scrollbars - Webkit browsers */
        .dark-mode ::-webkit-scrollbar {
            width: 14px;
            height: 14px;
        }
        
        .dark-mode ::-webkit-scrollbar-track {
            background: #1a202c;
        }
        
        .dark-mode ::-webkit-scrollbar-thumb {
            background-color: #4a5568;
            border-radius: 10px;
            border: 3px solid #1a202c;
        }
        
        .dark-mode ::-webkit-scrollbar-thumb:hover {
            background-color: #718096;
        }
        
        /* Scrollbars - Firefox */
        .dark-mode * {
            scrollbar-color: #4a5568 #1a202c;
            scrollbar-width: thin;
        }
        
        /* Selection highlight */
        .dark-mode ::selection {
            background-color: #5a67d8 !important;
            color: #ffffff !important;
        }
        
        /* Active states */
        .dark-mode .active,
        .dark-mode .selected,
        .dark-mode .current,
        .dark-mode .bg-indigo-100,
        .dark-mode .bg-blue-100,
        .dark-mode .bg-green-100,
        .dark-mode .bg-yellow-100,
        .dark-mode .bg-red-100,
        .dark-mode .bg-purple-100,
        .dark-mode .bg-pink-100 {
            background-color: #3c4655 !important;
            color: #e2e8f0 !important;
        }
        
        /* Tooltips and popovers */
        .dark-mode [role="tooltip"],
        .dark-mode .tooltip,
        .dark-mode .popover {
            background-color: #2d3748 !important;
            color: #e2e8f0 !important;
            border-color: #4a5568 !important;
        }
        
        /* Progress bars */
        .dark-mode progress,
        .dark-mode .progress {
            background-color: #4a5568 !important;
        }
        
        .dark-mode progress::-webkit-progress-bar,
        .dark-mode .progress-bar {
            background-color: #4a5568 !important;
        }
        
        .dark-mode progress::-webkit-progress-value,
        .dark-mode .progress-value {
            background-color: #5a67d8 !important;
        }
        
        .dark-mode progress::-moz-progress-bar {
            background-color: #5a67d8 !important;
        }
        
        /* Dashboard stat cards */
        .dark-mode .bg-blue-50,
        .dark-mode .bg-indigo-50,
        .dark-mode .bg-purple-50,
        .dark-mode .bg-pink-50,
        .dark-mode .bg-red-50,
        .dark-mode .bg-orange-50,
        .dark-mode .bg-yellow-50,
        .dark-mode .bg-green-50,
        .dark-mode .bg-emerald-50,
        .dark-mode .bg-teal-50,
        .dark-mode .bg-cyan-50 {
            background-color: #2d3748 !important;
            color: #e2e8f0 !important;
            border: 1px solid #4a5568 !important;
        }
        
        /* Dashboard stat numbers with specific colors */
        .dark-mode .text-blue-600,
        .dark-mode .text-blue-500 {
            color: #63b3ed !important; /* lighter blue */
        }
        
        .dark-mode .text-indigo-600,
        .dark-mode .text-indigo-500 {
            color: #7f9cf5 !important; /* lighter indigo */
        }
        
        .dark-mode .text-purple-600,
        .dark-mode .text-purple-500 {
            color: #b794f4 !important; /* lighter purple */
        }
        
        .dark-mode .text-green-600,
        .dark-mode .text-green-500 {
            color: #68d391 !important; /* lighter green */
        }
        
        .dark-mode .text-emerald-600,
        .dark-mode .text-emerald-500 {
            color: #34d399 !important; /* lighter emerald */
        }
        
        .dark-mode .text-yellow-600,
        .dark-mode .text-yellow-500 {
            color: #faf089 !important; /* lighter yellow */
        }
        
        .dark-mode .text-red-600,
        .dark-mode .text-red-500 {
            color: #fc8181 !important; /* lighter red */
        }
        
        .dark-mode .text-orange-600,
        .dark-mode .text-orange-500 {
            color: #fbd38d !important; /* lighter orange */
        }
        
        /* Toggle switch styles */
        .toggle-bg {
            position: relative;
            display: inline-block;
            transition: background-color 0.2s;
        }
        
        .toggle-bg:after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 50%;
            background-color: white;
            border-radius: 9999px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s;
        }
        
        input:checked + .toggle-bg {
            background-color: #4c51bf;
            border-color: #4c51bf;
        }
        
        input:checked + .toggle-bg:after {
            transform: translateX(100%);
        }
        
        /* Dark mode text colors */
        .dark-mode .text-gray-900 {
            color: #f7fafc;
        }
        
        .dark-mode .text-gray-700 {
            color: #e2e8f0;
        }
        
        .dark-mode .text-gray-500 {
            color: #a0aec0;
        }
        
        .dark-mode .border-gray-200 {
            border-color: #4a5568;
        }
    </style>
    <script>
        // Close user menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('user-dropdown-menu');
            const button = document.getElementById('user-menu-button');
            
            if (menu && !menu.classList.contains('hidden') && 
                button && !button.contains(event.target) && 
                menu && !menu.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });
        
        // Initialize dark mode functionality when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Dark mode functionality
            const darkModeToggle = document.getElementById('dark-mode-toggle');
            const toggleDarkMode = document.getElementById('toggle-dark-mode');
            
            if (toggleDarkMode) {
                toggleDarkMode.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const html = document.documentElement;
                    if (html.classList.contains('dark')) {
                        disableDarkMode();
                    } else {
                        enableDarkMode();
                    }
                });
            }
            
            // Check for saved dark mode preference or use system preference
            const savedDarkMode = localStorage.getItem('darkMode');
            const prefersDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            // Initialize dark mode based on saved preference or system preference
            if (savedDarkMode === 'enabled' || (savedDarkMode === null && prefersDarkMode)) {
                enableDarkMode();
            } else {
                disableDarkMode();
            }
        });
        
        // Function to enable dark mode
        function enableDarkMode() {
            const html = document.documentElement;
            const darkModeToggle = document.getElementById('dark-mode-toggle');
            const darkModeLight = document.querySelector('.dark-mode-light');
            const darkModeDark = document.querySelector('.dark-mode-dark');
            
            html.classList.add('dark');
            if (darkModeToggle) darkModeToggle.checked = true;
            if (darkModeLight) darkModeLight.classList.add('hidden');
            if (darkModeDark) darkModeDark.classList.remove('hidden');
            localStorage.setItem('darkMode', 'enabled');
            
            // Add dark mode class to body
            document.body.classList.add('dark-mode');
            
            // No need to manually change classes as we're using CSS overrides
            // This approach is simpler and more reliable
        }
        
        // Function to disable dark mode
        function disableDarkMode() {
            const html = document.documentElement;
            const darkModeToggle = document.getElementById('dark-mode-toggle');
            const darkModeLight = document.querySelector('.dark-mode-light');
            const darkModeDark = document.querySelector('.dark-mode-dark');
            
            html.classList.remove('dark');
            if (darkModeToggle) darkModeToggle.checked = false;
            if (darkModeLight) darkModeLight.classList.remove('hidden');
            if (darkModeDark) darkModeDark.classList.add('hidden');
            localStorage.setItem('darkMode', 'disabled');
            
            // Remove dark mode class from body
            document.body.classList.remove('dark-mode');
            
            // No need to manually change classes as we're using CSS overrides
            // This approach is simpler and more reliable
        }
    </script>
</head>
<body class="bg-gray-100 dark:bg-slate-900 flex flex-col min-h-screen">
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <?php
                        $dashboardUrl = '/';
                        if (isset($_SESSION['user_id'])) {
                            if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
                                $dashboardUrl = '/admin/dashboard';
                            } elseif (isset($_SESSION['is_coach']) && $_SESSION['is_coach']) {
                                $dashboardUrl = '/coach/dashboard';
                            } else {
                                $dashboardUrl = '/dashboard';
                            }
                        }
                        ?>
                        <a href="<?= $dashboardUrl ?>" class="text-xl font-bold text-indigo-600">
                            <?= APP_NAME ?>
                        </a>
                    </div>
                </div>
                
                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="ml-3 relative">
                            <div>
                                <button type="button" class="bg-white rounded-full flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true" onclick="document.getElementById('user-dropdown-menu').classList.toggle('hidden'); event.stopPropagation();">
                                    <span class="sr-only">Open user menu</span>
                                    <span class="inline-block h-8 w-8 rounded-full overflow-hidden bg-gray-100">
                                        <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </span>
                                </button>
                            </div>
                            <div id="user-dropdown-menu" class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                    <div class="flex items-center">
                                        <svg class="h-4 w-4 mr-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                        </svg>
                                        Your Profile
                                    </div>
                                </a>
                                <a href="/dashboard/certificates" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                    <div class="flex items-center">
                                        <svg class="h-4 w-4 mr-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                                        </svg>
                                        Certificates
                                    </div>
                                </a>
                                <button id="toggle-dark-mode" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <svg class="h-4 w-4 mr-2 text-gray-500 dark-mode-light" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                                            </svg>
                                            <svg class="h-4 w-4 mr-2 text-gray-500 dark-mode-dark hidden" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
                                            </svg>
                                            Dark Mode
                                        </div>
                                        <div class="relative inline-block w-10 mr-2 align-middle select-none">
                                            <input type="checkbox" id="dark-mode-toggle" class="sr-only" />
                                            <span class="toggle-bg bg-gray-200 border-2 border-gray-200 h-5 w-9 rounded-full transition-colors duration-200 ease-in-out block"></span>
                                        </div>
                                    </div>
                                </button>
                                <div class="border-t border-gray-100 my-1"></div>
                                <a href="/logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                    <div class="flex items-center">
                                        <svg class="h-4 w-4 mr-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V4a1 1 0 00-1-1H3zm11 4a1 1 0 10-2 0v4a1 1 0 102 0V7zm-3 1a1 1 0 10-2 0v3a1 1 0 102 0V8zM8 9a1 1 0 00-2 0v2a1 1 0 102 0V9z" clip-rule="evenodd" />
                                            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v12a1 1 0 01-1 1H4a1 1 0 01-1-1V3zm1 0v12h12V3H4z" clip-rule="evenodd" />
                                        </svg>
                                        Sign out
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php if ($_SERVER['REQUEST_URI'] !== '/login'): ?>
                        <a href="/login" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            Sign in
                        </a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="rounded-md bg-<?= $_SESSION['flash']['type'] === 'error' ? 'red' : 'green' ?>-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <?php if ($_SESSION['flash']['type'] === 'error'): ?>
                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        <?php else: ?>
                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        <?php endif; ?>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-<?= $_SESSION['flash']['type'] === 'error' ? 'red' : 'green' ?>-800">
                            <?= $_SESSION['flash']['message'] ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <?php unset($_SESSION['flash']); ?>
    </div>
</div>
<?php endif; ?>

<?php
// Determine if we are on a page that needs a full-page centered layout (e.g., login, register)
$fullPageCenteredLayout = false;
$uri = $_SERVER['REQUEST_URI'];
// Check if the URI starts with /login or /register, or is exactly /login or /register
if (strpos($uri, '/login') === 0 || strpos($uri, '/register') === 0) {
    $fullPageCenteredLayout = true;
}

if ($fullPageCenteredLayout) {
    // For login/register, main itself will center the content. Padding from original login.php
    echo '<main class="flex-grow w-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">';
} else {
    // For standard pages, provide a flex-grow main and an inner content container
    echo '<main class="flex-grow">';
    echo '<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">'; // This div is closed in footer.php
}
?>

<?php
