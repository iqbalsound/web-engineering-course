<?php
declare(strict_types=1);

function letterGrade(float $pct): string {
    return match (true) {
        $pct >= 85 => 'A',
        $pct >= 70 => 'B',
        $pct >= 55 => 'C',
        $pct >= 40 => 'D',
        default => 'F',
    };
}
/** @param list<int|float> $marks */
function average(array $marks): float {
    return $marks === [] ? 0.0 : array_sum($marks) / count($marks);
}
function e(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
