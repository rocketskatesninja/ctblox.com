<?php
require_once __DIR__ . '/../../includes/header.php';
$title = 'Manage Lessons';
?>

<div class="space-y-6">
    <?php if (!empty($_SESSION['scan_errors'])): ?>
    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Lesson scan encountered errors</h3>
                <div class="mt-2 text-sm text-red-700">
                    <ul class="list-disc pl-5 space-y-1">
                        <?php foreach ($_SESSION['scan_errors'] as $error): ?>
                            <li><?= $this->sanitize($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php unset($_SESSION['scan_errors']); ?>
    <?php endif; ?>
    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Upload New Lesson
            </h3>
            <div class="mt-5">
                <form action="/admin/lessons" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= $csrf_token ?>">
                    <input type="hidden" name="action" value="create">
                    
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                            <div class="mt-1">
                                <input type="text" name="title" id="title" required
                                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md h-10 px-3">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="author" class="block text-sm font-medium text-gray-700">Author</label>
                            <div class="mt-1">
                                <input type="text" name="author" id="author"
                                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md h-10 px-3">
                            </div>
                        </div>

                        <div class="sm:col-span-6">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <div class="mt-1">
                                <textarea name="description" id="description" rows="3"
                                          class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md px-3 py-2"></textarea>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="version" class="block text-sm font-medium text-gray-700">Version</label>
                            <div class="mt-1">
                                <input type="text" name="version" id="version" value="1.0"
                                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md h-10 px-3">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="language" class="block text-sm font-medium text-gray-700">Language</label>
                            <div class="mt-1">
                                <select name="language" id="language"
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md h-10 px-3">
                                    <option value="en">English</option>
                                    <option value="es">Spanish</option>
                                    <option value="fr">French</option>
                                </select>
                            </div>
                        </div>

                        <div class="sm:col-span-6">
                            <label for="file" class="block text-sm font-medium text-gray-700">Lesson File</label>
                            <div class="mt-1">
                                <input type="file" name="file" id="file" required accept=".php"
                                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300">
                                <p class="mt-2 text-sm text-gray-500">Upload a PHP file containing the lesson content.</p>
                            </div>
                        </div>

                        <div class="sm:col-span-6">
                            <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Upload Lesson
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Available Lessons
            </h3>
            <form action="/admin/lessons" method="POST" class="inline-block">
                <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= $csrf_token ?>">
                <input type="hidden" name="action" value="scan">
                <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-0.5 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Scan for New Lessons
                </button>
            </form>
        </div>
        <div class="border-t border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Title
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Author
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Version
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Completion
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($lessons as $lesson): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                <?= $this->sanitize($lesson['title']) ?>
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                <?= $this->sanitize(substr($lesson['description'], 0, 50)) ?>...
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= $this->sanitize($lesson['author']) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= $this->sanitize($lesson['version']) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if ($lesson['active']): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Inactive
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= $lesson['completed_users'] ?> users completed
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <form action="/admin/lessons" method="POST" class="inline-block">
                                            <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= $csrf_token ?>">
                                            <input type="hidden" name="action" value="toggle">
                                            <input type="hidden" name="lesson_id" value="<?= $lesson['id'] ?>">
                                            <button type="submit" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                <?= $lesson['active'] ? 'Deactivate' : 'Activate' ?>
                                            </button>
                                        </form>
                                        <button type="button" 
                                                onclick="editLesson(<?= htmlspecialchars(json_encode($lesson), ENT_QUOTES, 'UTF-8') ?>)"
                                                class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Edit
                                        </button>
                                        <form action="/admin/lessons" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this lesson?');">
                                            <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= $csrf_token ?>">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="lesson_id" value="<?= $lesson['id'] ?>">
                                            <button type="submit" class="inline-flex items-center px-2.5 py-1.5 border border-red-300 shadow-sm text-xs font-medium rounded text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Edit Lesson Modal -->
<div id="editLessonModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <form action="/admin/lessons" method="POST">
                <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= $csrf_token ?>">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="lesson_id" id="edit-lesson-id">
                
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                        Edit Lesson
                    </h3>
                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-6">
                            <label for="edit-title" class="block text-sm font-medium text-gray-700">Title</label>
                            <div class="mt-1">
                                <input type="text" name="title" id="edit-title" required
                                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md h-10 px-3">
                            </div>
                        </div>

                        <div class="sm:col-span-6">
                            <label for="edit-description" class="block text-sm font-medium text-gray-700">Description</label>
                            <div class="mt-1">
                                <textarea name="description" id="edit-description" rows="3"
                                          class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md px-3 py-2"></textarea>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="edit-author" class="block text-sm font-medium text-gray-700">Author</label>
                            <div class="mt-1">
                                <input type="text" name="author" id="edit-author"
                                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md h-10 px-3">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="edit-version" class="block text-sm font-medium text-gray-700">Version</label>
                            <div class="mt-1">
                                <input type="text" name="version" id="edit-version"
                                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md h-10 px-3">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">
                        Save Changes
                    </button>
                    <button type="button" 
                            onclick="closeEditLessonModal()" 
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editLesson(lesson) {
    console.log('Opening edit lesson modal for:', lesson);
    
    // Create a completely new modal from scratch
    // First, let's remove any existing modal backdrop
    let existingModal = document.getElementById('manual-edit-lesson-modal');
    if (existingModal) {
        document.body.removeChild(existingModal);
    }
    
    // Check if dark mode is enabled
    const isDarkMode = document.documentElement.classList.contains('dark');
    
    // Create a new modal container
    const modalContainer = document.createElement('div');
    modalContainer.id = 'manual-edit-lesson-modal';
    modalContainer.style.position = 'fixed';
    modalContainer.style.zIndex = '1050';
    modalContainer.style.top = '0';
    modalContainer.style.left = '0';
    modalContainer.style.width = '100%';
    modalContainer.style.height = '100%';
    modalContainer.style.overflow = 'auto';
    modalContainer.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
    modalContainer.style.display = 'flex';
    modalContainer.style.alignItems = 'center';
    modalContainer.style.justifyContent = 'center';
    
    // Create modal content with appropriate dark mode styling
    const modalContent = document.createElement('div');
    if (isDarkMode) {
        modalContent.style.backgroundColor = '#2d3748';
        modalContent.style.color = '#f3f4f6';
    } else {
        modalContent.style.backgroundColor = 'white';
        modalContent.style.color = '#111827';
    }
    modalContent.style.borderRadius = '8px';
    modalContent.style.padding = '20px';
    modalContent.style.width = '90%';
    modalContent.style.maxWidth = '600px';
    modalContent.style.maxHeight = '90vh';
    modalContent.style.overflowY = 'auto';
    modalContent.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
    
    // Get the form from the original modal
    const originalForm = document.querySelector('#editLessonModal form').cloneNode(true);
    
    // Set form values
    originalForm.querySelector('#edit-lesson-id').value = lesson.id;
    originalForm.querySelector('#edit-title').value = lesson.title;
    originalForm.querySelector('#edit-description').value = lesson.description;
    originalForm.querySelector('#edit-author').value = lesson.author;
    originalForm.querySelector('#edit-version').value = lesson.version;
    
    // Make sure the form submits properly
    originalForm.addEventListener('submit', function(event) {
        event.preventDefault();
        // Submit the form data
        fetch('/admin/lessons', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams(new FormData(originalForm))
        })
        .then(response => {
            closeEditLessonModal();
            window.location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while saving the lesson. Please try again.');
        });
    });
    
    // Add a title with appropriate dark mode styling
    const title = document.createElement('h3');
    title.textContent = 'Edit Lesson';
    title.style.fontSize = '1.25rem';
    title.style.fontWeight = 'bold';
    title.style.marginBottom = '1rem';
    if (isDarkMode) {
        title.style.color = '#f3f4f6';
    } else {
        title.style.color = '#111827';
    }
    
    // Apply dark mode styling to form elements
    // Style form inputs
    const inputs = originalForm.querySelectorAll('input[type="text"], input[type="email"], textarea');
    inputs.forEach(input => {
        if (isDarkMode) {
            input.style.backgroundColor = '#374151';
            input.style.borderColor = '#4b5563';
            input.style.color = '#f3f4f6';
        } else {
            input.style.backgroundColor = '#ffffff';
            input.style.borderColor = '#d1d5db';
            input.style.color = '#111827';
        }
    });
    
    // Style labels
    const labels = originalForm.querySelectorAll('label');
    labels.forEach(label => {
        if (isDarkMode) {
            label.style.color = '#f3f4f6';
        } else {
            label.style.color = '#374151';
        }
    });
    
    // Style buttons
    const buttons = originalForm.querySelectorAll('button:not([type="submit"])');
    buttons.forEach(button => {
        if (!button.classList.contains('bg-indigo-600')) {
            if (isDarkMode) {
                button.style.backgroundColor = '#374151';
                button.style.borderColor = '#4b5563';
                button.style.color = '#f3f4f6';
            } else {
                button.style.backgroundColor = '#f9fafb';
                button.style.borderColor = '#d1d5db';
                button.style.color = '#111827';
            }
        }
    });
    
    // Style any dividers/borders
    const dividers = originalForm.querySelectorAll('.border-t, .border-b, .border-l, .border-r, [class*="border"]');
    dividers.forEach(divider => {
        if (isDarkMode) {
            divider.style.borderColor = '#4b5563';
        } else {
            divider.style.borderColor = '#e5e7eb';
        }
    });
    
    // Add content to the modal
    modalContent.appendChild(title);
    modalContent.appendChild(originalForm);
    modalContainer.appendChild(modalContent);
    
    // Add the modal to the body
    document.body.appendChild(modalContainer);
    
    // Prevent scrolling on the body
    document.body.style.overflow = 'hidden';
    
    // Add event listener to close modal when clicking outside
    modalContainer.addEventListener('click', function(event) {
        if (event.target === modalContainer) {
            closeEditLessonModal();
        }
    });
    
    // Add event listener to the cancel button
    const cancelButton = originalForm.querySelector('button[type="button"]');
    if (cancelButton) {
        cancelButton.addEventListener('click', closeEditLessonModal);
    }
}

function closeEditLessonModal() {
    const manualModal = document.getElementById('manual-edit-lesson-modal');
    if (manualModal) {
        document.body.removeChild(manualModal);
    }
    
    // Restore body scrolling
    document.body.style.overflow = '';
}
</script>
