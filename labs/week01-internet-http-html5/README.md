# Week 1: Internet, HTTP, Web Architectures and HTML5 Foundations

| Syllabus lectures | CLO | PLO | Bloom | Assessment |
| --- | --- | --- | --- | --- |
| Lec 1–2 | CLO_1 | PLO_2 | C2 (Understanding) | A1 issued (due Week 2) |

## Lab: Own Web Server, HTTPS and First HTML5 Page

Publish an HTML5 student profile on your own Apache virtual host, capture and explain real HTTP traffic, resolve DNS names and upgrade the site to HTTPS with a self-signed certificate.

### Free and open-source tools
- Apache HTTP Server 2.4 (Apache-2.0)
- curl (MIT-style), OpenSSL (Apache-2.0), tcpdump (BSD), dig (MPL-2.0)
- Firefox DevTools (MPL-2.0), Kate / VSCodium (LGPL / MIT)

### Deliverables
- `/var/www/webeng/week01/index.html` served over HTTP and HTTPS
- Text file `http-notes.txt` with 3 captured requests (200, 301/404, 304) and a one-line explanation of each
- Screenshot of DevTools Network tab showing HTTP version and timing
- Starts Assignment A1 (see below)

### Contents of this folder
- [`lecture-notes.md`](lecture-notes.md) – the week's theory
- [`rocky10.md`](rocky10.md) – step-by-step lab, **Version A (Rocky Linux 10)**
- [`kubuntu2604.md`](kubuntu2604.md) – step-by-step lab, **Version B (Kubuntu 26.04 LTS)**
- `code/index.html`

`code/` holds the reference source files exactly as printed in the lab manual (they are the files the labs ask you to create).


### Verification checklist
| # | Check | Expected Result |
| --- | --- | --- |
| 1 | `curl -sI http://webeng.test/week01/ \| head -1` | `HTTP/1.1 200 OK` |
| 2 | `curl -sI .../missing.html \| head -1` | `HTTP/1.1 404 Not Found` |
| 3 | `curl -skI --http2 https://webeng.test/week01/ \| head -1` | `HTTP/2 200` |
| 4 | tcpdump output | Request line and headers visible in clear text on port 80 |
| 5 | Firefox DevTools → Network | Protocol column shows `h2` for the HTTPS request |
| 6 | Rocky: `sudo ausearch -m avc -ts recent` | No SELinux denials (Version B: no errors in error.log) |

### Stretch goals
- Add `Header always set Strict-Transport-Security "max-age=300"` and `X-Content-Type-Options: nosniff`; confirm with `curl -sI`.
- Redirect HTTP to HTTPS with a `Redirect permanent` rule and observe the 301.
- Replace the self-signed certificate with a locally trusted one using `mkcert` (BSD-3).

### Additional work
#### Assignment A1 (CLO_1, 4 marks) – issued this week, due Week 2

Write a 2-page report on the architecture of an **online university portal**. Draw the 1-tier, 2-tier and 3-tier versions and then show how MVC organises the application tier. Support the report with the HTTP evidence captured in this lab and justify one trade-off (security, scalability or cost).

### Review questions
1. Differentiate Internet and WWW with one example service of each.
2. Break `https://api.shop.pk:8443/v1/items?id=5#top` into its URI components.
3. Why is a URL fragment never sent to the server?
4. Explain, with an example, why a site can be three-tier at runtime and still use MVC in code.
5. What do status codes 301, 304, 403 and 502 tell you about where a problem lies?

---
Instructor solutions: [`instructor/solutions/week01-internet-http-html5.md`](../../instructor/solutions/week01-internet-http-html5.md)
