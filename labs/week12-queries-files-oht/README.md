# Week 12: Queries, Result Handling, File Handling and Hourly Test

| Syllabus lectures | CLO | PLO | Bloom | Assessment |
| --- | --- | --- | --- | --- |
| Lec 23–24 | CLO_3 | PLO_4 | C4 (Analyzing) | A3 due; OHT (CLO_2, 10 marks) |

## Lab: Product Search, CSV Import/Export and Thumbnail Generation

Generate 5,000 products, build a searchable paginated listing, tune it with an index, export products as CSV, import CSV transactionally and create WebP thumbnails.

### Free and open-source tools
- MariaDB `seq` tables, `EXPLAIN`
- PHP `SplFileObject`, GD
- PHPStan
- curl, `head`, `wc`

### Deliverables
- `search.php`, `export.php`, `import.php`, `src/images.php` under `/var/www/webeng/week12`
- EXPLAIN output before and after the index (copied into a text file)
- Imported products from a sample CSV with one bad line that rolls the whole import back

### Contents of this folder
- [`lecture-notes.md`](lecture-notes.md) – the week's theory
- [`rocky10.md`](rocky10.md) – step-by-step lab, **Version A (Rocky Linux 10)**
- [`kubuntu2604.md`](kubuntu2604.md) – step-by-step lab, **Version B (Kubuntu 26.04 LTS)**
- `code/.htaccess`
- `code/bin/thumbs.php`
- `code/config/db.php`
- `code/practice.sql`
- `code/public/avatar.php`
- `code/public/captcha.php`
- `code/public/cart.php`
- `code/public/checkout.php`
- `code/public/export.php`
- `code/public/import.php`
- `code/public/login.php`
- `code/public/logout.php`
- `code/public/products.php`
- `code/public/register.php`
- `code/public/search.php`
- `code/sample-import.csv`
- `code/schema.sql`
- `code/sql/seed-and-explain.sql`
- `code/src/bootstrap.php`
- `code/src/db.php`
- `code/src/images.php`
- `code/storage/.gitkeep`
- `code/storage/avatars/.gitkeep`
- `code/storage/thumbs/.gitkeep`

`code/` holds the reference source files exactly as printed in the lab manual (they are the files the labs ask you to create).
Code is PHP 8.3 compatible and runs under `/var/www/webeng/week12` (see the OS steps).

### Verification checklist
| # | Check | Expected Result |
| --- | --- | --- |
| 1 | First EXPLAIN (no index) | `type = ALL`, rows ≈ 5,000 |
| 2 | EXPLAIN after index (prefix LIKE) | `type = range`, `key = idx_prod_name`, far fewer rows |
| 3 | EXPLAIN with `%12%` | Index not usable (`ALL`): explain why in your notes |
| 4 | Search `q=Item 12` | Result count and pagination links preserve the query |
| 5 | Import with invalid line | “Import cancelled; nothing saved.” and product count unchanged |
| 6 | Import valid file | 2 products imported; export contains them |
| 7 | Thumbnails | WebP files ≤ 200 px created in `storage/thumbs` |

### Stretch goals
- Implement keyset pagination and compare page 400 timings.
- Stream a 100,000-row export using unbuffered queries (`PDO::MYSQL_ATTR_USE_BUFFERED_QUERY`).
- Add a unit test for `makeThumb()` with PHPUnit.

### Additional work
#### Hourly Test (OHT) – Blueprint and Sample Questions

| Q | Topic (CLO_2) | Marks | Type |
| --- | --- | --- | --- |
| 1 | PHP syntax: arrays, loops, `match` | 2 | Write code |
| 2 | SQL: DDL + SELECT with JOIN and GROUP BY | 3 | Write queries |
| 3 | PDO: prepared statement, login check, error handling | 3 | Complete code |
| 4 | Sessions, CSRF, upload validation | 2 | Short answers |

1. Given `$marks = ["Ali" => [70, 80], "Sara" => [90, 85]]`, print each student’s average and the name of the top student.
2. Write SQL to list category names with the number of products priced above 1000, only categories with more than one such product.
3. Complete the PHP fragment that checks a login with PDO and `password_verify`, regenerating the session ID on success.
4. List three checks for an uploaded image and one reason a CSRF token is needed on the logout form.

### Review questions
1. Why does `LIKE '%12%'` ignore an index on `name` while `LIKE '12%'` can use it?
2. When would you choose `fetchAll()` over iterating the statement?
3. Why does the import run inside a transaction?
4. What is a path-traversal attack and how does `basename()` help?
5. Explain the N+1 query problem with a shop example.

---
Instructor solutions: [`instructor/solutions/week12-queries-files-oht.md`](../../instructor/solutions/week12-queries-files-oht.md)
