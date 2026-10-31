# Web Engineering (SEWE-6109) – course repository

Lecture notes, hands-on labs, assessments and solutions for **Web Engineering** (BSSE, 5th semester, Hamdard University – Karachi Campus).
Every lab exists in two complete versions: **A – Rocky Linux 10** and **B – Kubuntu 26.04 LTS**. All tools are free and open source.

## Repository layout

```text
web-engineering-course/
├── setup/                  Lab 0: base environment scripts (rocky10/, kubuntu2604/)
├── labs/
│   └── weekNN-topic/       16 weekly packs
│       ├── README.md       goal, tools, deliverables, verification checklist, review questions
│       ├── lecture-notes.md
│       ├── rocky10.md      Version A step-by-step
│       ├── kubuntu2604.md  Version B step-by-step
│       └── code/           reference source files used by the lab
├── assessments/
│   ├── assignments/        A1, A2, A3 (+ solution/ for code)
│   ├── quizzes/            Q1, Q2, Q3 + answer keys
│   ├── midterm/            paper, check.sh auto-checker, model solution
│   ├── oht/                hourly test + solution
│   └── class-tasks/        CT-01 … CT-16 (+ solution/)
├── instructor/             solutions, expected evidence, troubleshooting, rubrics, record sheets
├── docs/                   the Word documents (lecture notes, solution manual, assessment pack)
└── .github/workflows/      CI: Node tests, PHP lint, shell/JSON/YAML checks
```

## The 16 weeks

