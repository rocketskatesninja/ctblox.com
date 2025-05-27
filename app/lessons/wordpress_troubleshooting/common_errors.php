<div class="lesson-chapter">
    
    <div class="mb-6">
        <p class="mb-3">WordPress is generally reliable, but like any complex system, it can encounter various errors. In this chapter, we'll cover the most common WordPress errors and provide step-by-step solutions to resolve them.</p>
        
        <p class="mb-3">Understanding these common errors will help you quickly diagnose and fix issues when they arise, minimizing downtime and frustration.</p>
    </div>
    
    <div class="mb-6">
        <h3 class="text-xl font-bold mb-2">The White Screen of Death (WSOD)</h3>
        <p class="mb-3">The White Screen of Death is one of the most dreaded WordPress errors. It occurs when your screen goes completely blank with no error message.</p>
        
        <div class="bg-red-50 dark:bg-red-900 p-4 rounded-lg mb-4">
            <h4 class="font-medium text-red-800 dark:text-red-200">Common Causes:</h4>
            <ul class="list-disc pl-6 space-y-1 text-red-700 dark:text-red-300">
                <li>PHP memory limit exceeded</li>
                <li>Plugin conflicts</li>
                <li>Theme compatibility issues</li>
                <li>PHP syntax errors</li>
                <li>Corrupted core WordPress files</li>
            </ul>
        </div>
        
        <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg mb-4">
            <h4 class="font-medium text-green-800 dark:text-green-200">How to Fix It:</h4>
            <ol class="list-decimal pl-6 space-y-2 text-green-700 dark:text-green-300">
                <li>
                    <strong>Enable WordPress Debug Mode:</strong>
                    <p class="mt-1">Add these lines to your wp-config.php file to see error messages:</p>
                    <div class="bg-white dark:bg-gray-800 p-2 mt-1 rounded">
                        <code class="text-sm">
                            define('WP_DEBUG', true);<br>
                            define('WP_DEBUG_LOG', true);<br>
                            define('WP_DEBUG_DISPLAY', false);
                        </code>
                    </div>
                </li>
                <li>
                    <strong>Increase PHP Memory Limit:</strong>
                    <p class="mt-1">Add this line to your wp-config.php file:</p>
                    <div class="bg-white dark:bg-gray-800 p-2 mt-1 rounded">
                        <code class="text-sm">
                            define('WP_MEMORY_LIMIT', '256M');
                        </code>
                    </div>
                </li>
                <li>
                    <strong>Deactivate All Plugins:</strong>
                    <p class="mt-1">If you can access your admin area, deactivate all plugins and then reactivate them one by one to identify the problematic plugin.</p>
                    <p class="mt-1">If you can't access your admin area, use FTP to rename the plugins folder (e.g., from "plugins" to "plugins_old"). This deactivates all plugins.</p>
                </li>
                <li>
                    <strong>Switch to a Default Theme:</strong>
                    <p class="mt-1">Via FTP, rename your current theme folder in wp-content/themes/. WordPress will automatically switch to a default theme.</p>
                </li>
                <li>
                    <strong>Reinstall WordPress Core:</strong>
                    <p class="mt-1">If the above steps don't work, download a fresh copy of WordPress and replace the wp-admin and wp-includes folders (don't touch wp-content or wp-config.php).</p>
                </li>
            </ol>
        </div>
    </div>
    
    <div class="mb-6">
        <h3 class="text-xl font-bold mb-2">Internal Server Error (500 Error)</h3>
        <p class="mb-3">The 500 Internal Server Error indicates that something has gone wrong on the server, but it can't provide more specific information about the exact problem.</p>
        
        <div class="bg-red-50 dark:bg-red-900 p-4 rounded-lg mb-4">
            <h4 class="font-medium text-red-800 dark:text-red-200">Common Causes:</h4>
            <ul class="list-disc pl-6 space-y-1 text-red-700 dark:text-red-300">
                <li>Corrupted .htaccess file</li>
                <li>PHP memory limit issues</li>
                <li>Plugin or theme conflicts</li>
                <li>Corrupted WordPress core files</li>
                <li>Server configuration issues</li>
            </ul>
        </div>
        
        <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg mb-4">
            <h4 class="font-medium text-green-800 dark:text-green-200">How to Fix It:</h4>
            <ol class="list-decimal pl-6 space-y-2 text-green-700 dark:text-green-300">
                <li>
                    <strong>Check and Reset .htaccess File:</strong>
                    <p class="mt-1">Via FTP, rename your current .htaccess file to .htaccess_old.</p>
                    <p class="mt-1">If your site works after this, go to Settings > Permalinks in your WordPress admin and click Save to generate a new, clean .htaccess file.</p>
                </li>
                <li>
                    <strong>Increase PHP Memory Limit:</strong>
                    <p class="mt-1">As with the White Screen of Death, try increasing your PHP memory limit in wp-config.php.</p>
                </li>
                <li>
                    <strong>Deactivate Plugins:</strong>
                    <p class="mt-1">Follow the same plugin deactivation process described for the White Screen of Death.</p>
                </li>
                <li>
                    <strong>Check Server Error Logs:</strong>
                    <p class="mt-1">Access your server error logs through your hosting control panel to get more specific information about the error.</p>
                </li>
                <li>
                    <strong>Contact Your Host:</strong>
                    <p class="mt-1">If you've tried all the above steps and still have issues, the problem might be with your server configuration. Contact your hosting provider for assistance.</p>
                </li>
            </ol>
        </div>
    </div>
    
    <div class="mb-6">
        <h3 class="text-xl font-bold mb-2">Error Establishing a Database Connection</h3>
        <p class="mb-3">This error occurs when WordPress cannot connect to your database, which contains all your website's content and settings.</p>
        
        <div class="bg-red-50 dark:bg-red-900 p-4 rounded-lg mb-4">
            <h4 class="font-medium text-red-800 dark:text-red-200">Common Causes:</h4>
            <ul class="list-disc pl-6 space-y-1 text-red-700 dark:text-red-300">
                <li>Incorrect database credentials in wp-config.php</li>
                <li>Corrupted database</li>
                <li>Database server is down</li>
                <li>Database user permissions issues</li>
                <li>Server resource limitations</li>
            </ul>
        </div>
        
        <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg mb-4">
            <h4 class="font-medium text-green-800 dark:text-green-200">How to Fix It:</h4>
            <ol class="list-decimal pl-6 space-y-2 text-green-700 dark:text-green-300">
                <li>
                    <strong>Verify Database Credentials:</strong>
                    <p class="mt-1">Check your wp-config.php file to ensure the database name, username, password, and host are correct.</p>
                    <div class="bg-white dark:bg-gray-800 p-2 mt-1 rounded">
                        <code class="text-sm">
                            define('DB_NAME', 'database_name');<br>
                            define('DB_USER', 'database_username');<br>
                            define('DB_PASSWORD', 'database_password');<br>
                            define('DB_HOST', 'localhost');
                        </code>
                    </div>
                </li>
                <li>
                    <strong>Check Database Server Status:</strong>
                    <p class="mt-1">Log in to your hosting control panel and check if the MySQL service is running. You might also try accessing phpMyAdmin to see if you can connect to your database.</p>
                </li>
                <li>
                    <strong>Repair Database:</strong>
                    <p class="mt-1">Add this line to your wp-config.php file:</p>
                    <div class="bg-white dark:bg-gray-800 p-2 mt-1 rounded">
                        <code class="text-sm">
                            define('WP_ALLOW_REPAIR', true);
                        </code>
                    </div>
                    <p class="mt-1">Then visit: yourdomain.com/wp-admin/maint/repair.php to run the database repair tool.</p>
                </li>
                <li>
                    <strong>Contact Your Host:</strong>
                    <p class="mt-1">If none of the above steps work, your database server might be experiencing issues. Contact your hosting provider for assistance.</p>
                </li>
            </ol>
        </div>
    </div>
    
    <div class="mb-6">
        <h3 class="text-xl font-bold mb-2">Briefly Unavailable for Scheduled Maintenance</h3>
        <p class="mb-3">This error appears when WordPress is in maintenance mode, usually during updates. If an update process is interrupted, WordPress might get stuck in maintenance mode.</p>
        
        <div class="bg-red-50 dark:bg-red-900 p-4 rounded-lg mb-4">
            <h4 class="font-medium text-red-800 dark:text-red-200">Common Causes:</h4>
            <ul class="list-disc pl-6 space-y-1 text-red-700 dark:text-red-300">
                <li>Interrupted update process</li>
                <li>Plugin or theme update failure</li>
                <li>Server timeout during updates</li>
            </ul>
        </div>
        
        <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg mb-4">
            <h4 class="font-medium text-green-800 dark:text-green-200">How to Fix It:</h4>
            <ol class="list-decimal pl-6 space-y-2 text-green-700 dark:text-green-300">
                <li>
                    <strong>Delete the .maintenance File:</strong>
                    <p class="mt-1">Using FTP, look for a file named .maintenance in your WordPress root directory.</p>
                    <p class="mt-1">Delete this file, and your site should return to normal.</p>
                </li>
                <li>
                    <strong>Complete the Update Process:</strong>
                    <p class="mt-1">If the update was interrupted, try visiting your WordPress admin area to see if you can complete the update process.</p>
                </li>
            </ol>
        </div>
    </div>
    
    <div class="mb-6">
        <h3 class="text-xl font-bold mb-2">Memory Exhausted Error</h3>
        <p class="mb-3">This error occurs when a PHP script requires more memory than is allocated. The error message typically includes "Allowed memory size of X bytes exhausted".</p>
        
        <div class="bg-red-50 dark:bg-red-900 p-4 rounded-lg mb-4">
            <h4 class="font-medium text-red-800 dark:text-red-200">Common Causes:</h4>
            <ul class="list-disc pl-6 space-y-1 text-red-700 dark:text-red-300">
                <li>Insufficient PHP memory limit</li>
                <li>Resource-intensive plugins</li>
                <li>Inefficient theme code</li>
                <li>Large image processing</li>
            </ul>
        </div>
        
        <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg mb-4">
            <h4 class="font-medium text-green-800 dark:text-green-200">How to Fix It:</h4>
            <ol class="list-decimal pl-6 space-y-2 text-green-700 dark:text-green-300">
                <li>
                    <strong>Increase PHP Memory Limit in wp-config.php:</strong>
                    <div class="bg-white dark:bg-gray-800 p-2 mt-1 rounded">
                        <code class="text-sm">
                            define('WP_MEMORY_LIMIT', '256M');
                        </code>
                    </div>
                </li>
                <li>
                    <strong>Increase Memory in php.ini:</strong>
                    <p class="mt-1">If you have access to your server's php.ini file, you can increase the memory_limit setting:</p>
                    <div class="bg-white dark:bg-gray-800 p-2 mt-1 rounded">
                        <code class="text-sm">
                            memory_limit = 256M;
                        </code>
                    </div>
                </li>
                <li>
                    <strong>Create or Edit .htaccess File:</strong>
                    <p class="mt-1">Add this line to your .htaccess file:</p>
                    <div class="bg-white dark:bg-gray-800 p-2 mt-1 rounded">
                        <code class="text-sm">
                            php_value memory_limit 256M
                        </code>
                    </div>
                </li>
                <li>
                    <strong>Identify Resource-Intensive Plugins:</strong>
                    <p class="mt-1">Deactivate plugins one by one to identify which one is causing the memory issues.</p>
                </li>
                <li>
                    <strong>Upgrade Your Hosting:</strong>
                    <p class="mt-1">If you consistently encounter memory issues, consider upgrading to a hosting plan with more resources.</p>
                </li>
            </ol>
        </div>
    </div>
    
    <div class="mb-6">
        <h3 class="text-xl font-bold mb-2">Parse or Syntax Error</h3>
        <p class="mb-3">Parse errors occur when there's a syntax mistake in your PHP code, such as a missing semicolon, bracket, or quote.</p>
        
        <div class="bg-red-50 dark:bg-red-900 p-4 rounded-lg mb-4">
            <h4 class="font-medium text-red-800 dark:text-red-200">Common Causes:</h4>
            <ul class="list-disc pl-6 space-y-1 text-red-700 dark:text-red-300">
                <li>Manual code edits with syntax errors</li>
                <li>Copy-pasting code snippets incorrectly</li>
                <li>Poorly coded plugins or themes</li>
                <li>Incomplete file uploads</li>
            </ul>
        </div>
        
        <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg mb-4">
            <h4 class="font-medium text-green-800 dark:text-green-200">How to Fix It:</h4>
            <ol class="list-decimal pl-6 space-y-2 text-green-700 dark:text-green-300">
                <li>
                    <strong>Identify the Error Location:</strong>
                    <p class="mt-1">The error message usually indicates the file and line number where the syntax error occurs.</p>
                </li>
                <li>
                    <strong>Fix the Code via FTP:</strong>
                    <p class="mt-1">Use FTP to access and edit the problematic file. Look for missing semicolons, brackets, or quotes at or near the indicated line.</p>
                </li>
                <li>
                    <strong>If It's a Plugin or Theme:</strong>
                    <p class="mt-1">If the error occurred after activating a plugin or theme, deactivate it via FTP by renaming its folder.</p>
                </li>
                <li>
                    <strong>Restore from Backup:</strong>
                    <p class="mt-1">If you can't fix the code, restore the file from a backup.</p>
                </li>
            </ol>
        </div>
        
        <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg mb-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-blue-600 dark:text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200">Example Parse Error</h4>
                    <div class="mt-1 text-sm text-blue-700 dark:text-blue-300">
                        <p>A typical parse error might look like this:</p>
                        <div class="bg-white dark:bg-gray-800 p-2 mt-1 rounded">
                            <code class="text-sm">
                                Parse error: syntax error, unexpected '}' in /home/username/public_html/wp-content/themes/my-theme/functions.php on line 25
                            </code>
                        </div>
                        <p class="mt-2">This tells you there's an unexpected closing curly brace in the functions.php file of your theme on line 25.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mb-6">
        <h3 class="text-xl font-bold mb-2">404 Page Not Found Errors</h3>
        <p class="mb-3">While some 404 errors are normal (when a visitor tries to access a non-existent page), persistent 404 errors for pages that should exist indicate a problem.</p>
        
        <div class="bg-red-50 dark:bg-red-900 p-4 rounded-lg mb-4">
            <h4 class="font-medium text-red-800 dark:text-red-200">Common Causes:</h4>
            <ul class="list-disc pl-6 space-y-1 text-red-700 dark:text-red-300">
                <li>Permalink structure issues</li>
                <li>Corrupted .htaccess file</li>
                <li>Server rewrite rules not configured correctly</li>
                <li>Plugin conflicts affecting URL structure</li>
            </ul>
        </div>
        
        <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg mb-4">
            <h4 class="font-medium text-green-800 dark:text-green-200">How to Fix It:</h4>
            <ol class="list-decimal pl-6 space-y-2 text-green-700 dark:text-green-300">
                <li>
                    <strong>Reset Permalinks:</strong>
                    <p class="mt-1">Go to Settings > Permalinks in your WordPress admin.</p>
                    <p class="mt-1">Without changing anything, click Save Changes to refresh the permalink structure.</p>
                </li>
                <li>
                    <strong>Check and Reset .htaccess:</strong>
                    <p class="mt-1">Follow the same .htaccess reset process described for the 500 Internal Server Error.</p>
                </li>
                <li>
                    <strong>Ensure mod_rewrite is Enabled:</strong>
                    <p class="mt-1">Contact your hosting provider to confirm that mod_rewrite is enabled on your server.</p>
                </li>
                <li>
                    <strong>Deactivate Plugins:</strong>
                    <p class="mt-1">Some plugins modify URL structures. Deactivate plugins one by one to identify if any are causing the issue.</p>
                </li>
            </ol>
        </div>
    </div>
    
    <div class="mb-6">
        <h3 class="text-xl font-bold mb-2">WordPress Login Issues</h3>
        <p class="mb-3">Problems logging into WordPress can be frustrating and prevent you from accessing your admin area to fix other issues.</p>
        
        <div class="bg-red-50 dark:bg-red-900 p-4 rounded-lg mb-4">
            <h4 class="font-medium text-red-800 dark:text-red-200">Common Causes:</h4>
            <ul class="list-disc pl-6 space-y-1 text-red-700 dark:text-red-300">
                <li>Forgotten password</li>
                <li>Corrupted cookies</li>
                <li>Authentication cookie issues</li>
                <li>Database connection problems</li>
                <li>Security plugin lockouts</li>
            </ul>
        </div>
        
        <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg mb-4">
            <h4 class="font-medium text-green-800 dark:text-green-200">How to Fix It:</h4>
            <ol class="list-decimal pl-6 space-y-2 text-green-700 dark:text-green-300">
                <li>
                    <strong>Clear Browser Cookies and Cache:</strong>
                    <p class="mt-1">Clear your browser's cookies and cache, or try using a different browser.</p>
                </li>
                <li>
                    <strong>Reset Password:</strong>
                    <p class="mt-1">Use the "Lost your password?" link on the login page to reset your password.</p>
                </li>
                <li>
                    <strong>Check Database Connection:</strong>
                    <p class="mt-1">Ensure your database connection is working properly (see "Error Establishing a Database Connection" section).</p>
                </li>
                <li>
                    <strong>Disable Security Plugins via FTP:</strong>
                    <p class="mt-1">If a security plugin is causing lockouts, rename its folder via FTP to deactivate it.</p>
                </li>
                <li>
                    <strong>Reset Password via phpMyAdmin:</strong>
                    <p class="mt-1">As a last resort, you can reset your password directly in the database:</p>
                    <ol class="list-decimal pl-6 mt-1 text-green-700 dark:text-green-300">
                        <li>Access phpMyAdmin through your hosting control panel</li>
                        <li>Select your WordPress database</li>
                        <li>Find the wp_users table (the prefix might be different)</li>
                        <li>Find your user and click Edit</li>
                        <li>Replace the value in the user_pass field with a new MD5 hash: <code>MD5('your-new-password')</code></li>
                        <li>Click Go to save</li>
                    </ol>
                </li>
            </ol>
        </div>
    </div>
    
    <div class="mb-6">
        <h3 class="text-xl font-bold mb-2">Image Upload Issues</h3>
        <p class="mb-3">Problems uploading images to WordPress can stem from various sources and can be particularly frustrating for content creators.</p>
        
        <div class="bg-red-50 dark:bg-red-900 p-4 rounded-lg mb-4">
            <h4 class="font-medium text-red-800 dark:text-red-200">Common Causes:</h4>
            <ul class="list-disc pl-6 space-y-1 text-red-700 dark:text-red-300">
                <li>Insufficient PHP memory limit</li>
                <li>Incorrect file permissions</li>
                <li>Upload directory is not writable</li>
                <li>Image exceeds maximum upload size</li>
                <li>Server timeout for large uploads</li>
            </ul>
        </div>
        
        <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg mb-4">
            <h4 class="font-medium text-green-800 dark:text-green-200">How to Fix It:</h4>
            <ol class="list-decimal pl-6 space-y-2 text-green-700 dark:text-green-300">
                <li>
                    <strong>Increase Maximum Upload Size:</strong>
                    <p class="mt-1">Add these lines to your wp-config.php file:</p>
                    <div class="bg-white dark:bg-gray-800 p-2 mt-1 rounded">
                        <code class="text-sm">
                            @ini_set('upload_max_size', '64M');<br>
                            @ini_set('post_max_size', '64M');<br>
                            @ini_set('max_execution_time', '300');
                        </code>
                    </div>
                </li>
                <li>
                    <strong>Check and Fix File Permissions:</strong>
                    <p class="mt-1">Using FTP, ensure these permissions are set:</p>
                    <ul class="list-disc pl-6 mt-1 text-green-700 dark:text-green-300">
                        <li>Folders: 755</li>
                        <li>Files: 644</li>
                        <li>wp-content/uploads directory: 755</li>
                    </ul>
                </li>
                <li>
                    <strong>Create or Edit .htaccess File:</strong>
                    <p class="mt-1">Add these lines to your .htaccess file:</p>
                    <div class="bg-white dark:bg-gray-800 p-2 mt-1 rounded">
                        <code class="text-sm">
                            php_value upload_max_filesize 64M<br>
                            php_value post_max_size 64M<br>
                            php_value max_execution_time 300<br>
                            php_value max_input_time 300
                        </code>
                    </div>
                </li>
                <li>
                    <strong>Try Alternative Upload Methods:</strong>
                    <p class="mt-1">If direct uploads still fail, try using the Add Media button in the post editor, or upload via FTP and use the Media Library's "Add from Server" option.</p>
                </li>
            </ol>
        </div>
    </div>
    
    <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg mb-4">
        <h4 class="font-medium text-gray-900 dark:text-white mb-2">Chapter Summary</h4>
        <ul class="list-disc pl-6 space-y-1 text-gray-700 dark:text-gray-300">
            <li>The White Screen of Death is often caused by PHP memory issues, plugin conflicts, or theme problems</li>
            <li>500 Internal Server Errors frequently stem from corrupted .htaccess files or server configuration issues</li>
            <li>Database connection errors require checking your database credentials and server status</li>
            <li>Maintenance mode can get stuck after interrupted updates; deleting the .maintenance file usually fixes it</li>
            <li>Memory exhausted errors can be resolved by increasing PHP memory limits</li>
            <li>Parse errors indicate syntax mistakes in PHP code that need to be fixed manually</li>
            <li>Persistent 404 errors often relate to permalink or .htaccess issues</li>
            <li>Login problems can be resolved through clearing cookies, password resets, or database edits</li>
            <li>Image upload issues typically involve file size limits or permission problems</li>
        </ul>
    </div>
    
    <div class="mt-8 bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
        <p class="text-blue-700 dark:text-blue-300">Now that you understand the most common WordPress errors and how to fix them, let's move on to the next chapter where we'll explore performance issues and optimization techniques.</p>
    </div>
</div>
