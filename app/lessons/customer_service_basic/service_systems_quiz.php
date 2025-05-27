<?php
// Define quiz data
$chapterId = 'service_systems';
$quizTitle = 'Service Systems Quiz';
$questions = [
    [
        'question' => 'What is the purpose of creating service standards in a small business?',
        'answers' => [
            'a' => 'To make employees follow rigid rules',
            'b' => 'To ensure consistency across all customer interactions',
            'c' => 'To reduce the need for customer service training',
            'd' => 'To eliminate the need for personalized service'
        ],
        'correct' => 'b',
        'explanation' => 'Service standards define what quality service looks like in your business and serve as guidelines for you and your team, ensuring consistency across all customer interactions.'
    ],
    [
        'question' => 'Which of the following is NOT mentioned as essential information to track in a CRM system?',
        'answers' => [
            'a' => 'Contact details',
            'b' => 'Purchase history',
            'c' => 'Competitor information',
            'd' => 'Service interactions'
        ],
        'correct' => 'c',
        'explanation' => 'Competitor information was not mentioned as essential CRM information. The lesson listed contact details, purchase history, service interactions, preferences, important dates, and notes as essential information to track in a CRM system.'
    ],
    [
        'question' => 'What is the Net Promoter Score (NPS) based on?',
        'answers' => [
            'a' => 'A detailed survey about product features',
            'b' => 'The question "How likely are you to recommend us to a friend or colleague?"',
            'c' => 'Customer retention rates over time',
            'd' => 'The number of positive reviews minus negative reviews'
        ],
        'correct' => 'b',
        'explanation' => 'The Net Promoter Score (NPS) is based on asking customers "On a scale of 0-10, how likely are you to recommend us to a friend or colleague?" This single question provides powerful insights into customer loyalty.'
    ],
    [
        'question' => 'What is the correct order of steps in the feedback loop?',
        'answers' => [
            'a' => 'Collect, Analyze, Act, Communicate, Measure',
            'b' => 'Analyze, Collect, Act, Measure, Communicate',
            'c' => 'Act, Collect, Analyze, Communicate, Measure',
            'd' => 'Collect, Act, Analyze, Measure, Communicate'
        ],
        'correct' => 'a',
        'explanation' => 'The correct order of steps in the feedback loop is: 1) Collect feedback systematically, 2) Analyze to identify patterns and priorities, 3) Act on the insights by making improvements, 4) Communicate changes to customers, and 5) Measure the impact of your changes.'
    ],
    [
        'question' => 'Why is employee empowerment important in customer service systems?',
        'answers' => [
            'a' => 'It reduces the need for management oversight',
            'b' => 'It allows employees to make their own rules',
            'c' => 'It helps them resolve issues quickly without always escalating to management',
            'd' => 'It eliminates the need for service standards'
        ],
        'correct' => 'c',
        'explanation' => 'Employee empowerment is important because it helps team members resolve issues quickly and confidently without always escalating to management. Clear guidelines on what they can offer customers (refunds, discounts, exceptions) support this empowerment.'
    ]
];

// Include the quiz template
include_once($_SERVER['DOCUMENT_ROOT'] . '/app/templates/quiz_template.php');
?>
