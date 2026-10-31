# Week 9 lab: PHP-FPM Stack, Grade Report and Matrix Exercises with PHPStan – Rocky Linux 10

## Step 1 – Install PHP-FPM and extensions

Rocky 10 provides PHP 8.3 in AppStream; extensions are separate packages.

```bash
sudo dnf -y install php-fpm php-cli php-mysqlnd php-mbstring php-xml php-gd php-intl php-opcache
sudo systemctl enable --now php-fpm
php -v && php -m | grep -E 'mbstring|pdo_mysql|gd|intl|fileinfo'
```

## Step 2 – Connect Apache to PHP-FPM

Apache talks to the FPM socket created by the pool (/run/php-fpm/www.sock).

```bash
sudo tee /etc/httpd/conf.d/webeng-php.conf >/dev/null <<'EOF'
<FilesMatch \.php$>
    SetHandler "proxy:unix:/run/php-fpm/www.sock|fcgi://localhost"
</FilesMatch>
DirectoryIndex index.php index.html
EOF
sudo apachectl configtest && sudo systemctl restart httpd
ps -eZ | grep php-fpm | head -n 2         # domain should be httpd_t
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

Create the four files from the listings; then relabel and install PHPStan.

```bash
mkdir -p /var/www/webeng/week09/{public,src,bin} && cd /var/www/webeng/week09
kate src/grades.php public/index.php bin/matrix.php .htaccess &
composer init --no-interaction --name=student/week09 && composer require --dev phpstan/phpstan
sudo restorecon -Rv /var/www/webeng/week09
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

PHP errors go to the FPM log; web errors to the Apache log.

```bash
sudo tail -n 5 /var/log/php-fpm/www-error.log /var/log/httpd/error_log
```
