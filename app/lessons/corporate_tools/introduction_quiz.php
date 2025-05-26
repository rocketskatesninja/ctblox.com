<?php
// Quiz for the "Introduction" chapter

// Define quiz data
$chapterId = 'introduction';
$quizTitle = 'Introduction Quiz';
$questions = [
    [
        'question' => 'Which of the following best describes the purpose of this chapter?',
        'answers' => [
            'a' => 'To provide theoretical knowledge',
            'b' => 'To develop practical skills',
            'c' => 'Both theoretical knowledge and practical skills'
        ],
        'correctAnswer' => 'c',
        'explanation' => 'The introduction chapter provides both theoretical knowledge about Corporate Tools and practical understanding of how the company operates.'
    ],
    [
        'question' => 'What is the best way to apply what you\'ve learned in this chapter?',
        'answers' => [
            'a' => 'By memorizing the key concepts',
            'b' => 'By practicing with real-world examples',
            'c' => 'By teaching the concepts to someone else'
        ],
        'correctAnswer' => 'b',
        'explanation' => 'Practicing with real-world examples is the most effective way to apply the knowledge gained from this chapter.'
    ],
    [
        'question' => 'What is most important for a well-structured lesson?',
        'answers' => [
            'a' => 'Fancy graphics and animations',
            'b' => 'Long, detailed paragraphs',
            'c' => 'Clear organization and flow'
        ],
        'correctAnswer' => 'c',
        'explanation' => 'Clear organization and flow are essential for a well-structured lesson that effectively communicates information.'
    ]
];

// Include the quiz template
require_once __DIR__ . '/../../templates/quiz_template.php';
