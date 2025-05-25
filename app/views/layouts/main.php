<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - ' : '' ?>CTBlox Training</title>
    <link rel="stylesheet" href="/css/tailwind.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
        <link rel="stylesheet" href="/css/admin.css">
    <?php endif; ?>
    <script src="/js/alpine.min.js" defer></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <?php include __DIR__ . '/../components/header.php'; ?>
    
    <?php if ($flash = $this->getFlash()): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="rounded-md p-4 <?= $flash['type'] === 'error' ? 'bg-red-50 text-red-700' : 'bg-green-50 text-green-700' ?>" 
                 x-data="{ show: true }" 
                 x-show="show"
                 x-init="setTimeout(() => show = false, 5000)">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <?php if ($flash['type'] === 'error'): ?>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        <?php else: ?>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        <?php endif; ?>
                    </div>
                    <div class="ml-3">
                        <p><?= $this->sanitize($flash['message']) ?></p>
                    </div>
                    <div class="ml-auto pl-3">
                        <button @click="show = false" class="inline-flex text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Close</span>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <?= $content ?>
    </main>
    
    <?php include __DIR__ . '/../components/footer.php'; ?>
    
    <script src="/js/app.js"></script>
</body>
</html>
