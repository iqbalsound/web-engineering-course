<?php
declare(strict_types=1);
require __DIR__ . '/../src/grades.php';

$students = [
    ['name' => 'Ayesha <b>Khan</b>', 'marks' => [88, 92, 79]],
    ['name' => 'Bilal Siddiqui',     'marks' => [64, 58, 71]],
    ['name' => 'Hira Ali',           'marks' => [35, 42, 39]],
];
$pass = filter_input(INPUT_GET, 'pass', FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 100]]);
if (!is_int($pass)) { $pass = 40; }
?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="utf-8"><title>Grades</title></head>
<body><main><h1>Grade report (pass mark <?= $pass ?>)</h1>
<table border="1"><thead><tr><th>Name</th><th>Average</th><th>Grade</th><th>Status</th></tr></thead><tbody>
<?php foreach ($students as $s): $avg = average($s['marks']); ?>
  <tr><td><?= e($s['name']) ?></td><td><?= number_format($avg, 1) ?></td>
      <td><?= letterGrade($avg) ?></td><td><?= $avg >= $pass ? 'Pass' : 'Fail' ?></td></tr>
<?php endforeach; ?>
</tbody></table></main></body></html>
