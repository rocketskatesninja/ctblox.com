# CTBlox Lesson Template

This directory contains a template lesson structure that can be used as a starting point for creating new lessons in the CTBlox platform.

## Directory Structure

- `introduction.php` - The first chapter of the lesson, introducing the topic
- `chapter_structure.php` - Chapter explaining proper lesson structure
- `content_formatting.php` - Chapter covering content formatting best practices
- `quiz_implementation.php` - Chapter explaining how to implement quizzes
- `*_quiz.php` - Quiz files for each chapter (using the standardized quiz template)
- `images/` - Directory for lesson-specific images

## Creating a New Lesson

1. Copy this entire directory to create a new lesson
2. Rename the directory to match your lesson topic (use snake_case)
3. Update the content in each PHP file to match your lesson's content
4. Ensure each quiz file follows the standardized format
5. Add the lesson to the database via the admin interface

## File Naming Conventions

- Chapter files: `descriptive_name.php`
- Quiz files: `descriptive_name_quiz.php` (must match the chapter name)
- Image files: Use descriptive names and place in the `images/` directory

## Quiz Implementation

All quizzes use the standardized quiz template located at `/app/templates/quiz_template.php`. To create a new quiz:

1. Create a PHP file named `chapter_name_quiz.php`
2. Define the quiz data variables:
   - `$chapterId` - Must match the chapter ID
   - `$quizTitle` - The title of the quiz
   - `$questions` - Array of question data
3. Include the quiz template

Example:
```php
<?php
// Define quiz data
$chapterId = 'chapter_name';
$quizTitle = 'Chapter Name Quiz';
$questions = [
    [
        'question' => 'Question text?',
        'answers' => [
            'a' => 'Answer option A',
            'b' => 'Answer option B',
            'c' => 'Answer option C',
            'd' => 'Answer option D'
        ],
        'correctAnswer' => 'b',
        'explanation' => 'Explanation of the correct answer'
    ],
    // Add more questions...
];

// Include the quiz template
require_once __DIR__ . '/../../templates/quiz_template.php';
```

## Quiz Scoring and Answer Keys

### IMPORTANT: Quiz Scoring System

The quiz scoring system requires specific configuration in the `LessonController.php` file. When creating new quizzes, you must ensure the answer keys in the controller match your quiz questions exactly:

1. Each quiz must have a corresponding answer key in the `$quizAnswers` array in `LessonController.php`
2. The answer key must use the same `chapterId` as your quiz file
3. The number of questions in the answer key must match the number of questions in your quiz file
4. The question numbering must match (q1, q2, q3, etc.)

Example of adding an answer key to the controller:

```php
'your_chapter_id' => [
    'q1' => 'c',  // Answer to question 1
    'q2' => 'b',  // Answer to question 2
    'q3' => 'a'   // Answer to question 3
],
```

### Troubleshooting Quiz Scoring

If a quiz is failing despite selecting the correct answers, check for these common issues:

1. The `chapterId` in your quiz file doesn't match the key in the `$quizAnswers` array
2. The number of questions in the quiz file doesn't match the number in the answer key
3. The controller is using a default answer key that has a different number of questions
4. The correct answers in your quiz file don't match those in the controller

Always test your quizzes thoroughly before deploying a new lesson.

## HTML Structure

All chapter content should be wrapped in a `<div class="lesson-chapter">` element. Use consistent heading levels and spacing classes as shown in the template files.
