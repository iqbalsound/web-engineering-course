# Week 13 solutions: E-mail, Sessions and MVC Frameworks

## Expected results and evidence
| Check | Expected result / model evidence |
| --- | --- |
| Mailpit API after `php send.php` | `total` ≥ 1; subject “Reset your password”; from `noreply@webeng.test` |
| `send.php` console | “Sent. Store only hash('sha256', token) = <64 hex>” |
| First `state.php` request | `Session visits: 1` and `Theme cookie: light` (the cookie is created in this response and is sent back from the second request on) |
| `cat jar.txt` | Line beginning `#HttpOnly_127.0.0.1` for `PHPSESSID`; a `theme` line with a future expiry |
| Second request | `Session visits: 2` (same session) |
| `php spark migrate` | “Running all new migrations…” and table `notes` in MariaDB |
| POST `/notes` without CSRF token | `403` (security exception) |
| Six notes | Pagination links appear after five; flash message after save and delete |

**Cookie jar excerpt**

```
#HttpOnly_127.0.0.1	FALSE	/	FALSE	0	PHPSESSID	kq2d9...
127.0.0.1	FALSE	/	FALSE	1795000000	theme	dark
```

**Typical route listing**

```
$ php spark routes | grep -i notes
GET   | notes                | Notes::index
POST  | notes                | Notes::store
POST  | notes/([0-9]+)/delete| Notes::delete/$1
```


## Troubleshooting guide
| Symptom | Likely cause | Fix (Rocky 10 / Kubuntu 26.04) |
| --- | --- | --- |
| `Connection refused` to 127.0.0.1:1025 | Mailpit container not running | `podman ps -a`, `podman start mailpit`, check ports not used by another process |
| CI4: “Unable to connect to the database” | Wrong `.env` values or database missing | Re-check the `database.default.*` lines; test with `mariadb -u notes_app -p notes` |
| CI4: `intl` extension required | Package missing | Rocky: `sudo dnf -y install php-intl`. Kubuntu: `sudo apt -y install php-intl` |
| CSRF `sed` changed nothing | Different comment layout in the installed version | Open `app/Config/Filters.php` and add `'csrf'` to `$globals['before']` manually |
| Port already in use | Earlier `php -S` / `spark serve` still running | `ss -tlnp \| grep 808`; `kill` the PID |
| Rocky: Apache-hosted PHP cannot send mail or reach a port | SELinux booleans off | Use `getsebool httpd_can_sendmail httpd_can_network_connect`; enable only the one needed with `setsebool -P` |
| Laravel install slow or fails at the end | SQLite extension missing | Rocky: `php-pdo` is installed; Kubuntu: `sudo apt -y install php-sqlite3`, rerun `php artisan migrate` |

## Viva prompts and marking notes
- Ask the student to explain in the Mailpit message why the reset token is random and short-lived.
- Ask which MVC file handles the “delete” request and where the CSRF check happens (before-filter).
- Marking points: e-mail (2), cookie/session evidence (2), CI4 CRUD (4), Laravel comparison (1), viva (1).

## Answers to review questions
1. If the database leaks, stored hashes cannot be used to reset accounts; only the person holding the original emailed token can.
2. HttpOnly: JavaScript cannot read the cookie (limits XSS theft). Secure: sent over HTTPS only (prevents sniffing). SameSite: not sent on cross-site requests (reduces CSRF).
3. Model, View and Controller all live in the application (middle) tier. The view’s output is delivered to the presentation tier (browser); the model talks to the data tier.
4. CodeIgniter 4: small, quick to learn, light on hosting, good for small to medium apps. Laravel: larger ecosystem (Eloquent, queues, auth kits), better for big teams and long-lived products.
5. Migrations store schema changes as versioned code, so every developer and server gets the same database and changes can be rolled back.
