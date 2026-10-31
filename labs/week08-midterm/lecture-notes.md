# Week 8: Mid-Term Examination (Weeks 1–7) – lecture notes

### 8.1 Examination Blueprint

| Part | CLO | Marks | Time | Coverage |
| --- | --- | --- | --- | --- |
| Objective (MCQ) | CLO_1 | 10 | 30 min | Internet, HTTP, DNS, URL, architectures, HTML5 semantics, forms |
| Subjective / practical | CLO_2 | 10 | 90 min | HTML5 + CSS3 responsive page + JavaScript behaviour + deployment |

### 8.2 Revision Map

| Week | Must-know items |
| --- | --- |
| 1 | URL parts, HTTP methods / status codes, 1/2/3-tier vs MVC, HTML5 tags |
| 2 | Semantic elements, input types, validation attributes, GET vs POST, accessibility basics |
| 3 | Specificity, box model, Flexbox vs Grid, media / container queries, animation |
| 4 | `let/const`, hoisting, closures, array methods, destructuring, modules |
| 5 | Classes, inheritance, async/await, regex, CSV, canvas |
| 6 | Event loop, EventEmitter, callbacks vs promises, Angular signals / services |
| 7 | Grid classes, components, pagination, carousel, Jumbotron / Glyphicon replacements |

### 8.3 Sample Objective Questions (with answer key)

| # | Question | Options | Key |
| --- | --- | --- | --- |
| 1 | Which part of a URL is never sent to the server? | A scheme  B query  C fragment  D port | C |
| 2 | HTTP status for “resource moved permanently”? | A 200  B 301  C 404  D 500 | B |
| 3 | MVC is best described as… | A a network topology  B a code-organisation pattern  C a database type  D a protocol | B |
| 4 | Which element wraps the dominant page content? | A `section`  B `div`  C `main`  D `article` | C |
| 5 | Which attribute makes a field mandatory? | A `needed`  B `required`  C `validate`  D `must` | B |
| 6 | Which CSS feature lets a component respond to its parent’s width? | A media query  B container query  C `@import`  D `float` | B |
| 7 | Result of `typeof null`? | A "null"  B "undefined"  C "object"  D "number" | C |
| 8 | Which keyword declares a block-scoped, reassignable variable? | A var  B const  C let  D static | C |
| 9 | Node.js handles I/O concurrency mainly through… | A threads per request  B the event loop  C CGI  D forking | B |
| 10 | Which Bootstrap class gives 3 columns per row on large screens? | A `col-lg-3`  B `col-lg-4`  C `col-3`  D `col-md-12` | B |

### 8.4 Sample Practical Question (10 marks, CLO_2)

Create a one-page site “Library Corner” in `/var/www/webeng/mid/<rollno>/` with: (a) semantic header, nav, main, footer **[2]**; (b) a search form with `required` input and a number input for “max price” **[1]**; (c) a responsive CSS Grid of at least six book cards that becomes a single column below 600 px, with a hover effect **[3]**; (d) JavaScript that filters the cards by title as the user types and shows the visible count **[3]**; (e) no HTML validation errors and no console errors **[1]**.

| Criterion | Marks | Evidence |
| --- | --- | --- |
| Semantic structure | 2 | header / nav / main / footer present, one `h1` |
| Form attributes | 1 | `required`, `type="number"`, `min`, labels |
| Responsive grid | 3 | Grid, media query, hover, no overflow at 360 px |
| JavaScript filter + count | 3 | Works while typing; textContent used, not innerHTML |
| Validity & cleanliness | 1 | `html-validate` exit code 0; no console errors |
