# Week 3 lab: Responsive Event Landing Page (Mobile-First) – Kubuntu 26.04 LTS

## Step 1 – Create files

Save index.html and style.css.

```bash
mkdir -p /var/www/webeng/week03 && cd /var/www/webeng/week03
kate index.html style.css &
```

## Step 2 – Install the linter

Stylelint checks CSS the way a compiler checks code.

```bash
npm init -y && npm install --save-dev stylelint stylelint-config-standard prettier
echo '{ "extends": "stylelint-config-standard" }' > .stylelintrc.json
npx prettier --write style.css && npx stylelint style.css
```

## Step 3 – Test responsiveness

Open the page, press Ctrl+Shift+M, choose 360×640, then 1280×800. Switch Plasma to the dark theme (System Settings → Colors & Themes) to test dark mode.

```bash
firefox http://webeng.test/week03/ &
```

## Step 4 – Check delivered size and caching

Industry teams track transferred bytes.

```bash
curl -s -o /dev/null -w "%{size_download} bytes, HTTP %{http_code}\n" http://webeng.test/week03/style.css
curl -sI http://webeng.test/week03/style.css | grep -iE 'etag|last-modified|content-type'
```
