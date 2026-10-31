# Week 9 lab: PHP-FPM Stack, Grade Report and Matrix Exercises with PHPStan – Kubuntu 26.04 LTS

## Step 1 – Install PHP-FPM and extensions

Kubuntu 26.04 provides PHP 8.5. Do not install the `php` metapackage because it pulls mod_php.

```bash
sudo apt -y install php-fpm php-cli php-mysql php-mbstring php-xml php-gd php-intl php-curl
PHPV=$(php -r 'echo PHP_MAJOR_VERSION.".".PHP_MINOR_VERSION;'); echo $PHPV
sudo systemctl enable --now php${PHPV}-fpm
php -v && php -m | grep -E 'mbstring|pdo_mysql|gd|intl|fileinfo'
```

## Step 2 – Connect Apache to PHP-FPM

proxy_fcgi plus the packaged configuration snippet.

```bash
sudo a2enmod proxy_fcgi setenvif
sudo a2enconf php${PHPV}-fpm
echo 'DirectoryIndex index.php index.html' | sudo tee /etc/apache2/conf-available/webeng-index.conf && sudo a2enconf webeng-index
sudo apache2ctl configtest && sudo systemctl reload apache2
ls /run/php/                          # php8.5-fpm.sock
```

## Step 3 – Install Composer (verified installer)

The installer signature is checked before running it.

```bash
cd /tmp
php -r "copy('https://getcomposer.org/installer','composer-setup.php');"
php -r "exit(hash_file('sha384','composer-setup.php') === trim(file_get_contents('https://composer.github.io/installer.sig')) ? 0 : 1);" && echo VERIFIED
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer && rm composer-setup.php
composer --version
```

## Step 4 – Create the project and files

Create the four files from the listings; then install PHPStan.

```bash
mkdir -p /var/www/webeng/week09/{public,src,bin} && cd /var/www/webeng/week09
kate src/grades.php public/index.php bin/matrix.php .htaccess &
composer init --no-interaction --name=student/week09 && composer require --dev phpstan/phpstan
```

## Step 5 – Run, test and analyse

CLI and web must give the same logic results.

```bash
php bin/matrix.php
curl -s "http://webeng.test/week09/public/?pass=60" | grep -E 'Pass|Fail'
curl -s -o /dev/null -w "%{http_code}\n" http://webeng.test/week09/src/grades.php      # expect 404
vendor/bin/phpstan analyse -l 6 src public bin
```

## Step 6 – Read the logs

PHP-FPM logs to /var/log; Apache to its own log.

```bash
sudo tail -n 5 /var/log/php${PHPV}-fpm.log /var/log/apache2/error.log
```
