# Week 14 solutions: WordPress Installation and Block Editor

## Expected results and evidence
| Check | Expected result / model evidence |
| --- | --- |
| `curl -sI http://webeng.test/wp/` | `HTTP/1.1 200 OK` |
| `wpa core version` | The current stable release number |
| `wpa plugin list` | query-monitor and contact-form-7 with status `active` |
| `wpa theme list` | `twentytwentyfive` with status `active` |
| `curl .../wp-json/ \| jq -r .name` | `WebEng Blog` |
| Front page | Heading, paragraph and “Read the blog” button from `home.html` plus the student’s own drag-and-drop change |
| `wpa db check \| tail -n 2` | Tables listed with `OK` |



## Troubleshooting guide
| Symptom | Likely cause | Fix (Rocky 10 / Kubuntu 26.04) |
| --- | --- | --- |
| “Error establishing a database connection” | Wrong DB name, user or password; MariaDB stopped | `mariadb -u wp_user -p wp_site`; check `wp-config.php`; `systemctl start mariadb` |
| Pretty permalinks give 404 | `mod_rewrite` / `.htaccess` problem | Rocky: `AllowOverride All` in the vhost and `.htaccess` owned by apache. Kubuntu: `a2enmod rewrite`, reload. Re-run `wpa rewrite flush --hard` |
| Plugin install fails: “Could not create directory” | Rocky: SELinux label; Kubuntu: ownership | Rocky: fcontext rule for `wp-content` + `restorecon -Rv`. Kubuntu: `chown -R www-data:www-data wp-content` |
| Plugin download “cURL error 7 / could not connect” | Rocky: outbound network blocked for httpd | `sudo setsebool -P httpd_can_network_connect on` |
| WP-CLI “Failed to create directory /usr/share/httpd/.wp-cli” | Web user has no home | Keep `WP_CLI_CACHE_DIR=/tmp/wp-cli-cache` in the `wpa` function |
| `wpa: command not found` in a new terminal | Function exists only in the session that defined it | Re-run the function definition or add it to `~/.bashrc` |
| `wpa post create` cannot read the file | File not readable by the web user | Copy to `/tmp` and `chmod 644` as in the lab |

## Viva prompts and marking notes
- Ask the student to show where the home page is stored (database table `wp_posts`) and what the block comments look like in `post_content`.
- Ask for one plugin they rejected or would reject and the criteria used.
- Marking points: working install (3), plugins reviewed with evidence (2), block page and Site Editor change (3), OS permissions (1), viva (1).

## Answers to review questions
1. Never edit WordPress core (`wp-admin`, `wp-includes`) or third-party plugin/theme code. Your own work lives in a child theme, a custom plugin, uploads and database content; settings go in `wp-config.php`.
2. An action runs code at a moment: `add_action("init", fn)`. A filter receives a value, changes it and returns it: `add_filter("the_title", fn($t) => strtoupper($t))`.
3. Accept: many active installs, recent update tested with the current WordPress/PHP, good support, GPL licence, low query cost. Reject: abandoned, unknown author, duplicate function, heavy queries.
4. A block theme uses HTML templates, template parts and `theme.json` edited in the Site Editor; a classic theme uses PHP templates with the Customizer and widgets.
5. Brochure site → WordPress; loan-approval workflow → CodeIgniter 4 or Laravel; mobile API → Laravel / CodeIgniter 4 (WordPress REST only if the content is the product).
