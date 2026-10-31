<?php
declare(strict_types=1);
session_start();
$chars = 'ABCDEFGHJKMNPQRSTUVWXYZ23456789';           // no 0/O/1/I confusion
$code = '';
for ($i = 0; $i < 5; $i++) { $code .= $chars[random_int(0, strlen($chars) - 1)]; }
$_SESSION['captcha'] = $code;
$im = imagecreatetruecolor(90, 28);
imagefilledrectangle($im, 0, 0, 90, 28, imagecolorallocate($im, 245, 247, 250));
for ($i = 0; $i < 5; $i++) {
    $c = imagecolorallocate($im, random_int(120, 200), random_int(120, 200), random_int(120, 200));
    imageline($im, random_int(0, 90), random_int(0, 28), random_int(0, 90), random_int(0, 28), $c);
}
foreach (str_split($code) as $i => $ch) {
    $c = imagecolorallocate($im, random_int(0, 90), random_int(0, 90), random_int(0, 90));
    imagestring($im, 5, 6 + $i * 16 + random_int(-1, 1), 6 + random_int(-3, 3), $ch, $c);
}
$big = imagescale($im, 180, 56);
header('Content-Type: image/png');
header('Cache-Control: no-store');
imagepng($big);
