<?php
// Quiz for the "Company Overview" chapter

// Define quiz data
$chapterId = 'company_overview';
$quizTitle = 'Company Overview Quiz';
$questions = [
    [
        'question' => 'In what year was Corporate Tools founded?',
        'answers' => [
            'a' => '2005',
            'b' => '2010',
            'c' => '2015',
            'd' => '2020'
        ],
        'correctAnswer' => 'b',
        'explanation' => 'Corporate Tools was founded in 2010 with a focus on LLC and corporation formation services.'
    ],
    [
        'question' => 'What is the primary mission of Corporate Tools?',
        'answers' => [
            'a' => 'To provide tax preparation services',
            'b' => 'To offer legal representation in court',
            'c' => 'To empower entrepreneurs by simplifying business formation and compliance',
            'd' => 'To sell business software applications'
        ],
        'correctAnswer' => 'c',
        'explanation' => 'Our mission is to empower entrepreneurs and businesses by simplifying the complex processes of formation, compliance, and management.'
    ],
    [
        'question' => 'Which of the following is NOT one of Corporate Tools\' core values?',
        'answers' => [
            'a' => 'Expertise',
            'b' => 'Integrity',
            'c' => 'Innovation',
            'd' => 'Competitiveness'
        ],
        'correctAnswer' => 'd',
        'explanation' => 'Our core values are Expertise, Integrity, Innovation, and Client Focus. Competitiveness is not one of our stated core values.'
    ],
    [
        'question' => 'What significant milestone did Corporate Tools reach in 2020?',
        'answers' => [
            'a' => 'Celebrated 10 years of service and 40,000+ businesses formed',
            'b' => 'Launched their first website',
            'c' => 'Opened their first international office',
            'd' => 'Became publicly traded on the stock market'
        ],
        'correctAnswer' => 'a',
        'explanation' => 'In 2020, Corporate Tools celebrated 10 years of service and having helped form over 40,000 businesses.'
    ],
    [
        'question' => 'Which of the following is a key differentiator for Corporate Tools in the market?',
        'answers' => [
            'a' => 'Offering services only in select states',
            'b' => 'Focusing exclusively on large corporations',
            'c' => 'Technology-driven approach with proprietary platforms',
            'd' => 'Providing only basic formation services'
        ],
        'correctAnswer' => 'c',
        'explanation' => 'A technology-driven approach with proprietary platforms is one of our key market differentiators, streamlining processes and enhancing client experience.'
    ]
];

// Include the quiz template
require_once __DIR__ . '/../../templates/quiz_template.php';
