# Week 16 lab: Containerised Capstone: Apache/PHP + MariaDB with Podman Compose and a Quadlet Service – Rocky Linux 10

## Step 1 – Install tools and create the repository

EPEL provides podman-compose; the fallback installs it with pip.

```bash
sudo dnf -y install podman git epel-release
sudo dnf -y install podman-compose || { sudo dnf -y install python3-pip && pip install --user podman-compose; }
mkdir -p ~/webeng/capstone/{web,app} && cd ~/webeng/capstone && git init -q -b main
cp /var/www/webeng/week10/schema.sql . && kate compose.yaml web/Containerfile app/index.php &
printf '.env\n*.log\n' > .gitignore
```

## Step 2 – Set the SELinux-aware mount option

On Rocky the `Z` option relabels the mounted host folders so that the container may read them.

```bash
echo 'MOUNT_OPTS=ro,Z' > .env
podman info --format 'rootless={{.Host.Security.Rootless}} selinux={{.Host.Security.SELinuxEnabled}}'
```

## Step 3 – Build and start the stack

First start downloads images and initialises the database from schema.sql.

```bash
podman-compose up -d --build
podman-compose ps
sleep 20 && curl -s http://127.0.0.1:8090/ | grep -E 'DB|PHP'
```

## Step 4 – Prove persistence and recovery

Data lives in the named volume; a stopped database yields HTTP 503 and recovers.

```bash
podman volume ls
podman-compose stop db; curl -s -o /dev/null -w "db down: %{http_code}\n" http://127.0.0.1:8090/
podman-compose start db; sleep 15; curl -s -o /dev/null -w "db up: %{http_code}\n" http://127.0.0.1:8090/
podman-compose down && podman-compose up -d && sleep 20 && curl -s http://127.0.0.1:8090/ | grep products
```

## Step 5 – Run Mailpit as a boot-time service (Quadlet)

Remove the Week 13 container first so the ports are free. Linger lets the user service start at boot.

```bash
podman rm -f mailpit 2>/dev/null; mkdir -p ~/.config/containers/systemd && kate ~/.config/containers/systemd/mailpit.container
systemctl --user daemon-reload && systemctl --user start mailpit.service
sudo loginctl enable-linger $USER && systemctl --user status mailpit.service --no-pager | head -n 5
curl -s -o /dev/null -w "mailpit UI: %{http_code}\n" http://127.0.0.1:8025/
```

## Step 6 – Commit with the hook and tag the release

The hook blocks commits that contain PHP syntax errors.

```bash
install -m 0755 /dev/stdin .git/hooks/pre-commit <<'EOF'
#!/usr/bin/env bash
set -e
for f in $(git diff --cached --name-only --diff-filter=ACM | grep '\.php$' || true); do php -l "$f" > /dev/null; done
echo "pre-commit OK"
EOF
git add -A && git commit -qm "Capstone: containerised shop stack" && git tag v1.0.0 && git log --oneline --decorate | head -n 3
```
