<?php
declare(strict_types=1);
try {
    $pdo = new PDO(sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', getenv('DB_HOST'), getenv('DB_NAME')),
                   (string)getenv('DB_USER'), (string)getenv('DB_PASS'), [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $n = (int)$pdo->query('SELECT COUNT(*) FROM products')->fetchColumn();
    $status = "DB OK – $n products";
} catch (Throwable $t) {
    error_log((string)$t); http_response_code(503); $status = 'DB unavailable';
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><title>Capstone</title></head>
<body><h1>Capstone stack</h1><p><?= htmlspecialchars($status) ?></p><p>PHP <?= PHP_VERSION ?></p></body></html>
