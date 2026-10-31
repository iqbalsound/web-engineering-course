CREATE TABLE users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(80) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  avatar VARCHAR(64) NULL,
  role ENUM('customer','admin') NOT NULL DEFAULT 'customer',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
CREATE TABLE categories (
  id TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(60) NOT NULL UNIQUE
) ENGINE=InnoDB;
CREATE TABLE products (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  category_id TINYINT UNSIGNED NOT NULL,
  name VARCHAR(120) NOT NULL,
  description TEXT NULL,
  price DECIMAL(10,2) NOT NULL CHECK (price >= 0),
  stock INT UNSIGNED NOT NULL DEFAULT 0,
  image VARCHAR(64) NULL,
  CONSTRAINT fk_prod_cat FOREIGN KEY (category_id) REFERENCES categories(id),
  INDEX idx_prod_cat (category_id)
) ENGINE=InnoDB;
CREATE TABLE orders (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  total DECIMAL(10,2) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_ord_user FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB;
CREATE TABLE order_items (
  order_id INT UNSIGNED NOT NULL,
  product_id INT UNSIGNED NOT NULL,
  qty INT UNSIGNED NOT NULL,
  unit_price DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (order_id, product_id),
  CONSTRAINT fk_oi_order FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  CONSTRAINT fk_oi_prod FOREIGN KEY (product_id) REFERENCES products(id)
) ENGINE=InnoDB;
INSERT INTO categories (name) VALUES ('Electronics'),('Books'),('Clothing'),('Stationery');
INSERT INTO products (category_id,name,description,price,stock) VALUES
 (1,'USB-C Cable','1 m braided cable',650.00,50),(1,'Wireless Mouse','2.4 GHz optical',1850.00,25),
 (1,'Power Bank 10000','Dual USB output',4200.00,15),(2,'PHP and MySQL Guide','Dynamic sites',3200.00,10),
 (2,'Learning Web Design','HTML, CSS, JS',2800.00,12),(3,'Hamdard T-Shirt','Cotton, size M',1200.00,40),
 (4,'A4 Notebook','200 pages',350.00,100),(4,'Gel Pen Pack','Pack of 10',280.00,80);
