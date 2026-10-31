<?php
declare(strict_types=1);
require __DIR__ . '/../src/bootstrap.php';
require_admin();
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $name  = trim((string)($_POST['name'] ?? ''));
    $price = filter_var($_POST['price'] ?? '', FILTER_VALIDATE_FLOAT);
    $stock = filter_var($_POST['stock'] ?? '', FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
    $cat   = filter_var($_POST['category_id'] ?? '', FILTER_VALIDATE_INT);
    if ($name === '' || mb_strlen($name) > 120) { $errors[] = 'Name is required (max 120).'; }
    if ($price === false || $price < 0)         { $errors[] = 'Price must be 0 or more.'; }
    if ($stock === false)                       { $errors[] = 'Stock must be a whole number.'; }
    if ($cat === false)                         { $errors[] = 'Choose a category.'; }
    $img = null;
    if (!$errors && ($_FILES['image']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
        $img = saveImage($_FILES['image'], 'products', $errors);     // generalised saveAvatar(): $sub folder
    }
    if (!$errors) {
        db()->prepare('INSERT INTO products (category_id, name, price, stock, image) VALUES (?,?,?,?,?)')
            ->execute([$cat, $name, $price, $stock, $img]);
        flash('Product added.', 'ok'); redirect('products.php');
    }
}
// form: csrf_field(), enctype="multipart/form-data", category <select> filled from the categories table
