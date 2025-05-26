<?php
// Quiz for the "Service Offerings" chapter

// Define quiz data
$chapterId = 'service_offerings';
$quizTitle = 'Service Offerings Quiz';
$questions = [
    [
        'question' => 'Which of the following is NOT included in Corporate Tools\' LLC Formation service?',
        'answers' => [
            'a' => 'Articles of Organization filing',
            'b' => 'Operating Agreement creation',
            'c' => 'EIN obtainment',
            'd' => 'Tax return preparation'
        ],
        'correctAnswer' => 'd',
        'explanation' => 'Corporate Tools\' LLC Formation service includes Articles of Organization filing, Operating Agreement creation, EIN obtainment, compliance calendar setup, and member certificates, but does not include tax return preparation.'
    ],
    [
        'question' => 'What is the primary purpose of Corporate Tools\' Registered Agent service?',
        'answers' => [
            'a' => 'To provide tax advice',
            'b' => 'To receive important legal and government documents on behalf of businesses',
            'c' => 'To represent businesses in court',
            'd' => 'To manage employee payroll'
        ],
        'correctAnswer' => 'b',
        'explanation' => 'The primary purpose of our Registered Agent service is to serve as a reliable point of contact for receiving important legal and government documents on behalf of businesses.'
    ],
    [
        'question' => 'Which of the following is a benefit of Corporate Tools\' Compliance Management services?',
        'answers' => [
            'a' => 'Reduced tax liability',
            'b' => 'Increased business revenue',
            'c' => 'Avoiding penalties and maintaining good standing',
            'd' => 'Guaranteed business loans'
        ],
        'correctAnswer' => 'c',
        'explanation' => 'Our Compliance Management services help businesses stay current with state and federal requirements, avoiding penalties and maintaining good standing.'
    ],
    [
        'question' => 'Which service package is ideal for multi-state or multi-entity businesses?',
        'answers' => [
            'a' => 'Starter',
            'b' => 'Professional',
            'c' => 'Premium',
            'd' => 'Enterprise'
        ],
        'correctAnswer' => 'd',
        'explanation' => 'The Enterprise package is designed for multi-state or multi-entity businesses and includes all Premium features plus a dedicated account manager and custom solutions.'
    ],
    [
        'question' => 'Which of the following is NOT one of the Business Management Tools offered by Corporate Tools?',
        'answers' => [
            'a' => 'Document Management',
            'b' => 'Compliance Dashboard',
            'c' => 'Team Management',
            'd' => 'Inventory Management'
        ],
        'correctAnswer' => 'd',
        'explanation' => 'Corporate Tools offers Document Management, Compliance Dashboard, and Team Management tools, but does not offer Inventory Management as part of its Business Management Tools.'
    ]
];

// Include the quiz template
require_once __DIR__ . '/../../templates/quiz_template.php';
