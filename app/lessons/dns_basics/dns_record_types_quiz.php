<?php
// Define quiz data
$chapterId = 'dns_record_types';
$quizTitle = 'DNS Record Types Quiz';
$questions = [
    [
        'question' => 'Which DNS record type maps a domain name to an IPv4 address?',
        'answers' => [
            'a' => 'CNAME Record',
            'b' => 'MX Record',
            'c' => 'A Record',
            'd' => 'TXT Record'
        ],
        'correct' => 'c',
        'explanation' => 'The A (Address) Record is the most fundamental DNS record type. It maps a domain name to an IPv4 address, telling DNS servers that a domain should resolve to a specific IP address.'
    ],
    [
        'question' => 'What is the purpose of a CNAME record?',
        'answers' => [
            'a' => 'To specify mail servers for a domain',
            'b' => 'To create an alias from one domain name to another',
            'c' => 'To map a domain to an IPv6 address',
            'd' => 'To verify domain ownership'
        ],
        'correct' => 'b',
        'explanation' => 'A CNAME (Canonical Name) record creates an alias from one domain name to another. Instead of pointing to an IP address, it points to another domain name. For example, www.example.com might be a CNAME pointing to example.com.'
    ],
    [
        'question' => 'Which DNS record type is primarily used for email delivery?',
        'answers' => [
            'a' => 'MX Record',
            'b' => 'SPF Record',
            'c' => 'NS Record',
            'd' => 'PTR Record'
        ],
        'correct' => 'a',
        'explanation' => 'MX (Mail Exchange) Records specify the mail servers responsible for accepting email messages on behalf of a domain. They include a priority value to indicate which mail server should be tried first.'
    ],
    [
        'question' => 'Which of the following is TRUE about TXT records?',
        'answers' => [
            'a' => 'They can only contain numeric values',
            'b' => 'They are used exclusively for DNSSEC',
            'c' => 'They allow domain administrators to insert arbitrary text into DNS records',
            'd' => 'They are being phased out in modern DNS implementations'
        ],
        'correct' => 'c',
        'explanation' => 'TXT (Text) Records allow domain administrators to insert arbitrary text into DNS records. They are commonly used for verification and security purposes, such as SPF, DKIM, and domain ownership verification.'
    ],
    [
        'question' => 'Which statement about NS records is correct?',
        'answers' => [
            'a' => 'They specify which certificate authorities can issue SSL certificates for a domain',
            'b' => 'They delegate a DNS zone to use specific authoritative nameservers',
            'c' => 'They are used for reverse DNS lookups',
            'd' => 'They are only required for subdomains, not root domains'
        ],
        'correct' => 'b',
        'explanation' => 'NS (Name Server) Records delegate a DNS zone to use the given authoritative nameservers. These records tell the internet which nameservers are authoritative for your domain. When you change DNS providers, you\'re essentially updating these records.'
    ]
];

// Include the quiz template
include_once($_SERVER['DOCUMENT_ROOT'] . '/app/templates/quiz_template.php');
?>
