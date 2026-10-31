# Week 8 solutions: Mid-Term Practical Environment

## Expected results and evidence
| Check | Expected result / model evidence |
| --- | --- |
| `./check.sh 24-001` with the model solution | All lines PASS; “Automatic score: 6” |
| MCQ key (lab manual sample) | 1 C, 2 B, 3 B, 4 C, 5 B, 6 B, 7 C, 8 C, 9 B, 10 B |
| Empty student folder | FAIL for page, header, nav, main, footer, form, grid, media query, listener, validator (see checker fix below) |
| `git log --oneline` | One commit “Mid-term submission 24-001” |
| `sha256sum ~/mid-submissions.tgz` | 64-hex-digit hash recorded in the exam register |

**Model output of check.sh**

```
PASS  page served (HTTP 200)
PASS  <header> present
PASS  <nav> present
PASS  <main> present
PASS  <footer> present
PASS  exactly one h1
PASS  form attributes
PASS  CSS grid used
PASS  media query used
PASS  JS event listener
PASS  no innerHTML
PASS  html-validate clean
Automatic score: 6 (instructor adds manual marks)
```

## Worked solutions
#### Model solution to the sample practical (Library Corner)

**index.html**

```html
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Library Corner</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>Library Corner</h1>
    <nav aria-label="Primary"><a href="#search">Search</a> <a href="#books">Books</a></nav>
  </header>
  <main>
    <section id="search">
      <h2>Find a book</h2>
      <form id="filter" action="#books" method="get">
        <p><label for="q">Title</label> <input id="q" name="q" type="search" required></p>
        <p><label for="max">Max price (Rs)</label> <input id="max" name="max" type="number" min="0" step="50"></p>
        <button type="submit">Search</button>
      </form>
      <p id="count" role="status"></p>
    </section>
    <section id="books" class="grid">
      <article class="card" data-price="1200"><h3>Clean Code</h3><p>Rs 1200</p></article>
      <article class="card" data-price="900"><h3>Learning PHP</h3><p>Rs 900</p></article>
      <article class="card" data-price="1500"><h3>Eloquent JavaScript</h3><p>Rs 1500</p></article>
      <article class="card" data-price="700"><h3>HTML and CSS</h3><p>Rs 700</p></article>
      <article class="card" data-price="1800"><h3>Linux Basics</h3><p>Rs 1800</p></article>
      <article class="card" data-price="600"><h3>SQL in Ten Minutes</h3><p>Rs 600</p></article>
    </section>
  </main>
  <footer><small>&copy; 2026 Library Corner</small></footer>
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
const max = document.querySelector('#max');
const cards = [...document.querySelectorAll('.card')];
const count = document.querySelector('#count');

function apply() {
  const term = q.value.trim().toLowerCase();
  const limit = max.value === '' ? Infinity : Number(max.value);
  let shown = 0;
  for (const c of cards) {
    const ok = c.querySelector('h3').textContent.toLowerCase().includes(term) && Number(c.dataset.price) <= limit;
    c.hidden = !ok;
    if (ok) shown++;
  }
  count.textContent = shown + ' book(s) shown';
}
q.addEventListener('input', apply);
max.addEventListener('input', apply);
document.querySelector('#filter').addEventListener('submit', e => e.preventDefault());
apply();
```

#### Checker fix: empty folders must not earn the “no innerHTML” point

With no `.js` file `grep` fails, so the original line awards the point. Replace that line of `check.sh` with:

```
if ls $DIR/*.js >/dev/null 2>&1 && ! grep -Eq 'innerHTML' $DIR/*.js; then ok "no innerHTML" 1; else bad "innerHTML used or no JS"; fi
```

#### How the automatic checks support the 10-mark rubric

| Rubric row | Marks | Supported by automatic check | Manual check |
| --- | --- | --- | --- |
| Semantic structure | 2 | header, nav, main, footer, one h1 | Sensible use of `section`, `article`, headings order |
| Form attributes | 1 | `required`, `type="number"` | Labels bound to inputs |
| Responsive grid | 3 | `display: grid`, `@media` | Single column below 600 px, hover effect, no overflow |
| JavaScript filter + count | 3 | listener, no `innerHTML` | Filters while typing; count correct |
| Validity & cleanliness | 1 | `html-validate` | No console errors |

## Troubleshooting guide
| Symptom | Likely cause | Fix (Rocky 10 / Kubuntu 26.04) |
| --- | --- | --- |
| `check.sh: html-validate errors` for a correct page | Typical: `<button>` without `type`, `border` attribute on a table, inline style | Add `type="submit"`, move presentation to CSS; read `npx html-validate file` output |
| `curl` returns 403 for a student folder | Rocky: wrong label. Kubuntu: folder not readable by www-data | Rocky: `sudo restorecon -Rv /var/www/webeng/mid`. Kubuntu: `chmod -R g+rX /var/www/webeng/mid` |
| `npx: not found` inside the script | Non-interactive shell does not load nvm | Add `source ~/.nvm/nvm.sh` near the top of `check.sh` |
| New files in the Rocky exam folder labelled wrongly | Files were moved, not created | Run `restorecon` after copying; `semanage fcontext` rule from the lab keeps defaults correct |

## Viva prompts and marking notes
- Ask the student to explain two defects found by the checker and how they fixed them.
- The checker supports but never replaces manual marking; the instructor confirms every rubric row.

## Answers to review questions
1. The objective paper assesses CLO_1 (classification, HTTP, architectures, HTML5 knowledge, 10 marks). The practical assesses CLO_2 (developing pages with HTML, CSS and JavaScript, 10 marks).
2. Three-tier splits a system into presentation, application and data tiers that can run and scale separately; MVC organises the code inside the application tier into model, view and controller. A site normally uses both.
3. A block-scoped variable (`let`, `const`) exists only inside its `{}` block; a function-scoped variable (`var`) exists in the whole function and is hoisted.
4. `html-validate` (markup quality), `check.sh` (requirements), Git (evidence/history); optionally Prettier and ESLint.
5. Typical answers: using `innerHTML`, missing `label`/`alt`, forgetting the viewport meta tag, deploying with the wrong path. Accept any two honest, specific mistakes with the fix.
