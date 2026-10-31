<?php
declare(strict_types=1);
require __DIR__ . '/../src/db.php';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$st = db()->prepare('SELECT avatar FROM users WHERE id = ?');
$st->execute([$id ?: 0]);
$file = $st->fetchColumn();
if (!is_string($file) || !preg_match('/^[a-f0-9]{32}\.(jpg|png|webp)$/', $file)) { http_response_code(404); exit; }
$types = ['jpg' => 'image/jpeg', 'png' => 'image/png', 'webp' => 'image/webp'];
header('Content-Type: ' . $types[pathinfo($file, PATHINFO_EXTENSION)]);
header('X-Content-Type-Options: nosniff');
readfile(__DIR__ . '/../storage/avatars/' . $file);
