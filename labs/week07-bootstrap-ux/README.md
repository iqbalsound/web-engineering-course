# Week 7: Bootstrap 5.3, UI/UX and Component-Based Interfaces

| Syllabus lectures | CLO | PLO | Bloom | Assessment |
| --- | --- | --- | --- | --- |
| Lec 13–14 | CLO_2 | PLO_5 | C3 (Applying) | — |

## Lab: Responsive Product Catalogue with Carousel, Pagination and Dark Mode

Build a Vite + Bootstrap 5.3 storefront front page with a hero section, image carousel, 24 generated product cards, JavaScript pagination (8 per page), icons and a light/dark toggle.

### Free and open-source tools
- Bootstrap 5.3 + Popper (MIT)
- Bootstrap Icons (MIT)
- Vite (MIT)
- Penpot (MPL-2.0) for the wireframe

### Deliverables
- Penpot wireframe screenshot (mobile + desktop)
- Vite project in `~/webeng/week07`, build deployed to `/var/www/webeng/week07/`
- Working carousel, pagination and theme toggle

### Contents of this folder
- [`lecture-notes.md`](lecture-notes.md) – the week's theory
- [`rocky10.md`](rocky10.md) – step-by-step lab, **Version A (Rocky Linux 10)**
- [`kubuntu2604.md`](kubuntu2604.md) – step-by-step lab, **Version B (Kubuntu 26.04 LTS)**
- `code/index.html`
- `code/main.js`
- `code/package.json`

`code/` holds the reference source files exactly as printed in the lab manual (they are the files the labs ask you to create).


### Verification checklist
| # | Check | Expected Result |
| --- | --- | --- |
| 1 | Resize to 360 / 800 / 1200 px | 2 / 3 / 4 cards per row |
| 2 | Pagination | Pages 1–3 each show 8 products; active page highlighted and has `aria-current` |
| 3 | Carousel | Auto-advances every 4 s; arrow buttons and keyboard work |
| 4 | Theme toggle | All components switch between light and dark |
| 5 | Penpot file | Wireframe matches the implemented layout |

### Stretch goals
- Add a Bootstrap modal showing product details.
- Use `@use` Sass customisation to change `$primary` and rebuild.
- Run a Lighthouse accessibility audit in Firefox/Chromium DevTools and fix findings.


### Review questions
1. Write the classes for a card that is full width on phones, half on tablets and one-third on desktops.
2. Why was the Jumbotron removed and how do you reproduce it in Bootstrap 5?
3. Which UX law explains why “Add to cart” buttons are large and near the product?
4. How does `data-bs-theme` implement dark mode without a second stylesheet?
5. List two accessibility attributes required for the carousel and pagination.

---
Instructor solutions: [`instructor/solutions/week07-bootstrap-ux.md`](../../instructor/solutions/week07-bootstrap-ux.md)
