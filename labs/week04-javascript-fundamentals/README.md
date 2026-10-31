# Week 4: JavaScript Fundamentals (ES2025 and Beyond)

| Syllabus lectures | CLO | PLO | Bloom | Assessment |
| --- | --- | --- | --- | --- |
| Lec 7–8 | CLO_2 | PLO_5 | C3 (Applying) | Q1 (CLO_1, 4 marks) |

## Lab: Expense Tracker – Tested ES Module Library with a Browser UI

Write a pure-function library for expenses, test it with `node --test`, lint it with ESLint, and attach a small browser UI served by Apache.

### Free and open-source tools
- Node.js 24 LTS test runner `node:test` (MIT)
- ESLint 9 flat config + `@eslint/js` (MIT)
- Prettier (MIT)

### Deliverables
- `expenses.js`, `expenses.test.js`, `app.js`, `index.html` in `/var/www/webeng/week04/`
- All tests pass (`node --test`)
- ESLint clean
- Working UI that adds expenses and displays totals per category

### Contents of this folder
- [`lecture-notes.md`](lecture-notes.md) – the week's theory
- [`rocky10.md`](rocky10.md) – step-by-step lab, **Version A (Rocky Linux 10)**
- [`kubuntu2604.md`](kubuntu2604.md) – step-by-step lab, **Version B (Kubuntu 26.04 LTS)**
- `code/app.js`
- `code/eslint.config.js`
- `code/expenses.js`
- `code/expenses.test.js`
- `code/index.html`
- `code/package.json`

`code/` holds the reference source files exactly as printed in the lab manual (they are the files the labs ask you to create).


### Verification checklist
| # | Check | Expected Result |
| --- | --- | --- |
| 1 | `node --test` | 3 tests pass, 0 fail |
| 2 | `npx eslint .` | No errors |
| 3 | Add expense with empty title in the UI | Alert “title required” |
| 4 | Add three expenses | Totals per category and grade label appear |
| 5 | `curl -sI .../app.js` | `Content-Type: text/javascript` |

### Stretch goals
- Persist expenses with `localStorage` and test the serialiser.
- Add `npm test` / `npm run lint` scripts and a Git pre-commit hook.
- Implement `totalsByCategory` with `Object.groupBy` and compare readability.


### Review questions
1. Explain hoisting and the temporal dead zone with a short example.
2. What is the difference between `==` and `===`? Predict `0 == ""` and `0 === ""`.
3. How does a closure keep a private counter?
4. Rewrite a `for` loop using `map` and `filter`.
5. Why should unit tests target pure functions rather than DOM code?

---
Instructor solutions: [`instructor/solutions/week04-javascript-fundamentals.md`](../../instructor/solutions/week04-javascript-fundamentals.md)
