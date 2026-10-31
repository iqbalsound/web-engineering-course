<?php
declare(strict_types=1);
function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $c = require __DIR__ . '/../config/db.php';
        $pdo = new PDO($c['dsn'], $c['user'], $c['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }
    return $pdo;
}
function e(string $s): string { return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function saveAvatar(array $f, array &$errors): ?string {
    if ($f['error'] !== UPLOAD_ERR_OK) { $errors[] = 'Upload failed (code ' . $f['error'] . ').'; return null; }
    if ($f['size'] > 2 * 1024 * 1024) { $errors[] = 'Image must be 2 MB or smaller.'; return null; }
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']);
    $ext = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'][$mime] ?? null;
    if ($ext === null || @getimagesize($f['tmp_name']) === false) { $errors[] = 'Only JPEG, PNG or WebP images.'; return null; }
    $name = bin2hex(random_bytes(16)) . '.' . $ext;
    if (!move_uploaded_file($f['tmp_name'], __DIR__ . '/../storage/avatars/' . $name)) { $errors[] = 'Could not save file.'; return null; }
    return $name;
}
