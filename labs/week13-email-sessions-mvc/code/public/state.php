<?php
declare(strict_types=1);
session_set_cookie_params(['lifetime' => 0, 'path' => '/', 'httponly' => true, 'samesite' => 'Lax', 'secure' => false]);
session_start();
$_SESSION['visits'] = ($_SESSION['visits'] ?? 0) + 1;
$theme = in_array($_GET['theme'] ?? '', ['light', 'dark'], true) ? $_GET['theme'] : ($_COOKIE['theme'] ?? 'light');
setcookie('theme', $theme, ['expires' => time() + 86400 * 30, 'path' => '/', 'samesite' => 'Lax']);
header('Content-Type: text/plain; charset=utf-8');
echo 'Session visits: ' . $_SESSION['visits'] . PHP_EOL . 'Theme cookie: ' . htmlspecialchars((string)$theme) . PHP_EOL;
