<?php
declare(strict_types=1);
require __DIR__ . '/../src/bootstrap.php';
$msg = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $f = $_FILES['csv'] ?? null;
    if (!$f || $f['error'] !== UPLOAD_ERR_OK || $f['size'] > 1_000_000) { $msg[] = 'Upload a CSV smaller than 1 MB.'; }
    else {
        $file = new SplFileObject($f['tmp_name']);
        $file->setFlags(SplFileObject::READ_CSV | SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);
        $file->setCsvControl(',', '"', '');
        $pdo = db(); $pdo->beginTransaction();
        $ins = $pdo->prepare('INSERT INTO products (category_id, name, price, stock) VALUES (?, ?, ?, ?)');
        $header = null; $n = 0;
        foreach ($file as $i => $row) {
            if ($header === null) { $header = $row; continue; }
            [$cat, $name, $price, $stock] = array_pad($row, 4, null);
            if (!ctype_digit((string)$cat) || trim((string)$name) === '' || !is_numeric($price) || !ctype_digit((string)$stock)) {
                $msg[] = 'Line ' . ($i + 1) . ' is invalid.'; continue;
            }
            $ins->execute([(int)$cat, trim((string)$name), $price, (int)$stock]); $n++;
        }
        if ($msg) { $pdo->rollBack(); $msg[] = 'Import cancelled; nothing saved.'; }
        else { $pdo->commit(); $msg[] = "$n products imported."; }
    }
}
page_start('Import products');
foreach ($msg as $m) { echo '<p>' . e($m) . '</p>'; }
?>
<form method="post" enctype="multipart/form-data"><?= csrf_field() ?><input type="file" name="csv" accept=".csv,text/csv" required><button>Import</button></form>
<?php page_end();
