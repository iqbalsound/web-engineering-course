# Week 16: Capstone Deployment with Containers, Course Revision and Final-Exam Preparation – lecture notes

### 16.1 The Full Stack in One Picture

| Tier | Technology used in this course | Weeks |
| --- | --- | --- |
| Presentation (browser) | HTML5, CSS3, JavaScript, Bootstrap, Angular | 1–7 |
| Application | Apache + PHP-FPM, Node.js, CodeIgniter 4 / Laravel, WordPress | 6, 9–15 |
| Data | MariaDB, files, sessions | 10–13 |
| Platform | Linux (Rocky / Kubuntu), TLS, firewall, SELinux / AppArmor, systemd, Podman | 1, 8–16 |

### 16.2 Containers and Podman

A **container** is a normal Linux process isolated with namespaces and cgroups; it is created from an **image** (layers described by a `Containerfile`). **Podman** is daemonless and runs containers **rootless**, so a breakout gives an attacker only your user’s rights. Data that must survive container replacement lives in **volumes**. `podman-compose` reads a Compose file and creates the services on a private network where each service is reachable by its name (the database host is simply `db`).

| Concept | Command / file | Purpose |
| --- | --- | --- |
| Image build | `podman build -t web ./web` | Create an image from a Containerfile |
| Run / list | `podman run -d …`, `podman ps` | Start and inspect containers |
| Compose | `podman-compose up -d --build` | Start the multi-service stack |
| Volumes | `podman volume ls` | Persistent data |
| Quadlet | `~/.config/containers/systemd/*.container` | Run containers as systemd services at boot |
| SELinux label | `:Z` on bind mounts | Relabel a host folder for one container (Rocky) |

### 16.3 Delivery Workflow

- **Git:** small commits with clear messages, feature branches, pull / merge requests, tags for releases (`v1.0.0`).
- **Automatic checks:** `php -l`, PHPStan, ESLint, html-validate, unit tests, run in a pre-commit hook locally and in a CI service (Forgejo Actions, GitLab CE runner or GitHub Actions) on every push.
- **Configuration:** secrets in environment variables or files outside Git (12-factor); never commit passwords.
- **Observability:** application logs to stdout/files, health endpoint, `podman logs`, `journalctl`.

### 16.4 OWASP Top 10 Mapped to the Course

| Risk | Where you defended against it |
| --- | --- |
| Broken access control | Role checks, `require_login()`, files outside web root (Weeks 10–11) |
| Cryptographic failures | HTTPS (Week 1), `password_hash`, random tokens (Weeks 11, 13) |
| Injection (SQL, XSS) | PDO prepared statements, output escaping `e()` (Weeks 9–12) |
| Insecure design | Transactions, least-privilege DB user, CAPTCHA (Weeks 10–11) |
| Security misconfiguration | SELinux, firewall, `display_errors=0`, hardening config (Weeks 1, 9, 15) |
| Vulnerable components | Composer / npm / WordPress updates, plugin vetting (Weeks 14–15) |
| Authentication failures | Session regeneration, rate limiting, generic messages (Week 11) |
| Integrity & logging failures | CSRF tokens, upload validation, error logs, backups with hashes (Weeks 11–15) |

### 16.5 Revision Map by CLO

| CLO | Marks in course | Weeks | Final-exam style |
| --- | --- | --- | --- |
| CLO_1 Classify web components; MVC vs 2/3-tier | 28 | 1–3, 13 | Subjective 10 marks: define, compare, draw architecture |
| CLO_2 Develop with HTML, CSS, JS, PHP, DB | 35 | 2–12 | Objective 15 marks: MCQ and code reading |
| CLO_3 Analyze / solve with WordPress, CodeIgniter | 37 | 10–15 | Subjective 25 marks: scenarios, design and justification |

### 16.6 Mock Final Exam – Sample Questions

| # | CLO | Question | Marking guide |
| --- | --- | --- | --- |
| 1 | CLO_1 | Draw and explain a three-tier architecture for an online admission portal and show where MVC fits. | Tiers (3), technologies (2), MVC mapping (3), one trade-off (2) |
| 2 | CLO_2 | Write PHP that accepts a search term, queries products by prefix with PDO and prints escaped results with pagination. | Prepared statement (3), LIKE escaping (1), escaping (2), pagination (2) |
| 3 | CLO_2 | Predict output of a JavaScript snippet using closures, `let` in loops and `await`. | Trace table with reasons |
| 4 | CLO_3 | A client wants a news site edited by journalists plus a custom subscription workflow. Compare WordPress, CodeIgniter 4 and a hybrid; recommend one. | Criteria (4), comparison (6), decision and risks (5) |
| 5 | CLO_3 | Analyse a CodeIgniter controller with no validation and a raw SQL string; list defects and fix them. | SQL injection, CSRF, validation, error handling (5 each) |
