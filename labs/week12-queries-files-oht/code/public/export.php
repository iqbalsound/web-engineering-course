<?php
declare(strict_types=1);
require __DIR__ . '/../src/bootstrap.php';
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="products-' . date('Ymd') . '.csv"');
$out = fopen('php://output', 'w');
fputcsv($out, ['category_id', 'name', 'price', 'stock'], ',', '"', '');
foreach (db()->query('SELECT category_id, name, price, stock FROM products ORDER BY id') as $row) {
    fputcsv($out, $row, ',', '"', '');
}
fclose($out);
