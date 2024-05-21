CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL
);
CREATE TABLE content (
    content_id INT AUTO_INCREMENT PRIMARY KEY,
    url VARCHAR(255) NOT NULL,
    type ENUM('photo', 'video') NOT NULL,
    tags JSON NOT NULL
);
CREATE TABLE view_history (
    view_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    content_id INT,
    watch_time INT, -- Tiempo visto en segundos (0 para fotos)
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (content_id) REFERENCES content(content_id)
);
