# Week 16: Capstone Deployment with Containers, Course Revision and Final-Exam Preparation

| Syllabus lectures | CLO | PLO | Bloom | Assessment |
| --- | --- | --- | --- | --- |
| Lec 31–32 | CLO_1, CLO_2, CLO_3 | PLO_2, PLO_4, PLO_5 | C2–C4 | Final examination follows (Subj 10 + Obj 15 + Subj 25) |

## Lab: Containerised Capstone: Apache/PHP + MariaDB with Podman Compose and a Quadlet Service

Build and run the shop stack as containers, prove persistence and recovery, run Mailpit as a boot-time systemd (Quadlet) service, and package the project in Git with a pre-commit check.

### Free and open-source tools
- Podman + podman-compose (Apache-2.0 / GPL)
- Official `php:apache` and `mariadb:lts` images
- Mailpit (MIT)
- Git + shell hooks

### Deliverables
- Git repository `capstone` with `compose.yaml`, `web/Containerfile`, `app/`, `schema.sql`, `.gitignore`, tag `v1.0.0`
- Stack reachable at `http://127.0.0.1:8090/` showing “DB OK” and the product count
- Evidence of persistence (`podman volume ls`, data survives `down` / `up`)
- Mailpit started as a user systemd service

### Contents of this folder
- [`lecture-notes.md`](lecture-notes.md) – the week's theory
- [`rocky10.md`](rocky10.md) – step-by-step lab, **Version A (Rocky Linux 10)**
- [`kubuntu2604.md`](kubuntu2604.md) – step-by-step lab, **Version B (Kubuntu 26.04 LTS)**
- `code/.env.kubuntu.example`
- `code/.env.rocky.example`
- `code/app/index.php`
- `code/compose.yaml`
- `code/hooks/pre-commit`
- `code/quadlet/mailpit.container`
- `code/schema.sql`
- `code/web/Containerfile`

`code/` holds the reference source files exactly as printed in the lab manual (they are the files the labs ask you to create).


### Verification checklist
| # | Check | Expected Result |
| --- | --- | --- |
| 1 | `curl http://127.0.0.1:8090/` | “DB OK – 8 products” and the PHP version |
| 2 | `podman info` format line | `rootless=true` (Rocky also `selinux=true`) |
| 3 | Stop `db` and request the page | HTTP 503 with “DB unavailable”; recovers after `start db` |
| 4 | `down` then `up` | Product count unchanged (named volume kept the data) |
| 5 | `systemctl --user status mailpit.service` | `active (running)` |
| 6 | Commit with a PHP syntax error | Hook prints the parse error and aborts the commit |
| 7 | `git tag` | `v1.0.0` present |

### Stretch goals
- Add a `phpmyadmin`-free admin check: a read-only `/health.php` returning JSON for monitoring.
- Add a CI pipeline file (Forgejo / GitLab CE / GitHub Actions) that runs `php -l` and PHPStan.
- Scan the image for known vulnerabilities with Trivy (Apache-2.0).

### Additional work
#### Course Wrap-up Checklist

- Submit the capstone repository link and the `README` listing commands for **your** operating system.
- Complete the CLO self-assessment (1–5 scale) for CLO_1, CLO_2 and CLO_3 and note one weakness to revise.
- Bring the final-exam permitted items (calculator, ID). Cell phones in silent mode; at least 75% attendance is required.

### Review questions
1. Explain the difference between an image, a container and a volume.
2. Why bind published ports to `127.0.0.1` in development?
3. Name five OWASP Top 10 risks and the countermeasure you implemented for each.
4. Compare 2-tier, 3-tier and MVC in a short paragraph.
5. Choose WordPress, CodeIgniter 4 or Laravel for a university event-registration system and justify with three criteria.

---
Instructor solutions: [`instructor/solutions/week16-containers-capstone.md`](../../instructor/solutions/week16-containers-capstone.md)
