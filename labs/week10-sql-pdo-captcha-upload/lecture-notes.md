# Week 10: SQL, MariaDB, PDO, CAPTCHA and Secure File Upload – lecture notes

### 10.1 Relational Concepts

A relational database stores data in tables of rows (records) and columns (attributes). A **primary key** uniquely identifies a row; a **foreign key** references another table and enforces referential integrity. **MariaDB** is the community fork of MySQL; it uses the InnoDB engine (transactions, row locks, foreign keys) and is the default open-source server on both distributions. Use `utf8mb4` for full Unicode (including Urdu and emoji).

| Normal form | Rule | Fix example |
| --- | --- | --- |
| 1NF | Atomic values, no repeating groups | Split “phone1, phone2” into a `phones` table |
| 2NF | No partial dependency on part of a composite key | Move product name out of `order_items` |
| 3NF | No transitive dependency (non-key → non-key) | Move city / province to a `cities` table |

### 10.2 DDL and DML

```
CREATE TABLE demo (id INT PRIMARY KEY AUTO_INCREMENT, title VARCHAR(50) NOT NULL);
ALTER TABLE demo ADD COLUMN created_at DATETIME DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE demo MODIFY title VARCHAR(100) NOT NULL;
DROP TABLE demo;

INSERT INTO categories (name) VALUES ('Toys');
UPDATE products SET price = price * 1.10 WHERE category_id = 2;
DELETE FROM products WHERE stock = 0;

SELECT c.name AS category, COUNT(*) AS items, ROUND(AVG(p.price),2) AS avg_price
FROM products p JOIN categories c ON c.id = p.category_id
GROUP BY c.id HAVING items > 1 ORDER BY avg_price DESC LIMIT 5;
```

Transactions group statements: `START TRANSACTION; … COMMIT;` or `ROLLBACK;` give the ACID guarantees (atomicity, consistency, isolation, durability). Never run application code as the database `root`; grant the application user only the privileges it needs.

### 10.3 PDO and SQL Injection

```
// VULNERABLE: input becomes part of the SQL text
$sql = "SELECT * FROM users WHERE email = '$email'";        // email = ' OR '1'='1  → returns every user

// SAFE: SQL and data travel separately
$st = db()->prepare('SELECT id, name FROM users WHERE email = :e');
$st->execute([':e' => $email]);
$user = $st->fetch();                                       // false when not found
```

> **Rule:** Prepared statements protect values, not identifiers. For dynamic column names or `ORDER BY` use an allow-list array.

### 10.4 CAPTCHA

A CAPTCHA distinguishes humans from bots, mainly on registration, login and contact forms. Always verify on the **server**; make the challenge single-use and time-limited.

| Solution | Open source? | Notes |
| --- | --- | --- |
| Image CAPTCHA (this lab) | Yes (own code, GD) | Weak against modern OCR; teaches the mechanism |
| Google reCAPTCHA v2/v3 | No (free service) | Syllabus topic; third-party tracking, needs keys |
| Cloudflare Turnstile | No (free service) | Privacy-focused, invisible challenge |
| hCaptcha | No (free tier) | Alternative to reCAPTCHA |
| ALTCHA | Yes (MIT) | Self-hosted proof-of-work, no tracking |

In production combine a CAPTCHA with rate limiting, e-mail confirmation and a honeypot field.

### 10.5 Secure File Uploads

- Check `$_FILES[..]["error"]` first, then size.
- Verify the real type with `finfo` / `getimagesize()`; never trust the client-supplied name or MIME type.
- Generate a random file name; never use the original name or extension.
- Store uploads **outside** the web root and serve them through a PHP script, or disable script execution in the upload folder.
- Limit sizes in `php.ini` (`upload_max_filesize`, `post_max_size`) and in the application.
