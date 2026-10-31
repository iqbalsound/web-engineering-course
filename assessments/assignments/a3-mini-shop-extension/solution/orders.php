<?php
declare(strict_types=1);
require __DIR__ . '/../src/bootstrap.php';
$user = require_login();
$st = db()->prepare('SELECT o.id, o.created_at, o.total, p.name, oi.qty, oi.unit_price
    FROM orders o JOIN order_items oi ON oi.order_id = o.id JOIN products p ON p.id = oi.product_id
    WHERE o.user_id = ? ORDER BY o.id DESC, p.name');
$st->execute([$user['id']]);               // ownership enforced in SQL
$orders = [];
foreach ($st as $r) { $orders[$r['id']]['head'] = $r; $orders[$r['id']]['lines'][] = $r; }
page_start('My orders');
foreach ($orders as $id => $o) {
    echo '<h2>Order #' . (int)$id . ' – ' . e($o['head']['created_at']) . ' – Rs ' . number_format((float)$o['head']['total'], 2) . '</h2><ul>';
    foreach ($o['lines'] as $l) { echo '<li>' . e($l['name']) . ' × ' . (int)$l['qty'] . ' @ ' . number_format((float)$l['unit_price'], 2) . '</li>'; }
    echo '</ul>';
}
if (!$orders) { echo '<p>No orders yet.</p>'; }
page_end();
