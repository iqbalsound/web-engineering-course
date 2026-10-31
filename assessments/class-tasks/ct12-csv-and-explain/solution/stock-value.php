<?php
declare(strict_types=1);
$h = fopen('products.csv', 'r');
fgetcsv($h, null, ',', '"', '');                          // skip header
$total = 0.0; $line = 1;
while (($r = fgetcsv($h, null, ',', '"', '')) !== false) {
    $line++;
    if (count($r) !== 4 || !is_numeric($r[2]) || !ctype_digit($r[3])) { fwrite(STDERR, "skip line $line\n"); continue; }
    $total += (float)$r[2] * (int)$r[3];
}
fclose($h);
printf("Total stock value: %.2f\n", $total);
