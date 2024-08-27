SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS products (
  id INT(11) NOT NULL AUTO_INCREMENT,
  sku VARCHAR(50) NOT NULL,
  name VARCHAR(100) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  description TEXT DEFAULT NULL,
  type ENUM('DVD','Furniture','Book') NOT NULL,
  size INT(11) DEFAULT NULL,
  height INT(11) DEFAULT NULL,
  width INT(11) DEFAULT NULL,
  length INT(11) DEFAULT NULL,
  weight DECIMAL(10,2) DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY sku (sku)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO products (sku, name, price, type, size, height, width, length, weight, description) VALUES
('DVD001', 'The Greatest Showman', 19.99, 'DVD', NULL, NULL, NULL, NULL, NULL, 'A musical film starring Hugh Jackman.'),
('DVD002', 'Inception', 14.99, 'DVD', NULL, NULL, NULL, NULL, NULL, 'A science fiction film directed by Christopher Nolan.'),
('FURN001', 'Wooden Dining Chair', 89.99, 'Furniture', NULL, 90, 45, 45, 5.5, 'A sturdy wooden dining chair with a classic design.'),
('DVD003', 'The Matrix', 12.99, 'DVD', NULL, NULL, NULL, NULL, NULL, 'A groundbreaking science fiction film from the Wachowskis.');

COMMIT;
