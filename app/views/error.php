<?php require_once 'partials/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body text-center p-5">
                    <?php if (isset($_GET['code']) && $_GET['code'] == '404'): ?>
                        <svg class="mb-4" width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#dc3545" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M15 9L9 15" stroke="#dc3545" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9 9L15 15" stroke="#dc3545" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <h1 class="h3 mb-3">Page Not Found</h1>
                        <p class="text-muted mb-4">The page you are looking for doesn't exist or has been moved.</p>
                    <?php else: ?>
                        <svg class="mb-4" width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#dc3545" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 8V12" stroke="#dc3545" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 16H12.01" stroke="#dc3545" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <h1 class="h3 mb-3">Something Went Wrong</h1>
                        <p class="text-muted mb-4">We're sorry, but an unexpected error occurred.</p>
                        
                        <?php if (isset($_GET['message']) && ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === '127.0.0.1')): ?>
                            <div class="alert alert-danger text-start">
                                <h5 class="alert-heading">Error Details:</h5>
                                <p class="mb-0"><?= htmlspecialchars($_GET['message']) ?></p>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                    <div class="mt-4">
                        <a href="/" class="btn btn-primary">Return to Home</a>
                        <?php if (isset($_SERVER['HTTP_REFERER'])): ?>
                            <a href="<?= htmlspecialchars($_SERVER['HTTP_REFERER']) ?>" class="btn btn-outline-secondary ms-2">Go Back</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'partials/footer.php'; ?>
