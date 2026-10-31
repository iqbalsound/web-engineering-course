# Week 1 lab: Own Web Server, HTTPS and First HTML5 Page – Rocky Linux 10

## Step 1 – Create and label the lab folder

Files you create inherit the label of the folder; files you move in with mv keep their old label, so run restorecon.

```bash
mkdir -p /var/www/webeng/week01 && cd /var/www/webeng/week01
kate index.html about.html &      # or: flatpak run com.vscodium.codium .
ls -Zd /var/www/webeng/week01     # expect httpd_sys_content_t
sudo restorecon -Rv /var/www/webeng
```

## Step 2 – Request the page and read the headers

Compare a normal request, a header-only request and a missing page.

```bash
curl -i http://webeng.test/week01/
curl -sI http://webeng.test/week01/ | head -n 5
curl -sI http://webeng.test/week01/missing.html | head -n 1
```

## Step 3 – Capture the traffic

Terminal 1 captures on the loopback interface; terminal 2 sends the request. Plain HTTP is readable, which is why HTTPS exists.

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
sudo firewall-cmd --list-all
```

## Step 5 – Create a certificate

Keys go to /etc/pki/tls/private and must keep their SELinux label.

```bash
sudo openssl req -x509 -newkey rsa:2048 -nodes -days 365 \
  -keyout /etc/pki/tls/private/webeng.key -out /etc/pki/tls/certs/webeng.crt \
  -subj "/C=PK/ST=Sindh/L=Karachi/O=Hamdard/CN=webeng.test" \
  -addext "subjectAltName=DNS:webeng.test"
sudo restorecon -v /etc/pki/tls/private/webeng.key /etc/pki/tls/certs/webeng.crt
```

## Step 6 – Add an HTTPS virtual host with HTTP/2

Append to the existing configuration file.

```bash
sudo tee -a /etc/httpd/conf.d/webeng.conf >/dev/null <<'EOF'
<VirtualHost *:443>
    ServerName webeng.test
    DocumentRoot /var/www/webeng
    Protocols h2 http/1.1
    SSLEngine on
    SSLCertificateFile /etc/pki/tls/certs/webeng.crt
    SSLCertificateKeyFile /etc/pki/tls/private/webeng.key
    <Directory /var/www/webeng>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
EOF
sudo apachectl configtest && sudo systemctl reload httpd
```

## Step 7 – Verify TLS and HTTP/2

`-k` accepts the self-signed certificate for testing only.

```bash
curl -skI --http2 https://webeng.test/week01/ | head -n 3
openssl s_client -connect webeng.test:443 -servername webeng.test </dev/null 2>/dev/null \
  | openssl x509 -noout -subject -dates
sudo ausearch -m avc -ts recent        # must show no denials
```
