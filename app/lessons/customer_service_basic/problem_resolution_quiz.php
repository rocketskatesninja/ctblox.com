<?php
// Define quiz data
$chapterId = 'problem_resolution';
$quizTitle = 'Problem Resolution Quiz';
$questions = [
    [
        'question' => 'What does the LAST method stand for in problem resolution?',
        'answers' => [
            'a' => 'Listen, Analyze, Solve, Track',
            'b' => 'Learn, Acknowledge, Service, Thank',
            'c' => 'Listen, Acknowledge, Solve, Thank',
            'd' => 'Look, Assess, Solve, Test'
        ],
        'correct' => 'c',
        'explanation' => 'The LAST method stands for Listen (give the customer your full attention), Acknowledge (validate their feelings), Solve (offer a clear solution), and Thank (express gratitude for their patience).'
    ],
    [
        'question' => 'Which of the following is a recommended approach when dealing with an angry customer?',
        'answers' => [
            'a' => 'Raise your voice to match their energy',
            'b' => 'Lower your voice if they raise theirs',
            'c' => 'Tell them to calm down',
            'd' => 'Immediately transfer them to a manager'
        ],
        'correct' => 'b',
        'explanation' => 'When dealing with an angry customer, it\'s recommended to lower your voice if they raise theirs. This can help de-escalate the situation and bring the emotional temperature down.'
    ],
    [
        'question' => 'What is the "service recovery paradox"?',
        'answers' => [
            'a' => 'The idea that service problems can never be fully resolved',
            'b' => 'When effective service recovery creates stronger customer loyalty than if no problem had occurred',
            'c' => 'The contradiction between customer expectations and business capabilities',
            'd' => 'When customers become more demanding after receiving good service'
        ],
        'correct' => 'b',
        'explanation' => 'The service recovery paradox refers to the phenomenon where effective service recovery can actually create stronger customer loyalty than if no problem had occurred in the first place.'
    ],
    [
        'question' => 'What is the first step in the five steps of service recovery?',
        'answers' => [
            'a' => 'Fix the immediate problem',
            'b' => 'Apologize sincerely and take responsibility',
            'c' => 'Compensate the customer',
            'd' => 'Review the situation with the customer'
        ],
        'correct' => 'b',
        'explanation' => 'The first step in the five steps of service recovery is to apologize sincerely and take responsibility. This sets the tone for the entire recovery process and shows the customer you value their experience.'
    ],
    [
        'question' => 'Which de-escalation technique uses the structure "I understand how you feel. Other customers have felt the same way. They found that [solution] worked well for them"?',
        'answers' => [
            'a' => 'The LAST method',
            'b' => 'The feel, felt, found approach',
            'c' => 'The empathy triangle',
            'd' => 'The service recovery paradox'
        ],
        'correct' => 'b',
        'explanation' => 'The "feel, felt, found" approach follows the structure: "I understand how you feel. Other customers have felt the same way. They found that [solution] worked well for them." It\'s an effective de-escalation technique that validates the customer\'s feelings while offering a solution.'
    ]
];

// Include the quiz template
include_once($_SERVER['DOCUMENT_ROOT'] . '/app/templates/quiz_template.php');
?>
