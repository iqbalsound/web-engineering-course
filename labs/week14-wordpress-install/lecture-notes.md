# Week 14: WordPress: Architecture, Installation, Plugins and the Block Editor – lecture notes

### 14.1 Why a CMS?

A content management system separates **content** from **presentation** and gives non-programmers an editor, user roles, media handling, revisions and an extension ecosystem. WordPress (GPL-2.0-or-later) is written in PHP on MariaDB/MySQL and runs a very large share of public websites, so WordPress skills are directly employable.

### 14.2 Architecture

| Component | Location / table | Role |
| --- | --- | --- |
| Core | `wp-admin/`, `wp-includes/` | Never edited; replaced on update |
| Content & settings | `wp_posts`, `wp_postmeta`, `wp_options`, `wp_users`, `wp_terms` | All site data in the database |
| Themes | `wp-content/themes/` | Appearance; **block themes** use HTML templates + `theme.json` |
| Plugins | `wp-content/plugins/` | Features added through hooks |
| Uploads | `wp-content/uploads/` | Media; the only folder that must be writable in production |
| Config | `wp-config.php` | DB credentials, salts, constants (keep outside web root if possible) |

Extensibility works through **hooks**: *actions* run code at a moment (`add_action("init", …)`), *filters* modify data (`add_filter("the_title", …)`). The **template hierarchy** decides which template renders a URL (`single-project.php` → `single.php` → `singular.php` → `index.php`; block themes use `templates/*.html`). The REST API (`/wp-json/`) exposes content as JSON, enabling headless use with Angular or React.

### 14.3 Block Editor, Patterns and Full-Site Editing

- Content is stored as HTML wrapped in block comments (`<!-- wp:paragraph -->`), so it stays readable and versionable.
- **Patterns** are reusable block layouts; **template parts** (header, footer) and **Styles** (colours, typography) are edited in the **Site Editor**.
- `theme.json` defines the design tokens (palette, font sizes, spacing) that appear as controls in the editor.

### 14.4 Choosing and Vetting Plugins

| Check | Good sign |
| --- | --- |
| Active installations | Large, stable user base |
| Last updated / tested up to | Updated in the last 6 months, tested with the current WordPress and PHP |
| Support forum | Developer answers issues |
| Licence / source | GPL-compatible and open source |
| Footprint | Does not add dozens of database queries (measure with Query Monitor) |
| Necessity | Could a block, pattern or a few lines of code replace it? |

### 14.5 WordPress vs a PHP Framework (CLO_3 Analysis)

| Requirement | Best fit | Reason |
| --- | --- | --- |
| Blog / marketing site edited by non-developers | WordPress | Editor, themes and plugins ready-made |
| Custom business rules, complex workflows | CodeIgniter 4 / Laravel | Full control, testable code |
| Mobile app back-end API | Laravel / CodeIgniter 4 (or WP REST API for content) | Structured routing, auth, validation |
| Store with standard catalogue | WordPress + WooCommerce (GPL) | Common requirements already solved |
