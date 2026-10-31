# Week 13: Email, Cookies, Sessions and MVC Frameworks (CodeIgniter 4 and Laravel) – lecture notes

### 13.1 How E-mail Works

A mail user agent hands a message to an **SMTP** server (port 587 with STARTTLS or 465 with TLS). The server looks up the recipient domain’s **MX** record in DNS and relays the message; the recipient reads it through **IMAP** or **POP3**. PHP’s built-in `mail()` function depends on a local mail program and offers little control, so applications use a library such as **Symfony Mailer** or PHPMailer with an authenticated SMTP service.

| Mechanism | What it proves | Where it lives |
| --- | --- | --- |
| SPF | Which servers may send for the domain | TXT record |
| DKIM | The message is signed and not altered | TXT record with public key |
| DMARC | Policy when SPF / DKIM fail; reports | TXT record `_dmarc` |

Rules for transactional mail: send from a domain you control, include a plain-text alternative, never put passwords in mail, make reset tokens random, single-use and short-lived, and store only a hash of the token. In development, use a **mail catcher** (Mailpit) so that no real message leaves the machine.

### 13.2 Cookies and Sessions

| Cookie attribute | Purpose |
| --- | --- |
| `Expires` / `Max-Age` | Lifetime; omitted = session cookie (deleted when the browser closes) |
| `Path`, `Domain` | Scope of the cookie |
| `Secure` | Send only over HTTPS |
| `HttpOnly` | Not readable from JavaScript (limits XSS damage) |
| `SameSite=Lax\|Strict\|None` | Controls cross-site sending (CSRF defence) |
| `__Host-` prefix | Forces Secure, Path=/ and no Domain |

A **session** keeps data on the server and gives the browser only a random identifier in a cookie. Storage can be files (PHP default), a database or Redis (needed when several servers share users). Protect sessions by regenerating the ID at privilege changes, setting an idle timeout and destroying the session on logout. Cookies are for preferences and identifiers, never for storing prices, roles or passwords.

### 13.3 MVC and the Three-Tier Model (CLO_1 Revisited)

| MVC part | Responsibility | Tier it lives in |
| --- | --- | --- |
| Model | Data access and business rules | Application tier (talks to the data tier) |
| View | Templates that produce HTML / JSON | Application tier (output sent to the presentation tier) |
| Controller | Receives the request, calls models, picks a view | Application tier |
| Router / filters | URL → controller; CSRF, auth, throttling | Application tier |

### 13.4 CodeIgniter 4 and Laravel

| Aspect | CodeIgniter 4 | Laravel |
| --- | --- | --- |
| Size / speed | Small, fast start, few dependencies | Large ecosystem, more setup and memory |
| CLI tool | `php spark` | `php artisan` |
| ORM | Model + Query Builder (entities optional) | Eloquent ORM (active record, relations) |
| Templates | PHP views, View Cells | Blade |
| Migrations / validation | Built in | Built in |
| Auth, queues, scheduler | Add-ons (Shield) / basic | First-party packages and starter kits |
| Typical fit | Small and medium apps, shared hosting | Large products, APIs, teams |

CodeIgniter 4 layout: `app/Controllers`, `app/Models`, `app/Views`, `app/Config` (Routes, Filters, Database), `app/Database/Migrations`, `public/` (the only web-exposed folder), `writable/` (logs, sessions, cache) and `.env` for secrets. Request lifecycle: `public/index.php` → router → before-filters (CSRF) → controller → model → view → after-filters → response.
