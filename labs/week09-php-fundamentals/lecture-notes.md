# Week 9: PHP Fundamentals and the Server-Side Stack – lecture notes

### 9.1 How PHP Runs

PHP is a server-side language: the browser never sees PHP code, only its output. In current production setups Apache (or Nginx) passes `.php` requests to **PHP-FPM**, a pool of worker processes, over FastCGI (a Unix socket). **OPcache** stores compiled bytecode so files are not re-parsed on each request. PHP is stateless between requests; state is kept in sessions, cookies or the database.

| Version | Notable features |
| --- | --- |
| 8.0 – 8.2 | Named arguments, `match`, union types, enums, readonly properties, constructor promotion |
| 8.3 (Rocky 10) | Typed class constants, `#[\Override]`, `json_validate()` |
| 8.4 | Property hooks, asymmetric visibility, `array_find()`, `array_any()`, `array_all()` |
| 8.5 (Kubuntu 26.04) | Pipe operator `\|>`, `array_first()` / `array_last()`, built-in URI extension |

### 9.2 Syntax, Types and Strings

```php
<?php
declare(strict_types=1);                   // no silent type juggling for scalar arguments
$name = 'Ayesha'; $age = 21; $gpa = 3.45; $ok = true; $none = null;
echo "Hello, {$name}! Next year: " . ($age + 1) . PHP_EOL;     // double quotes interpolate
echo 'Single quotes do not $interpolate', PHP_EOL;
$text = <<<TXT
Heredoc keeps formatting for {$name}
TXT;
var_dump(strlen($name), strtoupper($name), str_contains($name, 'ye'), substr($name, 0, 3));
printf("%s has %.1f GPA (%05d)\n", $name, $gpa, 42);
```

| Operator group | Examples |
| --- | --- |
| Arithmetic | `+ - * / % **`, integer division `intdiv()` |
| Comparison | `==` (loose) vs `===` (strict), `<=>` spaceship |
| Logical | `&&  \|\|  !  xor`, and low-precedence `and`, `or` |
| Null handling | `??` (null coalescing), `??=`, `?->` (null-safe) |
| String | `.` concatenation, `.=` |

### 9.3 Control Structures

```
$score = 72;
if ($score >= 85) { $g = 'A'; } elseif ($score >= 70) { $g = 'B'; } else { $g = 'C'; }
$g2 = match (true) { $score >= 85 => 'A', $score >= 70 => 'B', default => 'C' };   // expression, strict
switch ($day) {                                   // nested switch
    case 'Mon': switch ($slot) { case 'lab': echo 'Lab A'; break; default: echo 'Hall'; } break;
    case 'Tue': case 'Wed': echo 'Theory'; break;
    default: echo 'Free';
}
for ($i = 1; $i <= 3; $i++) echo $i;      $n = 3; while ($n > 0) echo $n--;
do { echo 'runs once'; } while (false);
```

### 9.4 Arrays: 1D, 2D and 3D

```
$langs = ['PHP', 'JS'];                           // indexed
$user  = ['name' => 'Ali', 'city' => 'Karachi'];     // associative
$grid  = [[1, 2, 3], [4, 5, 6]];                     // 2D: $grid[1][2] = 6
$cube  = ['Fall' => ['Web' => [8, 9], 'DB' => [7, 6]]];   // 3D: $cube['Fall']['Web'][0]
foreach ($cube as $term => $courses)
    foreach ($courses as $course => $marks)
        echo "$term / $course: " . array_sum($marks) / count($marks) . PHP_EOL;
array_map(fn($x) => $x * 2, [1, 2]); array_filter($langs, fn($l) => $l !== 'JS'); usort($rows, fn($a, $b) => $a['m'] <=> $b['m']);
[$a, $b] = [10, 20]; ['name' => $n] = $user;           // destructuring
```

### 9.5 Functions, Superglobals and Output Escaping

Functions should declare parameter and return types. Input arrives in `$_GET`, `$_POST`, `$_COOKIE`, `$_FILES`, `$_SERVER` and `$_SESSION`. Always treat input as untrusted: validate with `filter_var()` / `filter_input()` and **escape on output** with `htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8")` to prevent cross-site scripting.

> **Security:** Set `display_errors = Off` and `log_errors = On` in production; errors shown to users leak paths and queries. During development you may enable them.
