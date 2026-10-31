# Week 15 solutions: Blog Configuration, Themes, Security and Backups

## Expected results and evidence
| Check | Expected result / model evidence |
| --- | --- |
| Admin settings | Timezone Asia/Karachi, permalinks `/%postname%/`, comments held for moderation |
| `wpa theme list --status=active --field=name` | `twentytwentyfive-child` |
| `curl .../wp-json/wp/v2/project \| jq 'map(.title.rendered)'` | `["CSV Explorer","Capstone Shop"]` (newest first) |
| `curl -o /dev/null -w "%{http_code}" .../xmlrpc.php` | `403` |
| Appearance menu | No “Theme File Editor” and no “Plugin File Editor” (DISALLOW_FILE_EDIT) |
| `systemctl list-timers wp-backup.timer` | NEXT shows the coming 02:30 |
| `journalctl -u wp-backup.service` | “backup 20261030-0230 complete” style line |
| `sha256sum -c SHA256-*.txt` | `db-….sql: OK` and `wp-files-….tgz: OK` |
| `grep -c "CREATE TABLE" db-*.sql` | 12 default tables (plus any plugin tables) |



## Troubleshooting guide
| Symptom | Likely cause | Fix (Rocky 10 / Kubuntu 26.04) |
| --- | --- | --- |
| `wp db export` fails: `mysqldump: command not found` | MariaDB client tools missing | Rocky: `sudo dnf -y install mariadb`. Kubuntu: `sudo apt -y install mariadb-client` |
| Backup service: `runuser: user apache does not exist` on Kubuntu | Wrong web user | `sed -i "s/WEBUSER=apache/WEBUSER=www-data/" wp-backup.service`, `systemctl daemon-reload` |
| Child theme not listed | Header missing `Template:` line or wrong folder name | Folder `twentytwentyfive-child`, `Template: twentytwentyfive` |
| Custom post type URL gives 404 | Rewrite rules not flushed | `wpa rewrite flush --hard` or deactivate/activate the plugin |
| Apache reload fails after hardening snippet | `mod_headers` missing | Rocky: built in. Kubuntu: `sudo a2enmod headers` |
| Timer never fires | Timer not enabled | `sudo systemctl enable --now wp-backup.timer` |
| Plugin editor still visible | Constant not set | `wpa config get DISALLOW_FILE_EDIT`; re-run `wpa config set DISALLOW_FILE_EDIT true --raw` |

## Viva prompts and marking notes
- Ask the student to restore the database dump into a scratch database and compare the post count.
- Ask why `Persistent=true` matters for a laptop that is switched off at 02:30.
- Marking points: blog configuration (2), child theme and plugin (3), hardening evidence (2), backup + verification (2), viva (1).

## Answers to review questions
1. A child theme keeps your changes when the parent theme is updated; edits made directly to the parent are overwritten.
2. A custom post type stored in a plugin survives theme changes; if it lived in the theme the content and URLs would disappear when the theme is switched.
3. Updates (`wp core update`), `DISALLOW_FILE_EDIT` (`wp config set`), file permissions 755/644/640 (`find … chmod`), blocking `xmlrpc.php` (`Require all denied`), 2FA / rate limiting (plugin or fail2ban).
4. `Persistent=true` makes systemd run a job that was missed while the machine was off as soon as the timer is active again.
5. Restore the dump and files into a scratch database and path, compare post/page counts and open key URLs, check SHA-256 values, and repeat on a schedule.
