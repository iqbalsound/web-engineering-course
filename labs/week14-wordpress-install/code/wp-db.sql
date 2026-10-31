# Database (run once, as database administrator)
CREATE DATABASE wp_site CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'wp_user'@'localhost' IDENTIFIED BY 'ChangeMe_2026!';
GRANT ALL PRIVILEGES ON wp_site.* TO 'wp_user'@'localhost';
