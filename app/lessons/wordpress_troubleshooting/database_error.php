<div class="lesson-chapter">
    <div class="mb-6">
        <h2 class="text-2xl font-bold mb-3">Error Establishing a Database Connection</h2>
        <p class="mb-3">This error occurs when WordPress cannot connect to your database, which contains all your website's content and settings.</p>
        
        <div class="bg-red-50 dark:bg-red-900 p-4 rounded-lg mb-4">
            <h4 class="font-medium text-red-800 dark:text-red-200">Common Causes:</h4>
            <ul class="list-disc pl-6 space-y-1 text-red-700 dark:text-red-300">
                <li>Incorrect database credentials in wp-config.php</li>
                <li>Database server is down or overloaded</li>
                <li>Database corruption</li>
                <li>Hosting issues</li>
                <li>Hacking attempt or malware</li>
            </ul>
        </div>
        
        <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg mb-4">
            <h4 class="font-medium text-green-800 dark:text-green-200">How to Fix It:</h4>
            <ol class="list-decimal pl-6 space-y-2 text-green-700 dark:text-green-300">
                <li>
                    <strong>Check Database Credentials:</strong>
                    <p class="mt-1">Verify that the database name, username, password, and host in your wp-config.php file are correct:</p>
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
                    <strong>Contact Your Hosting Provider:</strong>
                    <p class="mt-1">If your credentials are correct, your database server might be down. Contact your hosting provider to check if there are any known issues.</p>
                </li>
                <li>
                    <strong>Repair Database:</strong>
                    <p class="mt-1">WordPress has a built-in database repair tool. Add this line to your wp-config.php file:</p>
                    <div class="bg-white dark:bg-gray-800 p-2 mt-1 rounded">
                        <code class="text-sm">
                            define('WP_ALLOW_REPAIR', true);
                        </code>
                    </div>
                    <p class="mt-1">Then visit: yourdomain.com/wp-admin/maint/repair.php</p>
                </li>
                <li>
                    <strong>Check for Corrupted Files:</strong>
                    <p class="mt-1">If you suspect malware, scan your WordPress installation with a security plugin like Wordfence or Sucuri.</p>
                </li>
                <li>
                    <strong>Restore from Backup:</strong>
                    <p class="mt-1">If all else fails, restore your website from a recent backup.</p>
                </li>
            </ol>
        </div>
        
        <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
            <h4 class="font-medium text-blue-800 dark:text-blue-200">Pro Tip:</h4>
            <p class="text-blue-700 dark:text-blue-300">Always keep a separate backup of your wp-config.php file with your database credentials. This makes it easier to restore access if you need to reinstall WordPress.</p>
        </div>
    </div>
</div>
