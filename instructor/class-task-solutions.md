# Class task solutions

| Task | Model answer / what to look for |
| --- | --- |
| CT-1 | Values vary by site and day. Accept evidence-based tables. Hallmarks of a proxy or CDN: `Via`, `X-Cache`, `CF-Ray`, `Age`. `webeng.test` should show `Server: Apache`, HTTP/2 over TLS, `ETag` and `Last-Modified` (cache validators). |
| CT-4 | `groupSum` with `reduce`, `dedupe` with `[...new Set(arr)]`, `makeCounter(step)` with a closure; each function has at least two assertions (see code below). |
| CT-7 | Hero `div` with `p-5 mb-4 bg-body-tertiary rounded-3 text-center`; `.row.g-3` with `col-12 col-md-6 col-lg-4`; `<nav aria-label="Pages"><ul class="pagination">` with `aria-current="page"` on the active link. |
| CT-8 | Add `<main>`, remove the second `h1` (use `h2`), add `required` to the text input, replace floats with `display: grid`, replace `innerHTML` with `textContent`; re-run `check.sh` until all PASS. |
| CT-14 | Answers vary. Strong answers cite numbers (installs, last update within 6 months, tested-up-to current WordPress), GPL licence, query count from Query Monitor and name a concrete risk (spam, upload handling, abandoned maintainer). |

### CT-2 Corrected form and defects

Defects: no labels; first input has no `name`; e-mail uses `type="text"`; age uses `type="text"` without limits; radios are not grouped with `fieldset`/`legend` or labelled; a `div` acts as a button (not focusable, `submit()` undefined); no `method`; no `required`.

```
<form action="/join" method="post">
  <p><label for="n">Name</label> <input id="n" name="name" required autocomplete="name"></p>
  <p><label for="e">Email</label> <input id="e" name="email" type="email" required autocomplete="email"></p>
  <p><label for="a">Age</label> <input id="a" name="age" type="number" min="10" max="99"></p>
  <fieldset><legend>Level</legend>
    <label><input type="radio" name="level" value="1" checked> Beginner</label>
    <label><input type="radio" name="level" value="2"> Advanced</label></fieldset>
  <button type="submit">Send</button>
</form>
```

### CT-3 Specificity and grid

| Rule | Specificity | Colour |
| --- | --- | --- |
| `p` | (0,0,1) | red |
| `.note` | (0,1,0) | blue |
| `.card p` | (0,1,1) | green |
| `#box p` | (1,0,1) | **orange – wins** |
| `p.intro.note` | (0,2,1) | purple |

```
.row { display: grid; gap: 1rem; grid-template-columns: repeat(3, 1fr); }
@media (max-width: 600px) { .row { grid-template-columns: 1fr; } }
```

### CT-4 JavaScript kata

```
export const groupSum = (items, key, valueKey) =>
  items.reduce((acc, it) => { acc[it[key]] = (acc[it[key]] ?? 0) + it[valueKey]; return acc; }, {});
export const dedupe = arr => [...new Set(arr)];
export const makeCounter = (step = 1) => { let n = 0; return () => (n += step); };
// tests: groupSum([{c:'a',v:1},{c:'a',v:2}],'c','v') -> {a:3}; dedupe([1,2,1]) -> [1,2];
//        const c = makeCounter(5); c(); c() -> 10
```

### CT-5 Async rewrite

```
const wait = ms => new Promise(res => setTimeout(() => res(ms), ms));   // or util.promisify(wait)
const getUser = async id => { await wait(100); if (id <= 0) throw new Error('bad id'); return { id }; };
try {
  console.log(await Promise.all([1, 2, 3].map(getUser)));   // concurrent: ~100 ms, not 300 ms
  await getUser(0);
} catch (e) { console.error('Handled:', e.message); }
```

### CT-6 Event bus and signal

```
import { EventEmitter } from 'node:events';
const bus = new EventEmitter();
bus.on('order', id => console.log('log', id));
bus.on('order', id => console.log('email', id));
bus.on('order', id => console.log('stock', id));
bus.once('order', id => console.log('first order only', id));
bus.emit('order', 1); bus.emit('order', 2);
// output: log 1, email 1, stock 1, first order only 1, log 2, email 2, stock 2
```

```
count = signal(0);
double = computed(() => this.count() * 2);
inc() { this.count.update(c => c + 1); }
// template: <button (click)="inc()">{{ count() }} → {{ double() }}</button>
```

### CT-9 PHP drill

```php
<?php
declare(strict_types=1);
for ($i = 1; $i <= 30; $i++) {
    echo match (true) { $i % 15 === 0 => 'FizzBuzz', $i % 3 === 0 => 'Fizz', $i % 5 === 0 => 'Buzz', default => $i }, PHP_EOL;
}
print_r(array_map(null, ...[[1, 2, 3], [4, 5, 6]]));                  // [[1,4],[2,5],[3,6]]
$f = array_count_values(str_word_count(strtolower('the cat and the hat and the bat'), 1));
arsort($f); print_r(array_slice($f, 0, 3, true));                      // the=3, and=2, cat=1
```

### CT-10 SQL drill (expected results on the seed data)

