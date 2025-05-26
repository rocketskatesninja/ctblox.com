<?php
/**
 * Lesson Generator Script
 * 
 * This script helps create a new lesson based on the template.
 * Run from command line: php create_new_lesson.php "Lesson Name"
 */

// Check if lesson name was provided
if ($argc < 2) {
    echo "Usage: php create_new_lesson.php \"Lesson Name\"\n";
    exit(1);
}

// Get lesson name from command line argument
$lessonName = $argv[1];
$lessonDirName = strtolower(str_replace(' ', '_', $lessonName));

// Define paths
$templatePath = __DIR__ . '/app/lessons/lesson_template';
$newLessonPath = __DIR__ . '/app/lessons/' . $lessonDirName;

// Check if lesson directory already exists
if (is_dir($newLessonPath)) {
    echo "Error: Lesson directory already exists: $newLessonPath\n";
    exit(1);
}

// Create the new lesson directory
if (!mkdir($newLessonPath, 0755, true)) {
    echo "Error: Failed to create lesson directory: $newLessonPath\n";
    exit(1);
}

// Create images directory
mkdir($newLessonPath . '/images', 0755, true);

// Copy template files (excluding README and _template files)
$templateFiles = scandir($templatePath);
foreach ($templateFiles as $file) {
    // Skip directories and template files
    if ($file === '.' || $file === '..' || 
        $file === 'README.md' || 
        strpos($file, '_template') === 0 ||
        is_dir($templatePath . '/' . $file)) {
        continue;
    }
    
    // Read the template file
    $content = file_get_contents($templatePath . '/' . $file);
    
    // Replace "Template Lesson" with the new lesson name
    $content = str_replace('Template Lesson', $lessonName, $content);
    
    // Write to the new file
    file_put_contents($newLessonPath . '/' . $file, $content);
    echo "Created: $file\n";
}

// Copy placeholder image
copy($templatePath . '/images/placeholder.html', $newLessonPath . '/images/placeholder.html');
echo "Created: images/placeholder.html\n";

echo "\nLesson created successfully at: $newLessonPath\n";
echo "Next steps:\n";
echo "1. Edit the PHP files to update the lesson content\n";
echo "2. Add the lesson to the database via the admin interface\n";
echo "3. Test the lesson to ensure all quizzes work correctly\n";
?>
