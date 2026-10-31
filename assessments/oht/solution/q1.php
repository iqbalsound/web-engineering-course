<?php
$best = null; $bestTotal = -1;
foreach ($sales as $day => $amounts) {
    $total = array_sum($amounts);          // array_sum([]) is 0, so empty days are safe
    echo "$day: $total\n";
    if ($total > $bestTotal) { $bestTotal = $total; $best = $day; }
}
echo "Top day: $best\n";
