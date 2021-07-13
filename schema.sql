CREATE DATABASE yeti_cave
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE yeti_cave;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reg_date DATETIME,
    email VARCHAR(50) UNIQUE,
    name VARCHAR(20),
    password VARCHAR(64),
    avatar VARCHAR(255),
    address VARCHAR(100)
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title CHAR(20)
);

CREATE TABLE bids (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATETIME,
    amount INT,
    user_id INT,
    lot_id INT
);

CREATE TABLE lots (
    id INT AUTO_INCREMENT PRIMARY KEY,
    create_date DATETIME,
    end_date DATETIME,
    title CHAR(255),
    description TEXT,
    img CHAR(255),
    start_price INT,
    current_price INT,
    price_step INT,
    is_closed BIT,
    author_id INT,
    winner_id INT,
    category_id INT
);

CREATE FULLTEXT INDEX lots_ft_search ON lots(title, description);