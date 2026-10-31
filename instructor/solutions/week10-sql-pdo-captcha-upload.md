# Week 10 solutions: SQL, MariaDB, PDO, CAPTCHA and Uploads

## Expected results and evidence
| Check | Expected result / model evidence |
| --- | --- |
| `SELECT COUNT(*) FROM products;` | 8 |
| Products priced above 1000, ascending | Hamdard T-Shirt 1200, Wireless Mouse 1850, Learning Web Design 2800, PHP and MySQL Guide 3200, Power Bank 10000 4200 |
| Products per category | Electronics 3, Books 2, Clothing 1, Stationery 2 |
| Stock below 20 | Power Bank 10000 (15), PHP and MySQL Guide (10), Learning Web Design (12) |
| Stock value per category (`SUM(price*stock)`) | 1 = 141750.00, 2 = 65600.00, 3 = 48000.00, 4 = 57400.00 |
| Products never ordered (LEFT JOIN) | All 8 (no orders yet) |
| Transaction test | After `ROLLBACK`, stock of product 2 is still 25 |
| `EXPLAIN … WHERE category_id = 2` | `key = idx_prod_cat` on larger data; with only 8 rows the optimizer may legitimately choose `type = ALL` |
| Stored password | `$2y$` bcrypt prefix (PASSWORD_DEFAULT), 60 characters |
| Hostile requests | `avatar.php?id=1 OR 1=1` → 404; `/week10/config/db.php` → 404 |

**Sample SELinux denial for the unlabeled upload folder (Rocky, before relabelling)**

```
type=AVC msg=audit(...): avc:  denied  { write } for  pid=1234 comm="php-fpm" name="avatars"
scontext=system_u:system_r:httpd_t:s0 tcontext=unconfined_u:object_r:httpd_sys_content_t:s0 tclass=dir permissive=0
```

**After the fcontext rule and restorecon**

```
$ ls -Zd storage/avatars
unconfined_u:object_r:httpd_sys_rw_content_t:s0 storage/avatars
```

**Restore sample data changed by practice.sql query 4**

```
sudo mariadb shop -e "UPDATE products SET stock = 50 WHERE id = 1;"
```


## Troubleshooting guide
| Symptom | Likely cause | Fix (Rocky 10 / Kubuntu 26.04) |
| --- | --- | --- |
| `SQLSTATE[HY000] [1045] Access denied` | Wrong credentials in `config/db.php` | Compare with the `CREATE USER` line; `sudo mariadb -e "SELECT user,host FROM mysql.user"` |
| `could not find driver` | `pdo_mysql` missing | Rocky: `sudo dnf -y install php-mysqlnd`. Kubuntu: `sudo apt -y install php-mysql`; restart PHP-FPM |
| CAPTCHA image broken | GD extension missing or an error before the PNG header | Install `php-gd`; open `captcha.php` directly and read the error log |
| “Could not save file” (Rocky) | SELinux blocks writes | `ausearch -m avc -ts recent`, add `httpd_sys_rw_content_t` rule, `restorecon -Rv storage` |
| “Could not save file” (Kubuntu) | No group write permission | `chmod 2775 storage storage/avatars`; `sudo -u www-data test -w storage/avatars` |
| Upload fails silently for big images | `upload_max_filesize` 2 MB default | Resize the image or raise limits in `php.ini` and restart FPM |
| CAPTCHA always wrong | Session cookie not kept | Do not open `captcha.php` and `register.php` on different host names |

## Viva prompts and marking notes
- Ask the student to demonstrate that the injection string is stored or compared as data, not executed.
- Ask why avatars live outside `public/` and how `avatar.php` validates the file name.
- Marking points: schema and SQL practice (3), registration security features (3), upload handling and OS permissions (3), viva (1).

## Answers to review questions
1. 3NF: `customers(customer_id, name, city)`, `products(product_id, name)`, `orders(order_id, customer_id)`, `order_items(order_id, product_id, qty)`. If city determines province, move that to `cities(city, province)` to remove the transitive dependency.
2. The statement is parsed with a placeholder first; the user text is sent afterwards as a value, so `' OR '1'='1` is only a string compared with the e-mail column.
3. Least privilege: a compromised application can only do what its account may do. `root` could drop databases, read every schema and use file privileges.
4. Upload error code, size, real MIME type with `finfo`, `getimagesize`, random file name, extension allow-list, storage outside the web root (any four).
5. Image CAPTCHA: self-hosted and private but weak against OCR and poor for visually impaired users. reCAPTCHA: stronger risk analysis and invisible modes, but third-party tracking and external dependency. Both need server-side verification and complementary rate limiting.
