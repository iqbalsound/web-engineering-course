# Week 11: Full-Stack PHP: Templates, Authentication, Products, Cart and Error Handling

| Syllabus lectures | CLO | PLO | Bloom | Assessment |
| --- | --- | --- | --- | --- |
| Lec 21–22 | CLO_3 | PLO_4 | C4 (Analyzing) | A3 issued (due Week 12); Q3 (CLO_3, 6 marks) |

## Lab: Mini-Shop: Login, Product List, Session Cart and Transactional Checkout

Extend the Week 10 application into a working shop with templates, login/logout, CSRF protection, a product list, cart and checkout that stores orders in MariaDB.

### Free and open-source tools
- PHP 8.x + PDO
- MariaDB
- PHP-FPM error log and Apache logs
- PHPStan

### Deliverables
- `/var/www/webeng/week11` copied from week10 with new pages
- Working flow: register → login → add to cart → checkout → order row in DB
- Error log entry produced by a deliberate failure
- PHPStan level 6 clean

### Contents of this folder
- [`lecture-notes.md`](lecture-notes.md) – the week's theory
- [`rocky10.md`](rocky10.md) – step-by-step lab, **Version A (Rocky Linux 10)**
- [`kubuntu2604.md`](kubuntu2604.md) – step-by-step lab, **Version B (Kubuntu 26.04 LTS)**
- `code/.htaccess`
- `code/config/db.php`
- `code/practice.sql`
- `code/public/avatar.php`
- `code/public/captcha.php`
- `code/public/cart.php`
- `code/public/checkout.php`
- `code/public/login.php`
- `code/public/logout.php`
- `code/public/products.php`
- `code/public/register.php`
- `code/schema.sql`
- `code/src/bootstrap.php`
- `code/src/db.php`
- `code/storage/.gitkeep`
- `code/storage/avatars/.gitkeep`

`code/` holds the reference source files exactly as printed in the lab manual (they are the files the labs ask you to create).
Code is PHP 8.3 compatible and runs under `/var/www/webeng/week11` (see the OS steps).

### Verification checklist
| # | Check | Expected Result |
| --- | --- | --- |
| 1 | POST to `cart.php` without token | `419` and message “Invalid CSRF token” |
| 2 | Login with wrong password | Generic error message; no session user |
| 3 | `session id` before and after login | Cookie value changes (regeneration) |
| 4 | Checkout with 2 products | One `orders` row, two `order_items` rows, stock reduced |
| 5 | Checkout quantity above stock | “could not complete your order”; no rows inserted (rollback) |
| 6 | Database stopped | HTTP 500 and a stack trace in `storage/php-error.log`, none on screen |

### Stretch goals
- Add an order-history page using a JOIN.
- Add a `role = admin` check and an admin page that edits product stock.
- Add login rate limiting (5 failures → 15 min lock) in a table.

### Additional work
#### Assignment A3 (CLO_3, 6 marks) – issued this week, due Week 12

Extend the shop with (a) an order-history page for the logged-in user, (b) an admin-only page to add products with an image upload, (c) a flash-message helper and (d) PHPStan level 6 clean. Submit the repository, a 1-page security checklist (CSRF, XSS, SQL injection, session handling) and screenshots.

### Review questions
1. Why must `session_regenerate_id(true)` be called after login?
2. Why does checkout re-read prices from the database instead of trusting the cart?
3. Explain what `SELECT … FOR UPDATE` prevents when two users buy the last item.
4. Why is logout implemented as POST with a CSRF token?
5. What is logged versus shown to the user when an exception occurs, and why?

---
Instructor solutions: [`instructor/solutions/week11-php-mini-shop.md`](../../instructor/solutions/week11-php-mini-shop.md)
