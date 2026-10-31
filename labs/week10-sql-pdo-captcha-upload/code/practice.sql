SELECT * FROM products WHERE price > 1000 ORDER BY price;
SELECT c.name, COUNT(*) n FROM products p JOIN categories c ON c.id = p.category_id GROUP BY c.id;
SELECT name FROM products WHERE stock < 20;
UPDATE products SET stock = stock - 1 WHERE id = 1;
SELECT category_id, SUM(price * stock) AS stock_value FROM products GROUP BY category_id;
SELECT p.name FROM products p LEFT JOIN order_items oi ON oi.product_id = p.id WHERE oi.order_id IS NULL;
START TRANSACTION; UPDATE products SET stock = 0 WHERE id = 2; ROLLBACK; SELECT stock FROM products WHERE id = 2;
EXPLAIN SELECT * FROM products WHERE category_id = 2;
