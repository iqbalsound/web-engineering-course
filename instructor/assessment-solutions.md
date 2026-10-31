# Assessment solutions

> **Confidential:** Remove Part B and Part C before issuing papers to students.

## A1 Model Answer (4 marks)

| Aspect | Two-tier | Three-tier |
| --- | --- | --- |
| Structure | Browser or thick client talks directly to the database server | Browser → web/application server (Apache + PHP-FPM) → MariaDB |
| Technology choice | Client app + MariaDB | Apache/Nginx, PHP or Node.js, MariaDB, optional cache |
| Advantages | Simple, quick to build, fewer servers | Database hidden from users, business rules in one place, each tier scales separately, easier security controls, replaceable parts |
| Drawbacks | Database exposed, rules duplicated in clients, poor scaling at semester start, hard updates | More components, extra latency, needs deployment and monitoring skills |
| Verdict | Rejected for the portal | **Chosen**: security of results and fees data, scalability at peak load |

| MVC part | Items for “Register for a course” | Responsibility |
| --- | --- | --- |
| Models | `Student`, `Course`, `Enrollment` | Prerequisite check, credit limit, seat availability, storing the enrolment |
| Views | `course_list`, `confirmation` | Show available courses; show result or errors |
| Controller | `EnrollmentController::register` | Validate request, call models, choose view, redirect |

1. Browser sends `POST /enrol` over HTTPS (presentation → application).
2. Web server hands the request to PHP; router selects `EnrollmentController::register` (application).
3. Filter checks login and CSRF token (application).
4. Controller validates input (application).
5. `Enrollment` model checks prerequisites and seats (application, reads data tier).
6. Model writes the enrolment in a transaction (data tier).
7. Controller selects the `confirmation` view (application).
8. HTML response returns to the browser (presentation).

**HTTP evidence (sample).** 200: request `GET /week01/index.html`, headers `Content-Type`, `Content-Length`, means success. 404: `GET /missing.html`, means the path does not exist. 304: `GET` with `If-None-Match`, means the cached copy is valid and no body is sent, which saves bandwidth for static timetable files at peak time. **Marking:** award Task 1: diagrams 0.75 + table 0.5 + decision 0.25; Task 2: 0.5 + 0.5; Task 3: 0.25 per status and 0.25 for the caching argument; Task 4: 0.5.

## A2 Model Solution (formative)

Changes to `main.js` (HTML: add `data-key` to each `th`, a `#filter` input and a `#bad` status element). Rows carry `data-id`, and edits look the student up by id so they stay correct under sorting and filtering.

**A2 key – additions**

```
let sortKey = null, sortDir = 1, filterText = '';
const val = v => (v !== '' && !isNaN(v) ? Number(v) : String(v).toLowerCase());
const view = () => {
  let list = students.filter(s => (s.name + ' ' + s.email).toLowerCase().includes(filterText));
  if (sortKey) list = list.toSorted((a, b) => (val(a[sortKey]) > val(b[sortKey]) ? 1 : val(a[sortKey]) < val(b[sortKey]) ? -1 : 0) * sortDir);
  return list;
};
// in render(): iterate view(), set data-id on the editable cell, then
document.querySelector('#bad').textContent = students.filter(s => !EMAIL.test(s.email)).length + ' invalid e-mail(s)';

document.querySelector('#t thead').addEventListener('click', e => {
  const th = e.target.closest('th[data-key]'); if (!th) return;
  sortDir = sortKey === th.dataset.key ? -sortDir : 1; sortKey = th.dataset.key; render();
});
document.querySelector('#filter').addEventListener('input', e => { filterText = e.target.value.trim().toLowerCase(); render(); });
// editing: const s = students.find(x => String(x.id) === td.dataset.id);

let text;
try {
  const res = await fetch(base + 'students.csv', { signal: AbortSignal.timeout(5000) });
  if (!res.ok) throw new Error('HTTP ' + res.status);
  text = await res.text();
} catch (err) {
  document.querySelector('#msg').textContent = 'Could not load students.csv (' + err.name + ').';
  text = 'id,name,email,marks';
}
```

