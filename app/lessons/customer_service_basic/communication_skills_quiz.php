<?php
// Define quiz data
$chapterId = 'communication_skills';
$quizTitle = 'Communication Skills Quiz';
$questions = [
    [
        'question' => 'What does the "S" in the LISTEN technique stand for?',
        'answers' => [
            'a' => 'Speak clearly',
            'b' => 'Stay focused and avoid interrupting',
            'c' => 'Summarize what you heard',
            'd' => 'Smile during the conversation'
        ],
        'correct' => 'b',
        'explanation' => 'In the LISTEN technique, "S" stands for "Stay focused and avoid interrupting." This is a critical part of active listening that shows respect for the customer and ensures you understand their complete message.'
    ],
    [
        'question' => 'According to research mentioned in the chapter, what percentage of face-to-face communication impact comes from body language?',
        'answers' => [
            'a' => '7%',
            'b' => '38%',
            'c' => '55%',
            'd' => '25%'
        ],
        'correct' => 'c',
        'explanation' => 'Research suggests that in face-to-face communication, 55% of the impact comes from body language, 38% from tone of voice, and only 7% from the actual words used.'
    ],
    [
        'question' => 'Which of the following is an example of positive language framing?',
        'answers' => [
            'a' => '"We don\'t offer refunds after 30 days."',
            'b' => '"You\'ll have to wait until next week for delivery."',
            'c' => '"We\'re happy to offer store credit or an exchange."',
            'd' => '"Our policy doesn\'t allow for that option."'
        ],
        'correct' => 'c',
        'explanation' => '"We\'re happy to offer store credit or an exchange" is an example of positive language framing. It focuses on what you can do for the customer rather than what you can\'t do.'
    ],
    [
        'question' => 'What is the recommended response time goal for chat inquiries?',
        'answers' => [
            'a' => 'Under 5 minutes',
            'b' => 'Under 1 hour',
            'c' => 'Within 24 hours',
            'd' => 'By the end of the business day'
        ],
        'correct' => 'a',
        'explanation' => 'For chat inquiries, the recommended response time goal is under 5 minutes. For social media, it\'s under 1 hour. Quick response times are essential for these real-time or near-real-time communication channels.'
    ],
    [
        'question' => 'Which of these is NOT one of the recommended email best practices?',
        'answers' => [
            'a' => 'Use a clear, specific subject line',
            'b' => 'Keep paragraphs short and scannable',
            'c' => 'Include multiple font styles to emphasize important points',
            'd' => 'End with a clear call to action or next steps'
        ],
        'correct' => 'c',
        'explanation' => 'Including multiple font styles to emphasize important points is NOT a recommended email best practice. Instead, use simple, consistent formatting for professional communication. The other options are all recommended practices for effective email communication.'
    ]
];

// Include the quiz template
include_once($_SERVER['DOCUMENT_ROOT'] . '/app/templates/quiz_template.php');
?>
