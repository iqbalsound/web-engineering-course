# Week 10 lab: MariaDB Schema, PDO Connection, CAPTCHA Registration and Avatar Upload – Kubuntu 26.04 LTS

## Step 1 – Install and start MariaDB

Kubuntu 26.04 ships MariaDB 11.8. The root account uses socket authentication.

```bash
sudo apt -y install mariadb-server
sudo systemctl enable --now mariadb
sudo mariadb-secure-installation        # answers: n (keep unix_socket), Y, Y, Y, Y
sudo mariadb -e "SELECT VERSION();"
```

## Step 2 – Create the database and least-privilege user

The application user cannot create or drop tables.

```bash
sudo mariadb <<'SQL'
CREATE DATABASE shop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'shop_app'@'localhost' IDENTIFIED BY 'ChangeMe_2026!';
GRANT SELECT, INSERT, UPDATE, DELETE ON shop.* TO 'shop_app'@'localhost';
SQL
mkdir -p /var/www/webeng/week10/{public,src,config,storage/avatars} && cd /var/www/webeng/week10
kate schema.sql config/db.php src/db.php public/*.php .htaccess practice.sql &
sudo mariadb shop < schema.sql
sudo mariadb shop -e "SELECT COUNT(*) FROM products;"
```

## Step 3 – Practise SQL and install a GUI

Run practice.sql line by line, then open DBeaver and view the ER diagram.

```bash
sudo mariadb shop < practice.sql | head -n 30
flatpak install -y flathub io.dbeaver.DBeaverCommunity
sudo mariadb -e "SELECT user,host FROM mysql.user WHERE user='shop_app';"
```

## Step 4 – Give the web server write access only where needed

PHP-FPM runs as www-data. The setgid web root already gives group www-data; allow group write on the storage folder only.

```bash
chmod 2775 storage storage/avatars
ls -ld storage/avatars                  # group should be www-data
sudo -u www-data test -w storage/avatars && echo "www-data can write"
```

## Step 5 – Test registration and injection attempts

Use the browser for the CAPTCHA; use curl to prove that hostile input is harmless.

```bash
firefox http://webeng.test/week10/public/register.php &
curl -s -o /dev/null -w "%{http_code}\n" "http://webeng.test/week10/public/avatar.php?id=1%20OR%201=1"
curl -s -o /dev/null -w "%{http_code}\n" http://webeng.test/week10/config/db.php
sudo mariadb shop -e "SELECT id,name,email,LEFT(password_hash,7) hash,avatar FROM users;"
ls -l storage/avatars
```
