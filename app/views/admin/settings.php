<?php
require_once __DIR__ . '/../../includes/header.php';
$title = 'System Settings';
?>

<div class="max-w-7xl mx-auto py-2 sm:px-6 lg:px-8">
    <div class="mx-auto" style="max-width: 60%;">
        <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 flex items-center">
                <svg class="h-6 w-6 text-indigo-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                </svg>
                System Configuration
            </h3>
            <form action="/admin/settings" method="POST" class="mt-5">
                <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= $csrf_token ?>">
                
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <!-- General Settings -->
                    <div class="sm:col-span-6 border-b border-gray-200 pb-5 mb-5">
                        <h4 class="text-base font-medium text-gray-900 flex items-center">
                            <svg class="h-5 w-5 text-gray-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                            </svg>
                            General Settings
                        </h4>
                    </div>
                    
                    <div class="sm:col-span-3">
                        <label for="max_users" class="block text-sm font-medium text-gray-700">Maximum Users</label>
                        <div class="mt-1">
                            <input type="number" name="max_users" id="max_users" min="1"
                                   value="<?= $settings['max_users'] ?? 100 ?>"
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full text-base border-gray-300 rounded-md h-10 px-3">
                        </div>
                        <p class="mt-2 text-sm text-gray-500">Maximum number of users allowed in the system.</p>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="allowed_ip_ranges" class="block text-sm font-medium text-gray-700">Allowed IP Ranges</label>
                        <div class="mt-1">
                            <input type="text" name="allowed_ip_ranges" id="allowed_ip_ranges"
                                   value="<?= isset($settings['allowed_ip_ranges']) ? htmlspecialchars(trim($settings['allowed_ip_ranges'], '[]"')) : '*' ?>"
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full text-base border-gray-300 rounded-md h-10 px-3">
                        </div>
                        <p class="mt-2 text-sm text-gray-500">Comma-separated list of allowed IP ranges. Use "*" for any IP.</p>
                    </div>
                    
                    <!-- Database Settings -->
                    <div class="sm:col-span-6 border-b border-gray-200 pb-5 mb-5 mt-6">
                        <h4 class="text-base font-medium text-gray-900 flex items-center">
                            <svg class="h-5 w-5 text-gray-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2h-2.22l.123.489.804.804A1 1 0 0113 18H7a1 1 0 01-.707-1.707l.804-.804L7.22 15H5a2 2 0 01-2-2V5zm5.771 7H5V5h10v7H8.771z" clip-rule="evenodd" />
                            </svg>
                            Database Settings
                        </h4>
                        <p class="mt-1 text-sm text-gray-500">These settings require a system restart to take effect.</p>
                    </div>
                    
                    <div class="sm:col-span-3">
                        <label for="db_host" class="block text-sm font-medium text-gray-700">Database Host</label>
                        <div class="mt-1">
                            <input type="text" name="db_host" id="db_host"
                                   value="<?= $settings['db_host'] ?? 'localhost' ?>"
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full text-base border-gray-300 rounded-md h-10 px-3">
                        </div>
                    </div>
                    
                    <div class="sm:col-span-3">
                        <label for="db_port" class="block text-sm font-medium text-gray-700">Database Port</label>
                        <div class="mt-1">
                            <input type="text" name="db_port" id="db_port"
                                   value="<?= $settings['db_port'] ?? '3306' ?>"
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full text-base border-gray-300 rounded-md h-10 px-3">
                        </div>
                    </div>
                    
                    <div class="sm:col-span-2">
                        <label for="db_name" class="block text-sm font-medium text-gray-700">Database Name</label>
                        <div class="mt-1">
                            <input type="text" name="db_name" id="db_name"
                                   value="<?= $settings['db_name'] ?? 'ctblox' ?>"
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full text-base border-gray-300 rounded-md h-10 px-3">
                        </div>
                    </div>
                    
                    <div class="sm:col-span-2">
                        <label for="db_user" class="block text-sm font-medium text-gray-700">Database Username</label>
                        <div class="mt-1">
                            <input type="text" name="db_user" id="db_user"
                                   value="<?= $settings['db_user'] ?? 'ctblox_user' ?>"
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full text-base border-gray-300 rounded-md h-10 px-3">
                        </div>
                    </div>
                    
                    <div class="sm:col-span-2">
                        <label for="db_password" class="block text-sm font-medium text-gray-700">Database Password</label>
                        <div class="mt-1">
                            <input type="password" name="db_password" id="db_password"
                                   value="<?= $settings['db_password'] ?? '' ?>"
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full text-base border-gray-300 rounded-md h-10 px-3">
                        </div>
                        <p class="mt-2 text-sm text-gray-500">Leave empty to keep current password.</p>
                    </div>

                    <!-- Email Settings -->
                    <div class="sm:col-span-6 border-b border-gray-200 pb-5 mb-5 mt-6">
                        <h4 class="text-base font-medium text-gray-900 flex items-center">
                            <svg class="h-5 w-5 text-gray-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                            Email Settings
                        </h4>
                        <p class="mt-1 text-sm text-gray-500">Configure the email server for notifications and password resets.</p>
                    </div>
                    
                    <div class="sm:col-span-3">
                        <label for="smtp_host" class="block text-sm font-medium text-gray-700">SMTP Host</label>
                        <div class="mt-1">
                            <input type="text" name="smtp_host" id="smtp_host"
                                   value="<?= $settings['smtp_host'] ?? '' ?>"
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full text-base border-gray-300 rounded-md h-10 px-3">
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="smtp_port" class="block text-sm font-medium text-gray-700">SMTP Port</label>
                        <div class="mt-1">
                            <input type="text" name="smtp_port" id="smtp_port"
                                   value="<?= $settings['smtp_port'] ?? '587' ?>"
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full text-base border-gray-300 rounded-md h-10 px-3">
                        </div>
                    </div>
                    
                    <div class="sm:col-span-6">
                        <label for="smtp_encryption" class="block text-sm font-medium text-gray-700">Encryption</label>
                        <div class="mt-1">
                            <select name="smtp_encryption" id="smtp_encryption"
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full max-w-lg text-base border-gray-300 rounded-md h-10 px-3">
                                <option value="tls" <?= ($settings['smtp_encryption'] ?? 'tls') === 'tls' ? 'selected' : '' ?>>TLS</option>
                                <option value="ssl" <?= ($settings['smtp_encryption'] ?? '') === 'ssl' ? 'selected' : '' ?>>SSL</option>
                                <option value="none" <?= ($settings['smtp_encryption'] ?? '') === 'none' ? 'selected' : '' ?>>None</option>
                            </select>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Select the encryption method for SMTP communication.</p>
                    </div>
                    
                    <div class="sm:col-span-6 mt-4">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox" name="smtp_auth_enabled" id="smtp_auth_enabled"
                                       <?= ($settings['smtp_auth_enabled'] ?? '1') === '1' ? 'checked' : '' ?>
                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                       onchange="toggleSmtpAuth()">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="smtp_auth_enabled" class="font-medium text-gray-700">Enable SMTP Authentication</label>
                                <p class="text-gray-500">Disable this if your IP is whitelisted or authentication is not required.</p>
                            </div>
                        </div>
                    </div>

                    <div id="smtp_auth_fields" class="sm:col-span-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="smtp_username" class="block text-sm font-medium text-gray-700">SMTP Username</label>
                            <div class="mt-1">
                                <input type="text" name="smtp_username" id="smtp_username"
                                       value="<?= $settings['smtp_username'] ?? '' ?>"
                                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full text-base border-gray-300 rounded-md h-10 px-3">
                            </div>
                        </div>

                        <div>
                            <label for="smtp_password" class="block text-sm font-medium text-gray-700">SMTP Password</label>
                            <div class="mt-1">
                                <input type="password" name="smtp_password" id="smtp_password"
                                       value="<?= $settings['smtp_password'] ?? '' ?>"
                                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full text-base border-gray-300 rounded-md h-10 px-3">
                            </div>
                        </div>
                    </div>
                    
                    <div class="sm:col-span-6 mt-4">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox" name="smtp_verify_ssl" id="smtp_verify_ssl"
                                       <?= ($settings['smtp_verify_ssl'] ?? '1') === '1' ? 'checked' : '' ?>
                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="smtp_verify_ssl" class="font-medium text-gray-700">Verify SSL Certificate</label>
                                <p class="text-gray-500">Disable this only if you're using a self-signed certificate.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="sm:col-span-3">
                        <label for="smtp_from_email" class="block text-sm font-medium text-gray-700">From Email Address</label>
                        <div class="mt-1">
                            <input type="email" name="smtp_from_email" id="smtp_from_email"
                                   value="<?= $settings['smtp_from_email'] ?? 'noreply@' . ($_SERVER['HTTP_HOST'] ?? 'example.com') ?>"
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full text-base border-gray-300 rounded-md h-10 px-3">
                        </div>
                    </div>
                    
                    <div class="sm:col-span-3">
                        <label for="smtp_from_name" class="block text-sm font-medium text-gray-700">From Name</label>
                        <div class="mt-1">
                            <input type="text" name="smtp_from_name" id="smtp_from_name"
                                   value="<?= $settings['smtp_from_name'] ?? 'CT Blox System' ?>"
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full text-base border-gray-300 rounded-md h-10 px-3">
                        </div>
                    </div>

                    <div class="sm:col-span-6 mt-4">
                        <button type="button" 
                                onclick="testEmail()"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Test Email Settings
                        </button>
                        <span id="email-test-result" class="ml-2 text-sm"></span>
                    </div>

                    <!-- Certificate Settings -->
                    <div class="sm:col-span-6 border-b border-gray-200 pb-5 mb-5 mt-6">
                        <h4 class="text-base font-medium text-gray-900 flex items-center">
                            <svg class="h-5 w-5 text-gray-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm2 10a1 1 0 10-2 0v3a1 1 0 102 0v-3zm2-3a1 1 0 011 1v5a1 1 0 11-2 0v-5a1 1 0 011-1zm4-1a1 1 0 10-2 0v7a1 1 0 102 0V8z" clip-rule="evenodd" />
                            </svg>
                            Certificate Settings
                        </h4>
                    </div>
                    
                    <div class="sm:col-span-6">
                        <label for="certificate_template" class="block text-sm font-medium text-gray-700">Certificate Template</label>
                        <div class="mt-1">
                            <textarea id="certificate_template" name="certificate_template" rows="10"
                                      class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full text-base border-gray-300 rounded-md"><?= isset($settings['certificate_template']) ? htmlspecialchars($settings['certificate_template']) : '' ?></textarea>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">HTML template for certificates. Use {{username}}, {{lesson_title}}, {{completion_date}} as placeholders.</p>
                        <div class="mt-3">
                            <button type="button" onclick="previewCertificate()" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Preview Certificate
                            </button>
                        </div>
                        <div id="certificate-preview" class="mt-4 p-4 border border-gray-200 rounded-lg hidden">
                            <h5 class="text-base font-medium text-gray-900 mb-4">Certificate Preview</h5>
                            <div id="certificate-preview-content" class="bg-white p-6 border border-gray-300 rounded-lg shadow-sm"></div>
                        </div>
                    </div>
                    

                    
                    <div class="sm:col-span-6">
                        <div class="flex justify-end space-x-3">
                            <a href="/admin/dashboard" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Save Settings
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

