<?php
// Quiz for the "Team Structure" chapter

// Define quiz data
$chapterId = 'team_structure';
$quizTitle = 'Team Structure Quiz';
$questions = [
    [
        'question' => 'Which department is primarily responsible for processing business formation filings and registrations?',
        'answers' => [
            'a' => 'Client Services',
            'b' => 'Operations',
            'c' => 'Legal & Compliance',
            'd' => 'Sales & Marketing'
        ],
        'correctAnswer' => 'b',
        'explanation' => 'The Operations department is responsible for processing business formation filings and registrations, managing registered agent services, and implementing compliance monitoring.'
    ],
    [
        'question' => 'What is the primary role of the Legal & Compliance department?',
        'answers' => [
            'a' => 'Managing client relationships',
            'b' => 'Developing marketing strategies',
            'c' => 'Ensuring services adhere to all applicable regulations',
            'd' => 'Processing client billing and payments'
        ],
        'correctAnswer' => 'c',
        'explanation' => 'The Legal & Compliance department ensures our services adhere to all applicable regulations and provides expert guidance on legal matters.'
    ],
    [
        'question' => 'How often are company-wide All-Hands meetings held at Corporate Tools?',
        'answers' => [
            'a' => 'Daily',
            'b' => 'Weekly',
            'c' => 'Monthly',
            'd' => 'Quarterly'
        ],
        'correctAnswer' => 'c',
        'explanation' => 'Monthly All-Hands meetings are held for company-wide updates and recognition.'
    ],
    [
        'question' => 'Which of the following is NOT one of the career development opportunities offered by Corporate Tools?',
        'answers' => [
            'a' => 'Professional certification programs',
            'b' => 'Formal mentoring program',
            'c' => 'Guaranteed promotions every year',
            'd' => 'Leadership development program'
        ],
        'correctAnswer' => 'c',
        'explanation' => 'While Corporate Tools offers many career development opportunities including certification programs, mentoring, and leadership development, the company does not offer guaranteed annual promotions.'
    ],
    [
        'question' => 'What approach does Corporate Tools use when handling complex client issues?',
        'answers' => [
            'a' => 'Escalation to the CEO',
            'b' => 'Transferring to an external consultant',
            'c' => 'Forming a rapid response team with a clear issue owner and supporting experts',
            'd' => 'Handling exclusively within the Client Services department'
        ],
        'correctAnswer' => 'c',
        'explanation' => 'For complex client issues, Corporate Tools forms a rapid response team with a clear issue owner and supporting experts from relevant departments like Client Services, Legal, and Operations.'
    ]
];

// Include the quiz template
require_once __DIR__ . '/../../templates/quiz_template.php';
