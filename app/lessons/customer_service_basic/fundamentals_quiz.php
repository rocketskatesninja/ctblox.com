<?php
// Define quiz data
$chapterId = 'fundamentals';
$quizTitle = 'Customer Service Fundamentals Quiz';
$questions = [
    [
        'question' => 'Which of the following is NOT one of the five pillars of customer service discussed in this chapter?',
        'answers' => [
            'a' => 'Reliability',
            'b' => 'Responsiveness',
            'c' => 'Efficiency',
            'd' => 'Empathy'
        ],
        'correct' => 'c',
        'explanation' => 'The five pillars of customer service discussed in the chapter are Reliability, Responsiveness, Assurance, Empathy, and Tangibles. Efficiency, while important, was not listed as one of the five core pillars.'
    ],
    [
        'question' => 'What is the recommended approach to setting customer expectations?',
        'answers' => [
            'a' => 'Promise quick delivery to make customers happy',
            'b' => 'Under-promise and over-deliver',
            'c' => 'Set ambitious goals to motivate your team',
            'd' => 'Match competitor promises exactly'
        ],
        'correct' => 'b',
        'explanation' => 'The key principle for setting customer expectations is to under-promise and over-deliver. It\'s better to exceed modest expectations than to fall short of ambitious ones.'
    ],
    [
        'question' => 'According to the lesson, what percentage of unhappy customers don\'t complain directly to the business?',
        'answers' => [
            'a' => '50%',
            'b' => '75%',
            'c' => '96%',
            'd' => '33%'
        ],
        'correct' => 'c',
        'explanation' => 'According to the lesson, 96% of unhappy customers don\'t complain directly to the business—they just leave. This highlights the importance of proactively seeking feedback.'
    ],
    [
        'question' => 'Which customer service mindset involves genuinely understanding and sharing the feelings of your customers?',
        'answers' => [
            'a' => 'Customer-Centric Thinking',
            'b' => 'Empathy',
            'c' => 'Ownership',
            'd' => 'Continuous Improvement'
        ],
        'correct' => 'b',
        'explanation' => 'Empathy involves genuinely understanding and sharing the feelings of your customers. It means putting yourself in their shoes to better address their needs.'
    ],
    [
        'question' => 'How many positive experiences does it take to make up for one negative experience?',
        'answers' => [
            'a' => '5',
            'b' => '8',
            'c' => '12',
            'd' => '3'
        ],
        'correct' => 'c',
        'explanation' => 'According to the lesson, it takes 12 positive experiences to make up for one negative experience. This demonstrates the significant impact that negative experiences can have on customer perception.'
    ]
];

// Include the quiz template
include_once($_SERVER['DOCUMENT_ROOT'] . '/app/templates/quiz_template.php');
?>
