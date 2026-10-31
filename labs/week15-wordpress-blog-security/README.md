# Week 15: Creating and Configuring a Blog: Themes, Custom Content, Security and Backups

| Syllabus lectures | CLO | PLO | Bloom | Assessment |
| --- | --- | --- | --- | --- |
| Lec 29–30 | CLO_3 | PLO_4 | C4 (Analyzing) | — |

## Lab: Configure the Blog, Child Theme, “Projects” Plugin, Hardening and Automatic Backup

Turn the Week 14 site into a configured blog, add a branded child theme, a custom post type plugin, apply a hardening checklist and schedule verified nightly backups with a systemd timer.

### Free and open-source tools
- WP-CLI
- systemd timers, `runuser`, `tar`, `sha256sum`
- Query Monitor
- jq, curl

### Deliverables
- Blog configured (timezone, permalinks, comment moderation, categories, 3 posts)
- Active child theme `twentytwentyfive-child` with custom palette
- Plugin `webeng-projects` and 2 “Project” entries visible via the REST API
- Hardening applied and a timer that produces a verified backup

### Contents of this folder
- [`lecture-notes.md`](lecture-notes.md) – the week's theory
- [`rocky10.md`](rocky10.md) – step-by-step lab, **Version A (Rocky Linux 10)**
- [`kubuntu2604.md`](kubuntu2604.md) – step-by-step lab, **Version B (Kubuntu 26.04 LTS)**
- `code/system/wp-backup.service`
- `code/system/wp-backup.sh`
- `code/system/wp-backup.timer`
- `code/wp-content/plugins/webeng-projects/webeng-projects.php`
- `code/wp-content/themes/twentytwentyfive-child/style.css`
- `code/wp-content/themes/twentytwentyfive-child/theme.json`

`code/` holds the reference source files exactly as printed in the lab manual (they are the files the labs ask you to create).


### Verification checklist
| # | Check | Expected Result |
| --- | --- | --- |
| 1 | Settings in the admin | Timezone Asia/Karachi, permalinks `/%postname%/`, comments held for moderation |
| 2 | `wpa theme list --status=active --field=name` | `twentytwentyfive-child` |
| 3 | REST: `/wp-json/wp/v2/project` | Two projects returned as JSON |
| 4 | `curl .../xmlrpc.php` | 403 Forbidden |
| 5 | Dashboard theme/plugin editor | Menu items absent (`DISALLOW_FILE_EDIT`) |
| 6 | `systemctl list-timers wp-backup.timer` | Next run 02:30; last manual run produced `SHA256-*.txt` with `OK` on check |

### Stretch goals
- Restore the backup into a second database and site path and compare post counts.
- Install `fail2ban` and add a jail for repeated `wp-login.php` failures.
- Add `rsync` to push the backup to another machine over SSH keys.


### Review questions
1. Why create a child theme instead of editing Twenty Twenty-Five directly?
2. Why should a custom post type live in a plugin and not in the theme?
3. Name four items on a WordPress hardening checklist and the command or setting for each.
4. What does `Persistent=true` do in a systemd timer?
5. How would you test that a backup is restorable?

---
Instructor solutions: [`instructor/solutions/week15-wordpress-blog-security.md`](../../instructor/solutions/week15-wordpress-blog-security.md)
