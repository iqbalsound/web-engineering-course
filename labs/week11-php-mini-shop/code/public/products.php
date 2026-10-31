<?php
declare(strict_types=1);
require __DIR__ . '/../src/bootstrap.php';
$rows = db()->query('SELECT p.id, p.name, p.price, p.stock, c.name AS cat
                     FROM products p JOIN categories c ON c.id = p.category_id ORDER BY c.name, p.name')->fetchAll();
page_start('Products');
echo '<table border="1"><tr><th>Name</th><th>Category</th><th>Price (Rs)</th><th>Stock</th><th></th></tr>';
foreach ($rows as $r) {
    echo '<tr><td>' . e($r['name']) . '</td><td>' . e($r['cat']) . '</td><td>' . number_format((float)$r['price'], 2) . '</td><td>' . (int)$r['stock'] . '</td><td>';
    echo $r['stock'] > 0 ? '<form method="post" action="cart.php">' . csrf_field() . '<input type="hidden" name="action" value="add"><input type="hidden" name="id" value="' . (int)$r['id'] . '"><button>Add</button></form>' : 'Sold out';
    echo '</td></tr>';
}
echo '</table>';
page_end();
