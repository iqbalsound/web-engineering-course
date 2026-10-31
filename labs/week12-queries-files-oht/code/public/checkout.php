<?php
declare(strict_types=1);
require __DIR__ . '/../src/bootstrap.php';
$user = require_login();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect('cart.php'); }
csrf_check();
$cart = $_SESSION['cart'] ?? [];
if (!$cart) { redirect('cart.php'); }
$pdo = db();
$pdo->beginTransaction();
try {
    $total = 0.0; $lines = [];
    $sel = $pdo->prepare('SELECT id, price, stock FROM products WHERE id = ? FOR UPDATE');   // row lock
    foreach ($cart as $id => $qty) {
        $sel->execute([$id]); $p = $sel->fetch();
        if (!$p || $p['stock'] < $qty) { throw new RuntimeException("Insufficient stock for product $id"); }
        $total += $qty * (float)$p['price']; $lines[] = [$id, $qty, $p['price']];
    }
    $pdo->prepare('INSERT INTO orders (user_id, total) VALUES (?, ?)')->execute([$user['id'], $total]);
    $oid = (int)$pdo->lastInsertId();
    $ins = $pdo->prepare('INSERT INTO order_items (order_id, product_id, qty, unit_price) VALUES (?,?,?,?)');
    $upd = $pdo->prepare('UPDATE products SET stock = stock - ? WHERE id = ?');
    foreach ($lines as [$id, $qty, $price]) { $ins->execute([$oid, $id, $qty, $price]); $upd->execute([$qty, $id]); }
    $pdo->commit();
    $_SESSION['cart'] = [];
    page_start('Order placed'); echo '<p>Order #' . $oid . ' total Rs ' . number_format($total, 2) . '</p>'; page_end();
} catch (Throwable $t) {
    $pdo->rollBack();
    error_log($t->getMessage());
    page_start('Checkout failed'); echo '<p>Sorry, we could not complete your order.</p>'; page_end();
}
