#!/usr/bin/env bash
# Lab 0 – Rocky Linux 10
# Assembled from the Lab 0 section of the lecture notes. Read it first, then run as a normal user with sudo rights.
# nvm needs an interactive shell, so it is loaded explicitly below.
set -eo pipefail

# ---- Step 1: Update and install base packages ----
# EPEL provides extra tooling; CRB enables build dependencies.
sudo dnf -y upgrade --refresh
sudo dnf -y install epel-release
sudo crb enable
sudo dnf -y install httpd mod_ssl git curl wget unzip tar jq tmux bind-utils \
  nmap-ncat tcpdump openssl policycoreutils-python-utils flatpak firefox

# ---- Step 2: Start Apache and open the firewall ----
# firewalld is the default firewall; permanent rules survive reboot.
sudo systemctl enable --now httpd
sudo firewall-cmd --permanent --add-service=http --add-service=https
sudo firewall-cmd --reload
sudo firewall-cmd --list-services

# ---- Step 3: Create the web root with correct SELinux labels ----
# SELinux is enforcing; content must carry the type `httpd_sys_content_t`.
sudo mkdir -p /var/www/webeng
sudo chown $USER:apache /var/www/webeng
sudo chmod 2775 /var/www/webeng
sudo semanage fcontext -a -t httpd_sys_content_t "/var/www/webeng(/.*)?"
sudo restorecon -Rv /var/www/webeng

# ---- Step 4: Create the virtual host ----
# Files in /etc/httpd/conf.d/ are loaded automatically.
sudo tee /etc/httpd/conf.d/webeng.conf >/dev/null <<'EOF'
<VirtualHost *:80>
    ServerName webeng.test
    DocumentRoot /var/www/webeng
    <Directory /var/www/webeng>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    ErrorLog logs/webeng_error.log
    CustomLog logs/webeng_access.log combined
</VirtualHost>
EOF
echo "127.0.0.1 webeng.test" | sudo tee -a /etc/hosts
sudo apachectl configtest && sudo systemctl reload httpd

# ---- Step 5: Install Node.js LTS with nvm and the editor ----
# nvm lets each student install Node without root. VSCodium is the open-source build of VS Code.
NVM_TAG=$(curl -s https://api.github.com/repos/nvm-sh/nvm/releases/latest | jq -r .tag_name)
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/${NVM_TAG}/install.sh | bash
export NVM_DIR="$HOME/.nvm"; . "$NVM_DIR/nvm.sh"
nvm install --lts && node -v && npm -v
flatpak remote-add --if-not-exists flathub https://dl.flathub.org/repo/flathub.flatpakrepo
flatpak install -y flathub com.vscodium.codium

# ---- Step 6: Smoke test ----
# You should see HTTP 200 and the test text.
echo "<h1>webeng ready</h1>" > /var/www/webeng/index.html
curl -i http://webeng.test/
