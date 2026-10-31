<?php
declare(strict_types=1);
require __DIR__ . '/../src/bootstrap.php';
$cart = $_SESSION['cart'] ?? [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $id = (int)($_POST['id'] ?? 0);
    switch ($_POST['action'] ?? '') {
        case 'add':    $cart[$id] = ($cart[$id] ?? 0) + 1; break;
        case 'update': $q = max(0, min(99, (int)($_POST['qty'] ?? 0))); if ($q === 0) { unset($cart[$id]); } else { $cart[$id] = $q; } break;
        case 'remove': unset($cart[$id]); break;
    }
    $_SESSION['cart'] = $cart;
    redirect('cart.php');
}
page_start('Your cart');
if (!$cart) { echo '<p>Cart is empty.</p>'; page_end(); exit; }
$in = implode(',', array_fill(0, count($cart), '?'));
$st = db()->prepare("SELECT id, name, price FROM products WHERE id IN ($in)");
$st->execute(array_keys($cart));
$total = 0.0;
echo '<table border="1"><tr><th>Item</th><th>Qty</th><th>Line (Rs)</th></tr>';
foreach ($st as $p) {
    $q = $cart[$p['id']]; $line = $q * (float)$p['price']; $total += $line;
    echo '<tr><td>' . e($p['name']) . '</td><td><form method="post">' . csrf_field() . '<input type="hidden" name="action" value="update"><input type="hidden" name="id" value="' . (int)$p['id'] . '"><input type="number" name="qty" min="0" max="99" value="' . $q . '"><button>Update</button></form></td><td>' . number_format($line, 2) . '</td></tr>';
}
echo '</table><p><strong>Total: Rs ' . number_format($total, 2) . '</strong></p>';
echo '<form method="post" action="checkout.php">' . csrf_field() . '<button>Checkout</button></form>';
page_end();
