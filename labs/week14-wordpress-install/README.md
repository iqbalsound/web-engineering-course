# Week 14: WordPress: Architecture, Installation, Plugins and the Block Editor

| Syllabus lectures | CLO | PLO | Bloom | Assessment |
| --- | --- | --- | --- | --- |
| Lec 27–28 | CLO_3 | PLO_4 | C4 (Analyzing) | — |

## Lab: WordPress with WP-CLI, Plugins and a Home Page Built from Blocks

Install WordPress using WP-CLI on your LAMP stack (MariaDB + PHP-FPM + Apache), set the SELinux / permission model correctly, install and review plugins, and build a front page with the block editor.

### Free and open-source tools
- WordPress (GPL-2.0+)
- WP-CLI (MIT)
- Plugins: Query Monitor (GPL), Contact Form 7 (GPL)
- MariaDB, Apache, PHP-FPM from earlier weeks

### Deliverables
- WordPress at `http://webeng.test/wp/` with pretty permalinks
- Two plugins active; a one-page review table (installs, last update, queries added)
- Home page created from `home.html` and edited by drag-and-drop in the editor, set as the static front page
- Screenshot of the Site Editor with one changed pattern

### Contents of this folder
- [`lecture-notes.md`](lecture-notes.md) – the week's theory
- [`rocky10.md`](rocky10.md) – step-by-step lab, **Version A (Rocky Linux 10)**
- [`kubuntu2604.md`](kubuntu2604.md) – step-by-step lab, **Version B (Kubuntu 26.04 LTS)**
- `code/home.html`
- `code/wp-db.sql`

`code/` holds the reference source files exactly as printed in the lab manual (they are the files the labs ask you to create).


### Verification checklist
| # | Check | Expected Result |
| --- | --- | --- |
| 1 | `curl -sI http://webeng.test/wp/` | `HTTP/1.1 200 OK` |
| 2 | `wpa core version` | Current WordPress release |
| 3 | `wpa plugin list --status=active --field=name` | `query-monitor` and `contact-form-7` |
| 4 | Browser front page | Heading, paragraph and button from `home.html`; your drag-and-drop change visible |
| 5 | `curl .../wp-json/ \| jq -r .name` | “WebEng Blog” |
| 6 | Query Monitor (admin bar) | Page generated with a recorded number of queries and time |

### Stretch goals
- Create a Contact Form 7 form and send a test mail to Mailpit through an SMTP plugin pointing to 127.0.0.1:1025.
- Use the WordPress REST API from Angular (Week 6 project) to list posts.
- Compare page weight and query count with and without Contact Form 7 enabled.


### Review questions
1. Which folders of a WordPress site must never be edited and which hold your own work?
2. Explain actions versus filters with one example of each.
3. List four criteria for accepting a plugin and one reason to avoid one.
4. How does a block theme differ from a classic theme?
5. For which of three requirements (brochure site, loan-approval workflow, mobile API) would you pick WordPress, and why?

---
Instructor solutions: [`instructor/solutions/week14-wordpress-install.md`](../../instructor/solutions/week14-wordpress-install.md)
