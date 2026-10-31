# Week 2: HTML5 Forms, Semantic Elements and Accessibility

| Syllabus lectures | CLO | PLO | Bloom | Assessment |
| --- | --- | --- | --- | --- |
| Lec 3–4 | CLO_1 | PLO_2 | C2 (Understanding) | A1 due |

## Lab: Accessible Student Registration Form with Automated Linting

Build a semantic, accessible, natively validated registration form using Pakistani CNIC and mobile patterns, then lint and format it using a Node.js toolchain.

### Free and open-source tools
- Node.js 24 LTS + npm (MIT)
- html-validate (MIT), Prettier (MIT)
- Firefox Accessibility Inspector (MPL-2.0)

### Deliverables
- `register.html` and `thanks.html` under `/var/www/webeng/week02/`
- `npx html-validate` reports 0 errors
- Screenshot of the Firefox Accessibility tree showing landmarks
- Form submits with GET and the query string is shown on `thanks.html`

### Contents of this folder
- [`lecture-notes.md`](lecture-notes.md) – the week's theory
- [`rocky10.md`](rocky10.md) – step-by-step lab, **Version A (Rocky Linux 10)**
- [`kubuntu2604.md`](kubuntu2604.md) – step-by-step lab, **Version B (Kubuntu 26.04 LTS)**
- `code/register.html`
- `code/thanks.html`

`code/` holds the reference source files exactly as printed in the lab manual (they are the files the labs ask you to create).


### Verification checklist
| # | Check | Expected Result |
| --- | --- | --- |
| 1 | `npx html-validate register.html thanks.html` | Exit code 0, no errors |
| 2 | Submit with an invalid CNIC | Browser blocks submit and shows a validation bubble |
| 3 | Tab through the form | Logical order, visible focus ring, skip link works |
| 4 | Submit valid data | `thanks.html?name=...&cnic=...` shows decoded values |
| 5 | Accessibility inspector | Landmarks banner / navigation / main / contentinfo present; no unlabeled inputs |

### Stretch goals
- Add a `<dialog>` that confirms the entry before submission.
- Style invalid fields with `input:user-invalid { outline: 2px solid #b00020 }`.
- Add a Prettier + html-validate `npm run check` script and a Git pre-commit hook.


### Review questions
1. Why is `<main>` preferable to `<div id="main">`?
2. When should a form use GET and when POST? Give one example of each.
3. Write a pattern for a Pakistani mobile number such as 0312-1234567 and explain each part.
4. Why must the server validate data that the browser already validated?
5. List four WCAG 2.2 AA checks you performed in the lab.

---
Instructor solutions: [`instructor/solutions/week02-html5-forms-accessibility.md`](../../instructor/solutions/week02-html5-forms-accessibility.md)
