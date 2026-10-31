INSERT INTO products (category_id, name, price, stock)
SELECT 1 + (seq % 4), CONCAT('Item ', seq), 100 + (seq % 900), seq % 50 FROM seq_1_to_5000;
EXPLAIN SELECT id, name FROM products WHERE name LIKE 'Item 12%';
CREATE INDEX idx_prod_name ON products (name);
EXPLAIN SELECT id, name FROM products WHERE name LIKE 'Item 12%';
