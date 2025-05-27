<div class="lesson-chapter">
    <div class="mb-6">
        <h2 class="text-2xl font-bold mb-3">Internal Server Error (500 Error)</h2>
        <p class="mb-3">The 500 Internal Server Error indicates that something has gone wrong on the server, but it can't provide more specific information about the exact problem.</p>
        
        <div class="bg-red-50 dark:bg-red-900 p-4 rounded-lg mb-4">
            <h4 class="font-medium text-red-800 dark:text-red-200">Common Causes:</h4>
            <ul class="list-disc pl-6 space-y-1 text-red-700 dark:text-red-300">
                <li>Corrupted .htaccess file</li>
                <li>PHP memory limit exceeded</li>
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
                    <p class="mt-1">The .htaccess file is often the culprit for 500 errors. Rename your current .htaccess file to .htaccess_old using FTP.</p>
                    <p class="mt-1">If your site starts working, create a new .htaccess file with the default WordPress rules:</p>
                    <div class="bg-white dark:bg-gray-800 p-2 mt-1 rounded">
                        <code class="text-sm">
                            # BEGIN WordPress<br>
                            &lt;IfModule mod_rewrite.c&gt;<br>
                            RewriteEngine On<br>
                            RewriteBase /<br>
                            RewriteRule ^index\.php$ - [L]<br>
                            RewriteCond %{REQUEST_FILENAME} !-f<br>
                            RewriteCond %{REQUEST_FILENAME} !-d<br>
                            RewriteRule . /index.php [L]<br>
                            &lt;/IfModule&gt;<br>
                            # END WordPress
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
                    <p class="mt-1">Follow the same plugin deactivation process described for the White Screen of Death.</p>
                </li>
                <li>
                    <strong>Switch to a Default Theme:</strong>
                    <p class="mt-1">Use FTP to rename your current theme folder and activate a default WordPress theme.</p>
                </li>
                <li>
                    <strong>Check Server Error Logs:</strong>
                    <p class="mt-1">If you have access to your server error logs, they can provide more specific information about what's causing the 500 error.</p>
                </li>
                <li>
                    <strong>Reinstall WordPress Core Files:</strong>
                    <p class="mt-1">As a last resort, download a fresh copy of WordPress and replace the wp-admin and wp-includes folders.</p>
                </li>
            </ol>
        </div>
        
        <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
            <h4 class="font-medium text-blue-800 dark:text-blue-200">Pro Tip:</h4>
            <p class="text-blue-700 dark:text-blue-300">If you're seeing 500 errors after making changes to your site, try clearing your browser cache. Sometimes browsers cache error pages, making it appear that the error persists even after you've fixed it.</p>
        </div>
    </div>
</div>
