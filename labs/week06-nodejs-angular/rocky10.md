# Week 6 lab: Node REST API and Angular Course Dashboard – Rocky Linux 10

## Step 1 – Create the API project

Create files from the listings above.

```bash
mkdir -p ~/webeng/week06/api && cd ~/webeng/week06/api
npm init -y && npm pkg set type=module
kate server.js ../compare.js &
node --watch server.js &              # background; use "kill %1" to stop
```

## Step 2 – Test the API from the shell

jq pretty-prints JSON.

```bash
curl -s http://127.0.0.1:3000/api/courses | jq .
curl -s -X POST -H 'Content-Type: application/json' \
  -d '{"code":"SEWE-7000","title":"Cloud","credits":3}' http://127.0.0.1:3000/api/courses -i | head -n 1
curl -s -X POST -d 'x' http://127.0.0.1:3000/api/courses -w "%{http_code}\n"
```

## Step 3 – Create the Angular app

The CLI asks no questions with --defaults.

```bash
cd ~/webeng/week06
npx --yes @angular/cli@latest new dashboard --defaults --skip-git
cd dashboard && ls src/app
```

## Step 4 – Replace the component and config files

Overwrite app.ts, app.html and app.config.ts with the listings above, then run the dev server.

```bash
npx ng serve --host 127.0.0.1
# browser: http://127.0.0.1:4200/
```

## Step 5 – Build and deploy

Output is in dist/dashboard/browser.

```bash
npx ng build --base-href /week06/
rsync -a --delete dist/dashboard/browser/ /var/www/webeng/week06/
sudo restorecon -Rv /var/www/webeng/week06
curl -sI http://webeng.test/week06/ | head -n 1
```

## Step 6 – Understand the browser restriction (SELinux/CORS)

The deployed page at webeng.test calls the API at 127.0.0.1:3000 from the browser, so the API’s CORS header is what permits it. Apache is not involved.

```bash
curl -sI -X OPTIONS http://127.0.0.1:3000/api/courses | grep -i access-control
```
