# Week 1 solutions: Internet, HTTP, Architectures and HTML5

## Expected results and evidence
| Check | Expected result / model evidence |
| --- | --- |
| `curl -sI http://webeng.test/week01/ \| head -1` | `HTTP/1.1 200 OK` |
| Missing page | `HTTP/1.1 404 Not Found` |
| Conditional request with the ETag | `HTTP/1.1 304 Not Modified` (no body) |
| `curl -skI --http2 https://webeng.test/week01/` | `HTTP/2 200` |
| TLS certificate | Subject `C=PK, ST=Sindh, L=Karachi, O=Hamdard, CN=webeng.test`, validity 365 days |
| tcpdump on port 80 | Request line, `Host`, `User-Agent` readable in clear text (HTTPS payload would be unreadable) |
| DevTools → Network | Protocol column `h2` for the HTTPS request; `http/1.1` for the HTTP request |

**Model response headers (Rocky shows “Rocky Linux”, Kubuntu shows “Ubuntu”)**

```
HTTP/1.1 200 OK
Server: Apache/2.4.x (Rocky Linux)          # Kubuntu: Apache/2.4.66 (Ubuntu)
Last-Modified: Fri, 30 Oct 2026 09:10:11 GMT
ETag: "4d2-64b1f0a2c3d40"
Accept-Ranges: bytes
Content-Length: 1234
Content-Type: text/html; charset=UTF-8
```

**Producing the 304 (same commands on both systems)**

```
URL=http://webeng.test/week01/index.html
ETAG=$(curl -sI $URL | awk -F': ' 'tolower($1)=="etag"{print $2}' | tr -d '\r')
curl -sI -H "If-None-Match: $ETAG" $URL | head -n 1      # HTTP/1.1 304 Not Modified
```

**Model http-notes.txt**

```
1) GET /week01/index.html      -> 200 OK: resource exists, body returned (Content-Length 1234).
2) GET /week01/missing.html    -> 404 Not Found: server reached, but no such path (client error).
3) GET with If-None-Match      -> 304 Not Modified: browser cache copy is still valid, no body sent.
```


## Troubleshooting guide
| Symptom | Likely cause | Fix (Rocky 10 / Kubuntu 26.04) |
| --- | --- | --- |
| `Could not resolve host: webeng.test` | Missing hosts entry | `echo "127.0.0.1 webeng.test" \| sudo tee -a /etc/hosts` |
| 403 Forbidden | Rocky: wrong SELinux type or folder not readable. Kubuntu: directory permissions | Rocky: `ls -Zd`, `sudo restorecon -Rv /var/www/webeng`. Kubuntu: `namei -l /var/www/webeng/week01/index.html`, `chmod o+rx` on the failing folder |
| `configtest` fails after adding the 443 host | SSL module missing or certificate path wrong | Rocky: `sudo dnf -y install mod_ssl`. Kubuntu: `sudo a2enmod ssl`. Check the two file paths with `ls -l` |
| HTTPS works but shows `HTTP/1.1` | `Protocols` line missing or prefork MPM | Put `Protocols h2 http/1.1` inside the 443 host. Kubuntu: `a2enmod http2`, confirm `apache2ctl -M \| grep mpm_event` |
| tcpdump prints nothing | Wrong interface | webeng.test is 127.0.0.1, so capture on `-i lo` |
| Page works locally but not from another PC | Firewall | Rocky: `firewall-cmd --permanent --add-service=http --add-service=https && firewall-cmd --reload`. Kubuntu: `sudo ufw allow "Apache Full"` |
| Browser shows a certificate warning | Self-signed certificate (expected) | Add an exception for the lab; in production use Let’s Encrypt, locally use `mkcert` |

## Viva prompts and marking notes
- Ask the student to explain what happened between pressing Enter and seeing the page (DNS → TCP → TLS → HTTP → render).
- Ask why `-k` is acceptable in this lab and never in production.
- Marking points: running server (4), correct captures and explanations (2), TLS/HTTP2 evidence (2), clean HTML5 (1), viva (1).

## Answers to review questions
1. The Internet is the global TCP/IP network; the Web is one service on it (hyperlinked resources over HTTP). E-mail over SMTP uses the Internet but is not the Web.
2. Scheme `https`, host `api.shop.pk`, port `8443`, path `/v1/items`, query `id=5`, fragment `top`.
3. The fragment is handled only by the browser (scroll position / client-side state); it is stripped from the HTTP request line.
4. At runtime the system is three-tier (browser → Apache + PHP → MariaDB). Inside the application tier the code is organised as Model, View and Controller, so both descriptions are true at once.
5. 301: resource moved permanently (update links; redirect rule). 304: cached copy still valid. 403: server understood but refuses (permissions, SELinux, access rule). 502: a gateway/proxy received an invalid response from the upstream application (for example PHP-FPM is down).
