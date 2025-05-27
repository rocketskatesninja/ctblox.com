<?php
// Define quiz data
$chapterId = 'troubleshooting_dns';
$quizTitle = 'Troubleshooting DNS Quiz';
$questions = [
    [
        'question' => 'If your website displays "Server not found" errors, which of the following is NOT a likely cause?',
        'answers' => [
            'a' => 'Missing or incorrect A/AAAA records',
            'b' => 'Recent DNS changes that haven\'t fully propagated',
            'c' => 'Expired domain name',
            'd' => 'Slow internet connection'
        ],
        'correct' => 'd',
        'explanation' => 'While a slow internet connection might cause timeout errors, it typically wouldn\'t result in "Server not found" errors. These errors are more commonly caused by DNS resolution problems like missing/incorrect A records, DNS propagation delays, or expired domains.'
    ],
    [
        'question' => 'Which command would you use to check MX records for a domain?',
        'answers' => [
            'a' => 'dig example.com A',
            'b' => 'dig example.com MX',
            'c' => 'nslookup -type=mail example.com',
            'd' => 'ping mail.example.com'
        ],
        'correct' => 'b',
        'explanation' => 'The command "dig example.com MX" is used to check MX (Mail Exchange) records for a domain. This will show you which mail servers are configured to handle email for the domain and their priority values.'
    ],
    [
        'question' => 'What does the "+trace" option do when used with the dig command?',
        'answers' => [
            'a' => 'Shows the IP address of the domain',
            'b' => 'Traces the network path to the server',
            'c' => 'Shows the full DNS resolution path from root servers',
            'd' => 'Displays historical DNS changes'
        ],
        'correct' => 'c',
        'explanation' => 'The "+trace" option with dig shows the full DNS resolution path, starting from the root servers, through TLD servers, to the authoritative nameservers. This helps identify where in the DNS hierarchy a resolution problem might be occurring.'
    ],
    [
        'question' => 'Which of the following is the best way to check if DNS changes have propagated globally?',
        'answers' => [
            'a' => 'Clear your browser cache and refresh the page',
            'b' => 'Use a tool that checks DNS from multiple global locations',
            'c' => 'Wait 24 hours and then check your website',
            'd' => 'Ask a friend in another city to check'
        ],
        'correct' => 'b',
        'explanation' => 'Using a tool that checks DNS from multiple global locations (like DNSChecker.org) is the best way to verify global propagation. This shows you how your DNS records appear from different locations around the world, giving you a comprehensive view of propagation status.'
    ],
    [
        'question' => 'If your website is accessible by IP address but not by domain name, what is the most likely issue?',
        'answers' => [
            'a' => 'Web server configuration problem',
            'b' => 'DNS resolution issue',
            'c' => 'Firewall blocking the website',
            'd' => 'SSL certificate error'
        ],
        'correct' => 'b',
        'explanation' => 'If a website is accessible by IP address but not by domain name, it strongly indicates a DNS resolution issue. This means the web server is running correctly, but there\'s a problem with the DNS configuration that prevents the domain name from resolving to the correct IP address.'
    ]
];

// Include the quiz template
include_once($_SERVER['DOCUMENT_ROOT'] . '/app/templates/quiz_template.php');
?>
