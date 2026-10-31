# Week 7 solutions: Bootstrap 5.3 and UI/UX

## Expected results and evidence
| Check | Expected result / model evidence |
| --- | --- |
| 360 / 800 / 1200 px | 2 / 3 / 4 cards per row (`col-6 col-md-4 col-lg-3`) |
| Pagination | 3 pages × 8 products; page 1 initially `active` with `aria-current="page"` |
| Carousel | Three slides, auto-advance every 4 s, Prev/Next buttons and arrow keys |
| Theme toggle | `<html data-bs-theme="dark">` switches all components |
| `npx vite build` output | Bootstrap CSS about 230 kB (about 30 kB gzipped); icon font files in `dist/assets` |
| Penpot wireframe | Mobile frame with 2-column cards; desktop frame with hero, carousel, 4-column grid |



## Troubleshooting guide
| Symptom | Likely cause | Fix (Rocky 10 / Kubuntu 26.04) |
| --- | --- | --- |
| `Failed to resolve import "@popperjs/core"` | Peer dependency missing | `npm install @popperjs/core` |
| Icons show as empty squares | Icon CSS not imported or fonts blocked | Keep `import "bootstrap-icons/font/bootstrap-icons.css"`; check DevTools network for 404 on `.woff2` |
| Carousel does not move | No `.active` item or JS not loaded | Ensure the first `.carousel-item` has `active` and `Carousel` is imported |
| Layout wrong after deployment | Wrong `--base` | `npx vite build --base=/week07/`, redeploy; Rocky: `restorecon -Rv` |
| Penpot not loading | Network or browser blocking | Use `design.penpot.app` in Firefox or self-host with Podman |

## Viva prompts and marking notes
- Ask the student which UX law justified a design decision in the wireframe.
- Marking points: responsive grid (3), components working (3), accessibility attributes (2), wireframe (1), viva (1).

## Answers to review questions
1. `<div class="container"><div class="row g-3"><div class="col-12 col-md-6 col-lg-4">…</div></div></div>`: full width on phones, half on tablets, one third on desktops.
2. Jumbotron was removed because utilities cover it. Recreate it with `<div class="p-5 mb-4 bg-body-tertiary rounded-3">` and heading/lead/button inside.
3. Fitts’s law: large targets that are close to the user’s focus are faster to hit.
4. `data-bs-theme` scopes a different set of CSS variables (`--bs-body-bg`, `--bs-body-color`, …); components read those variables, so no second stylesheet is required.
5. Carousel: controls with visually hidden labels, `aria-label` on indicators, `alt`/`aria-label` on slide images. Pagination: `<nav aria-label>` wrapper and `aria-current="page"` on the current page.