**Marking notes:** R1 sorts by marks 74, 88, 91 then reversed (numeric, not text order). R2 “bil” leaves only Bilal. R3 shows “1 invalid e-mail(s)”. R4 handles both a 404 and a timeout without an uncaught exception. Typical errors: editing by array index after sorting (wrong record changes), sorting marks as strings (100 before 90), using `innerHTML` with CSV data.

## A3 Model Solution (6 marks)

**src/bootstrap.php additions (call flash_show() inside page_start())**

```
function flash(string $msg, string $type = 'info'): void { $_SESSION['flash'][] = [$type, $msg]; }
function flash_show(): void {
    foreach ($_SESSION['flash'] ?? [] as [$t, $m]) { echo '<p role="status" class="flash-' . e($t) . '">' . e($m) . '</p>'; }
    unset($_SESSION['flash']);
}
function require_admin(): array {
    $u = require_login();
    if ($u['role'] !== 'admin') { http_response_code(403); exit('Forbidden'); }
    return $u;
}
```

**public/orders.php (F1)**

```php
<?php
declare(strict_types=1);
require __DIR__ . '/../src/bootstrap.php';
$user = require_login();
$st = db()->prepare('SELECT o.id, o.created_at, o.total, p.name, oi.qty, oi.unit_price
    FROM orders o JOIN order_items oi ON oi.order_id = o.id JOIN products p ON p.id = oi.product_id
    WHERE o.user_id = ? ORDER BY o.id DESC, p.name');
$st->execute([$user['id']]);               // ownership enforced in SQL
$orders = [];
foreach ($st as $r) { $orders[$r['id']]['head'] = $r; $orders[$r['id']]['lines'][] = $r; }
page_start('My orders');
foreach ($orders as $id => $o) {
    echo '<h2>Order #' . (int)$id . ' – ' . e($o['head']['created_at']) . ' – Rs ' . number_format((float)$o['head']['total'], 2) . '</h2><ul>';
    foreach ($o['lines'] as $l) { echo '<li>' . e($l['name']) . ' × ' . (int)$l['qty'] . ' @ ' . number_format((float)$l['unit_price'], 2) . '</li>'; }
    echo '</ul>';
}
if (!$orders) { echo '<p>No orders yet.</p>'; }
page_end();
```

**public/admin_product.php (F2)**

```php
<?php
declare(strict_types=1);
require __DIR__ . '/../src/bootstrap.php';
require_admin();
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $name  = trim((string)($_POST['name'] ?? ''));
    $price = filter_var($_POST['price'] ?? '', FILTER_VALIDATE_FLOAT);
    $stock = filter_var($_POST['stock'] ?? '', FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
    $cat   = filter_var($_POST['category_id'] ?? '', FILTER_VALIDATE_INT);
    if ($name === '' || mb_strlen($name) > 120) { $errors[] = 'Name is required (max 120).'; }
    if ($price === false || $price < 0)         { $errors[] = 'Price must be 0 or more.'; }
    if ($stock === false)                       { $errors[] = 'Stock must be a whole number.'; }
    if ($cat === false)                         { $errors[] = 'Choose a category.'; }
    $img = null;
    if (!$errors && ($_FILES['image']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
        $img = saveImage($_FILES['image'], 'products', $errors);     // generalised saveAvatar(): $sub folder
    }
    if (!$errors) {
        db()->prepare('INSERT INTO products (category_id, name, price, stock, image) VALUES (?,?,?,?,?)')
            ->execute([$cat, $name, $price, $stock, $img]);
        flash('Product added.', 'ok'); redirect('products.php');
    }
}
// form: csrf_field(), enctype="multipart/form-data", category <select> filled from the categories table
```

`saveImage(array $f, string $sub, array &$errors)` is `saveAvatar()` with the path `__DIR__ . "/../storage/$sub/"`; `$sub` must come from code, never from the user. Create the folder with the same SELinux rule (Rocky) or group permission (Kubuntu). Make a user an admin with `sudo mariadb shop -e "UPDATE users SET role='admin' WHERE email='you@example.com'"`.

