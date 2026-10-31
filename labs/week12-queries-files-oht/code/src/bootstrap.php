<?php
declare(strict_types=1);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/../storage/php-error.log');
session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax', 'secure' => !empty($_SERVER['HTTPS'])]);
session_start();
require __DIR__ . '/db.php';
set_exception_handler(function (Throwable $t): void {
    error_log((string)$t);
    http_response_code(500);
    echo '<h1>Something went wrong</h1><p>Please try again later.</p>';
});
function csrf_token(): string { return $_SESSION['csrf'] ??= bin2hex(random_bytes(32)); }
function csrf_field(): string { return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">'; }
function csrf_check(): void {
    $t = (string)($_SESSION['csrf'] ?? '');
    if ($t === '' || !hash_equals($t, (string)($_POST['csrf'] ?? ''))) { http_response_code(419); exit('Invalid CSRF token'); }
}
function current_user(): ?array {
    static $u = false;
    if ($u === false) {
        $u = null;
        if (isset($_SESSION['uid'])) {
            $st = db()->prepare('SELECT id, name, role FROM users WHERE id = ?'); $st->execute([$_SESSION['uid']]);
            $u = $st->fetch() ?: null;
        }
    }
    return $u;
}
function require_login(): array { $u = current_user(); if (!$u) { header('Location: login.php'); exit; } return $u; }
function redirect(string $to): never { header('Location: ' . $to); exit; }
function page_start(string $title): void {
    $u = current_user(); $n = array_sum($_SESSION['cart'] ?? []);
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">';
    echo '<title>' . e($title) . ' – PK Shop</title></head><body><header><nav><a href="products.php">Products</a> | <a href="cart.php">Cart (' . $n . ')</a> | ';
    echo $u ? e($u['name']) . ' <form method="post" action="logout.php" style="display:inline">' . csrf_field() . '<button>Logout</button></form>'
            : '<a href="login.php">Login</a> | <a href="register.php">Register</a>';
    echo '</nav></header><main><h1>' . e($title) . '</h1>';
}
function page_end(): void { echo '</main><footer><small>&copy; 2026 PK Shop</small></footer></body></html>'; }
