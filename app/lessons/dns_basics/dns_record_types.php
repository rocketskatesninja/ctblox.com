<div class="lesson-chapter">
    
    <div class="mb-6">
        <p class="mb-3">DNS records are instructions that live on authoritative DNS servers and provide information about a domain, including what IP address is associated with that domain and how to handle requests for that domain. Different types of records serve different purposes.</p>
        
        <p class="mb-3">Understanding the common DNS record types is essential for properly configuring your domain for websites, email, and other services.</p>
    </div>
    
    <div class="mb-6">
        <h3 class="text-xl font-bold mb-2">Essential DNS Record Types</h3>
        <p class="mb-3">Let's explore the most common DNS record types you'll encounter when managing your domain:</p>
        
        <div class="space-y-6 mb-4">
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
                <h4 class="font-medium text-gray-900 dark:text-white">A Record (Address Record)</h4>
                <p class="text-gray-700 dark:text-gray-300 mb-2">The most fundamental DNS record type. It maps a domain name to an IPv4 address.</p>
                
                <div class="bg-white dark:bg-gray-700 p-3 rounded border border-gray-200 dark:border-gray-600">
                    <p class="text-sm font-mono text-gray-800 dark:text-gray-200"><strong>Example:</strong></p>
                    <p class="text-sm font-mono text-gray-800 dark:text-gray-200">example.com.    IN    A    192.0.2.1</p>
                </div>
                
                <p class="text-gray-700 dark:text-gray-300 mt-2">This record tells DNS servers that the domain example.com should resolve to the IP address 192.0.2.1.</p>
            </div>
            
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
                <h4 class="font-medium text-gray-900 dark:text-white">AAAA Record (IPv6 Address Record)</h4>
                <p class="text-gray-700 dark:text-gray-300 mb-2">Similar to an A record, but for IPv6 addresses instead of IPv4.</p>
                
                <div class="bg-white dark:bg-gray-700 p-3 rounded border border-gray-200 dark:border-gray-600">
                    <p class="text-sm font-mono text-gray-800 dark:text-gray-200"><strong>Example:</strong></p>
                    <p class="text-sm font-mono text-gray-800 dark:text-gray-200">example.com.    IN    AAAA    2001:0db8:85a3:0000:0000:8a2e:0370:7334</p>
                </div>
                
                <p class="text-gray-700 dark:text-gray-300 mt-2">As IPv6 adoption grows, having both A and AAAA records ensures your domain is accessible via both protocols.</p>
            </div>
            
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
                <h4 class="font-medium text-gray-900 dark:text-white">CNAME Record (Canonical Name)</h4>
                <p class="text-gray-700 dark:text-gray-300 mb-2">Creates an alias from one domain name to another. Instead of pointing to an IP address, it points to another domain name.</p>
                
                <div class="bg-white dark:bg-gray-700 p-3 rounded border border-gray-200 dark:border-gray-600">
                    <p class="text-sm font-mono text-gray-800 dark:text-gray-200"><strong>Example:</strong></p>
                    <p class="text-sm font-mono text-gray-800 dark:text-gray-200">www.example.com.    IN    CNAME    example.com.</p>
                </div>
                
                <p class="text-gray-700 dark:text-gray-300 mt-2">This record tells DNS servers that www.example.com is an alias for example.com. When someone visits www.example.com, they'll be directed to the same place as example.com.</p>
                
                <div class="bg-yellow-50 dark:bg-yellow-900 p-3 rounded mt-2">
                    <p class="text-sm text-yellow-700 dark:text-yellow-300"><strong>Important:</strong> You cannot create a CNAME record for the root domain (example.com) itself, only for subdomains (www.example.com).</p>
                </div>
            </div>
            
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
                <h4 class="font-medium text-gray-900 dark:text-white">MX Record (Mail Exchange)</h4>
                <p class="text-gray-700 dark:text-gray-300 mb-2">Specifies the mail servers responsible for accepting email messages on behalf of a domain.</p>
                
                <div class="bg-white dark:bg-gray-700 p-3 rounded border border-gray-200 dark:border-gray-600">
                    <p class="text-sm font-mono text-gray-800 dark:text-gray-200"><strong>Example:</strong></p>
                    <p class="text-sm font-mono text-gray-800 dark:text-gray-200">example.com.    IN    MX    10    mail.example.com.</p>
                    <p class="text-sm font-mono text-gray-800 dark:text-gray-200">example.com.    IN    MX    20    backup-mail.example.com.</p>
                </div>
                
                <p class="text-gray-700 dark:text-gray-300 mt-2">The number before the server name is the priority (lower numbers have higher priority). In this example, mail.example.com is the primary mail server, and backup-mail.example.com is the backup.</p>
            </div>
            
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
                <h4 class="font-medium text-gray-900 dark:text-white">TXT Record (Text)</h4>
                <p class="text-gray-700 dark:text-gray-300 mb-2">Allows domain administrators to insert arbitrary text into DNS records. Commonly used for verification and security purposes.</p>
                
                <div class="bg-white dark:bg-gray-700 p-3 rounded border border-gray-200 dark:border-gray-600">
                    <p class="text-sm font-mono text-gray-800 dark:text-gray-200"><strong>Example (SPF Record):</strong></p>
                    <p class="text-sm font-mono text-gray-800 dark:text-gray-200">example.com.    IN    TXT    "v=spf1 ip4:192.0.2.0/24 include:_spf.example.com ~all"</p>
                </div>
                
                <p class="text-gray-700 dark:text-gray-300 mt-2">TXT records are frequently used for:</p>
                <ul class="list-disc pl-6 text-gray-700 dark:text-gray-300">
                    <li>SPF (Sender Policy Framework) - Helps prevent email spoofing</li>
                    <li>DKIM (DomainKeys Identified Mail) - Email authentication method</li>
                    <li>Domain ownership verification for services like Google Workspace, Microsoft 365, etc.</li>
                </ul>
            </div>
            
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
                <h4 class="font-medium text-gray-900 dark:text-white">NS Record (Name Server)</h4>
                <p class="text-gray-700 dark:text-gray-300 mb-2">Delegates a DNS zone to use the given authoritative nameservers.</p>
                
                <div class="bg-white dark:bg-gray-700 p-3 rounded border border-gray-200 dark:border-gray-600">
                    <p class="text-sm font-mono text-gray-800 dark:text-gray-200"><strong>Example:</strong></p>
                    <p class="text-sm font-mono text-gray-800 dark:text-gray-200">example.com.    IN    NS    ns1.dnsprovider.com.</p>
                    <p class="text-sm font-mono text-gray-800 dark:text-gray-200">example.com.    IN    NS    ns2.dnsprovider.com.</p>
                </div>
                
                <p class="text-gray-700 dark:text-gray-300 mt-2">These records tell the internet which nameservers are authoritative for your domain. When you change DNS providers, you're essentially updating these records.</p>
            </div>
        </div>
    </div>
    
    <div class="mb-6">
        <h3 class="text-xl font-bold mb-2">Less Common but Useful DNS Records</h3>
        <p class="mb-3">Beyond the essential records, several specialized DNS record types serve specific purposes:</p>
        
        <div class="space-y-4 mb-4">
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
                <h4 class="font-medium text-gray-900 dark:text-white">PTR Record (Pointer)</h4>
                <p class="text-gray-700 dark:text-gray-300">Used for reverse DNS lookups, mapping an IP address to a domain name. Important for email deliverability as many servers check for valid PTR records.</p>
            </div>
            
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
                <h4 class="font-medium text-gray-900 dark:text-white">SRV Record (Service)</h4>
                <p class="text-gray-700 dark:text-gray-300">Specifies the location of servers for specific services. Used for VoIP, instant messaging, and other protocols that need to discover services.</p>
            </div>
            
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
                <h4 class="font-medium text-gray-900 dark:text-white">CAA Record (Certification Authority Authorization)</h4>
                <p class="text-gray-700 dark:text-gray-300">Specifies which certificate authorities (CAs) are allowed to issue certificates for a domain. Helps prevent unauthorized certificate issuance.</p>
            </div>
            
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
                <h4 class="font-medium text-gray-900 dark:text-white">DNSKEY, DS, and RRSIG Records</h4>
                <p class="text-gray-700 dark:text-gray-300">Used for DNSSEC (DNS Security Extensions), which adds authentication to DNS to help protect against certain attacks.</p>
            </div>
        </div>
    </div>
    
    <div class="mb-6">
        <h3 class="text-xl font-bold mb-2">Common DNS Record Configurations</h3>
        <p class="mb-3">Here are some typical DNS configurations for common scenarios:</p>
        
        <div class="space-y-6 mb-4">
            <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
                <h4 class="font-medium text-blue-800 dark:text-blue-200">Basic Website Setup</h4>
                <div class="bg-white dark:bg-gray-700 p-3 rounded border border-blue-200 dark:border-blue-800 mt-2">
                    <p class="text-sm font-mono text-gray-800 dark:text-gray-200">example.com.         IN    A       192.0.2.1</p>
                    <p class="text-sm font-mono text-gray-800 dark:text-gray-200">www.example.com.     IN    CNAME   example.com.</p>
                </div>
                <p class="text-sm text-blue-700 dark:text-blue-300 mt-2">This configuration points both your root domain and www subdomain to the same IP address.</p>
            </div>
            
            <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg">
                <h4 class="font-medium text-green-800 dark:text-green-200">Email Setup with Google Workspace</h4>
                <div class="bg-white dark:bg-gray-700 p-3 rounded border border-green-200 dark:border-green-800 mt-2">
                    <p class="text-sm font-mono text-gray-800 dark:text-gray-200">example.com.    IN    MX    1     aspmx.l.google.com.</p>
                    <p class="text-sm font-mono text-gray-800 dark:text-gray-200">example.com.    IN    MX    5     alt1.aspmx.l.google.com.</p>
                    <p class="text-sm font-mono text-gray-800 dark:text-gray-200">example.com.    IN    MX    10    alt2.aspmx.l.google.com.</p>
                    <p class="text-sm font-mono text-gray-800 dark:text-gray-200">example.com.    IN    TXT   "v=spf1 include:_spf.google.com ~all"</p>
                </div>
                <p class="text-sm text-green-700 dark:text-green-300 mt-2">This configuration sets up Google Workspace as your email provider and includes an SPF record to help prevent email spoofing.</p>
            </div>
            
            <div class="bg-purple-50 dark:bg-purple-900 p-4 rounded-lg">
                <h4 class="font-medium text-purple-800 dark:text-purple-200">Website with Cloudflare CDN</h4>
                <div class="bg-white dark:bg-gray-700 p-3 rounded border border-purple-200 dark:border-purple-800 mt-2">
                    <p class="text-sm font-mono text-gray-800 dark:text-gray-200">example.com.         IN    A       104.18.0.52</p>
                    <p class="text-sm font-mono text-gray-800 dark:text-gray-200">www.example.com.     IN    CNAME   example.com.</p>
                    <p class="text-sm font-mono text-gray-800 dark:text-gray-200">example.com.         IN    NS      kim.ns.cloudflare.com.</p>
                    <p class="text-sm font-mono text-gray-800 dark:text-gray-200">example.com.         IN    NS      kyle.ns.cloudflare.com.</p>
                </div>
                <p class="text-sm text-purple-700 dark:text-purple-300 mt-2">This configuration uses Cloudflare as both a DNS provider and CDN. The A record points to Cloudflare's servers, which then proxy requests to your actual web server.</p>
            </div>
        </div>
    </div>
    
    <div class="mb-6">
        <h3 class="text-xl font-bold mb-2">DNS Record Best Practices</h3>
        <p class="mb-3">Follow these guidelines when managing your DNS records:</p>
        
        <ul class="list-disc pl-6 space-y-2 mb-4">
            <li><strong>Document your DNS configuration</strong> - Keep a record of all your DNS settings in case you need to recreate them</li>
            <li><strong>Use appropriate TTL values</strong> - Lower TTLs (300-1800 seconds) for records that might change frequently, higher TTLs (3600-86400 seconds) for stable records</li>
            <li><strong>Implement security records</strong> - Use SPF, DKIM, and DMARC records to protect your email domain from spoofing</li>
            <li><strong>Set up redundancy</strong> - Use multiple MX records with different priorities for email reliability</li>
            <li><strong>Regularly audit your DNS records</strong> - Remove outdated records and ensure all records are still needed</li>
            <li><strong>Test after changes</strong> - Use DNS lookup tools to verify your changes have propagated correctly</li>
        </ul>
        
        <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg mb-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-blue-600 dark:text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200">Pro Tip: DNS Lookup Tools</h4>
                    <div class="mt-1 text-sm text-blue-700 dark:text-blue-300">
                        <p>Use online DNS lookup tools like MXToolbox, DNSChecker, or Google's Dig tool to verify your DNS records and check propagation status. These tools allow you to see how your DNS records appear from different locations around the world.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg mb-4">
        <h4 class="font-medium text-gray-900 dark:text-white mb-2">Chapter Summary</h4>
        <ul class="list-disc pl-6 space-y-1 text-gray-700 dark:text-gray-300">
            <li>A records map domain names to IPv4 addresses</li>
            <li>AAAA records map domain names to IPv6 addresses</li>
            <li>CNAME records create aliases from one domain to another</li>
            <li>MX records specify mail servers for a domain</li>
            <li>TXT records store text information, often for security purposes</li>
            <li>NS records specify the authoritative nameservers for a domain</li>
            <li>Follow best practices like documentation, appropriate TTLs, and regular audits</li>
        </ul>
    </div>
</div>
