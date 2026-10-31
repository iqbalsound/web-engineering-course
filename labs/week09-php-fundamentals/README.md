# Week 9: PHP Fundamentals and the Server-Side Stack

| Syllabus lectures | CLO | PLO | Bloom | Assessment |
| --- | --- | --- | --- | --- |
| Lec 17–18 | CLO_2 | PLO_5 | C3 (Applying) | Q2 (formative) |

## Lab: PHP-FPM Stack, Grade Report and Matrix Exercises with PHPStan

Install Apache + PHP-FPM, Composer and PHPStan; write typed PHP functions, a grade report page and CLI exercises that use match, nested switch, loops and 2D/3D arrays.

### Free and open-source tools
- PHP 8.x with PHP-FPM (PHP licence)
- Composer (MIT)
- PHPStan (MIT)
- Apache `mod_proxy_fcgi`

### Deliverables
- Project `/var/www/webeng/week09` with `public/`, `src/`, `bin/`
- Web page `http://webeng.test/week09/public/` showing the grade table
- `php bin/matrix.php` output for 2D and 3D arrays
- PHPStan level 6 with 0 errors

### Contents of this folder
- [`lecture-notes.md`](lecture-notes.md) – the week's theory
- [`rocky10.md`](rocky10.md) – step-by-step lab, **Version A (Rocky Linux 10)**
- [`kubuntu2604.md`](kubuntu2604.md) – step-by-step lab, **Version B (Kubuntu 26.04 LTS)**
- `code/.htaccess`
- `code/bin/matrix.php`
- `code/public/index.php`
- `code/src/grades.php`

`code/` holds the reference source files exactly as printed in the lab manual (they are the files the labs ask you to create).
Code is PHP 8.3 compatible and runs under `/var/www/webeng/week09` (see the OS steps).

### Verification checklist
| # | Check | Expected Result |
| --- | --- | --- |
| 1 | `php bin/matrix.php` | Timetable lines, three term/course averages, `5! = 120`, nested switch output |
| 2 | `curl .../public/?pass=60` | Ayesha Pass, Bilal Pass or Fail by average, Hira Fail; name shown escaped (`&lt;b&gt;`) |
| 3 | `curl .../src/grades.php` | 404 (protected by .htaccess) |
| 4 | `vendor/bin/phpstan analyse -l 6 …` | `[OK] No errors` |
| 5 | Rocky: `ps -eZ \| grep php-fpm` | Process runs in `httpd_t` (confined) |

### Stretch goals
- Kubuntu (PHP 8.4+): replace a `foreach` search with `array_find()`.
- Raise PHPStan to level 8 and fix findings.
- Add a PHPUnit test for `letterGrade()` boundaries (84.9, 85).


### Review questions
1. Describe the path of a request from the browser to PHP-FPM and back.
2. Why is `match` safer than `switch` for returning values?
3. Show how to read the mark of the second course of the first term in the 3D array above.
4. What does `declare(strict_types=1)` change? Give a failing example.
5. Why must output be escaped even if input was validated?

---
Instructor solutions: [`instructor/solutions/week09-php-fundamentals.md`](../../instructor/solutions/week09-php-fundamentals.md)
