<?php
// Define quiz data
$chapterId = 'how_dns_works';
$quizTitle = 'How DNS Works Quiz';
$questions = [
    [
        'question' => 'What is the primary purpose of DNS?',
        'answers' => [
            'a' => 'To encrypt website traffic',
            'b' => 'To translate domain names to IP addresses',
            'c' => 'To store website content',
            'd' => 'To manage email delivery'
        ],
        'correct' => 'b',
        'explanation' => 'The primary purpose of DNS (Domain Name System) is to translate human-friendly domain names (like example.com) into machine-readable IP addresses (like 192.0.2.1) that computers use to identify each other on the network.'
    ],
    [
        'question' => 'What is the correct order of the DNS resolution process?',
        'answers' => [
            'a' => 'Browser cache, OS cache, Router cache, ISP resolver, Root server, TLD server, Authoritative nameserver',
            'b' => 'ISP resolver, Browser cache, OS cache, Router cache, Authoritative nameserver, TLD server, Root server',
            'c' => 'Root server, TLD server, Authoritative nameserver, ISP resolver, Router cache, OS cache, Browser cache',
            'd' => 'Authoritative nameserver, TLD server, Root server, ISP resolver, Router cache, OS cache, Browser cache'
        ],
        'correct' => 'a',
        'explanation' => 'The DNS resolution process typically follows this order: Browser cache first, then OS cache, Router cache, ISP resolver, and if not found in any cache, a recursive query begins from Root server to TLD server to Authoritative nameserver.'
    ],
    [
        'question' => 'What is DNS propagation?',
        'answers' => [
            'a' => 'The process of securing DNS records with encryption',
            'b' => 'The delay that occurs when DNS changes spread across the internet',
            'c' => 'The method of transferring domain ownership',
            'd' => 'The process of optimizing DNS for faster loading'
        ],
        'correct' => 'b',
        'explanation' => 'DNS propagation refers to the delay that occurs when you make changes to your DNS records, as those changes don\'t take effect immediately everywhere. This delay happens because DNS information is cached at various levels throughout the internet.'
    ],
    [
        'question' => 'What is a TTL value in DNS?',
        'answers' => [
            'a' => 'The total time a website takes to load',
            'b' => 'The number of DNS servers in a network',
            'c' => 'The time a DNS record can be cached before it needs to be refreshed',
            'd' => 'The maximum number of DNS queries allowed per hour'
        ],
        'correct' => 'c',
        'explanation' => 'TTL (Time To Live) is a value specified in DNS records that indicates how long (in seconds) the record can be cached before the resolver needs to request a fresh copy from the authoritative nameserver.'
    ],
    [
        'question' => 'Which of the following is NOT a level in the DNS hierarchy?',
        'answers' => [
            'a' => 'Root Servers',
            'b' => 'TLD Servers',
            'c' => 'Authoritative Name Servers',
            'd' => 'Domain Control Servers'
        ],
        'correct' => 'd',
        'explanation' => 'Domain Control Servers is not a level in the DNS hierarchy. The DNS hierarchy consists of Root Servers at the top, followed by TLD (Top-Level Domain) Servers, and Authoritative Name Servers. Recursive Resolvers query this hierarchy on behalf of users.'
    ]
];

// Include the quiz template
include_once($_SERVER['DOCUMENT_ROOT'] . '/app/templates/quiz_template.php');
?>
