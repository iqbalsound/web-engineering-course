# Week 12 lab: Product Search, CSV Import/Export and Thumbnail Generation – Rocky Linux 10

## Step 1 – Copy the project and seed 5,000 rows

Reuse the previous application and its relabelled storage folder.

```bash
cd /var/www/webeng && cp -a week11 week12 && cd week12 && mkdir -p sql storage/thumbs bin
kate sql/seed-and-explain.sql public/search.php public/export.php public/import.php src/images.php bin/thumbs.php sample-import.csv &
sudo semanage fcontext -a -t httpd_sys_rw_content_t "/var/www/webeng/week12/storage(/.*)?" && sudo restorecon -Rv .
sudo mariadb shop < sql/seed-and-explain.sql
```

## Step 2 – Compare the two EXPLAIN plans

Record `type`, `key` and `rows` before and after the index.

```bash
sudo mariadb shop -e "EXPLAIN SELECT id,name FROM products WHERE name LIKE 'Item 12%'\G" | grep -E 'type|key:|rows'
sudo mariadb shop -e "EXPLAIN SELECT id,name FROM products WHERE name LIKE '%12%'\G" | grep -E 'type|key:|rows'
```

## Step 3 – Test search and CSV export

Use the browser for pages that need a login session; curl can test export when the page does not require one.

```bash
curl -s "http://webeng.test/week12/public/search.php?q=Item%2012" | grep -E 'result|page'
curl -s http://webeng.test/week12/public/export.php | head -n 3
curl -s http://webeng.test/week12/public/export.php | wc -l
```

## Step 4 – Test the transactional import

Import the sample file in the browser; the bad line must cancel everything. Then remove the bad line and retry.

```bash
firefox http://webeng.test/week12/public/import.php &
sudo mariadb shop -e "SELECT COUNT(*) FROM products;"
```

## Step 5 – Generate thumbnails from CLI

CLI runs as your user, so it reads files created by php-fpm (group apache).

```bash
cp ~/Pictures/*.jpg storage/avatars/ 2>/dev/null; php bin/thumbs.php
ls -lh storage/thumbs
php -r 'print_r(array_intersect_key(gd_info(), array_flip(["WebP Support","JPEG Support","PNG Support"])));'
sudo ausearch -m avc -ts recent | tail -n 3
```
