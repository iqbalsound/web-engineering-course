# Week 11: Full-Stack PHP: Templates, Authentication, Products, Cart and Error Handling – lecture notes

### 11.1 Application Structure

Even without a framework, separate **public entry points** (`public/*.php`) from **non-public code** (`src/`, `config/`, `storage/`). A `bootstrap.php` starts the session, configures error handling and loads helpers. Templates (header/footer) remove duplication. This is the seed of the MVC pattern used by CodeIgniter and Laravel in Week 13.

### 11.2 Authentication and Sessions

- **Hash passwords** with `password_hash($pw, PASSWORD_DEFAULT)` (bcrypt/argon2) and verify with `password_verify()`; never use MD5 or SHA-1.
- After login call `session_regenerate_id(true)` to prevent **session fixation**.
- Session cookie flags: `HttpOnly`, `Secure` (HTTPS), `SameSite=Lax`.
- Use one generic message (“E-mail or password incorrect”) to avoid revealing which accounts exist.
- **Authentication** = who you are; **authorisation** = what you may do (check `role` on every protected action).

### 11.3 CSRF

Cross-Site Request Forgery tricks a logged-in browser into submitting a request. Defence: embed a random per-session token in every state-changing form, verify it with `hash_equals()` and use `SameSite` cookies. State-changing actions must use POST, never GET.

### 11.4 Cart and Checkout

A simple cart lives in `$_SESSION["cart"]` as `product_id => qty`. Prices must always be read from the database at checkout, never from the browser. Checkout runs in a **transaction**: lock the product rows (`SELECT … FOR UPDATE`), verify stock, insert the order and items, decrement stock, commit; on any exception roll back so the database never holds half an order.

### 11.5 Error Handling and Logging

- Configure PDO with `ERRMODE_EXCEPTION`; catch `PDOException` only where you can recover (for example duplicate keys).
- Install `set_exception_handler()` for everything else: log the full error, show users a short message and HTTP 500.
- Production: `display_errors=0`, `log_errors=1`, a log file outside the web root, and log rotation.
