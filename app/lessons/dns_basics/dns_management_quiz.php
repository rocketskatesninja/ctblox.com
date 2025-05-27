<?php
// Define quiz data
$chapterId = 'dns_management';
$quizTitle = 'DNS Management Quiz';
$questions = [
    [
        'question' => 'Where can DNS settings be managed? (Select the INCORRECT option)',
        'answers' => [
            'a' => 'Domain registrar',
            'b' => 'Web hosting provider',
            'c' => 'Third-party DNS providers',
            'd' => 'Web browser settings'
        ],
        'correct' => 'd',
        'explanation' => 'DNS settings cannot be managed through web browser settings. They are typically managed at your domain registrar, web hosting provider, or through third-party DNS providers like Cloudflare or Amazon Route 53.'
    ],
    [
        'question' => 'What is the first step you should take when planning to change DNS providers?',
        'answers' => [
            'a' => 'Update nameservers at your registrar immediately',
            'b' => 'Set up your DNS records at the new provider first',
            'c' => 'Increase TTL values to maximum',
            'd' => 'Take your website offline temporarily'
        ],
        'correct' => 'b',
        'explanation' => 'Before making any changes to your current setup, you should create all your DNS records at the new provider. This ensures a smooth transition when you eventually update your nameservers.'
    ],
    [
        'question' => 'What is the purpose of lowering TTL values before making DNS changes?',
        'answers' => [
            'a' => 'To reduce DNS server load',
            'b' => 'To improve website loading speed',
            'c' => 'To speed up propagation when you make the change',
            'd' => 'To prevent DNS hijacking'
        ],
        'correct' => 'c',
        'explanation' => 'Lowering TTL values before making DNS changes speeds up propagation when you make the actual change. With lower TTLs, cached records expire more quickly, allowing the new records to be fetched sooner.'
    ],
    [
        'question' => 'Which of the following is a best practice for DNS management?',
        'answers' => [
            'a' => 'Use a single nameserver for simplicity',
            'b' => 'Change DNS settings frequently to improve security',
            'c' => 'Document your DNS configuration',
            'd' => 'Set all TTL values to the minimum permanently'
        ],
        'correct' => 'c',
        'explanation' => 'Documenting your DNS configuration is a best practice. This documentation is invaluable if you need to recreate your DNS configuration or troubleshoot issues. You should always use multiple nameservers for redundancy, not change DNS settings unnecessarily, and balance TTL values appropriately.'
    ],
    [
        'question' => 'What is DNSSEC used for?',
        'answers' => [
            'a' => 'To encrypt DNS queries',
            'b' => 'To add authentication to DNS records',
            'c' => 'To speed up DNS resolution',
            'd' => 'To block malicious websites'
        ],
        'correct' => 'b',
        'explanation' => 'DNSSEC (DNS Security Extensions) adds digital signatures to DNS records, allowing DNS resolvers to verify that the data hasn\'t been tampered with. This helps protect against DNS spoofing attacks by adding authentication to DNS records.'
    ]
];

// Include the quiz template
include_once($_SERVER['DOCUMENT_ROOT'] . '/app/templates/quiz_template.php');
?>
