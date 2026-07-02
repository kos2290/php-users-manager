CREATE DATABASE IF NOT EXISTS `users_manager_db`;
USE `users_manager_db`;

-- Single table for all users with role flag
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `first_name` VARCHAR(100) NOT NULL,
    `last_name` VARCHAR(100) NOT NULL,
    `gender` ENUM('male', 'female', 'other') NOT NULL,
    `birth_date` DATE NOT NULL,
    `is_admin` TINYINT(1) NOT NULL DEFAULT 0, -- 1 for Admin, 0 for Regular User
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed initial data
-- Default Administrator account (Credentials: admin / admin123)
INSERT INTO `users` (`username`, `password`, `first_name`, `last_name`, `gender`, `birth_date`, `is_admin`)
VALUES (
    'admin',
    '$2y$10$mN6EKGEF408cophfvgZCHumFM.mY5Eq2p7/9KtN67/MQG0XrrWRVu',
    'System',
    'Administrator',
    'other',
    '1985-01-01',
    1
)
ON DUPLICATE KEY UPDATE `id`=`id`;

-- Seed regular users for testing pagination and sorting
INSERT INTO `users` (`username`, `password`, `first_name`, `last_name`, `gender`, `birth_date`, `is_admin`) VALUES
('john_doe', '$2y$10$mN6EKGEF408cophfvgZCHumFM.mY5Eq2p7/9KtN67/MQG0XrrWRVu', 'John', 'Doe', 'male', '1990-05-15', 0),
('jane_smith', '$2y$10$mN6EKGEF408cophfvgZCHumFM.mY5Eq2p7/9KtN67/MQG0XrrWRVu', 'Jane', 'Smith', 'female', '1993-08-22', 0),
('alex_jones', '$2y$10$mN6EKGEF408cophfvgZCHumFM.mY5Eq2p7/9KtN67/MQG0XrrWRVu', 'Alex', 'Jones', 'other', '1988-11-02', 0),
('michael_b', '$2y$10$mN6EKGEF408cophfvgZCHumFM.mY5Eq2p7/9KtN67/MQG0XrrWRVu', 'Michael', 'Brown', 'male', '1995-01-30', 0),
('emily_w', '$2y$10$mN6EKGEF408cophfvgZCHumFM.mY5Eq2p7/9KtN67/MQG0XrrWRVu', 'Emily', 'Watson', 'female', '1992-04-12', 0)
ON DUPLICATE KEY UPDATE `id`=`id`;
