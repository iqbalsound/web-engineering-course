<?php
declare(strict_types=1);
$timetable = [
    'Mon' => ['08:30' => 'Web Engineering', '10:00' => 'Databases'],
    'Tue' => ['08:30' => 'Web Engineering'],
    'Wed' => ['08:30' => 'Web Engineering', '14:30' => 'Web Lab'],
];
foreach ($timetable as $day => $slots) {                 // 2D associative
    foreach ($slots as $time => $course) { printf("%-4s %s  %s\n", $day, $time, $course); }
}
$marks = ['Fall' => ['Web' => [8, 9, 10], 'DB' => [7, 6, 9]],        // 3D: term / course / quizzes
          'Spring' => ['Net' => [9, 9, 8]]];
foreach ($marks as $term => $courses) {
    foreach ($courses as $course => $quizzes) {
        $i = 0; $sum = 0;
        do { $sum += $quizzes[$i]; $i++; } while ($i < count($quizzes));    // do-while
        printf("%s/%s average %.2f\n", $term, $course, $sum / count($quizzes));
    }
}
$n = 5; $fact = 1; while ($n > 1) { $fact *= $n--; } echo "5! = $fact", PHP_EOL;
foreach ([1, 3, 5] as $slot) {
    switch ($slot) { case 1: echo "first\n"; break; case 3: switch (true) { case $slot > 2: echo "third+\n"; break; } break; default: echo "other\n"; }
}
