<?php
// Determine if we are on a page that needs a full-page centered layout (e.g., login, register)
$fullPageCenteredLayout = false;
$uri = $_SERVER['REQUEST_URI'];
// Check if the URI starts with /login or /register, or is exactly /login or /register
if (strpos($uri, '/login') === 0 || strpos($uri, '/register') === 0) {
    $fullPageCenteredLayout = true;
}

if (!$fullPageCenteredLayout) {
    // For standard pages, close the inner content container opened in header.php
    echo '</div>';
}
// Always close the main tag
echo '</main>';
?>

    <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-auto">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 md:flex md:items-center md:justify-between lg:px-8">
            <div class="flex justify-center space-x-6 md:order-2">
                <p class="text-center text-base text-gray-400 dark:text-gray-500">
                    &copy; <?= date('Y') ?> <?= APP_NAME ?>. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- All JavaScript functionality moved to header.php -->
</body>
</html>
