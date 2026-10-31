# Week 11 solutions: Mini-Shop: Auth, Cart and Errors

## Expected results and evidence
| Check | Expected result / model evidence |
| --- | --- |
| POST to `cart.php` without a token | `419` and “Invalid CSRF token” |
| Login with wrong password | “E-mail or password incorrect.”; no session user |
| Session ID before and after login | Different `PHPSESSID` value (regeneration) |
| Cookie flags | `Set-Cookie: PHPSESSID=...; path=/; HttpOnly; SameSite=Lax` |
| Checkout: 1 USB-C Cable + 1 Wireless Mouse | Order total 2500.00; 2 `order_items`; stock 49 and 24 if starting from 50 and 25 |
| Checkout with quantity above stock (set 99) | “could not complete your order”; no new `orders` row; stock unchanged |
| Database stopped | HTTP 500 page; stack trace only in `storage/php-error.log` |

**Verification queries and sample output**

```
SELECT id, user_id, total FROM orders;
+----+---------+---------+
| id | user_id | total   |
+----+---------+---------+
|  1 |       1 | 2500.00 |
+----+---------+---------+
SELECT order_id, product_id, qty, unit_price FROM order_items;   -- (1,1,1,650.00) and (1,2,1,1850.00)
```

**register.php header after copying from Week 10 (the sed edit does this)**

```
<?php
declare(strict_types=1);
require __DIR__ . '/../src/bootstrap.php';     // replaces session_start() and the db.php require
$errors = []; ...
```


## Troubleshooting guide
| Symptom | Likely cause | Fix (Rocky 10 / Kubuntu 26.04) |
| --- | --- | --- |
| “session_start(): Ignoring session_start()” | Session started twice | Only `bootstrap.php` calls `session_start()`; remove the call from `register.php` |
| “Cannot modify header information” | Output before `header()` / redirect | No HTML or whitespace before `<?php`; call `redirect()` before `page_start()` |
| `Call to undefined function e()` | `db.php` not loaded | `bootstrap.php` must `require db.php` (it defines `e()`) |
| 419 on every form | Missing `csrf_field()` or cookie blocked | Include `<?= csrf_field() ?>` in each POST form; use one host name only |
| Log file empty (Rocky) | SELinux label on `storage/` | `restorecon -Rv storage` and confirm `httpd_sys_rw_content_t` |
| 500 instead of CAPTCHA/DB message | DB service stopped | `sudo systemctl start mariadb` |
| `Unknown column role` | Old schema | Re-import `schema.sql` into a fresh `shop` database |

## Viva prompts and marking notes
- Ask the student to show the cookie in DevTools (Storage → Cookies) and explain each flag.
- Ask why prices are read inside the transaction with `FOR UPDATE` and not from the cart.
- Marking points: auth and CSRF (3), cart and checkout correctness (3), error handling/logging (2), PHPStan (1), viva (1).

## Answers to review questions
1. It replaces the session ID after a privilege change, so an attacker who planted a known ID before login cannot reuse it (session fixation).
2. Browser data can be tampered with. The database is the authority for price and stock, and prices may change between adding and buying.
3. `SELECT … FOR UPDATE` locks the product row until commit. A second buyer waits, then sees the reduced stock, so the last item cannot be sold twice.
4. A GET logout can be triggered by any page (`<img src="…/logout">`). A POST with a CSRF token only works from your own form.
5. Logged: the full exception and stack trace in a protected file. Shown: a generic message and HTTP 500, because details help attackers and confuse users.
