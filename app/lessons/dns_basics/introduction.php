<div class="lesson-chapter">
    
    <div class="mb-6">
        <p class="mb-3">Welcome to "What is DNS?" This lesson will demystify the Domain Name System (DNS), one of the most fundamental technologies that makes the internet usable. While DNS works quietly behind the scenes, understanding its basics is essential for anyone who manages a website or online services.</p>
        
        <p class="mb-3">By the end of this lesson, you'll understand how DNS works, why it's important, and how to troubleshoot common DNS issues that might affect your website or email services.</p>
    </div>
    
    <div class="mb-6">
        <h3 class="text-xl font-bold mb-2">Lesson Objectives</h3>
        <ul class="list-disc pl-6 space-y-2">
            <li>Understand what DNS is and why it's essential for the internet</li>
            <li>Learn how the DNS hierarchy works</li>
            <li>Explore common DNS record types and their purposes</li>
            <li>Discover how DNS affects websites, email, and other online services</li>
            <li>Learn basic DNS troubleshooting techniques</li>
        </ul>
    </div>
    
    <div class="mb-6">
        <h3 class="text-xl font-bold mb-2">What is DNS?</h3>
        <p class="mb-3">The Domain Name System (DNS) is often described as the "phone book of the internet." Its primary purpose is to translate human-friendly domain names (like example.com) into machine-readable IP addresses (like 192.0.2.1) that computers use to identify each other on the network.</p>
        
        <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg mb-4">
            <div class="flex items-center justify-center">
                <div class="text-center">
                    <div class="flex items-center justify-center mb-2">
                        <div class="px-4 py-2 bg-blue-100 dark:bg-blue-900 rounded-lg text-blue-800 dark:text-blue-200 font-medium">
                            example.com
                        </div>
                        <div class="mx-4">
                            <svg class="h-6 w-6 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </div>
                        <div class="px-4 py-2 bg-green-100 dark:bg-green-900 rounded-lg text-green-800 dark:text-green-200 font-medium">
                            192.0.2.1
                        </div>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 text-sm">DNS translates human-readable domain names to machine-readable IP addresses</p>
                </div>
            </div>
        </div>
        
        <p class="mb-3">Without DNS, you would need to remember numeric IP addresses for every website you want to visit. Instead of typing "google.com" in your browser, you'd have to type something like "142.250.190.78" — and that address might even change over time!</p>
    </div>
    
    <div class="mb-6">
        <h3 class="text-xl font-bold mb-2">Why DNS Matters for Your Business</h3>
        <p class="mb-3">DNS is critical for several aspects of your online presence:</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
                <h4 class="font-medium text-blue-800 dark:text-blue-200">Website Accessibility</h4>
                <p class="text-blue-700 dark:text-blue-300">DNS ensures customers can find your website by typing your domain name. If DNS fails, your website becomes inaccessible even if your web server is running perfectly.</p>
            </div>
            
            <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg">
                <h4 class="font-medium text-green-800 dark:text-green-200">Email Delivery</h4>
                <p class="text-green-700 dark:text-green-300">Your email system relies on DNS to route messages correctly. Improper DNS configuration can prevent emails from being sent or received.</p>
            </div>
            
            <div class="bg-yellow-50 dark:bg-yellow-900 p-4 rounded-lg">
                <h4 class="font-medium text-yellow-800 dark:text-yellow-200">Security</h4>
                <p class="text-yellow-700 dark:text-yellow-300">DNS includes security mechanisms that help protect your domain from spoofing and other attacks that could damage your reputation.</p>
            </div>
            
            <div class="bg-purple-50 dark:bg-purple-900 p-4 rounded-lg">
                <h4 class="font-medium text-purple-800 dark:text-purple-200">Service Reliability</h4>
                <p class="text-purple-700 dark:text-purple-300">DNS allows for redundancy and load balancing, ensuring your online services remain available even if some servers fail.</p>
            </div>
        </div>
    </div>
    
    <div class="mb-6">
        <h3 class="text-xl font-bold mb-2">The DNS Ecosystem</h3>
        <p class="mb-3">DNS isn't a single system but a global, distributed network of servers that work together hierarchically:</p>
        
        <ol class="list-decimal pl-6 space-y-2 mb-4">
            <li>
                <strong>Root Servers</strong> - The foundation of the DNS hierarchy, operated by 12 different organizations worldwide
            </li>
            <li>
                <strong>TLD Servers</strong> - Manage top-level domains like .com, .org, .net, and country codes like .uk or .ca
            </li>
            <li>
                <strong>Authoritative Name Servers</strong> - Store DNS records for specific domains (often managed by your domain registrar or hosting provider)
            </li>
            <li>
                <strong>Recursive Resolvers</strong> - Usually operated by ISPs or public services like Google (8.8.8.8) or Cloudflare (1.1.1.1), these servers query the DNS hierarchy on behalf of users
            </li>
        </ol>
        
        <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg mb-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-blue-600 dark:text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200">Did You Know?</h4>
                    <div class="mt-1 text-sm text-blue-700 dark:text-blue-300">
                        <p>The DNS system processes billions of queries every day. Despite this enormous volume, most DNS lookups are completed in less than 100 milliseconds!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mb-6">
        <h3 class="text-xl font-bold mb-2">What You'll Learn</h3>
        <p class="mb-3">In the following chapters, we'll explore:</p>
        
        <ol class="list-decimal pl-6 space-y-2">
            <li><strong>How DNS Works</strong> - A deeper look at the DNS resolution process</li>
            <li><strong>DNS Record Types</strong> - Understanding A, CNAME, MX, TXT, and other record types</li>
            <li><strong>DNS Management</strong> - How to manage DNS for your domain</li>
            <li><strong>Troubleshooting DNS Issues</strong> - Common problems and how to solve them</li>
        </ol>
        
        <div class="bg-yellow-50 dark:bg-yellow-900 p-4 rounded-lg mt-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h4 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Pro Tip</h4>
                    <div class="mt-1 text-sm text-yellow-700 dark:text-yellow-300">
                        <p>As you go through this lesson, think about your own domain names and how DNS affects your online presence. Understanding DNS will help you communicate more effectively with technical support teams when issues arise.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
