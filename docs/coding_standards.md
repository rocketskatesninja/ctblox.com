# CTBlox Coding Standards

This document outlines the coding standards for the CTBlox application to ensure consistency and maintainability across the codebase.

## PHP Coding Standards

### File Structure
- Files should use the `.php` extension
- PHP opening tags should be `<?php` (full tag)
- Files containing only PHP code should not have a closing `?>` tag
- Each file should contain a single class, interface, or trait
- File names should match the class name (e.g., `User.php` for the `User` class)

### Namespaces and Class Names
- Class names should use PascalCase (e.g., `UserController`, `DatabaseRepository`)
- Interface names should use PascalCase and end with "Interface" (e.g., `RepositoryInterface`)
- Trait names should use PascalCase and end with "Trait" (e.g., `LoggableTrait`)

### Method Naming Conventions
- Method names should use camelCase (e.g., `getUserById`, `saveSettings`)
- Method names should start with a verb that indicates the action being performed:
  - `get` - Retrieves data (e.g., `getUser`, `getAllLessons`)
  - `set` - Sets a value (e.g., `setUsername`, `setConfig`)
  - `create` - Creates a new resource (e.g., `createUser`, `createLesson`)
  - `update` - Updates an existing resource (e.g., `updateProfile`, `updateSettings`)
  - `delete` - Deletes a resource (e.g., `deleteUser`, `deleteLesson`)
  - `is` - Boolean check that returns true/false (e.g., `isAdmin`, `isLoggedIn`)
  - `has` - Boolean check for existence (e.g., `hasPermission`, `hasCompletedLesson`)
  - `can` - Boolean check for capability (e.g., `canAccessDashboard`, `canEditLesson`)
- Controller action methods should use descriptive names (e.g., `dashboard`, `viewLesson`, `updateProfile`)

### Variable Naming
- Variable names should use camelCase (e.g., `$userName`, `$lessonId`)
- Variable names should be descriptive and indicate their purpose
- Boolean variables should use prefixes like `is`, `has`, or `can` (e.g., `$isAdmin`, `$hasAccess`)

### Constants
- Constants should use UPPER_SNAKE_CASE (e.g., `APP_NAME`, `MAX_UPLOAD_SIZE`)
- Constants should be defined at the top of the file or in a centralized configuration file

### Comments and Documentation
- Classes and methods should include PHPDoc comments
- Complex code sections should include inline comments explaining the logic
- TODO, FIXME, and other action items should be clearly marked and include a description

### Error Handling
- Use try/catch blocks for error handling
- Log errors using the centralized ErrorHandler class
- Return meaningful error messages to users

## Database Standards

### Table Naming
- Table names should use snake_case and be plural (e.g., `users`, `lessons`)
- Junction tables should combine the names of the related tables (e.g., `user_lessons`)

### Column Naming
- Column names should use snake_case (e.g., `user_id`, `created_at`)
- Primary keys should be named `id`
- Foreign keys should be named `{table_singular}_id` (e.g., `user_id`, `lesson_id`)
- Boolean columns should use prefixes like `is_` or `has_` (e.g., `is_admin`, `has_verified_email`)
- Timestamp columns should use `created_at`, `updated_at`, and `deleted_at`

## JavaScript Coding Standards

### Variable and Function Naming
- Variable and function names should use camelCase (e.g., `userName`, `calculateTotal`)
- Constants should use UPPER_SNAKE_CASE (e.g., `MAX_ATTEMPTS`, `API_URL`)
- Class names should use PascalCase (e.g., `UserProfile`, `LessonManager`)

### Event Handlers
- Event handler functions should be prefixed with `handle` or `on` (e.g., `handleClick`, `onSubmit`)

## CSS/SCSS Coding Standards

### Class Naming
- CSS classes should use kebab-case (e.g., `header-container`, `nav-item`)
- Use BEM (Block Element Modifier) methodology for complex components

## Version Control Standards

### Commit Messages
- Commit messages should be clear and descriptive
- Use present tense ("Add feature" not "Added feature")
- Reference issue numbers when applicable

### Branching
- Use feature branches for new features
- Use hotfix branches for urgent fixes
- Merge through pull requests after code review
