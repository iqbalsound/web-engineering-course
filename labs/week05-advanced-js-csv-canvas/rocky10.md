# Week 5 lab: CSV Student Explorer and Rotating 3D Cube (Vite Build) – Rocky Linux 10

## Step 1 – Scaffold the project manually

Keeping source outside the web root is the professional pattern; only the built files are served.

```bash
mkdir -p ~/webeng/week05/public && cd ~/webeng/week05
npm init -y && npm pkg set type=module
npm install papaparse three && npm install --save-dev vite
kate index.html main.js public/students.csv &
```

## Step 2 – Run the dev server with hot reload

Vite listens on 5173; open the firewall only if testing from another machine.

```bash
npx vite --host 127.0.0.1
# browser: http://127.0.0.1:5173/      (Ctrl+C to stop)
```

## Step 3 – Build for production under /week05/

The --base option rewrites asset URLs.

```bash
npx vite build --base=/week05/
ls -lh dist dist/assets
```

## Step 4 – Deploy and relabel

rsync copies and --delete removes stale files; restorecon fixes labels for SELinux.

```bash
rsync -a --delete dist/ /var/www/webeng/week05/
sudo restorecon -Rv /var/www/webeng/week05
curl -sI http://webeng.test/week05/assets/ | head -n 1
```

## Step 5 – Enable compression for text assets

mod_deflate is built in; add a rule and compare transfer size.

```bash
echo 'AddOutputFilterByType DEFLATE text/html text/css text/javascript' | sudo tee /etc/httpd/conf.d/deflate.conf
sudo systemctl reload httpd
curl -s -H 'Accept-Encoding: gzip' -o /dev/null -w "%{size_download}\n" http://webeng.test/week05/assets/$(ls dist/assets | grep js | head -1)
```
