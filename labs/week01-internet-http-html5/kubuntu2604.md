# Week 1 lab: Own Web Server, HTTPS and First HTML5 Page – Kubuntu 26.04 LTS

## Step 1 – Create the lab folder

The web root is group-writable by your user and www-data (Lab 0).

```bash
mkdir -p /var/www/webeng/week01 && cd /var/www/webeng/week01
kate index.html about.html &      # or: flatpak run com.vscodium.codium .
ls -ld /var/www/webeng/week01
```

## Step 2 – Request the page and read the headers

Compare a normal request, a header-only request and a missing page.

```bash
curl -i http://webeng.test/week01/
curl -sI http://webeng.test/week01/ | head -n 5
curl -sI http://webeng.test/week01/missing.html | head -n 1
```

## Step 3 – Capture the traffic

Terminal 1 captures on the loopback interface; terminal 2 sends the request.

```bash
sudo tcpdump -i lo -A -nn port 80 -c 20        # terminal 1
curl -s http://webeng.test/week01/ > /dev/null   # terminal 2
```

## Step 4 – Resolve names and check listening ports

Document the DNS chain and which process owns port 80.

```bash
dig +short hamdard.edu.pk A
dig +trace hamdard.edu.pk | tail -n 12
sudo ss -tlnp | grep -E ':80|:443'
sudo ufw status verbose
```

## Step 5 – Create a certificate

Keys live in /etc/ssl/private (group ssl-cert).

```bash
sudo openssl req -x509 -newkey rsa:2048 -nodes -days 365 \
  -keyout /etc/ssl/private/webeng.key -out /etc/ssl/certs/webeng.crt \
  -subj "/C=PK/ST=Sindh/L=Karachi/O=Hamdard/CN=webeng.test" \
  -addext "subjectAltName=DNS:webeng.test"
```

## Step 6 – Add an HTTPS virtual host with HTTP/2

Enable the http2 module and the new site.

```bash
sudo tee /etc/apache2/sites-available/webeng-ssl.conf >/dev/null <<'EOF'
<VirtualHost *:443>
    ServerName webeng.test
    DocumentRoot /var/www/webeng
    Protocols h2 http/1.1
    SSLEngine on
    SSLCertificateFile /etc/ssl/certs/webeng.crt
    SSLCertificateKeyFile /etc/ssl/private/webeng.key
    <Directory /var/www/webeng>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
EOF
sudo a2enmod http2 && sudo a2ensite webeng-ssl
sudo apache2ctl configtest && sudo systemctl reload apache2
```

## Step 7 – Verify TLS and HTTP/2

`-k` accepts the self-signed certificate for testing only.

```bash
curl -skI --http2 https://webeng.test/week01/ | head -n 3
openssl s_client -connect webeng.test:443 -servername webeng.test </dev/null 2>/dev/null \
  | openssl x509 -noout -subject -dates
sudo tail -n 5 /var/log/apache2/error.log
```
