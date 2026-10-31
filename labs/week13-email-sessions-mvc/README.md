# Week 13: Email, Cookies, Sessions and MVC Frameworks (CodeIgniter 4 and Laravel)

| Syllabus lectures | CLO | PLO | Bloom | Assessment |
| --- | --- | --- | --- | --- |
| Lec 25–26 | CLO_3 (revisits CLO_1: MVC) | PLO_4 | C4 (Analyzing) | — |

## Lab: Mailpit, Secure Sessions and a CodeIgniter 4 Notes Application

Catch e-mail with Mailpit in a Podman container, observe cookie and session behaviour with curl, then build a CRUD “Notes” application with CodeIgniter 4 (migrations, model validation, CSRF, flash data, pagination). Finish with a guided Laravel demo.

### Free and open-source tools
- Podman (Apache-2.0) + Mailpit (MIT)
- Symfony Mailer (MIT)
- CodeIgniter 4 (MIT)
- Laravel (MIT) – demo
- PHP built-in server `php -S`

### Deliverables
- `mail/send.php` message visible in the Mailpit inbox (HTML + text)
- `state.php` demo with cookie jar output explaining each flag
- CodeIgniter project `ci-notes` with working add / list / delete / pagination and CSRF
- Laravel `route:list` screenshot and a one-paragraph comparison

### Contents of this folder
- [`lecture-notes.md`](lecture-notes.md) – the week's theory
- [`rocky10.md`](rocky10.md) – step-by-step lab, **Version A (Rocky Linux 10)**
- [`kubuntu2604.md`](kubuntu2604.md) – step-by-step lab, **Version B (Kubuntu 26.04 LTS)**
- `code/ci-notes-overlay/app/Config/Routes.snippet.txt`
- `code/ci-notes-overlay/app/Controllers/Notes.php`
- `code/ci-notes-overlay/app/Database/Migrations/2026-10-30-090000_CreateNotes.php`
- `code/ci-notes-overlay/app/Models/NoteModel.php`
- `code/ci-notes-overlay/app/Views/notes/index.php`
- `code/mail/send.php`
- `code/public/state.php`

`code/` holds the reference source files exactly as printed in the lab manual (they are the files the labs ask you to create).


### Verification checklist
| # | Check | Expected Result |
| --- | --- | --- |
| 1 | Mailpit UI `http://127.0.0.1:8025` | One message with subject “Reset your password”, HTML and text parts |
| 2 | `cat jar.txt` | `PHPSESSID` marked HttpOnly (`#HttpOnly_` prefix); `theme` cookie with future expiry |
| 3 | Second request visits counter | Increments from 1 to 2 using the same session |
| 4 | `php spark migrate` | `notes` table exists in MariaDB |
| 5 | POST /notes without token | Rejected (403 / error page) because the CSRF filter is active |
| 6 | Add six notes | Pagination appears after five; flash message shown after save and delete |
| 7 | Title shorter than 3 characters | Validation error displayed and old input preserved |

### Stretch goals
- Use CodeIgniter’s `service("email")` with `email.SMTPHost=127.0.0.1`, `email.SMTPPort=1025` in `.env` to mail a note.
- Switch sessions to the database handler and inspect the table.
- Create a Laravel migration and compare the generated code with CodeIgniter.


### Review questions
1. Why are password-reset tokens stored hashed?
2. Explain `HttpOnly`, `Secure` and `SameSite` and which attack each reduces.
3. Place Model, View and Controller on a three-tier diagram and justify.
4. Give two reasons to choose CodeIgniter 4 and two to choose Laravel for a new project.
5. What problem does a database migration solve in a team?

---
Instructor solutions: [`instructor/solutions/week13-email-sessions-mvc.md`](../../instructor/solutions/week13-email-sessions-mvc.md)
