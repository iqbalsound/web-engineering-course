# Week 15: Creating and Configuring a Blog: Themes, Custom Content, Security and Backups – lecture notes

### 15.1 Blog Anatomy and Settings

| Element | Use |
| --- | --- |
| Posts | Time-ordered entries with author, categories and tags (appear in feeds) |
| Pages | Static content (About, Contact); hierarchical |
| Categories / tags | Category = broad topic (hierarchical); tag = specific keyword |
| Media library | Images and files; always add alt text |
| Comments | Moderation queue, “comment held for approval”, disable on old posts |
| Settings | General (timezone Asia/Karachi), Reading (front page), Discussion, Permalinks (`/%postname%/`) |
| Roles | Administrator, Editor, Author, Contributor, Subscriber – give least privilege |

SEO and sharing basics: meaningful titles and headings, descriptive permalinks, excerpts, image alt text, fast pages, XML sitemap (built into core) and Open Graph metadata.

### 15.2 Child Themes and theme.json

Never edit a parent theme directly; an update would erase your work. A **child theme** inherits everything and overrides only what you change. In a block theme, the child’s `theme.json` merges with the parent’s, so you can replace palette, typography and spacing tokens without copying templates.

### 15.3 Custom Post Types, Taxonomies and Hooks

Content that is not a blog post (projects, events, courses) should be a **custom post type** registered by a **plugin**, not by the theme, so the content survives a theme change. `show_in_rest` makes it available in the block editor and the REST API.

### 15.4 Performance

- Enable PHP **OPcache**; use a page cache for anonymous visitors; serve images as WebP/AVIF with `width`/`height`.
- Keep plugins few; measure with Query Monitor and browser DevTools; target good Core Web Vitals (LCP, INP, CLS).

### 15.5 Security Hardening Checklist

| Control | How |
| --- | --- |
| Updates | Core, plugins and themes updated promptly (`wp core update`, `wp plugin update --all`) |
| Least privilege | Admin account only for administration; editors write content |
| File editing off | `DISALLOW_FILE_EDIT` stops code edits from the dashboard |
| File permissions | Directories 755, files 644, `wp-config.php` 640 |
| Attack surface | Remove unused plugins/themes; block `xmlrpc.php` if unused |
| Authentication | Strong unique passwords, 2FA plugin, login rate limiting |
| Transport | HTTPS everywhere (Let’s Encrypt in production) |
| Backups | Database + files, off-machine copy, tested restore |

> **Operations:** A backup that has never been restored is only a hope. Schedule a restore test.
