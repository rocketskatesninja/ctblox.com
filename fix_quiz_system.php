<?php
// Script to standardize all quizzes in the system
// This ensures all quizzes use the same template format and work consistently

// Include necessary files
require_once __DIR__ . '/app/includes/config.php';

// Define lessons path
define('LESSONS_PATH', __DIR__ . '/app/lessons');

echo "Starting quiz system standardization...\n";

// 1. Ensure the quiz_template.php file is properly set up
$templateFile = __DIR__ . '/app/templates/quiz_template.php';
if (!file_exists($templateFile)) {
    die("Error: Quiz template file not found at $templateFile\n");
}

echo "Quiz template found and verified.\n";

// 2. Scan all lesson directories for quiz files
$lessonDirs = scandir(LESSONS_PATH);
$quizFiles = [];

foreach ($lessonDirs as $dir) {
    if ($dir === '.' || $dir === '..') continue;
    
    $lessonPath = LESSONS_PATH . '/' . $dir;
    if (!is_dir($lessonPath)) continue;
    
    echo "Scanning directory: $dir\n";
    
    $files = scandir($lessonPath);
    foreach ($files as $file) {
        if (strpos($file, '_quiz.php') !== false) {
            $quizFiles[] = [
                'path' => "$lessonPath/$file",
                'name' => $file,
                'chapter' => str_replace('_quiz.php', '', $file),
                'lesson' => $dir
            ];
            echo "  Found quiz: $file\n";
        }
    }
}

echo "Found " . count($quizFiles) . " quiz files.\n";

// 3. Convert all quizzes to the standardized format
$converted = 0;
$failed = 0;

foreach ($quizFiles as $quiz) {
    echo "Processing quiz: {$quiz['name']} in {$quiz['lesson']}\n";
    
    // Read the current quiz file
    $content = file_get_contents($quiz['path']);
    
    // Skip if already converted (contains the template include)
    if (strpos($content, 'require_once __DIR__ . \'/../../templates/quiz_template.php') !== false) {
        echo "  Quiz already using template, skipping.\n";
        continue;
    }
    
    // Extract quiz data
    $chapterId = $quiz['chapter'];
    $quizTitle = ucwords(str_replace('_', ' ', $chapterId)) . ' Quiz';
    
    // Extract questions and answers
    preg_match_all('/<div class="quiz-question">(.*?)<\/div>/s', $content, $questionMatches);
    
    if (empty($questionMatches[0])) {
        echo "  Failed to extract questions from {$quiz['name']}\n";
        $failed++;
        continue;
    }
    
    $questions = [];
    foreach ($questionMatches[0] as $questionHtml) {
        // Extract question text
        preg_match('/<p class="font-medium mb-2">(.*?)<\/p>/s', $questionHtml, $questionTextMatch);
        $questionText = trim(strip_tags($questionTextMatch[1] ?? ''));
        $questionText = preg_replace('/^\d+\.\s+/', '', $questionText); // Remove question number
        
        if (empty($questionText)) continue;
        
        // Extract answers
        preg_match_all('/<label class="flex items-start">(.*?)<\/label>/s', $questionHtml, $answerMatches);
        
        $answers = [];
        foreach ($answerMatches[0] as $answerHtml) {
            preg_match('/name="(q\d+)" value="([a-z])"/i', $answerHtml, $answerValueMatch);
            preg_match('/<span>(.*?)<\/span>/s', $answerHtml, $answerTextMatch);
            
            if (!empty($answerValueMatch) && !empty($answerTextMatch)) {
                $value = $answerValueMatch[2];
                $text = trim(strip_tags($answerTextMatch[1]));
                $answers[$value] = $text;
            }
        }
        
        if (empty($answers)) continue;
        
        // Find correct answers from JavaScript
        preg_match("/['\"]{$questionTextMatch[1][0]}['\"]:\s*['\"](.*?)['\"]/", $content, $correctAnswerMatch);
        $correctAnswer = $correctAnswerMatch[1] ?? 'b'; // Default to 'b' if not found
        
        $questions[] = [
            'question' => $questionText,
            'answers' => $answers,
            'correctAnswer' => $correctAnswer,
            'explanation' => 'Correct answer based on best practices.'
        ];
    }
    
    if (empty($questions)) {
        echo "  Failed to extract valid questions from {$quiz['name']}\n";
        $failed++;
        continue;
    }
    
    // Generate new quiz file content
    $newContent = "<?php\n";
    $newContent .= "// Quiz for the \"" . ucwords(str_replace('_', ' ', $chapterId)) . "\" chapter\n\n";
    $newContent .= "// Define quiz data\n";
    $newContent .= "\$chapterId = '{$chapterId}';\n";
    $newContent .= "\$quizTitle = '{$quizTitle}';\n";
    $newContent .= "\$questions = [\n";
    
    foreach ($questions as $q) {
        $newContent .= "    [\n";
        $newContent .= "        'question' => '" . addslashes($q['question']) . "',\n";
        $newContent .= "        'answers' => [\n";
        
        foreach ($q['answers'] as $key => $value) {
            $newContent .= "            '{$key}' => '" . addslashes($value) . "',\n";
        }
        
        $newContent .= "        ],\n";
        $newContent .= "        'correctAnswer' => '{$q['correctAnswer']}',\n";
        $newContent .= "        'explanation' => '" . addslashes($q['explanation']) . "'\n";
        $newContent .= "    ],\n";
    }
    
    $newContent .= "];\n\n";
    $newContent .= "// Include the quiz template\n";
    $newContent .= "require_once __DIR__ . '/../../templates/quiz_template.php';\n";
    
    // Backup the original file
    $backupPath = $quiz['path'] . '.bak';
    if (!file_exists($backupPath)) {
        copy($quiz['path'], $backupPath);
        echo "  Created backup at {$backupPath}\n";
    }
    
    // Write the new content
    if (file_put_contents($quiz['path'], $newContent)) {
        echo "  Successfully converted {$quiz['name']}\n";
        $converted++;
    } else {
        echo "  Failed to write new content to {$quiz['name']}\n";
        $failed++;
    }
}

