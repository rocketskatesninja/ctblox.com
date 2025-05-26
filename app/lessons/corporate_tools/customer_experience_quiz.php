<?php
// Quiz for the "Customer Experience" chapter

// Define quiz data
$chapterId = 'customer_experience';
$quizTitle = 'Customer Experience Quiz';
$questions = [
    [
        'question' => 'What is the foundation of Corporate Tools\' customer service philosophy?',
        'answers' => [
            'a' => 'Providing the lowest prices in the industry',
            'b' => 'Offering the fastest service possible',
            'c' => 'Combining expertise with empathy',
            'd' => 'Maintaining a large support staff'
        ],
        'correctAnswer' => 'c',
        'explanation' => 'Corporate Tools\' customer service philosophy is built on combining technical expertise with a deep understanding of our clients\' needs and concerns (expertise with empathy).'
    ],
    [
        'question' => 'What does the "C" stand for in the CARE framework for resolving issues?',
        'answers' => [
            'a' => 'Correct',
            'b' => 'Connect',
            'c' => 'Compensate',
            'd' => 'Complete'
        ],
        'correctAnswer' => 'b',
        'explanation' => 'In the CARE framework, "C" stands for Connect - listening actively and empathetically to understand the client\'s concern.'
    ],
    [
        'question' => 'What is the maximum response time for client emails according to Corporate Tools\' service standards?',
        'answers' => [
            'a' => '1 business hour',
            'b' => '4 business hours',
            'c' => '24 business hours',
            'd' => '48 business hours'
        ],
        'correctAnswer' => 'b',
        'explanation' => 'Corporate Tools\' service standards require an initial response to client emails within 4 business hours.'
    ],
    [
        'question' => 'Which metric measures how easy it is for clients to get their needs met?',
        'answers' => [
            'a' => 'Net Promoter Score (NPS)',
            'b' => 'Customer Satisfaction (CSAT)',
            'c' => 'Customer Effort Score (CES)',
            'd' => 'Customer Loyalty Index (CLI)'
        ],
        'correctAnswer' => 'c',
        'explanation' => 'The Customer Effort Score (CES) assesses how easy it is for clients to get their needs met when interacting with Corporate Tools.'
    ],
    [
        'question' => 'What is the appropriate action when a client has a complex inquiry via live chat?',
        'answers' => [
            'a' => 'Provide a lengthy text explanation in the chat',
            'b' => 'Ask them to email instead and close the chat',
            'c' => 'Offer to transition to phone or email for better assistance',
            'd' => 'Direct them to the FAQ section of the website'
        ],
        'correctAnswer' => 'c',
        'explanation' => 'When handling complex inquiries via live chat, team members should offer to transition to phone or email for more thorough assistance, providing a better customer experience.'
    ]
];

// Include the quiz template
require_once __DIR__ . '/../../templates/quiz_template.php';
