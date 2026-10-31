# Week 8: Mid-Term Examination (Weeks 1–7)

| Syllabus lectures | CLO | PLO | Bloom | Assessment |
| --- | --- | --- | --- | --- |
| Lec 15–16 | CLO_1, CLO_2 | PLO_2, PLO_5 | C2–C3 | Mid-Term: Objective 10 (CLO_1) + Subjective/Practical 10 (CLO_2) |

## Lab: Mid-Term Practical Environment and Automatic Checker

Prepare per-student exam folders with correct permissions, deploy the exam site and verify it with a shell-based auto-checker. The same script is used by the instructor to pre-test the model solution.

### Free and open-source tools
- Bash, curl, grep, diff (GPL)
- html-validate (MIT)
- Git (GPL-2.0)

### Deliverables
- Exam folder `/var/www/webeng/mid/<rollno>/` with `index.html`, `style.css`, `app.js`
- `check.sh` report saved as `report.txt`
- Git commit of the final submission

### Contents of this folder
- [`lecture-notes.md`](lecture-notes.md) – the week's theory
- [`rocky10.md`](rocky10.md) – step-by-step lab, **Version A (Rocky Linux 10)**
- [`kubuntu2604.md`](kubuntu2604.md) – step-by-step lab, **Version B (Kubuntu 26.04 LTS)**
- `code/check.sh`
- `solution/` – model solution of the sample practical and the corrected `check.sh`

`code/` holds the reference source files exactly as printed in the lab manual (they are the files the labs ask you to create).


### Verification checklist
| # | Check | Expected Result |
| --- | --- | --- |
| 1 | `./check.sh 24-001` with the model solution | All automatic checks PASS |
| 2 | Empty folder | Page not served; checks FAIL gracefully without script errors |
| 3 | `git log --oneline` | At least one commit with the roll number |
| 4 | `sha256sum ~/mid-submissions.tgz` | Hash recorded for integrity |

### Stretch goals
- Add a Playwright test that types in the filter box and counts visible cards.
- Generate an HTML report from check.sh output.
- Run the checker inside a Podman container for a clean, repeatable environment.


### Review questions
1. Which CLO does each part of the mid-term assess and why?
2. Explain MVC versus three-tier in three sentences.
3. What is the difference between a block-scoped and a function-scoped variable?
4. Which tools in the practical enforce quality automatically?
5. Name two mistakes from this exam you will avoid in the final.

---
Instructor solutions: [`instructor/solutions/week08-midterm.md`](../../instructor/solutions/week08-midterm.md)
