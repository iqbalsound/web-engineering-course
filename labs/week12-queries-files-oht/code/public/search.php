<?php
declare(strict_types=1);
require __DIR__ . '/../src/bootstrap.php';
function run(string $sql, array $args = []): PDOStatement { $s = db()->prepare($sql); $s->execute($args); return $s; }
$q = trim((string)($_GET['q'] ?? ''));
$cat = filter_input(INPUT_GET, 'cat', FILTER_VALIDATE_INT) ?: null;
$page = max(1, (int)($_GET['page'] ?? 1)); $per = 10;
$where = []; $args = [];
if ($q !== '') { $where[] = 'p.name LIKE :q'; $args[':q'] = addcslashes($q, '%_\\') . '%'; }
if ($cat)      { $where[] = 'p.category_id = :c'; $args[':c'] = $cat; }
$w = $where ? 'WHERE ' . implode(' AND ', $where) : '';
$total = (int)run("SELECT COUNT(*) FROM products p $w", $args)->fetchColumn();
$pages = max(1, (int)ceil($total / $per)); $page = min($page, $pages); $off = ($page - 1) * $per;
$rows = run("SELECT p.id, p.name, p.price, c.name AS cat FROM products p JOIN categories c ON c.id = p.category_id $w ORDER BY p.id LIMIT $per OFFSET $off", $args)->fetchAll();
$cats = db()->query('SELECT id, name FROM categories')->fetchAll(PDO::FETCH_KEY_PAIR);
page_start('Product search');
?>
<form method="get"><input name="q" value="<?= e($q) ?>" placeholder="Name starts with…">
<select name="cat"><option value="">All</option><?php foreach ($cats as $id => $n): ?><option value="<?= $id ?>" <?= $cat === $id ? 'selected' : '' ?>><?= e($n) ?></option><?php endforeach; ?></select>
<button>Search</button></form>
<p><?= $total ?> result(s) – page <?= $page ?> of <?= $pages ?> | <a href="export.php">Export CSV</a></p>
<table border="1"><?php foreach ($rows as $r): ?><tr><td><?= (int)$r['id'] ?></td><td><?= e($r['name']) ?></td><td><?= e($r['cat']) ?></td><td><?= number_format((float)$r['price'], 2) ?></td></tr><?php endforeach; ?></table>
<p><?php if ($page > 1): ?><a href="?<?= e(http_build_query(['q' => $q, 'cat' => $cat, 'page' => $page - 1])) ?>">Prev</a><?php endif; ?>
<?php if ($page < $pages): ?> <a href="?<?= e(http_build_query(['q' => $q, 'cat' => $cat, 'page' => $page + 1])) ?>">Next</a><?php endif; ?></p>
<?php page_end();
