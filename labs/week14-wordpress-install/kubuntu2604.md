# Week 14 lab: WordPress with WP-CLI, Plugins and a Home Page Built from Blocks – Kubuntu 26.04 LTS

## Step 1 – Install PHP extensions, MariaDB and the database

Reuse the Week 9–10 packages; add WordPress extras.

```bash
sudo apt -y install php-fpm php-mysql php-gd php-intl php-mbstring php-xml php-curl mariadb-server
PHPV=$(php -r 'echo PHP_MAJOR_VERSION.".".PHP_MINOR_VERSION;'); sudo systemctl enable --now php${PHPV}-fpm mariadb
sudo mariadb < wp-db.sql
```

## Step 2 – Install WP-CLI and define a helper

WP-CLI must run as the web user so files get the right owner. The helper keeps commands short.

```bash
curl -sSLo /tmp/wp-cli.phar https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
php /tmp/wp-cli.phar --info | head -n 4
sudo install -m 0755 /tmp/wp-cli.phar /usr/local/bin/wp
wpa() { sudo -u www-data env WP_CLI_CACHE_DIR=/tmp/wp-cli-cache wp --path=/var/www/webeng/wp "$@"; }
```

## Step 3 – Prepare the folder

AppArmor does not restrict this layout; ownership is enough.

```bash
sudo mkdir -p /var/www/webeng/wp && sudo chown www-data:www-data /var/www/webeng/wp
wpa core download && ls /var/www/webeng/wp | head
```

## Step 4 – Create the configuration and install

The URL includes /wp because the site is inside the virtual host.

```bash
wpa config create --dbname=wp_site --dbuser=wp_user --dbpass='ChangeMe_2026!' --dbhost=localhost
wpa core install --url=http://webeng.test/wp --title="WebEng Blog" --admin_user=siteadmin \
  --admin_password='Str0ng!Pass-2026' --admin_email=admin@webeng.test --skip-email
wpa rewrite structure '/%postname%/' --hard
curl -sI http://webeng.test/wp/ | head -n 1
```

## Step 5 – Install plugins and the default block theme

Query Monitor is a developer tool; Contact Form 7 adds forms.

```bash
wpa plugin install query-monitor contact-form-7 --activate
wpa theme install twentytwentyfive --activate || wpa theme activate twentytwentyfive
wpa plugin list && wpa theme list
```

## Step 6 – Create the home page from block markup

Content comes from the file; then set it as the front page.

```bash
cp home.html /tmp/home.html && chmod 644 /tmp/home.html
ID=$(wpa post create /tmp/home.html --post_type=page --post_title='Home' --post_status=publish --porcelain)
wpa option update show_on_front page && wpa option update page_on_front "$ID"
wpa post generate --count=5 --post_type=post
firefox http://webeng.test/wp/wp-admin/ &      # drag blocks, insert a pattern, open Appearance → Editor
```

## Step 7 – Verify and troubleshoot

Check the logs when something fails.

```bash
curl -s http://webeng.test/wp/ | grep -io '<title>[^<]*'
curl -s http://webeng.test/wp/wp-json/ | jq -r .name
wpa core version && wpa db check | tail -n 2
sudo tail -n 5 /var/log/apache2/error.log
```
