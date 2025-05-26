<?php
// Quiz for the "Chapter Structure" chapter

// Define quiz data
$chapterId = 'chapter_structure';
$quizTitle = 'Chapter Structure Quiz';
$questions = [
    [
        'question' => 'What type of knowledge is most important for effective chapter writing?',
        'answers' => [
            'a' => 'Only theoretical knowledge',
            'b' => 'Only practical skills',
            'c' => 'Both theoretical knowledge and practical skills',
            'd' => 'Neither theoretical knowledge nor practical skills'
        ],
        'correctAnswer' => 'c',
        'explanation' => 'Effective chapter writing requires both theoretical knowledge of content structure and practical skills in implementation.'
    ],
    [
        'question' => 'How can you best improve your chapter writing skills?',
        'answers' => [
            'a' => 'By reading about writing techniques',
            'b' => 'By practicing with real-world examples',
            'c' => 'By watching video tutorials',
            'd' => 'By memorizing rules'
        ],
        'correctAnswer' => 'b',
        'explanation' => 'Hands-on practice with real-world examples is the most effective way to improve chapter writing skills.'
    ],
    [
        'question' => 'What is the most important element of a well-structured chapter?',
        'answers' => [
            'a' => 'Fancy formatting',
            'b' => 'Long paragraphs',
            'c' => 'Clear organization and flow',
            'd' => 'Complex vocabulary'
        ],
        'correctAnswer' => 'c',
        'explanation' => 'Clear organization and logical flow are essential for effective chapter structure.'
    ]
];

// Include the quiz template
require_once __DIR__ . '/../../templates/quiz_template.php';
