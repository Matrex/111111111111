-- database.sql - SQL file for database structure

-- Create game_settings table
CREATE TABLE IF NOT EXISTS game_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    win_chance INT NOT NULL DEFAULT 20,
    time_limit INT NOT NULL DEFAULT 60
);

-- Insert default game settings
INSERT INTO game_settings (win_chance, time_limit) VALUES (20, 60);

-- Create prizes table
CREATE TABLE IF NOT EXISTS prizes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    image_url VARCHAR(255) NOT NULL
);

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    is_admin BOOLEAN NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create wins table
CREATE TABLE IF NOT EXISTS wins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    prize_id INT NOT NULL,
    win_time DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (prize_id) REFERENCES prizes(id)
);

-- Insert a default admin user (password: admin123)
INSERT INTO users (username, password, email, is_admin) 
VALUES ('admin', '$2y$10$uXm82qpsjLCAXoYIWt4YbO18QtgcY9Aq6Xfb.PYp88I.0ksMo5i7m', 'admin@example.com', 1);
