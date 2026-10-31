<?php
declare(strict_types=1);
require __DIR__ . '/../src/images.php';
foreach (glob(__DIR__ . '/../storage/avatars/*.{jpg,png,webp}', GLOB_BRACE) ?: [] as $f) {
    $dst = __DIR__ . '/../storage/thumbs/' . pathinfo($f, PATHINFO_FILENAME) . '.webp';
    echo basename($f), makeThumb($f, $dst) ? ' -> thumb OK' : ' -> FAILED', PHP_EOL;
}
