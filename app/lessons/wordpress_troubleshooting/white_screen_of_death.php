<div class="lesson-chapter">
    <div class="mb-6">
        <h2 class="text-2xl font-bold mb-3">The White Screen of Death (WSOD)</h2>
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
                    <p class="mt-1">If the issue is with your theme, switch to a default WordPress theme like Twenty Twenty-One using FTP by renaming your current theme folder and creating a new wp-content/themes/twentytwentyone folder.</p>
                </li>
                <li>
                    <strong>Check for Syntax Errors:</strong>
                    <p class="mt-1">If you recently edited any PHP files, check for syntax errors. Even a missing semicolon can cause a white screen.</p>
                </li>
                <li>
                    <strong>Reinstall WordPress Core Files:</strong>
                    <p class="mt-1">As a last resort, download a fresh copy of WordPress and replace the wp-admin and wp-includes folders (but not wp-content).</p>
                </li>
            </ol>
        </div>
        
        <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
            <h4 class="font-medium text-blue-800 dark:text-blue-200">Pro Tip:</h4>
            <p class="text-blue-700 dark:text-blue-300">Always keep a backup of your WordPress site. This allows you to quickly restore your site if troubleshooting doesn't resolve the issue.</p>
        </div>
    </div>
</div>
