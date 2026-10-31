# Week 15 lab: Configure the Blog, Child Theme, “Projects” Plugin, Hardening and Automatic Backup – Kubuntu 26.04 LTS

## Step 1 – Define the helper and configure the blog

Settings are changed from the command line so they are repeatable.

```bash
wpa() { sudo -u www-data env WP_CLI_CACHE_DIR=/tmp/wp-cli-cache wp --path=/var/www/webeng/wp "$@"; }
wpa option update timezone_string Asia/Karachi
wpa option update blogdescription "Web Engineering lab notes"
wpa option update comment_moderation 1 && wpa option update default_comment_status closed
wpa term create category "Lab Notes" --porcelain
for t in "Linux" "PHP" "WordPress"; do wpa post create --post_title="$t basics" --post_content="<!-- wp:paragraph --><p>Notes on $t.</p><!-- /wp:paragraph -->" --post_status=publish --post_category=$(wpa term list category --name="Lab Notes" --field=term_id) --tags_input="$t" --porcelain; done
```

## Step 2 – Create and activate the child theme and plugin

Files must belong to the web user.

```bash
T=/var/www/webeng/wp/wp-content
sudo -u www-data mkdir -p $T/themes/twentytwentyfive-child $T/plugins/webeng-projects
sudo -u www-data tee $T/themes/twentytwentyfive-child/style.css < style.css >/dev/null
sudo -u www-data tee $T/themes/twentytwentyfive-child/theme.json < theme.json >/dev/null
sudo -u www-data tee $T/plugins/webeng-projects/webeng-projects.php < webeng-projects.php >/dev/null
wpa theme activate twentytwentyfive-child && wpa plugin activate webeng-projects
wpa post create --post_type=project --post_title="Capstone Shop" --post_status=publish
wpa post create --post_type=project --post_title="CSV Explorer" --post_status=publish
curl -s http://webeng.test/wp/wp-json/wp/v2/project | jq 'map(.title.rendered)'
```

## Step 3 – Apply hardening

Constants, permissions and a block on XML-RPC at the web-server level.

```bash
wpa config set DISALLOW_FILE_EDIT true --raw && wpa config set WP_DEBUG false --raw
sudo find /var/www/webeng/wp -type d -exec chmod 755 {} + && sudo find /var/www/webeng/wp -type f -exec chmod 644 {} +
sudo chmod 640 /var/www/webeng/wp/wp-config.php
sudo tee /etc/apache2/conf-available/wp-hardening.conf >/dev/null <<'EOF'
<Directory /var/www/webeng/wp>
    <Files xmlrpc.php>
        Require all denied
    </Files>
    Header always set X-Content-Type-Options "nosniff"
</Directory>
EOF
sudo a2enconf wp-hardening && sudo apache2ctl configtest && sudo systemctl reload apache2
curl -s -o /dev/null -w "xmlrpc: %{http_code}\n" http://webeng.test/wp/xmlrpc.php
```

## Step 4 – Install the backup script and timer

The script runs as root from systemd and drops privileges for WP-CLI. Set WEBUSER to www-data in the service file.

```bash
sudo install -d -m 0750 /var/backups/webeng
kate wp-backup.sh wp-backup.service wp-backup.timer &
sed -i 's/WEBUSER=apache/WEBUSER=www-data/' wp-backup.service
sudo install -m 0750 wp-backup.sh /usr/local/sbin/wp-backup.sh
sudo install -m 0644 wp-backup.service wp-backup.timer /etc/systemd/system/
sudo systemctl daemon-reload && sudo systemctl enable --now wp-backup.timer
sudo systemctl start wp-backup.service && sudo journalctl -u wp-backup.service -n 5 --no-pager
systemctl list-timers wp-backup.timer
```

## Step 5 – Verify the backup

Integrity first; then check that the archive and dump contain what you expect.

```bash
cd /var/backups/webeng && sudo sha256sum -c SHA256-*.txt
sudo tar tzf wp-files-*.tgz | grep -c . && sudo grep -c 'CREATE TABLE' db-*.sql
```
