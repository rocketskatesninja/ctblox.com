<?php
// Quiz for the "Technology & Tools" chapter

// Define quiz data
$chapterId = 'technology_tools';
$quizTitle = 'Technology & Tools Quiz';
$questions = [
    [
        'question' => 'What is the primary digital interface for clients at Corporate Tools?',
        'answers' => [
            'a' => 'Filing Management System (FMS)',
            'b' => 'Client Portal',
            'c' => 'Compliance Management System (CMS)',
            'd' => 'Registered Agent Platform (RAP)'
        ],
        'correctAnswer' => 'b',
        'explanation' => 'The Client Portal is Corporate Tools\' primary digital interface for clients, providing secure access to their business information, documents, and services.'
    ],
    [
        'question' => 'Which system is responsible for tracking compliance requirements, deadlines, and status across all jurisdictions?',
        'answers' => [
            'a' => 'Compliance Management System (CMS)',
            'b' => 'Filing Management System (FMS)',
            'c' => 'Registered Agent Platform (RAP)',
            'd' => 'Knowledge Base'
        ],
        'correctAnswer' => 'a',
        'explanation' => 'The Compliance Management System (CMS) is responsible for tracking requirements, deadlines, and compliance status across all jurisdictions.'
    ],
    [
        'question' => 'What technology feature helps ensure the security of client data in the Client Portal?',
        'answers' => [
            'a' => 'Public access to all documents',
            'b' => 'Basic password protection',
            'c' => 'Multi-factor authentication and 256-bit encryption',
            'd' => 'Manual backup of files'
        ],
        'correctAnswer' => 'c',
        'explanation' => 'The Client Portal uses multi-factor authentication and 256-bit encryption for all data to ensure security.'
    ],
    [
        'question' => 'What is the first step in the Registered Agent Platform\'s document processing workflow?',
        'answers' => [
            'a' => 'Classification of document type',
            'b' => 'Receipt of physical or electronic document',
            'c' => 'Notification to the client',
            'd' => 'Scanning the document'
        ],
        'correctAnswer' => 'b',
        'explanation' => 'The first step in the Registered Agent Platform\'s document processing workflow is the receipt of a physical or electronic document at our registered office.'
    ],
    [
        'question' => 'Which internal tool provides insights into service performance, client satisfaction, and operational metrics?',
        'answers' => [
            'a' => 'CRM System',
            'b' => 'Knowledge Base',
            'c' => 'Analytics Dashboard',
            'd' => 'Billing System'
        ],
        'correctAnswer' => 'c',
        'explanation' => 'The Analytics Dashboard provides insights into service performance, client satisfaction, and operational metrics.'
    ]
];

// Include the quiz template
require_once __DIR__ . '/../../templates/quiz_template.php';
