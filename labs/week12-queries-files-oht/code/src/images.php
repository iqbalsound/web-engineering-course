<?php
declare(strict_types=1);
function makeThumb(string $src, string $dst, int $max = 200): bool {
    $info = getimagesize($src);
    if ($info === false) { return false; }
    [$w, $h, $type] = $info;
    $im = match ($type) {
        IMAGETYPE_JPEG => imagecreatefromjpeg($src),
        IMAGETYPE_PNG  => imagecreatefrompng($src),
        IMAGETYPE_WEBP => imagecreatefromwebp($src),
        default        => false,
    };
    if ($im === false) { return false; }
    $r = min($max / $w, $max / $h, 1);
    $t = imagescale($im, max(1, (int)($w * $r)), max(1, (int)($h * $r)));
    return $t !== false && imagewebp($t, $dst, 80);
}
