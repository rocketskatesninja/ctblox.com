<?php
// Quiz for the "Quiz Implementation" chapter

// Define quiz data
$chapterId = 'quiz_implementation';
$quizTitle = 'Quiz Implementation Quiz';
$questions = [
    [
        'question' => 'What is the recommended file naming convention for quiz files?',
        'answers' => [
            'a' => 'quiz_[chapter_number].php',
            'b' => '[chapter_name]_quiz.php',
            'c' => 'test_[chapter_name].php',
            'd' => 'assessment_[chapter_name].php'
        ],
        'correctAnswer' => 'b',
        'explanation' => 'Using [chapter_name]_quiz.php provides clear identification of which chapter the quiz belongs to.'
    ],
    [
        'question' => 'How should quiz results be submitted to the server?',
        'answers' => [
            'a' => 'Through a standard form submission',
            'b' => 'Via AJAX using the fetch API',
            'c' => 'By redirecting to a results page',
            'd' => 'Results do not need to be submitted to the server'
        ],
        'correctAnswer' => 'b',
        'explanation' => 'AJAX submissions provide a smoother user experience without page refreshes.'
    ],
    [
        'question' => 'What should happen after a user submits a quiz?',
        'answers' => [
            'a' => 'The page should refresh to show a new page',
            'b' => 'Nothing, the user should continue to the next chapter',
            'c' => 'The user should see their score and the correct answers immediately',
            'd' => 'An email with results should be sent to the user'
        ],
        'correctAnswer' => 'c',
        'explanation' => 'Immediate feedback helps reinforce learning and provides a better user experience.'
    ]
];

// Include the quiz template
require_once __DIR__ . '/../../templates/quiz_template.php';
