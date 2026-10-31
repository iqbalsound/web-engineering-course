# Week 9 solutions: PHP Fundamentals

## Expected results and evidence
| Check | Expected result / model evidence |
| --- | --- |
| `php bin/matrix.php` | Timetable lines, three term averages, `5! = 120`, then `first`, `third+`, `other` |
| `curl ".../public/?pass=60"` | Ayesha A / Pass, Bilal C / Pass, Hira F / Fail; first name appears as `Ayesha &lt;b&gt;Khan&lt;/b&gt;` |
| Without `?pass` | Heading shows pass mark 40; Hira (38.7) fails |
| `curl .../src/grades.php` | `404` (blocked by `.htaccess`; without the rule it returns 200 with empty body) |
| `vendor/bin/phpstan analyse -l 6 src public bin` | `[OK] No errors` |
| Rocky `ps -eZ \| grep php-fpm` | `system_u:system_r:httpd_t:s0 … php-fpm` (confined) |

**Expected output of php bin/matrix.php**

```
Mon  08:30  Web Engineering
Mon  10:00  Databases
Tue  08:30  Web Engineering
Wed  08:30  Web Engineering
Wed  14:30  Web Lab
Fall/Web average 9.00
Fall/DB average 7.33
Spring/Net average 8.67
5! = 120
first
third+
other
```

**Averages used by the web page**

```
Ayesha: (88+92+79)/3 = 86.3 -> A
Bilal : (64+58+71)/3 = 64.3 -> C
Hira  : (35+42+39)/3 = 38.7 -> F
```


## Troubleshooting guide
| Symptom | Likely cause | Fix (Rocky 10 / Kubuntu 26.04) |
| --- | --- | --- |
| Browser downloads or shows PHP source | PHP-FPM not connected to Apache | Rocky: `webeng-php.conf` present, `systemctl restart httpd`, `systemctl status php-fpm`. Kubuntu: `a2enmod proxy_fcgi`, `a2enconf php${PHPV}-fpm`, reload |
| `503 Service Unavailable` | FPM socket missing or service stopped | Rocky: `ls /run/php-fpm/www.sock`. Kubuntu: `ls /run/php/`; start `php${PHPV}-fpm` |
| `composer: command not found` | Installer step skipped or `/usr/local/bin` not in sudo PATH | Re-run the verified installer; use `/usr/local/bin/composer` |
| `.htaccess` has no effect | `AllowOverride` not `All` | Check the vhost from Lab 0 and reload Apache |
| PHPStan reports “no value type specified in iterable type array” | Level 6 wants array shapes | Add `@param list<int\|float> $marks` style docblocks |
| Rocky: `Class "PDO" not found` later | Extension not installed | `sudo dnf -y install php-mysqlnd` and restart `php-fpm` |

## Viva prompts and marking notes
- Ask the student to draw the request path browser → Apache → socket → PHP-FPM.
- Ask what `declare(strict_types=1)` and `match` change in the grade function.
- Marking points: working stack on own OS (3), PHP correctness (3), PHPStan clean (2), protected source folders (1), viva (1).

## Answers to review questions
1. Browser → Apache (TLS, static files) → `mod_proxy_fcgi` → Unix socket → a PHP-FPM worker runs the script (bytecode from OPcache) → output returns through Apache to the browser.
2. `match` compares strictly, is an expression that returns a value, has no fall-through and throws `UnhandledMatchError` when no arm fits, so mistakes surface instead of hiding.
3. `$marks["Fall"]["DB"]` is the array `[7, 6, 9]`; the first quiz mark of the second Fall course is `$marks["Fall"]["DB"][0]`, which is 7.
4. With strict types, a scalar of the wrong type is rejected: `function f(int $x) {}  f("5");` throws `TypeError`, whereas in weak mode `"5"` is converted to 5.
5. Validation checks that data has the expected shape; escaping protects a specific output context. Data can also reach the page from imports, admin tools or older rows, and legal text such as `<b>` becomes stored XSS if printed unescaped.
