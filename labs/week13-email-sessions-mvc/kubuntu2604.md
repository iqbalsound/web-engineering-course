# Week 13 lab: Mailpit, Secure Sessions and a CodeIgniter 4 Notes Application – Kubuntu 26.04 LTS

## Step 1 – Install Podman and start Mailpit

Rootless container; ports are bound to the loopback interface only.

```bash
sudo apt -y install podman
podman run -d --name mailpit -p 127.0.0.1:8025:8025 -p 127.0.0.1:1025:1025 docker.io/axllent/mailpit:latest
podman ps && curl -s http://127.0.0.1:8025/api/v1/messages | jq '.total'
```

## Step 2 – Send mail with Symfony Mailer

Create the project folder, install the library and send.

```bash
mkdir -p ~/webeng/week13/{mail,public} && cd ~/webeng/week13/mail
composer require symfony/mailer
kate send.php && php send.php
curl -s http://127.0.0.1:8025/api/v1/messages | jq '.messages[0] | {Subject, From: .From.Address, To: .To[0].Address}'
```

## Step 3 – Observe cookies and sessions

Use a cookie jar; compare the first and second request, then change the theme.

```bash
cd ~/webeng/week13 && kate public/state.php && (php -S 127.0.0.1:8080 -t public >/dev/null 2>&1 &)
curl -si -c jar.txt http://127.0.0.1:8080/state.php | sed -n '1,12p'
curl -s -b jar.txt -c jar.txt "http://127.0.0.1:8080/state.php?theme=dark"; cat jar.txt
```

## Step 4 – Create the CodeIgniter database and project

The application account may run migrations, so it owns the `notes` schema.

```bash
sudo apt -y install php-intl php-mbstring php-xml php-mysql php-sqlite3
sudo mariadb -e "CREATE DATABASE notes CHARACTER SET utf8mb4; CREATE USER 'notes_app'@'localhost' IDENTIFIED BY 'ChangeMe_2026!'; GRANT ALL ON notes.* TO 'notes_app'@'localhost';"
cd ~/webeng/week13 && composer create-project codeigniter4/appstarter ci-notes && cd ci-notes
cp env .env && cat >> .env <<'EOF'
CI_ENVIRONMENT = development
database.default.hostname = localhost
database.default.database = notes
database.default.username = notes_app
database.default.password = ChangeMe_2026!
database.default.DBDriver = MySQLi
EOF
```

## Step 5 – Generate files, enable CSRF and migrate

Use the generators, then replace the class bodies with the listings above.

```bash
php spark make:migration CreateNotes
php spark make:model NoteModel
php spark make:controller Notes
mkdir -p app/Views/notes && kate app/Models/NoteModel.php app/Controllers/Notes.php app/Views/notes/index.php app/Config/Routes.php &
sed -i "s#// 'csrf',#'csrf',#" app/Config/Filters.php && grep -n "'csrf'" app/Config/Filters.php
php spark migrate && php spark routes | grep -i notes
```

## Step 6 – Run and test

Check that the framework refuses a POST without a CSRF token.

```bash
php spark serve --port 8081 &
sleep 2; curl -s -o /dev/null -w "POST without CSRF: %{http_code}\n" -X POST -d 'title=x' http://127.0.0.1:8081/notes
firefox http://127.0.0.1:8081/notes &
sudo ss -tlnp | grep -E '8080|8081|1025|8025'
```

## Step 7 – Laravel demo (guided, 15 min)

Observe how the same MVC ideas appear with different tooling.

```bash
cd ~/webeng/week13 && composer create-project laravel/laravel lv-demo && cd lv-demo
php artisan route:list && php artisan make:controller NoteController --resource
php artisan serve --port=8082 &
```
