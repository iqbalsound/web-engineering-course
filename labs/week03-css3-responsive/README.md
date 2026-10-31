# Week 3: CSS3: Selectors, Modern Layout and Responsive Design

| Syllabus lectures | CLO | PLO | Bloom | Assessment |
| --- | --- | --- | --- | --- |
| Lec 5–6 | CLO_1 | PLO_2 | C2 (Understanding) | — |

## Lab: Responsive Event Landing Page (Mobile-First)

Build a “Karachi Dev Meetup” landing page using Grid, Flexbox, custom properties, dark mode, a container-query card and a CSS-only loader, linted with Stylelint.

### Free and open-source tools
- Stylelint + stylelint-config-standard (MIT)
- Firefox Responsive Design Mode (Ctrl+Shift+M)
- Prettier (MIT)

### Deliverables
- `index.html` + `style.css` in `/var/www/webeng/week03/`
- No horizontal scrolling at 360 px width
- Dark mode follows the OS; animations stop with reduced-motion
- Stylelint reports 0 problems

### Contents of this folder
- [`lecture-notes.md`](lecture-notes.md) – the week's theory
- [`rocky10.md`](rocky10.md) – step-by-step lab, **Version A (Rocky Linux 10)**
- [`kubuntu2604.md`](kubuntu2604.md) – step-by-step lab, **Version B (Kubuntu 26.04 LTS)**
- `code/index.html`
- `code/style.css`

`code/` holds the reference source files exactly as printed in the lab manual (they are the files the labs ask you to create).


### Verification checklist
| # | Check | Expected Result |
| --- | --- | --- |
| 1 | `npx stylelint style.css` | No problems reported |
| 2 | Width 360 px | Single column, no horizontal scrollbar |
| 3 | Width ≥ 1000 px | Three card columns; cards switch to row layout via container query |
| 4 | OS dark mode on | Background and text colours invert using custom properties |
| 5 | Reduced motion enabled | Loader stops spinning |

### Stretch goals
- Add a `@media print` stylesheet.
- Replace the colour palette using `oklch()` and `color-mix()`.
- Use `@view-transition` or scroll-driven animation (progressive enhancement).


### Review questions
1. Order these selectors by specificity: `#a .b`, `ul li.active`, `a:hover`, `:where(.x)`.
2. What problem do cascade layers solve compared with `!important`?
3. When would you pick Grid over Flexbox? Give two examples.
4. Explain the difference between a media query and a container query.
5. Why animate `transform` instead of `left`?

---
Instructor solutions: [`instructor/solutions/week03-css3-responsive.md`](../../instructor/solutions/week03-css3-responsive.md)
