<?php
// Quiz template - Copy this file and modify for each chapter quiz

// Define quiz data
$chapterId = 'chapter_name'; // Change to match your chapter ID
$quizTitle = 'Chapter Name Quiz'; // Change to match your chapter title
$questions = [
    [
        'question' => 'First question text goes here?',
        'answers' => [
            'a' => 'First answer option',
            'b' => 'Second answer option',
            'c' => 'Third answer option',
            'd' => 'Fourth answer option'
        ],
        'correctAnswer' => 'b', // The correct answer key (a, b, c, or d)
        'explanation' => 'Explanation of why this answer is correct.'
    ],
    [
        'question' => 'Second question text goes here?',
        'answers' => [
            'a' => 'First answer option',
            'b' => 'Second answer option',
            'c' => 'Third answer option',
            'd' => 'Fourth answer option'
        ],
        'correctAnswer' => 'c', // The correct answer key (a, b, c, or d)
        'explanation' => 'Explanation of why this answer is correct.'
    ],
    [
        'question' => 'Third question text goes here?',
        'answers' => [
            'a' => 'First answer option',
            'b' => 'Second answer option',
            'c' => 'Third answer option',
            'd' => 'Fourth answer option'
        ],
        'correctAnswer' => 'a', // The correct answer key (a, b, c, or d)
        'explanation' => 'Explanation of why this answer is correct.'
    ]
    // Add more questions as needed
];

// Include the quiz template - DO NOT MODIFY THIS LINE
require_once __DIR__ . '/../../templates/quiz_template.php';
