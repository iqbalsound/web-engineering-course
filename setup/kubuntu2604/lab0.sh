#!/usr/bin/env bash
# Lab 0 – Kubuntu 26.04 LTS
# Assembled from the Lab 0 section of the lecture notes. Read it first, then run as a normal user with sudo rights.
# nvm needs an interactive shell, so it is loaded explicitly below.
set -eo pipefail

# ---- Step 1: Update and install base packages ----
# Kubuntu already includes Firefox (snap) and Kate.
sudo apt update && sudo apt -y full-upgrade
sudo apt -y install apache2 git curl wget unzip jq tmux bind9-dnsutils \
  netcat-openbsd tcpdump openssl ufw flatpak plasma-discover-backend-flatpak
sudo a2enmod ssl rewrite headers

# ---- Step 2: Start Apache and configure the firewall ----
# Allow SSH first if you work remotely. ufw is inactive by default.
sudo systemctl enable --now apache2
sudo ufw allow OpenSSH
sudo ufw allow "Apache Full"
sudo ufw --force enable
sudo ufw status verbose

# ---- Step 3: Create the web root ----
# www-data is the Apache user; the setgid bit keeps group ownership.
sudo mkdir -p /var/www/webeng
sudo chown $USER:www-data /var/www/webeng
sudo chmod 2775 /var/www/webeng

# ---- Step 4: Create the virtual host ----
# Sites are enabled with a2ensite; the default site is disabled.
sudo tee /etc/apache2/sites-available/webeng.conf >/dev/null <<'EOF'
<VirtualHost *:80>
    ServerName webeng.test
    DocumentRoot /var/www/webeng
    <Directory /var/www/webeng>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    ErrorLog ${APACHE_LOG_DIR}/webeng_error.log
    CustomLog ${APACHE_LOG_DIR}/webeng_access.log combined
</VirtualHost>
EOF
echo "127.0.0.1 webeng.test" | sudo tee -a /etc/hosts
sudo a2dissite 000-default && sudo a2ensite webeng
sudo apache2ctl configtest && sudo systemctl reload apache2

# ---- Step 5: Install Node.js LTS with nvm and the editor ----
# Identical to Rocky because nvm is distribution-independent.
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