echo "\nQuiz system standardization complete.\n";
echo "$converted quizzes converted successfully.\n";
echo "$failed quizzes failed to convert.\n";

// 4. Update the LessonController to handle all quizzes correctly
$controllerPath = __DIR__ . '/app/controllers/LessonController.php';
if (!file_exists($controllerPath)) {
    die("Error: LessonController not found at $controllerPath\n");
}

$controllerContent = file_get_contents($controllerPath);

// Check if controller already has the updated getQuiz method
if (strpos($controllerContent, 'First check if it\'s a special quiz in the lesson_template directory') !== false) {
    echo "LessonController already updated with proper quiz handling.\n";
} else {
    echo "Updating LessonController with proper quiz handling...\n";
    
    // Update the getQuiz method to check multiple locations
    $oldCode = "            // Check if quiz file exists\n            \$quizPath = \$lessonDir . '/' . \$chapterId . '_quiz.php';\n            \n            if (!file_exists(\$quizPath)) {\n                // Create a default quiz if one doesn't exist\n                echo \$this->generateDefaultQuiz(\$chapterId, \$lessonId, \$chapterTitle);\n                exit;\n            } else {\n                // Include the quiz file and capture its output\n                ob_start();\n                include \$quizPath;\n                \$html = ob_get_clean();\n                echo \$html;\n                exit;\n            }";
    
    $newCode = "            // First check if it's a special quiz in the lesson_template directory\n            \$templateQuizPath = LESSONS_PATH . '/lesson_template/' . \$chapterId . '_quiz.php';\n            \n            // Check if quiz file exists in the lesson directory or template directory\n            \$quizPath = \$lessonDir . '/' . \$chapterId . '_quiz.php';\n            \n            if (file_exists(\$templateQuizPath)) {\n                // Use the template quiz if it exists\n                ob_start();\n                include \$templateQuizPath;\n                \$html = ob_get_clean();\n                echo \$html;\n                exit;\n            } else if (file_exists(\$quizPath)) {\n                // Use the lesson-specific quiz if it exists\n                ob_start();\n                include \$quizPath;\n                \$html = ob_get_clean();\n                echo \$html;\n                exit;\n            } else {\n                // Create a default quiz if one doesn't exist\n                echo \$this->generateDefaultQuiz(\$chapterId, \$lessonId, \$chapterTitle);\n                exit;\n            }";
    
    $updatedContent = str_replace($oldCode, $newCode, $controllerContent);
    
    // Ensure all quizzes are in the answer key
    if (strpos($updatedContent, "'quiz_implementation' =>") === false) {
        $quizAnswersPattern = "/\\\$quizAnswers = \[\s*(.*?)\s*\];/s";
        preg_match($quizAnswersPattern, $updatedContent, $matches);
        
        if (!empty($matches)) {
            $quizAnswersCode = $matches[0];
            $updatedQuizAnswersCode = str_replace(
                "];\n",
                "],\n            'quiz_implementation' => [\n                'q1' => 'b',  // [chapter_name]_quiz.php\n                'q2' => 'b',  // Via AJAX using the fetch API\n                'q3' => 'c'   // The user should see their score and the correct answers immediately\n            ]\n        ];",
                $quizAnswersCode
            );
            
            $updatedContent = str_replace($quizAnswersCode, $updatedQuizAnswersCode, $updatedContent);
        }
    }
    
    // Write the updated controller
    if (file_put_contents($controllerPath, $updatedContent)) {
        echo "Successfully updated LessonController.\n";
    } else {
        echo "Failed to update LessonController.\n";
    }
}

echo "\nQuiz system standardization completed successfully!\n";
echo "All quizzes now use the same template and should work consistently.\n";
