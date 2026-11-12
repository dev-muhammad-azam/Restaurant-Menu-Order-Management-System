CREATE DATABASE IF NOT EXISTS restaurant_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE restaurant_management;

SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS reservations;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS food_items;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS=1;

CREATE TABLE users (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100) NOT NULL,
 email VARCHAR(190) NOT NULL UNIQUE,
 phone VARCHAR(30) NULL,
 password VARCHAR(255) NOT NULL,
 role ENUM('admin','customer') NOT NULL DEFAULT 'customer',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE categories (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(80) NOT NULL UNIQUE,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE food_items (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 category_id INT UNSIGNED NULL,
 name VARCHAR(120) NOT NULL,
 description TEXT NULL,
 price DECIMAL(10,2) NOT NULL,
 image_url VARCHAR(500) NULL,
 is_available TINYINT(1) NOT NULL DEFAULT 1,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT fk_food_category FOREIGN KEY(category_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE orders (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 user_id INT UNSIGNED NOT NULL,
 total_amount DECIMAL(10,2) NOT NULL,
 delivery_address VARCHAR(500) NOT NULL,
 notes VARCHAR(500) NULL,
 status ENUM('Pending','Confirmed','Preparing','Ready','Delivered','Cancelled') NOT NULL DEFAULT 'Pending',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT fk_order_user FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE order_items (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 order_id INT UNSIGNED NOT NULL,
 food_id INT UNSIGNED NOT NULL,
 quantity INT UNSIGNED NOT NULL,
 unit_price DECIMAL(10,2) NOT NULL,
 CONSTRAINT fk_item_order FOREIGN KEY(order_id) REFERENCES orders(id) ON DELETE CASCADE,
 CONSTRAINT fk_item_food FOREIGN KEY(food_id) REFERENCES food_items(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE reservations (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 user_id INT UNSIGNED NULL,
 customer_name VARCHAR(100) NOT NULL,
 email VARCHAR(190) NOT NULL,
 phone VARCHAR(30) NOT NULL,
 reservation_date DATE NOT NULL,
 reservation_time TIME NOT NULL,
 guests TINYINT UNSIGNED NOT NULL,
 notes VARCHAR(500) NULL,
 status ENUM('Pending','Confirmed','Cancelled','Completed') NOT NULL DEFAULT 'Pending',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT fk_reservation_user FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

INSERT INTO categories(name) VALUES
('Burgers'),('Pizza'),('Pasta'),('Drinks'),('Desserts');

INSERT INTO food_items(category_id,name,description,price,image_url,is_available) VALUES
(1,'Classic Beef Burger','Juicy beef patty, lettuce, tomato and house sauce.',850,'🍔',1),
(1,'Crispy Chicken Burger','Crispy chicken fillet with fresh lettuce and mayo.',720,'🍗',1),
(2,'Margherita Pizza','Classic pizza with mozzarella, basil and tomato.',1250,'🍕',1),
(2,'Pepperoni Pizza','Mozzarella, pepperoni and rich tomato sauce.',1650,'🍕',1),
(3,'Creamy Alfredo Pasta','Pasta tossed in a creamy parmesan sauce.',980,'🍝',1),
(4,'Fresh Lemonade','Fresh lemon juice served chilled.',250,'🍋',1),
(5,'Chocolate Brownie','Warm chocolate brownie for dessert.',390,'🍫',1);

-- Demo admin account:
-- Email: admin@foodhub.test
-- Password: password
-- Change this password after first login.
INSERT INTO users(name,email,phone,password,role) VALUES
('FoodHub Admin','admin@foodhub.test','03001234567',
'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.',
'admin');
