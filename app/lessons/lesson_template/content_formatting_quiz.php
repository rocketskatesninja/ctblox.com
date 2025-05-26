<?php
// Quiz for the "Content Formatting" chapter

// Define quiz data
$chapterId = 'content_formatting';
$quizTitle = 'Content Formatting Quiz';
$questions = [
    [
        'question' => 'Which of the following is recommended for organizing related items without a specific sequence?',
        'answers' => [
            'a' => 'Ordered lists (list-decimal)',
            'b' => 'Unordered lists (list-disc)',
            'c' => 'Definition lists',
            'd' => 'Numbered paragraphs'
        ],
        'correctAnswer' => 'b',
        'explanation' => 'Unordered lists are ideal for organizing related items when their sequence does not matter.'
    ],
    [
        'question' => 'What is the recommended length for paragraphs in lesson content?',
        'answers' => [
            'a' => '1-2 sentences',
            'b' => '3-5 sentences',
            'c' => '7-10 sentences',
            'd' => 'As long as needed with no limit'
        ],
        'correctAnswer' => 'b',
        'explanation' => '3-5 sentences is the optimal length for readability and comprehension.'
    ],
    [
        'question' => 'When should tables be used in lesson content?',
        'answers' => [
            'a' => 'For all types of content organization',
            'b' => 'Only for numerical data',
            'c' => 'When comparing multiple items across consistent categories',
            'd' => 'Never, lists should be used instead'
        ],
        'correctAnswer' => 'c',
        'explanation' => 'Tables are most effective when comparing multiple items across consistent categories.'
    ]
];

// Include the quiz template
require_once __DIR__ . '/../../templates/quiz_template.php';
