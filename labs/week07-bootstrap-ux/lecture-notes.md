# Week 7: Bootstrap 5.3, UI/UX and Component-Based Interfaces – lecture notes

### 7.1 UI/UX Foundations

- **Nielsen’s heuristics:** visibility of system status, match with the real world, user control, consistency, error prevention, recognition over recall, flexibility, minimalist design, help users recover from errors, documentation.
- **Laws of UX:** Fitts’s law (bigger, closer targets), Hick’s law (fewer choices decide faster), Jakob’s law (users expect your site to work like others).
- **Process:** user research → wireframe → prototype → usability test → build. **Penpot** (open-source design tool, browser-based) is used for wireframes.

### 7.2 Bootstrap Grid and Utilities

Bootstrap 5.3 is mobile-first and flexbox/grid-based. A `container` holds `row`s of up to 12 `col`s. Breakpoint prefixes: `sm` ≥576, `md` ≥768, `lg` ≥992, `xl` ≥1200, `xxl` ≥1400 px.

```
<div class="container">
  <div class="row g-3">
    <div class="col-12 col-md-6 col-lg-4">…</div>       <!-- 1 / 2 / 3 per row -->
  </div>
</div>
<p class="text-center fw-bold mt-3 mb-0 text-primary">Utilities replace custom CSS</p>
```

| Utility group | Examples |
| --- | --- |
| Spacing | `m-3`, `px-4`, `mt-auto`, `gap-2` |
| Display / flex | `d-flex`, `justify-content-between`, `align-items-center`, `d-none d-md-block` |
| Text / colour | `text-center`, `fs-4`, `text-body-secondary`, `bg-body-tertiary` |
| Sizing / border | `w-100`, `rounded-3`, `border`, `shadow-sm` |

### 7.3 Components and Replaced Features

| Syllabus item | Status in Bootstrap 5.3 | What to use |
| --- | --- | --- |
| Jumbotron | Removed in v5 | `<div class="p-5 mb-4 bg-body-tertiary rounded-3">` hero using utilities |
| Glyphicons | Removed in v4 | Bootstrap Icons: `<i class="bi bi-cart"></i>` |
| Pagination | Available | `ul.pagination > li.page-item > a.page-link`; mark current with `.active` and `aria-current="page"` |
| Carousel plugin | Available | `.carousel.slide` with `data-bs-ride`, controls and indicators; add `alt` text |

### 7.4 Colour Modes, Customisation and Accessibility

Bootstrap 5.3 supports light and dark modes with `data-bs-theme="dark"` on `<html>` or any element. Components are themed by CSS variables such as `--bs-primary`; override them in your own stylesheet or compile Sass for deep customisation. Bootstrap’s JavaScript components (modal, carousel, dropdown) include keyboard handling and ARIA roles; keep the required attributes (`aria-label`, `aria-current`, `aria-controls`).

> **Trade-off:** A framework speeds delivery but increases page weight. Import only what you use in real projects and measure with the browser Network tab.