| Security checklist item | Expected evidence |
| --- | --- |
| SQL injection | All queries use `prepare()` with placeholders; dynamic parts from allow-lists |
| XSS | `e()` on every echo of user or DB text; `textContent` in JavaScript |
| CSRF | `csrf_field()` in every POST form; `csrf_check()` at the top of every POST handler |
| Sessions | `session_regenerate_id(true)` at login; HttpOnly + SameSite cookie parameters; logout destroys the session |
| Uploads | Size, `finfo`, `getimagesize`, random name, folder outside `public/`, OS permission or SELinux label |
| Errors | `display_errors=0`, exception handler, log file in `storage/` |

## Q1 Key (4 marks)

| Q | Answer | Reason |
| --- | --- | --- |
| 1 | D | The fragment is used only by the browser |
| 2 | C | 404 Not Found |
| 3 | B | MVC organises code; tiers separate deployment layers |
| 4 | B | PUT replaces and is idempotent |
| 5 | C | `main` is unique and wraps primary content |
| 6 | B | `required` blocks empty submission |
| 7 | C | An id selector (1,0,0) beats class and element selectors |
| 8 | B | auto-fit with minmax gives responsive wrapping columns |

## Q2 Key (formative, 10 marks for feedback)

| Q | Answer | Reason |
| --- | --- | --- |
| 1 | C | Historic quirk: `typeof null` is `"object"` |
| 2 | C | `const` |
| 3 | B | map → [2,4,6]; filter > 2 → [4,6] |
| 4 | B | `Promise.all` |
| 5 | C | `node:events` |
| 6 | B | `computed()` derives from signals |
| 7 | B | `col-12 col-md-6` |
| 8 | B | AngularJS reached end-of-life in January 2022 |
| 9 | B | Utilities replace the Jumbotron |
| 10 | B | `data-bs-theme="dark"` |

## Q3 Key (6 marks)

| Q | Answer | Reason |
| --- | --- | --- |
| 1 | B | Prepared statements separate SQL from data |
| 2 | C | `password_hash()` (bcrypt/argon2) |
| 3 | B | Regeneration prevents session fixation |
| 4 | C | HttpOnly hides the cookie from JavaScript |
| 5 | B | Row locks until commit prevent overselling |
| 6 | C | `hash_equals` is timing-safe |
| 7 | B | Outside the web root with a random name |
| 8 | B | Hide errors from users, log them |

| Q | Model answer | Marking |
| --- | --- | --- |
| 9 | The browser can be tampered with, so prices must come from the database. Reading them inside the transaction (with row locks) makes price and stock consistent at the moment the order is written. | 1: tamper risk (0.5) + transaction/consistency (0.5) |
| 10 | `$st = $pdo->prepare("INSERT INTO users (name, email) VALUES (:n, :e)"); $st->execute([":n" => $name, ":e" => $email]);` | 0.5 statement with named placeholders, 0.5 execute with bound values |

## Section A Key (10 marks, CLO_1)

| Q | 1 | 2 | 3 | 4 | 5 | 6 | 7 | 8 | 9 | 10 |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| Ans. | B | B | C | B | A | B | B | C | B | B |

## Section B Model Solution (10 marks, CLO_2)

**index.html**

```html
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Campus Event Board</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>Campus Event Board</h1>
    <nav aria-label="Primary"><a href="#search">Search</a> <a href="#events">Events</a></nav>
  </header>
  <main>
    <section id="search">
      <h2>Find an event</h2>
      <form id="filter" action="#events" method="get">
        <p><label for="q">Title</label> <input id="q" name="q" type="search" required></p>
        <p><label for="fee">Max fee (Rs)</label> <input id="fee" name="fee" type="number" min="0" step="100"></p>
        <button type="submit">Search</button>
      </form>
      <p id="count" role="status"></p>
    </section>
    <section id="events" class="grid">
      <article class="card" data-fee="0"><h3>Linux Install Day</h3><p>Free</p></article>
      <article class="card" data-fee="500"><h3>PHP Workshop</h3><p>Rs 500</p></article>
      <article class="card" data-fee="800"><h3>Web Design Contest</h3><p>Rs 800</p></article>
      <article class="card" data-fee="0"><h3>Career Talk</h3><p>Free</p></article>
      <article class="card" data-fee="1500"><h3>Cloud Bootcamp</h3><p>Rs 1500</p></article>
      <article class="card" data-fee="300"><h3>Git Basics</h3><p>Rs 300</p></article>
    </section>
  </main>
  <footer><small>&copy; 2026 Hamdard University</small></footer>
  <script src="app.js"></script>
</body>
</html>
```

