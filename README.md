# CTBlox Training Platform

A comprehensive training platform for Corporate Tools, designed to provide structured learning experiences for employees and clients.

## Features

- **User Management**: Admin, coach, and student role-based access
- **Lesson Management**: Create, update, and manage interactive lessons
- **Progress Tracking**: Monitor student progress through lessons and chapters
- **Quiz System**: Interactive quizzes with automatic scoring
- **Dark Mode Support**: Full dark mode compatibility throughout the platform
- **Responsive Design**: Works on desktop and mobile devices

## Technical Stack

- PHP backend with MVC architecture
- MariaDB database
- Tailwind CSS for styling
- Alpine.js for interactive components
- Vanilla JavaScript for functionality

## Installation

1. Clone the repository
2. Set up a web server (Apache/Nginx) with PHP support
3. Create a MySQL/MariaDB database
4. Import the database schema from `database/schema.sql`
5. Configure database connection in `config/config.php`
6. Point your web server to the project directory

## Lesson Structure

Lessons are stored in the `app/lessons` directory, with each lesson having its own subdirectory. The system automatically scans for new lessons and registers them in the database.

Each lesson directory should contain:
- `introduction.php` - Introduction to the lesson
- Chapter files (e.g., `chapter_name.php`)
- Quiz files for each chapter (e.g., `chapter_name_quiz.php`)

## License

Proprietary - Corporate Tools LLC
