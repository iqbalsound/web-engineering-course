-- CT-10 SQL drill (run as the database administrator on the shop database)
-- 1) three most expensive products
SELECT name, price FROM products ORDER BY price DESC LIMIT 3;
-- 2) average price per category (at least two products), highest first
SELECT c.name, ROUND(AVG(p.price), 2) AS avg_price
FROM products p JOIN categories c ON c.id = p.category_id
GROUP BY c.id, c.name HAVING COUNT(*) >= 2 ORDER BY avg_price DESC;
-- 3) low stock
SELECT name, stock FROM products WHERE stock < 20;
-- 4) total stock value (312750.00 on the seed data)
SELECT SUM(price * stock) AS stock_value FROM products;
-- 5) new category and product
INSERT INTO categories (name) VALUES ('Toys');
INSERT INTO products (category_id, name, price, stock) VALUES (LAST_INSERT_ID(), 'Puzzle', 899.00, 15);
-- 6) products that were never ordered
SELECT p.name FROM products p LEFT JOIN order_items oi ON oi.product_id = p.id WHERE oi.order_id IS NULL;
