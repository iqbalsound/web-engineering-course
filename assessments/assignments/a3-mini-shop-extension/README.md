| **Course** | SEWE-6109 Web Engineering | **CLO** | CLO_3 (C4) |
| --- | --- | --- | --- |
| **Issued** | Week 11 | **Due** | Week 12 (start of class) |
| **Marks** | 6 | **Mode** | Individual, Git repository + PDF security checklist |

Extend the Week 11 mini-shop (PHP 8.3 compatible code, MariaDB, PDO).

| Req. | Requirement | Notes |
| --- | --- | --- |
| F1 | **Order history** page for the logged-in user showing each order with date, lines and total | One JOIN query; a user must never see another user’s order |
| F2 | **Admin-only** page to add a product with name, category, price, stock and an optional image | Role check, CSRF, validation, secure upload stored outside the web root |
| F3 | **Flash-message helper** (`flash()` and `flash_show()`) used after login, add-to-cart, checkout and product creation | Messages are escaped and shown once |
| F4 | PHPStan level 6 reports **no errors** | Add docblocks where needed |
| F5 | A **one-page security checklist** (PDF) covering SQL injection, XSS, CSRF, session handling, upload handling and error handling, each with the file and line where you implemented it | Honest “not implemented” entries are marked down less than false claims |

| Criterion | Marks | Excellent means |
| --- | --- | --- |
| Order history (F1) | 1.5 | Correct JOIN, grouped display, ownership enforced |
| Admin add-product with upload (F2) | 2 | Role check, CSRF, validation, safe image handling, prepared statements |
| Flash helper (F3) | 0.5 | Reusable, escaped, shown once |
| PHPStan clean (F4) | 1 | Level 6, zero errors, evidence screenshot |
| Security checklist (F5) | 1 | Accurate, specific, evidence-based |
