# Week 7 lab: Responsive Product Catalogue with Carousel, Pagination and Dark Mode – Rocky Linux 10

## Step 1 – Wireframe first in Penpot

Open penpot.app (free) or your self-hosted instance and sketch a mobile and a desktop frame with hero, grid and pager.

```bash
firefox https://design.penpot.app &
```

## Step 2 – Create the project

Install Bootstrap with its Popper peer dependency and the icon font.

```bash
mkdir -p ~/webeng/week07 && cd ~/webeng/week07
npm init -y && npm pkg set type=module
npm install bootstrap @popperjs/core bootstrap-icons && npm install --save-dev vite
kate index.html main.js &
npx vite --host 127.0.0.1
```

## Step 3 – Build and deploy

Icon font files are bundled into dist/assets automatically.

```bash
npx vite build --base=/week07/
rsync -a --delete dist/ /var/www/webeng/week07/
sudo restorecon -Rv /var/www/webeng/week07
```

## Step 4 – Measure page weight

Compare uncompressed and gzip transfer; this is the framework trade-off.

```bash
du -sh dist; ls -lh dist/assets | sort -k5 -h | tail -n 4
curl -s -H 'Accept-Encoding: gzip' -o /dev/null -w "HTML: %{size_download} bytes\n" http://webeng.test/week07/
```
