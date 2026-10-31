# Week 1: Internet, HTTP, Web Architectures and HTML5 Foundations – lecture notes

### 1.1 What Is Web Engineering?

Web engineering applies systematic, measurable engineering practice to the design, development, deployment and maintenance of web applications. Unlike a desktop program, a web application is delivered continuously, is exposed to the public internet, runs on thousands of device and browser combinations and is judged by performance, accessibility and security as much as by features.

| Aspect | Traditional software | Web application |
| --- | --- | --- |
| Release cycle | Versioned installers | Continuous deployment, often daily |
| Client | Known OS / hardware | Any browser, phone or desktop |
| Attack surface | Local machine | Public internet (OWASP Top 10) |
| Quality drivers | Correctness | Correctness + speed + accessibility + SEO |
| Content | Mostly code | Code + content + media |

### 1.2 Internet vs World Wide Web

The **Internet** is the global network of networks that moves packets using TCP/IP. The **World Wide Web** is one service on top of it: hyperlinked resources identified by URLs and transferred with HTTP. E-mail (SMTP) and file transfer (FTP/SFTP) are other services on the same Internet.

| Year | Milestone |
| --- | --- |
| 1969 / 1983 | ARPANET starts / TCP/IP becomes the standard protocol suite |
| 1989–1991 | Tim Berners-Lee proposes the Web; first server, browser and page |
| 1995 | JavaScript and PHP appear |
| 2015 | HTTP/2 (multiplexing over one TCP connection), now RFC 9113 |
| 2018 | TLS 1.3 (RFC 8446): faster, safer handshake |
| 2022 | HTTP/3 over QUIC (RFC 9114); HTTP semantics unified in RFC 9110 |

### 1.3 URI, URL and URN

A **URI** identifies a resource. A **URL** says where it is and how to fetch it; a **URN** names it independent of location (for example `urn:isbn:9780133775983`). Every URL is a URI, not every URI is a URL.

```
https://student@www.example.com:8443/docs/index.html?lang=en&page=2#intro
```

| Part | Value | Meaning |
| --- | --- | --- |
| Scheme | `https` | Protocol to use |
| Userinfo | `student` | Optional credentials (avoid) |
| Host | `www.example.com` | Resolved by DNS to an IP address |
| Port | `8443` | Default 80 (HTTP) / 443 (HTTPS) |
| Path | `/docs/index.html` | Resource on the server |
| Query | `?lang=en&page=2` | Parameters sent to the server |
| Fragment | `#intro` | Position inside the page; never sent to the server |

### 1.4 What Happens When You Open a Page

1. The browser parses the URL and checks its caches.
2. **DNS** resolves the host name: stub resolver → recursive resolver → root → TLD → authoritative server.
3. A **TCP** connection is opened (three-way handshake), or **QUIC** for HTTP/3.
4. A **TLS** handshake authenticates the server certificate and negotiates keys.
5. The browser sends an **HTTP request**; the server returns static content or runs application code and a database query.
6. The browser builds the **DOM** from HTML, fetches CSS / JS / images, builds the CSSOM, lays out, paints and runs JavaScript.

### 1.5 HTTP in Detail

**Request (top) and response (bottom)**

```
GET /week01/index.html HTTP/1.1
Host: webeng.test
Accept: text/html
User-Agent: curl/8.x

HTTP/1.1 200 OK
Content-Type: text/html; charset=UTF-8
Content-Length: 1234
Cache-Control: max-age=3600
```

| Method | Purpose | Safe | Idempotent |
| --- | --- | --- | --- |
| GET | Read a resource | Yes | Yes |
| HEAD | Headers only | Yes | Yes |
| POST | Create / submit data | No | No |
| PUT | Replace a resource | No | Yes |
| PATCH | Partial update | No | No |
| DELETE | Remove a resource | No | Yes |
| OPTIONS | Capabilities / CORS pre-flight | Yes | Yes |

| Class | Common codes |
| --- | --- |
| 1xx Informational | 101 Switching Protocols |
| 2xx Success | 200 OK, 201 Created, 204 No Content |
| 3xx Redirection | 301 Moved Permanently, 302 Found, 304 Not Modified |
| 4xx Client error | 400 Bad Request, 401 Unauthorized, 403 Forbidden, 404 Not Found, 405 Method Not Allowed |
| 5xx Server error | 500 Internal Server Error, 502 Bad Gateway, 503 Service Unavailable |

| Protocol | Layer | Role |
| --- | --- | --- |
| HTTP / HTTPS | Application | Web transfer; HTTPS = HTTP inside TLS |
| FTP / SFTP | Application | File transfer; FTP is unencrypted, prefer SFTP |
| TCP / UDP / QUIC | Transport | Reliable stream / datagrams / encrypted multiplexed transport on UDP |
| IP (v4, v6) | Internet | Addressing and routing |
| Ethernet, Wi-Fi | Link | Local delivery |

### 1.6 Web Architectures (CLO_1)

| Style | Structure | Example | Strength / weakness |
| --- | --- | --- | --- |
| 1-tier | UI, logic, data in one program | Local HTML file with JS and localStorage | Simple / no sharing, no security |
| 2-tier | Client ↔ database server | Old client-server app with SQL in the page | Fast to build / DB exposed, logic duplicated |
| 3-tier | Presentation ↔ application ↔ data tiers | Browser → Apache + PHP → MariaDB | Scalable, secure, replaceable tiers / more moving parts |
| MVC | Model (data/rules), View (output), Controller (input handling) | CodeIgniter, Laravel, Rails | Clean code organisation / learning curve |

> **Key distinction:** N-tier describes how a system is **deployed and layered**. MVC describes how code **inside** the application tier is **organised**. A modern site is usually 3-tier at runtime and MVC in its code.

**Web components** you must be able to classify: client (browser), web server (Apache, Nginx, Caddy), application runtime (PHP-FPM, Node.js), database (MariaDB), protocols (HTTP, TLS, DNS) and content languages (HTML, CSS, JavaScript).

### 1.7 HTML5 Essentials

**Minimal valid HTML5 document**

```html
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Page title</title>
</head>
<body>
  <h1>Heading</h1>
  <p>Paragraph with <strong>strong</strong>, <em>emphasis</em> and a <a href="about.html">link</a>.</p>
</body>
</html>
```

| Group | Elements |
| --- | --- |
| Headings / text | `h1`–`h6`, `p`, `strong`, `em`, `mark`, `small`, `sub`, `sup`, `br`, `hr`, `pre`, `code`, `blockquote` |
| Links / media | `a` (`href`, `target`, `rel`), `img` (`src`, `alt`, `width`, `height`) |
| Lists | `ul`, `ol`, `li`, `dl`, `dt`, `dd` |
| Tables | `table`, `caption`, `thead`, `tbody`, `tfoot`, `tr`, `th scope`, `td`, `colspan`, `rowspan` |
| Generic | `div` (block), `span` (inline), global attributes `id`, `class`, `lang`, `title`, `hidden`, `data-*` |
| Comments | `<!-- comment -->` (visible in page source, never put secrets in them) |

External links that open a new tab should include `rel="noopener noreferrer"`. Always provide meaningful `alt` text. Tables are for tabular data only, never for page layout.
