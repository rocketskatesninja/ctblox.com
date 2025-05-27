<div class="lesson-chapter">
    
    <div class="mb-6">
        <p class="mb-3">Website security is a critical aspect of web hosting that's often overlooked by small business owners until it's too late. A security breach can damage your reputation, compromise customer data, and even lead to legal consequences.</p>
        
        <p class="mb-3">In this chapter, we'll explore the essential security measures every website owner should implement, common threats to be aware of, and best practices to keep your site secure.</p>
    </div>
    
    <div class="mb-6">
        <h3 class="text-xl font-bold mb-2">Understanding Website Security Threats</h3>
        <p class="mb-3">Before implementing security measures, it's important to understand what you're protecting against:</p>
        
        <div class="space-y-4 mb-4">
            <div class="bg-red-50 dark:bg-red-900 p-4 rounded-lg">
                <h4 class="font-medium text-red-800 dark:text-red-200">Malware</h4>
                <p class="text-red-700 dark:text-red-300">Malicious software that can infect your website, potentially stealing data, redirecting visitors to malicious sites, or using your server resources for illegal activities.</p>
            </div>
            
            <div class="bg-red-50 dark:bg-red-900 p-4 rounded-lg">
                <h4 class="font-medium text-red-800 dark:text-red-200">Phishing Attacks</h4>
                <p class="text-red-700 dark:text-red-300">Attempts to trick your visitors into revealing sensitive information by impersonating legitimate entities. Your site could be compromised to host these attacks.</p>
            </div>
            
            <div class="bg-red-50 dark:bg-red-900 p-4 rounded-lg">
                <h4 class="font-medium text-red-800 dark:text-red-200">SQL Injection</h4>
                <p class="text-red-700 dark:text-red-300">Attackers insert malicious SQL code into your website's database queries, potentially gaining access to sensitive data or corrupting your database.</p>
            </div>
            
            <div class="bg-red-50 dark:bg-red-900 p-4 rounded-lg">
                <h4 class="font-medium text-red-800 dark:text-red-200">Cross-Site Scripting (XSS)</h4>
                <p class="text-red-700 dark:text-red-300">Attackers inject malicious JavaScript into your pages that executes in visitors' browsers, potentially stealing cookies or other sensitive information.</p>
            </div>
            
            <div class="bg-red-50 dark:bg-red-900 p-4 rounded-lg">
                <h4 class="font-medium text-red-800 dark:text-red-200">Brute Force Attacks</h4>
                <p class="text-red-700 dark:text-red-300">Repeated login attempts using different username and password combinations to gain unauthorized access to your site's admin area.</p>
            </div>
            
            <div class="bg-red-50 dark:bg-red-900 p-4 rounded-lg">
                <h4 class="font-medium text-red-800 dark:text-red-200">DDoS Attacks</h4>
                <p class="text-red-700 dark:text-red-300">Distributed Denial of Service attacks overwhelm your server with traffic from multiple sources, making your website unavailable to legitimate users.</p>
            </div>
        </div>
    </div>
    
    <div class="mb-6">
        <h3 class="text-xl font-bold mb-2">Essential Security Measures</h3>
        <p class="mb-3">Implementing these fundamental security measures will significantly reduce your website's vulnerability:</p>
        
        <div class="space-y-6 mb-4">
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
                <h4 class="font-medium text-gray-900 dark:text-white">1. Keep Everything Updated</h4>
                <p class="text-gray-700 dark:text-gray-300 mb-2">One of the most important security measures is keeping all software up to date.</p>
                
                <div class="bg-white dark:bg-gray-700 p-3 rounded border border-gray-200 dark:border-gray-600">
                    <h5 class="font-medium text-gray-800 dark:text-gray-200">What to Update:</h5>
                    <ul class="list-disc pl-6 space-y-1 text-gray-700 dark:text-gray-300">
                        <li>Content Management System (WordPress, Joomla, etc.)</li>
                        <li>Themes and templates</li>
                        <li>Plugins and extensions</li>
                        <li>Server software (if you manage your own server)</li>
                        <li>Database software</li>
                    </ul>
                </div>
                
                <div class="mt-2 bg-yellow-50 dark:bg-yellow-900 p-3 rounded">
                    <p class="text-sm text-yellow-700 dark:text-yellow-300"><strong>Why it matters:</strong> Many security breaches occur through known vulnerabilities that have already been patched in newer versions. Hackers specifically target outdated software.</p>
                </div>
            </div>
            
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
                <h4 class="font-medium text-gray-900 dark:text-white">2. Use Strong Passwords and Two-Factor Authentication</h4>
                <p class="text-gray-700 dark:text-gray-300 mb-2">Weak passwords are one of the easiest ways for attackers to gain access to your site.</p>
                
                <div class="bg-white dark:bg-gray-700 p-3 rounded border border-gray-200 dark:border-gray-600">
                    <h5 class="font-medium text-gray-800 dark:text-gray-200">Password Best Practices:</h5>
                    <ul class="list-disc pl-6 space-y-1 text-gray-700 dark:text-gray-300">
                        <li>Use unique passwords for each service</li>
                        <li>Create passwords at least 12 characters long</li>
                        <li>Include a mix of uppercase, lowercase, numbers, and special characters</li>
                        <li>Use a password manager to generate and store complex passwords</li>
                        <li>Enable two-factor authentication (2FA) whenever possible</li>
                        <li>Change default usernames (don't use "admin")</li>
                    </ul>
                </div>
                
                <div class="mt-2 bg-blue-50 dark:bg-blue-900 p-3 rounded">
                    <p class="text-sm text-blue-700 dark:text-blue-300"><strong>Pro Tip:</strong> Two-factor authentication adds an extra layer of security by requiring a second verification method (usually a code sent to your phone) in addition to your password.</p>
                </div>
            </div>
            
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
                <h4 class="font-medium text-gray-900 dark:text-white">3. Implement SSL/TLS Encryption</h4>
                <p class="text-gray-700 dark:text-gray-300 mb-2">SSL (Secure Sockets Layer) and its successor TLS (Transport Layer Security) encrypt the connection between your visitors' browsers and your website.</p>
                
                <div class="bg-white dark:bg-gray-700 p-3 rounded border border-gray-200 dark:border-gray-600">
                    <h5 class="font-medium text-gray-800 dark:text-gray-200">Benefits of SSL/TLS:</h5>
                    <ul class="list-disc pl-6 space-y-1 text-gray-700 dark:text-gray-300">
                        <li>Protects sensitive data during transmission</li>
                        <li>Builds trust with visitors (shows the padlock icon)</li>
                        <li>Improves SEO (Google gives preference to HTTPS sites)</li>
                        <li>Required for e-commerce and sites collecting personal data</li>
                        <li>Prevents certain types of attacks (like man-in-the-middle)</li>
                    </ul>
                </div>
                
                <div class="mt-2 bg-green-50 dark:bg-green-900 p-3 rounded">
                    <p class="text-sm text-green-700 dark:text-green-300"><strong>How to get SSL:</strong> Many hosting providers offer free SSL certificates through Let's Encrypt. Premium certificates with extended validation are available for purchase if you need higher levels of trust indication.</p>
                </div>
            </div>
            
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
                <h4 class="font-medium text-gray-900 dark:text-white">4. Regular Backups</h4>
                <p class="text-gray-700 dark:text-gray-300 mb-2">While backups don't prevent attacks, they're crucial for recovery if your site is compromised.</p>
                
                <div class="bg-white dark:bg-gray-700 p-3 rounded border border-gray-200 dark:border-gray-600">
                    <h5 class="font-medium text-gray-800 dark:text-gray-200">Backup Strategy:</h5>
                    <ul class="list-disc pl-6 space-y-1 text-gray-700 dark:text-gray-300">
                        <li>Back up both files and databases</li>
                        <li>Store backups in multiple locations (not just on your server)</li>
                        <li>Automate the backup process</li>
                        <li>Test restoring from backups periodically</li>
                        <li>Keep multiple backup versions (daily, weekly, monthly)</li>
                        <li>Encrypt sensitive backup data</li>
                    </ul>
                </div>
            </div>
            
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
                <h4 class="font-medium text-gray-900 dark:text-white">5. Use a Web Application Firewall (WAF)</h4>
                <p class="text-gray-700 dark:text-gray-300 mb-2">A WAF filters and monitors HTTP traffic between a web application and the Internet, blocking malicious traffic.</p>
                
                <div class="bg-white dark:bg-gray-700 p-3 rounded border border-gray-200 dark:border-gray-600">
                    <h5 class="font-medium text-gray-800 dark:text-gray-200">WAF Protection:</h5>
                    <ul class="list-disc pl-6 space-y-1 text-gray-700 dark:text-gray-300">
                        <li>Blocks common attack patterns (SQL injection, XSS)</li>
                        <li>Prevents DDoS attacks</li>
                        <li>Filters out malicious bots</li>
                        <li>Provides an additional layer of security</li>
                        <li>Often includes other security features like malware scanning</li>
                    </ul>
                </div>
                
                <div class="mt-2 bg-blue-50 dark:bg-blue-900 p-3 rounded">
                    <p class="text-sm text-blue-700 dark:text-blue-300"><strong>Options:</strong> Services like Cloudflare, Sucuri, and AWS WAF provide WAF protection. Some hosting providers include WAF services in their premium plans.</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mb-6">
        <h3 class="text-xl font-bold mb-2">CMS-Specific Security</h3>
        <p class="mb-3">If you're using a popular Content Management System, there are specific security measures to consider:</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
                <h4 class="font-medium text-gray-900 dark:text-white">WordPress Security</h4>
                <ul class="list-disc pl-6 space-y-1 text-gray-700 dark:text-gray-300">
                    <li>Use security plugins (Wordfence, Sucuri, iThemes Security)</li>
                    <li>Limit login attempts</li>
                    <li>Change the default database prefix</li>
                    <li>Disable file editing in the admin area</li>
                    <li>Hide WordPress version information</li>
                    <li>Remove inactive themes and plugins</li>
                </ul>
            </div>
            
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
                <h4 class="font-medium text-gray-900 dark:text-white">Joomla Security</h4>
                <ul class="list-disc pl-6 space-y-1 text-gray-700 dark:text-gray-300">
                    <li>Use security extensions (JHackGuard, RSFirewall)</li>
                    <li>Enable two-factor authentication</li>
                    <li>Use Joomla's built-in security features</li>
                    <li>Implement custom .htaccess rules</li>
                    <li>Regularly scan for vulnerabilities</li>
                    <li>Use Joomla's ACL (Access Control List) effectively</li>
                </ul>
            </div>
            
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
                <h4 class="font-medium text-gray-900 dark:text-white">Drupal Security</h4>
                <ul class="list-disc pl-6 space-y-1 text-gray-700 dark:text-gray-300">
                    <li>Use the Security Review module</li>
                    <li>Implement the Password Policy module</li>
                    <li>Configure Drupal's built-in security features</li>
                    <li>Use the Captcha module for forms</li>
                    <li>Regularly check the Drupal security advisories</li>
                    <li>Use Drupal's role-based access control properly</li>
                </ul>
            </div>
            
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
                <h4 class="font-medium text-gray-900 dark:text-white">Magento Security</h4>
                <ul class="list-disc pl-6 space-y-1 text-gray-700 dark:text-gray-300">
                    <li>Use Magento Security Scan Tool</li>
                    <li>Implement two-factor authentication</li>
                    <li>Use custom admin URLs</li>
                    <li>Set proper file permissions</li>
                    <li>Enable CAPTCHA for customer accounts</li>
                    <li>Follow Magento security best practices</li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="mb-6">
        <h3 class="text-xl font-bold mb-2">Advanced Security Measures</h3>
        <p class="mb-3">For websites with higher security requirements, consider these additional measures:</p>
        
        <div class="space-y-4 mb-4">
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
                <h4 class="font-medium text-gray-900 dark:text-white">File Integrity Monitoring</h4>
                <p class="text-gray-700 dark:text-gray-300">Automatically detect unauthorized changes to your website files, which could indicate a compromise.</p>
            </div>
            
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
                <h4 class="font-medium text-gray-900 dark:text-white">Security Headers</h4>
                <p class="text-gray-700 dark:text-gray-300">Implement HTTP security headers like Content-Security-Policy, X-XSS-Protection, and X-Frame-Options to prevent various attacks.</p>
            </div>
            
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
                <h4 class="font-medium text-gray-900 dark:text-white">IP Blocking</h4>
                <p class="text-gray-700 dark:text-gray-300">Block access from suspicious IP addresses or entire regions if you don't do business there.</p>
            </div>
            
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
                <h4 class="font-medium text-gray-900 dark:text-white">CAPTCHA and Rate Limiting</h4>
                <p class="text-gray-700 dark:text-gray-300">Implement CAPTCHA on forms and rate limiting on login attempts to prevent automated attacks.</p>
            </div>
            
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
                <h4 class="font-medium text-gray-900 dark:text-white">Security Scanning and Penetration Testing</h4>
                <p class="text-gray-700 dark:text-gray-300">Regularly scan your website for vulnerabilities and consider professional penetration testing for critical websites.</p>
            </div>
        </div>
    </div>
    
    <div class="mb-6">
        <h3 class="text-xl font-bold mb-2">Security Incident Response</h3>
        <p class="mb-3">Despite your best efforts, security incidents can still occur. Having a plan in place can minimize damage:</p>
        
        <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg mb-4">
            <h4 class="font-medium text-gray-900 dark:text-white mb-2">If Your Site Is Compromised:</h4>
            <ol class="list-decimal pl-6 space-y-2 text-gray-700 dark:text-gray-300">
                <li>
                    <strong>Isolate the problem:</strong> Take the affected site offline if necessary to prevent further damage.
                </li>
                <li>
                    <strong>Identify the breach:</strong> Determine how the attacker gained access and what was compromised.
                </li>
                <li>
                    <strong>Clean up:</strong> Remove malicious code, reset passwords, and restore from a clean backup.
                </li>
                <li>
                    <strong>Patch vulnerabilities:</strong> Fix the security issue that allowed the breach.
                </li>
                <li>
                    <strong>Document the incident:</strong> Record what happened and what steps were taken.
                </li>
                <li>
                    <strong>Notify affected parties:</strong> If customer data was compromised, you may have legal obligations to notify them.
                </li>
                <li>
                    <strong>Strengthen security:</strong> Implement additional measures to prevent similar incidents.
                </li>
            </ol>
        </div>
        
        <div class="bg-yellow-50 dark:bg-yellow-900 p-4 rounded-lg mb-4">
            <h4 class="font-medium text-yellow-800 dark:text-yellow-200">Legal Considerations</h4>
            <p class="text-yellow-700 dark:text-yellow-300 mt-2">If your website collects personal data, you may have legal obligations regarding data security and breach notifications. Regulations like GDPR (in Europe), CCPA (in California), and others require specific security measures and timely notification of affected individuals in case of a data breach.</p>
            <p class="text-yellow-700 dark:text-yellow-300 mt-2">Consult with a legal professional to understand your obligations based on your location and the type of data you collect.</p>
        </div>
    </div>
    
    <div class="mb-6">
        <h3 class="text-xl font-bold mb-2">Security Best Practices for Small Business Owners</h3>
        <p class="mb-3">As a small business owner, these practical tips can help you maintain website security without requiring extensive technical knowledge:</p>
        
        <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg mb-4">
            <div class="space-y-3">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-600 dark:text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-blue-700 dark:text-blue-300">Choose reputable hosting providers with strong security features.</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-600 dark:text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-blue-700 dark:text-blue-300">Set a calendar reminder for regular security maintenance (updates, backups, etc.).</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-600 dark:text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-blue-700 dark:text-blue-300">Use a password manager to generate and store strong, unique passwords.</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-600 dark:text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-blue-700 dark:text-blue-300">Limit admin access to only those who absolutely need it.</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-600 dark:text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-blue-700 dark:text-blue-300">Consider cyber insurance for your business if you handle sensitive customer data.</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-600 dark:text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-blue-700 dark:text-blue-300">Use security plugins or services that automate many security tasks.</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-600 dark:text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-blue-700 dark:text-blue-300">Train staff on basic security practices, especially if they have access to the website.</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-600 dark:text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-blue-700 dark:text-blue-300">Consider hiring a security professional for an annual security audit if your website is critical to your business.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg mb-4">
        <h4 class="font-medium text-gray-900 dark:text-white mb-2">Chapter Summary</h4>
        <ul class="list-disc pl-6 space-y-1 text-gray-700 dark:text-gray-300">
            <li>Website security is essential for protecting your business and customer data</li>
            <li>Common threats include malware, phishing, SQL injection, XSS, and brute force attacks</li>
            <li>Essential security measures include keeping software updated, using strong passwords, implementing SSL/TLS, regular backups, and using a WAF</li>
            <li>Different CMS platforms have specific security considerations and tools</li>
            <li>Advanced security measures can provide additional protection for sensitive websites</li>
            <li>Having an incident response plan helps minimize damage if a breach occurs</li>
            <li>Small business owners should follow security best practices and consider their legal obligations</li>
        </ul>
    </div>
</div>
