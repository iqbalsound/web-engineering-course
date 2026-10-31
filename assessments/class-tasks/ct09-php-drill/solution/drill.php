<?php
declare(strict_types=1);
for ($i = 1; $i <= 30; $i++) {
    echo match (true) { $i % 15 === 0 => 'FizzBuzz', $i % 3 === 0 => 'Fizz', $i % 5 === 0 => 'Buzz', default => $i }, PHP_EOL;
}
print_r(array_map(null, ...[[1, 2, 3], [4, 5, 6]]));                  // [[1,4],[2,5],[3,6]]
$f = array_count_values(str_word_count(strtolower('the cat and the hat and the bat'), 1));
arsort($f); print_r(array_slice($f, 0, 3, true));                      // the=3, and=2, cat=1
