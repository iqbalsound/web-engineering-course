# Week 2: HTML5 Forms, Semantic Elements and Accessibility – lecture notes

### 2.1 Semantic HTML

Semantic elements describe **meaning**, not appearance. They give screen readers landmarks, improve SEO and make the code self-documenting. Use `div` and `span` only when no semantic element fits.

| Element | Meaning |
| --- | --- |
| `header` / `footer` | Introductory / closing content of a page or section |
| `nav` | Major navigation links |
| `main` | Dominant content, exactly one per page |
| `article` / `section` | Self-contained item / thematic grouping with a heading |
| `aside` | Tangential content (sidebar) |
| `figure` / `figcaption` | Illustration with caption |
| `details` / `summary` | Native disclosure widget (no JavaScript) |
| `dialog` | Modal or non-modal dialog (`showModal()`) |
| `search` | Landmark that wraps a search form |
| `time`, `mark`, `address` | Machine-readable date, highlight, contact info |

### 2.2 Forms

A form collects user input and sends it as name=value pairs. Key attributes: `action` (URL), `method` (`get` puts data in the query string and is for searches; `post` puts it in the body and is for changes), `enctype="multipart/form-data"` for file uploads, `autocomplete`, `novalidate`.

| Input type | Typical attributes | Benefit |
| --- | --- | --- |
| `text`, `search` | `required`, `minlength`, `maxlength`, `pattern` | Basic text |
| `email`, `url`, `tel` | `multiple`, `inputmode`, `autocomplete` | Mobile keyboards + validation |
| `number`, `range` | `min`, `max`, `step` | Numeric constraints |
| `date`, `time`, `datetime-local`, `month` | `min`, `max` | Native pickers |
| `checkbox`, `radio` | `name`, `value`, `checked` | Choices (radios share a name) |
| `file` | `accept`, `multiple`, `capture` | Uploads |
| `color`, `hidden`, `password` | `autocomplete="new-password"` | Specialised |

Other form elements: `label` (always bind with `for`/`id`), `fieldset` + `legend` (group related controls), `select` / `option`, `datalist` (suggestions), `textarea`, `output`, `button type="submit|reset|button"`, `progress`, `meter`.

### 2.3 Constraint Validation and the Client–Server Rule

Attributes such as `required` and `pattern` give instant feedback and can be styled with `:user-invalid`. The JavaScript Constraint Validation API (`input.validity`, `setCustomValidity()`, `form.reportValidity()`) allows custom messages.

> **Security rule:** Client-side validation is a convenience, never security. Anyone can bypass it with curl. The server must validate again (Weeks 9–11).

### 2.4 Accessibility (WCAG 2.2 AA Essentials)

- **Perceivable:** `alt` text, captions, text contrast at least 4.5:1, do not rely on colour alone.
- **Operable:** everything usable by keyboard (Tab, Enter, Space), visible focus, “skip to content” link, target size at least 24×24 CSS px.
- **Understandable:** `lang` attribute, labels and instructions, helpful error messages, `autocomplete` tokens.
- **Robust:** valid HTML first; use ARIA only when native elements cannot do the job (“no ARIA is better than bad ARIA”).

### 2.5 Metadata and Responsive Media

```
<meta name="description" content="Short page summary for search results">
<meta property="og:title" content="Registration">
<link rel="icon" href="favicon.svg" type="image/svg+xml">
<picture>
  <source srcset="hero.avif" type="image/avif">
  <img src="hero.jpg" alt="Students in a lab" width="800" height="450" loading="lazy">
</picture>
```