**style.css**

```css
*, *::before, *::after { box-sizing: border-box; }
body { margin: 0; font-family: system-ui, sans-serif; line-height: 1.5; }
header, main, footer { padding: 1rem; }
.grid { display: grid; gap: 1rem; grid-template-columns: repeat(auto-fit, minmax(14rem, 1fr)); }
.card { padding: 1rem; border: 1px solid #cbd5e1; border-radius: .5rem; transition: transform .2s, box-shadow .2s; }
.card:hover { transform: translateY(-3px); box-shadow: 0 4px 12px #0003; }
@media (max-width: 600px) { .grid { grid-template-columns: 1fr; } }
```

**app.js**

```js
const q = document.querySelector('#q');
const fee = document.querySelector('#fee');
const cards = [...document.querySelectorAll('.card')];
const count = document.querySelector('#count');
function apply() {
  const term = q.value.trim().toLowerCase();
  const max = fee.value === '' ? Infinity : Number(fee.value);
  let shown = 0;
  for (const c of cards) {
    const ok = c.querySelector('h3').textContent.toLowerCase().includes(term) && Number(c.dataset.fee) <= max;
    c.hidden = !ok;
    if (ok) shown++;
  }
  count.textContent = shown + ' event(s) shown';
}
q.addEventListener('input', apply);
fee.addEventListener('input', apply);
document.querySelector('#filter').addEventListener('submit', e => e.preventDefault());
apply();
```

| Part | Full marks | Typical deductions |
| --- | --- | --- |
| (a) 2 | All four landmarks, one `h1` | −0.5 each missing landmark; −0.5 for two `h1` |
| (b) 1 | `required` text input, number input, labels | −0.5 no labels; −0.5 wrong type |
| (c) 3 | Grid, single column < 600 px, hover | −1 floats/flex instead of grid; −1 no media query; −1 no hover |
| (d) 3 | Filters while typing and by fee, count correct, `textContent` only | −1 only on submit; −1 count wrong; −1 `innerHTML` |
| (e) 1 | Validator and console clean | −0.5 each class of error |

**Q1 model answer (output: Mon: 200, Tue: 400, Wed: 0, Top day: Tue)**

```php
<?php
$best = null; $bestTotal = -1;
foreach ($sales as $day => $amounts) {
    $total = array_sum($amounts);          // array_sum([]) is 0, so empty days are safe
    echo "$day: $total\n";
    if ($total > $bestTotal) { $bestTotal = $total; $best = $day; }
}
echo "Top day: $best\n";
```

**Q2 model answer**

```
-- (a)
SELECT p.name, c.name AS category FROM products p JOIN categories c ON c.id = p.category_id
WHERE p.price > 1000 ORDER BY p.price DESC;
-- (b)  (on the seed data: Electronics 1, Books 2)
SELECT c.name, COUNT(*) AS low_stock FROM products p JOIN categories c ON c.id = p.category_id
WHERE p.stock < 20 GROUP BY c.id, c.name HAVING COUNT(*) >= 1;
-- (c)
ALTER TABLE products ADD COLUMN sku VARCHAR(20) UNIQUE;
UPDATE products p JOIN categories c ON c.id = p.category_id SET p.price = p.price * 1.10 WHERE c.name = 'Stationery';
```

| Q3 blank | Answer | Marks |
| --- | --- | --- |
| (1) | `?` (or `:e` when the next line passes `[":e" => …]`) | 0.5 |
| (2) | `$_POST["email"]` (trimmed value accepted) | 0.5 |
| (3) | `password_verify` | 0.5 |
| (4) | `session_regenerate_id` | 0.5 |
| (5) | `(int)` | 0.5 |
| (6) | `exit` (or `die`) | 0.5 |

**Q4.** (a) HttpOnly: JavaScript cannot read the cookie (limits XSS theft). Secure: sent only over HTTPS (stops sniffing). SameSite: not sent with cross-site requests (limits CSRF). Any two correctly explained flags = 1 mark. (b) Without a token any other site could make the browser call the logout URL and sign the user out; the token proves the request came from the shop’s own form (1 mark).
