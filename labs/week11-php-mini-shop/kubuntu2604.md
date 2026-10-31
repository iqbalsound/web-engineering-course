# Week 11 lab: Mini-Shop: Login, Product List, Session Cart and Transactional Checkout – Kubuntu 26.04 LTS

## Step 1 – Copy the Week 10 project

Copy register.php and the shared source, and make register.php use the new bootstrap.

```bash
cd /var/www/webeng && cp -a week10 week11 && cd week11
rm -f storage/avatars/* && kate src/bootstrap.php public/login.php public/logout.php public/products.php public/cart.php public/checkout.php &
sed -i "s#^session_start();#require __DIR__ . '/../src/bootstrap.php';#; /require __DIR__ . '\/..\/src\/db.php';/d" public/register.php
chmod 2775 storage storage/avatars
```

## Step 2 – Create a test user and walk through the flow

Register in the browser (CAPTCHA), then log in and buy.

```bash
firefox http://webeng.test/week11/public/register.php &
firefox http://webeng.test/week11/public/login.php &
sudo mariadb shop -e "SELECT id,email FROM users;"
```

## Step 3 – Verify CSRF protection from the shell

A POST without a token must be refused with 419.

```bash
curl -s -o /dev/null -w "%{http_code}\n" -X POST -d 'action=add&id=1' http://webeng.test/week11/public/cart.php
curl -sI -c - http://webeng.test/week11/public/login.php | grep -i -E 'set-cookie'
```

## Step 4 – Verify the order in the database

Order, items and reduced stock must match.

```bash
sudo mariadb shop -e "SELECT * FROM orders; SELECT * FROM order_items; SELECT id,name,stock FROM products LIMIT 3;"
```

## Step 5 – Trigger and read an error

Stop the database, load the products page, read the log, restart.

```bash
sudo systemctl stop mariadb; curl -s -o /dev/null -w "%{http_code}\n" http://webeng.test/week11/public/products.php
tail -n 5 storage/php-error.log; sudo systemctl start mariadb
composer require --dev phpstan/phpstan && vendor/bin/phpstan analyse -l 6 src public
```