| Wk | Topic | CLO | Lab | OS steps |
| --- | --- | --- | --- | --- |
| 1 | [Internet, HTTP, Web Architectures and HTML5 Foundations](labs/week01-internet-http-html5) | CLO_1 | Own Web Server, HTTPS and First HTML5 Page | [A](labs/week01-internet-http-html5/rocky10.md) · [B](labs/week01-internet-http-html5/kubuntu2604.md) |
| 2 | [HTML5 Forms, Semantic Elements and Accessibility](labs/week02-html5-forms-accessibility) | CLO_1 | Accessible Student Registration Form with Automated Linting | [A](labs/week02-html5-forms-accessibility/rocky10.md) · [B](labs/week02-html5-forms-accessibility/kubuntu2604.md) |
| 3 | [CSS3: Selectors, Modern Layout and Responsive Design](labs/week03-css3-responsive) | CLO_1 | Responsive Event Landing Page (Mobile-First) | [A](labs/week03-css3-responsive/rocky10.md) · [B](labs/week03-css3-responsive/kubuntu2604.md) |
| 4 | [JavaScript Fundamentals (ES2025 and Beyond)](labs/week04-javascript-fundamentals) | CLO_2 | Expense Tracker – Tested ES Module Library with a Browser UI | [A](labs/week04-javascript-fundamentals/rocky10.md) · [B](labs/week04-javascript-fundamentals/kubuntu2604.md) |
| 5 | [Advanced JavaScript: OOP, Async, CSV Data and Canvas / 3D](labs/week05-advanced-js-csv-canvas) | CLO_2 | CSV Student Explorer and Rotating 3D Cube (Vite Build) | [A](labs/week05-advanced-js-csv-canvas/rocky10.md) · [B](labs/week05-advanced-js-csv-canvas/kubuntu2604.md) |
| 6 | [Node.js and Modern Angular](labs/week06-nodejs-angular) | CLO_2 | Node REST API and Angular Course Dashboard | [A](labs/week06-nodejs-angular/rocky10.md) · [B](labs/week06-nodejs-angular/kubuntu2604.md) |
| 7 | [Bootstrap 5.3, UI/UX and Component-Based Interfaces](labs/week07-bootstrap-ux) | CLO_2 | Responsive Product Catalogue with Carousel, Pagination and Dark Mode | [A](labs/week07-bootstrap-ux/rocky10.md) · [B](labs/week07-bootstrap-ux/kubuntu2604.md) |
| 8 | [Mid-Term Examination (Weeks 1–7)](labs/week08-midterm) | CLO_1, CLO_2 | Mid-Term Practical Environment and Automatic Checker | [A](labs/week08-midterm/rocky10.md) · [B](labs/week08-midterm/kubuntu2604.md) |
| 9 | [PHP Fundamentals and the Server-Side Stack](labs/week09-php-fundamentals) | CLO_2 | PHP-FPM Stack, Grade Report and Matrix Exercises with PHPStan | [A](labs/week09-php-fundamentals/rocky10.md) · [B](labs/week09-php-fundamentals/kubuntu2604.md) |
| 10 | [SQL, MariaDB, PDO, CAPTCHA and Secure File Upload](labs/week10-sql-pdo-captcha-upload) | CLO_3 | MariaDB Schema, PDO Connection, CAPTCHA Registration and Avatar Upload | [A](labs/week10-sql-pdo-captcha-upload/rocky10.md) · [B](labs/week10-sql-pdo-captcha-upload/kubuntu2604.md) |
| 11 | [Full-Stack PHP: Templates, Authentication, Products, Cart and Error Handling](labs/week11-php-mini-shop) | CLO_3 | Mini-Shop: Login, Product List, Session Cart and Transactional Checkout | [A](labs/week11-php-mini-shop/rocky10.md) · [B](labs/week11-php-mini-shop/kubuntu2604.md) |
| 12 | [Queries, Result Handling, File Handling and Hourly Test](labs/week12-queries-files-oht) | CLO_3 | Product Search, CSV Import/Export and Thumbnail Generation | [A](labs/week12-queries-files-oht/rocky10.md) · [B](labs/week12-queries-files-oht/kubuntu2604.md) |
| 13 | [Email, Cookies, Sessions and MVC Frameworks (CodeIgniter 4 and Laravel)](labs/week13-email-sessions-mvc) | CLO_3 (revisits CLO_1: MVC) | Mailpit, Secure Sessions and a CodeIgniter 4 Notes Application | [A](labs/week13-email-sessions-mvc/rocky10.md) · [B](labs/week13-email-sessions-mvc/kubuntu2604.md) |
| 14 | [WordPress: Architecture, Installation, Plugins and the Block Editor](labs/week14-wordpress-install) | CLO_3 | WordPress with WP-CLI, Plugins and a Home Page Built from Blocks | [A](labs/week14-wordpress-install/rocky10.md) · [B](labs/week14-wordpress-install/kubuntu2604.md) |
| 15 | [Creating and Configuring a Blog: Themes, Custom Content, Security and Backups](labs/week15-wordpress-blog-security) | CLO_3 | Configure the Blog, Child Theme, “Projects” Plugin, Hardening and Automatic Backup | [A](labs/week15-wordpress-blog-security/rocky10.md) · [B](labs/week15-wordpress-blog-security/kubuntu2604.md) |
| 16 | [Capstone Deployment with Containers, Course Revision and Final-Exam Preparation](labs/week16-containers-capstone) | CLO_1, CLO_2, CLO_3 | Containerised Capstone: Apache/PHP + MariaDB with Podman Compose and a Quadlet Service | [A](labs/week16-containers-capstone/rocky10.md) · [B](labs/week16-containers-capstone/kubuntu2604.md) |

## Quick start

1. Install the base system: see [`setup/README.md`](setup/README.md).
2. Open a week folder, read its `README.md`, then follow `rocky10.md` **or** `kubuntu2604.md`.
3. Copy files from `code/` into `/var/www/webeng/weekNN/` (or the project folder named in the steps) and run the verification checklist.

```bash
git clone git@github.com:iqbalsound/web-engineering-course.git
cd web-engineering-course
node --test "labs/week04-javascript-fundamentals/code/*.test.js"   # example: run the Week 4 unit tests
```

## Notes

- **Versions:** Rocky 10 ships PHP 8.3 and MariaDB 10.11; Kubuntu 26.04 ships PHP 8.5 and MariaDB 11.8. Code is written for PHP 8.3 and later.
- **Generated projects:** Angular, CodeIgniter 4, Laravel and WordPress are created by their own installers during the labs; this repo stores only the files you add or change (overlays).
- **Secrets:** passwords in the labs (for example `ChangeMe_2026!`) are classroom placeholders. Never reuse them.
- **Instructor material** is in `instructor/` and in `assessments/**/solution/`. Keep it private if the repository is public.

## Licence

MIT – see [`LICENSE`](LICENSE).