<script>
function testEmail() {
    const result = document.getElementById('email-test-result');
    result.textContent = 'Testing email settings...';
    result.className = 'ml-2 text-sm text-gray-500';
    
    const formData = new URLSearchParams({
        smtp_host: document.getElementById('smtp_host').value,
        smtp_port: document.getElementById('smtp_port').value,
        smtp_encryption: document.getElementById('smtp_encryption').value,
        smtp_auth_enabled: document.getElementById('smtp_auth_enabled').checked ? '1' : '0',
        smtp_verify_ssl: document.getElementById('smtp_verify_ssl').checked ? '1' : '0',
        smtp_from_email: document.getElementById('smtp_from_email').value,
        smtp_from_name: document.getElementById('smtp_from_name').value
    });
    
    if (document.getElementById('smtp_auth_enabled').checked) {
        formData.append('smtp_username', document.getElementById('smtp_username').value);
        formData.append('smtp_password', document.getElementById('smtp_password').value);
    }
    
    fetch('/app/controllers/AdminController.php?action=testEmail', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            result.textContent = 'Email test successful!';
            result.className = 'ml-2 text-sm text-green-600';
        } else {
            result.textContent = 'Email test failed: ' + data.message;
            result.className = 'ml-2 text-sm text-red-600';
        }
    })
    .catch(error => {
        result.textContent = 'Error: ' + error.message;
        result.className = 'ml-2 text-sm text-red-600';
    });
}

function toggleSmtpAuth() {
    const authEnabled = document.getElementById('smtp_auth_enabled').checked;
    const authFields = document.getElementById('smtp_auth_fields');
    
    if (authEnabled) {
        authFields.style.display = 'grid';
    } else {
        authFields.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    toggleSmtpAuth();
});

function previewCertificate() {
    const templateContent = document.getElementById('certificate_template').value;
    if (!templateContent.trim()) {
        alert('Please enter a certificate template first.');
        return;
    }
    
    // Sample data for preview
    const sampleData = {
        username: 'John Smith',
        lesson_title: 'WordPress Troubleshooting',
        completion_date: new Date().toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        })
    };
    
    // Replace placeholders with sample data
    let previewContent = templateContent;
    for (const [key, value] of Object.entries(sampleData)) {
        previewContent = previewContent.replace(new RegExp('{{' + key + '}}', 'g'), value);
    }
    
    // Display the preview
    const previewContainer = document.getElementById('certificate-preview');
    const previewContentElement = document.getElementById('certificate-preview-content');
    
    previewContentElement.innerHTML = previewContent;
    previewContainer.classList.remove('hidden');
    
    // Scroll to the preview
    previewContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}
</script>