| # | Statement (summary) | Expected |
| --- | --- | --- |
| 1 | `SELECT name, price FROM products ORDER BY price DESC LIMIT 3;` | Power Bank 10000 4200, PHP and MySQL Guide 3200, Learning Web Design 2800 |
| 2 | `… GROUP BY c.id HAVING COUNT(*) >= 2 ORDER BY avg_price DESC` with `ROUND(AVG(price),2)` | Books 3000.00, Electronics 2233.33, Stationery 315.00 |
| 3 | `WHERE stock < 20` | Power Bank 10000, PHP and MySQL Guide, Learning Web Design |
| 4 | `SELECT SUM(price * stock) FROM products;` | 312750.00 |
| 5 | `INSERT INTO categories (name) VALUES ('Toys'); INSERT INTO products (category_id, name, price, stock) VALUES (LAST_INSERT_ID(), 'Puzzle', 899.00, 15);` (run as root) | 2 rows inserted; product has the new category id |
| 6 | `LEFT JOIN order_items … WHERE oi.order_id IS NULL` | All 8 original products before any order exists |

### CT-11 Security review

| Defect | Impact | Fix |
| --- | --- | --- |
| String-built SQL | SQL injection (`' OR '1'='1`) | PDO prepared statement |
| `md5()` password | Fast, unsalted hash; cracked in seconds | `password_hash` / `password_verify`; compare in PHP not SQL |
| No CSRF token | Forged login/POST actions | `csrf_field()` and `csrf_check()` |
| No `session_regenerate_id` | Session fixation | Regenerate after login |
| Unescaped `$_GET["name"]` | Reflected XSS | `e()` or avoid echoing user input |
| Session stores e-mail, no validation | Identity confusion, undefined index warnings | Store user id; validate with `filter_var` |
| No error handling / cookie flags | Leaks and theft | Exception handler, HttpOnly + SameSite cookie parameters |

```
$st = db()->prepare('SELECT id, password_hash FROM users WHERE email = ?');
$st->execute([trim((string)($_POST['email'] ?? ''))]);
$u = $st->fetch();
if ($u && password_verify((string)($_POST['password'] ?? ''), $u['password_hash'])) {
    session_regenerate_id(true);
    $_SESSION['uid'] = (int)$u['id'];
    redirect('products.php');
}
```

### CT-12 CSV and EXPLAIN

```php
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
```

Plan 2 uses `idx_prod_name` (`type: range`, 111 rows) because the search value has a known prefix and the index is sorted from the first character. Plan 1 scans all 5008 rows (`type: ALL`) because `LIKE '%12%'` begins with a wildcard, so no starting point exists in the sorted index.

### CT-13 Cookie audit and MVC card sort

| Header | Problems | Fix |
| --- | --- | --- |
| 1 | Session identifier without `HttpOnly`, `Secure`, `SameSite` | `sid=…; Path=/; HttpOnly; Secure; SameSite=Lax` |
| 2 | Acceptable: a preference cookie holds no secret, has a lifetime and `SameSite` | Optionally add `Secure` |
| 3 | `auth=1` is guessable and forgeable; broad `Domain`; no `HttpOnly`/`SameSite` | Store a random session ID server-side; drop `Domain`; add flags; consider `__Host-` prefix |

| Snippet | Part |
| --- | --- |
| `SELECT * FROM notes` | Model |
| `<h1><?= esc($title) ?></h1>` | View |
| `$this->request->getPost("title")` | Controller |
| `$validationRules = [...]` | Model |
| `return view("notes/index")` | Controller |
| `<form method="post">` | View |
| `redirect()->to("/notes")` | Controller |
| `$model->paginate(5)` | Controller calls Model (query logic belongs to the model) |
| `password_hash($pw, PASSWORD_DEFAULT)` | Model (business rule) – accept Controller if the student justifies it |

### CT-15 Theme token and shortcode

```
"settings": {
  "color": { "palette": [ { "slug": "accent", "name": "Accent", "color": "#b45309" } ] },
  "typography": { "fontSizes": [
    { "slug": "small", "name": "Small", "size": "0.875rem" },
    { "slug": "xl", "name": "Extra large", "size": "2rem" } ] }
}
// plugin: add_shortcode('year', fn(): string => esc_html(wp_date('Y')));
```

Check **Styles → Colors** in the Site Editor: both parent and new colours should be listed. If the parent’s colours disappeared, copy them into the child’s palette array.

### CT-16 Compose review

| Problem | Fix |
| --- | --- |
| Unpinned image `mariadb` | `docker.io/library/mariadb:lts` (fully qualified, tagged) |
| Weak root password in the file | Random root password; credentials from `.env` that is in `.gitignore` |
| Database port published on all interfaces | Remove `ports` (service-to-service access needs none) or bind `127.0.0.1:3306:3306` |
| Web on port 80, all interfaces; rootless cannot bind below 1024 | `127.0.0.1:8090:80` |
| No volume | Named volume `dbdata:/var/lib/mysql` |
| `depends_on` does not wait for readiness; no application database/user | Healthcheck plus `condition: service_healthy`; set `MARIADB_DATABASE`, `MARIADB_USER`, `MARIADB_PASSWORD` |
