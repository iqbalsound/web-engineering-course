-- (a)
SELECT p.name, c.name AS category FROM products p JOIN categories c ON c.id = p.category_id
WHERE p.price > 1000 ORDER BY p.price DESC;
-- (b)  (on the seed data: Electronics 1, Books 2)
SELECT c.name, COUNT(*) AS low_stock FROM products p JOIN categories c ON c.id = p.category_id
WHERE p.stock < 20 GROUP BY c.id, c.name HAVING COUNT(*) >= 1;
-- (c)
ALTER TABLE products ADD COLUMN sku VARCHAR(20) UNIQUE;
UPDATE products p JOIN categories c ON c.id = p.category_id SET p.price = p.price * 1.10 WHERE c.name = 'Stationery';
