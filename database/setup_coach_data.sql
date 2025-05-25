-- Create a sample coach user (password: coach123) if it doesn't exist
INSERT IGNORE INTO users (username, password, email, is_admin, is_coach) 
VALUES ('coach', '$2y$10$8K1p/a0dL1LXMIhuZ5Mw8.XZh.MwF1T5MCqwJ7mGBB6AAVt.pq3PC', 'coach@example.com', FALSE, TRUE);

-- Get the coach ID
SET @coach_id = (SELECT id FROM users WHERE username = 'coach' LIMIT 1);

-- Create some sample student users if they don't exist
INSERT IGNORE INTO users (username, password, email, is_admin, is_coach, coach_id) 
VALUES 
('student1', '$2y$10$8K1p/a0dL1LXMIhuZ5Mw8.XZh.MwF1T5MCqwJ7mGBB6AAVt.pq3PC', 'student1@example.com', FALSE, FALSE, @coach_id),
('student2', '$2y$10$8K1p/a0dL1LXMIhuZ5Mw8.XZh.MwF1T5MCqwJ7mGBB6AAVt.pq3PC', 'student2@example.com', FALSE, FALSE, @coach_id),
('student3', '$2y$10$8K1p/a0dL1LXMIhuZ5Mw8.XZh.MwF1T5MCqwJ7mGBB6AAVt.pq3PC', 'student3@example.com', FALSE, FALSE, @coach_id);

-- Add some sample progress data for the students
-- First, get the student IDs
SET @student1_id = (SELECT id FROM users WHERE username = 'student1' LIMIT 1);
SET @student2_id = (SELECT id FROM users WHERE username = 'student2' LIMIT 1);
SET @student3_id = (SELECT id FROM users WHERE username = 'student3' LIMIT 1);

-- Get a lesson ID to use for progress data
SET @lesson_id = (SELECT id FROM lessons LIMIT 1);

-- If we have a lesson, add some progress data
INSERT IGNORE INTO progress (user_id, lesson_id, chapter_id, completed, completed_at)
SELECT @student1_id, @lesson_id, 'chapter1', TRUE, NOW() - INTERVAL 3 DAY
WHERE @lesson_id IS NOT NULL;

INSERT IGNORE INTO progress (user_id, lesson_id, chapter_id, completed, completed_at)
SELECT @student1_id, @lesson_id, 'chapter2', TRUE, NOW() - INTERVAL 2 DAY
WHERE @lesson_id IS NOT NULL;

INSERT IGNORE INTO progress (user_id, lesson_id, chapter_id, completed, completed_at)
SELECT @student1_id, @lesson_id, 'chapter3', FALSE, NULL
WHERE @lesson_id IS NOT NULL;

INSERT IGNORE INTO progress (user_id, lesson_id, chapter_id, completed, completed_at)
SELECT @student2_id, @lesson_id, 'chapter1', TRUE, NOW() - INTERVAL 1 DAY
WHERE @lesson_id IS NOT NULL;

INSERT IGNORE INTO quiz_results (user_id, lesson_id, chapter_id, score)
SELECT @student1_id, @lesson_id, 'chapter1', 85
WHERE @lesson_id IS NOT NULL;

-- Create an index for faster coach-student lookups if it doesn't exist
CREATE INDEX IF NOT EXISTS idx_coach_id ON users(coach_id);
