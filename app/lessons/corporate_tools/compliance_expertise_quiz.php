<?php
// Quiz for the "Compliance Expertise" chapter

// Define quiz data
$chapterId = 'compliance_expertise';
$quizTitle = 'Compliance Expertise Quiz';
$questions = [
    [
        'question' => 'What is the first pillar of Corporate Tools\' Five-Pillar Compliance Framework?',
        'answers' => [
            'a' => 'Execution',
            'b' => 'Planning',
            'c' => 'Assessment',
            'd' => 'Monitoring'
        ],
        'correctAnswer' => 'c',
        'explanation' => 'Assessment is the first pillar of our compliance framework, involving a comprehensive evaluation of compliance needs based on entity type, location, and industry.'
    ],
    [
        'question' => 'Which of the following is a common compliance challenge for businesses with operations in multiple states?',
        'answers' => [
            'a' => 'Managing different requirements across multiple states',
            'b' => 'Finding office space in each state',
            'c' => 'Hiring employees who speak different languages',
            'd' => 'Designing different logos for each state'
        ],
        'correctAnswer' => 'a',
        'explanation' => 'Managing different requirements across multiple states is a common compliance challenge for businesses with multi-state operations.'
    ],
    [
        'question' => 'What type of compliance requirement is typically associated with corporations but not LLCs?',
        'answers' => [
            'a' => 'Annual reports',
            'b' => 'Tax filings',
            'c' => 'Board meetings and corporate minutes',
            'd' => 'Business licenses'
        ],
        'correctAnswer' => 'c',
        'explanation' => 'Board meetings and corporate minutes are typically required for corporations but not for LLCs, which have more flexible governance requirements.'
    ],
    [
        'question' => 'How does Corporate Tools help clients adapt to regulatory changes?',
        'answers' => [
            'a' => 'By ignoring minor regulatory changes',
            'b' => 'Through proactive monitoring systems and regular compliance updates with impact assessments',
            'c' => 'By lobbying against new regulations',
            'd' => 'By recommending clients relocate to states with fewer regulations'
        ],
        'correctAnswer' => 'b',
        'explanation' => 'Corporate Tools helps clients adapt to regulatory changes through proactive monitoring systems and regular compliance updates with impact assessments.'
    ],
    [
        'question' => 'Which of the following is NOT one of the compliance resources provided by Corporate Tools?',
        'answers' => [
            'a' => 'Knowledge Base',
            'b' => 'Webinars',
            'c' => 'Templates',
            'd' => 'Legal representation in court'
        ],
        'correctAnswer' => 'd',
        'explanation' => 'While Corporate Tools provides Knowledge Base articles, Webinars, and Templates as compliance resources, we do not provide legal representation in court.'
    ]
];

// Include the quiz template
require_once __DIR__ . '/../../templates/quiz_template.php';
