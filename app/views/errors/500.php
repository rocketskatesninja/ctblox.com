<?php
require_once __DIR__ . '/../../includes/header.php';
$title = '500 Internal Server Error';
?>

<div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 text-center">
        <div>
            <h1 class="mt-6 text-center text-4xl font-extrabold text-gray-900">
                500
            </h1>
            <h2 class="mt-2 text-center text-2xl font-bold text-gray-900">
                Internal Server Error
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Something went wrong on our end. Please try again later.
            </p>
        </div>
        <div>
            <a href="/dashboard" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Return to Dashboard
            </a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
