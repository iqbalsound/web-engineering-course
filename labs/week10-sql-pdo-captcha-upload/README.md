# Week 10: SQL, MariaDB, PDO, CAPTCHA and Secure File Upload

| Syllabus lectures | CLO | PLO | Bloom | Assessment |
| --- | --- | --- | --- | --- |
| Lec 19–20 | CLO_3 | PLO_4 | C4 (Analyzing) | — |

## Lab: MariaDB Schema, PDO Connection, CAPTCHA Registration and Avatar Upload

Install and secure MariaDB, create the `shop` schema, practise SQL, then build `register.php` with an image CAPTCHA, password hashing, validation and a safe avatar upload served by a PHP script.

### Free and open-source tools
- MariaDB Server 10.11 / 11.8 (GPL-2.0)
- PHP PDO + GD
- DBeaver Community (Apache-2.0) as GUI client
- SELinux tools (Rocky) / ls, chgrp (Kubuntu)

### Deliverables
- Database `shop` with 5 tables and sample data; SQL practice file with 8 queries
- Working `register.php` with CAPTCHA, validation, hashing and avatar
- Avatar stored outside web root and served by `avatar.php`
- Proof that SQL injection fails (screenshot or curl output)

### Contents of this folder
- [`lecture-notes.md`](lecture-notes.md) – the week's theory
- [`rocky10.md`](rocky10.md) – step-by-step lab, **Version A (Rocky Linux 10)**
- [`kubuntu2604.md`](kubuntu2604.md) – step-by-step lab, **Version B (Kubuntu 26.04 LTS)**
- `code/.htaccess`
- `code/config/db.php`
- `code/practice.sql`
- `code/public/avatar.php`
- `code/public/captcha.php`
- `code/public/register.php`
- `code/schema.sql`
- `code/src/db.php`
- `code/storage/avatars/.gitkeep`

`code/` holds the reference source files exactly as printed in the lab manual (they are the files the labs ask you to create).
Code is PHP 8.3 compatible and runs under `/var/www/webeng/week10` (see the OS steps).

### Verification checklist
| # | Check | Expected Result |
| --- | --- | --- |
| 1 | `SELECT COUNT(*) FROM products;` | 8 |
| 2 | Register with wrong CAPTCHA | Error “CAPTCHA is incorrect.” and no row inserted |
| 3 | Register twice with the same e-mail | Error “E-mail is already registered.” (SQLSTATE 23000) |
| 4 | Stored password | `password_hash` begins with `$2y$` or `$argon2id$`, never plain text |
| 5 | Upload a `.php` file renamed `.png` | Rejected by `finfo` / `getimagesize` |
| 6 | `curl .../config/db.php` | 404; `avatar.php?id=1 OR 1=1` returns 404, not data |
| 7 | Rocky: avatar upload after relabel | Saved in `storage/avatars` with type `httpd_sys_rw_content_t` |

### Stretch goals
- Add a 60-second CAPTCHA expiry and a limit of 5 attempts per IP using a database table.
- Integrate the self-hosted ALTCHA widget in place of the image CAPTCHA.
- Add `ALTER TABLE users ADD COLUMN email_verified_at DATETIME NULL` and write a migration script.


### Review questions
1. Normalise a table `orders(order_id, customer_name, customer_city, product_name, qty)` to 3NF.
2. Why does a prepared statement stop `' OR '1'='1`?
3. Why is the application database user not `root`?
4. List four checks performed before accepting an uploaded image.
5. Compare an image CAPTCHA with reCAPTCHA in terms of security, privacy and accessibility.

---
Instructor solutions: [`instructor/solutions/week10-sql-pdo-captcha-upload.md`](../../instructor/solutions/week10-sql-pdo-captcha-upload.md)
