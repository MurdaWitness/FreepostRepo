USE freepost;

-- Добавление пользователей
INSERT INTO `users` (`username`, `email`, `password`, `role`) VALUES
('admin', 'admin@example.com', 'password1', 'admin'),
('user1', 'user1@example.com', 'password2', 'user'),
('user2', 'user2@example.com', 'password3', 'user');

-- Добавление модулей
INSERT INTO `modules` (`name`, `brief_description`, `description`, `downloads_count`, `status`, `user_id`) VALUES
('VK', 'VK module', 'Module for interacting with VK API', 1000, 'depends', 1),
('Twitter', 'Twitter module', 'Module for interacting with Twitter API', 200, 'not depends', 2),
('Telegram', 'Telegram module', 'Module for interacting with Telegram API', 500, 'unchecked', 1);

-- Добавление файлов
INSERT INTO `files` (`module_id`, `file_name`, `file_path`) VALUES
(1, 'module.py', 'C:/xampp/htdocs/storage/1/module.py'),
(1, 'validate.py', 'C:/xampp/htdocs/storage/1/validate.py'),
(1, 'config.py', 'C:/xampp/htdocs/storage/1/config.py'),
(2, 'module.py', 'C:/xampp/htdocs/storage/2/module.py'),
(2, 'validate.py', 'C:/xampp/htdocs/storage/2/validate.py'),
(3, 'module.py', 'C:/xampp/htdocs/storage/3/module.py'),
(3, 'validate.py', 'C:/xampp/htdocs/storage/3/validate.py'),
(3, 'bot.py', 'C:/xampp/htdocs/storage/3/bot.py');
