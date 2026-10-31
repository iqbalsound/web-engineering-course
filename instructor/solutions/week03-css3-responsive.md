# Week 3 solutions: CSS3 Layout and Responsive Design

## Expected results and evidence
| Check | Expected result / model evidence |
| --- | --- |
| `npx stylelint style.css` | No output (exit code 0) after `npx prettier --write style.css` |
| 360 px viewport | One column, no horizontal scrollbar |
| Dark mode | Background `#0b1220`, text `#e5e7eb` via custom properties |
| Reduced motion | Loader stops, button no longer slides |
| Container query behaviour | See the table below – the row layout depends on the **card column width (≥ 22 rem = 352 px)**, not the viewport |


## Worked solutions
Correction to the checklist wording: because the container query watches the width of each card wrapper, cards switch to a row layout only when a column is at least 352 px wide. With the supplied grid the behaviour is:

| Viewport | Columns | Wrapper width | Card layout |
| --- | --- | --- | --- |
| 360 px | 1 | ≈ 328 px | Stacked |
| 600 px | 2 | ≈ 276 px | Stacked |
| 800 px | 2 | ≈ 376 px | Row (flex) |
| 1000 px | 3 | ≈ 312 px | Stacked |
| 1200 px | 3 | ≈ 378 px | Row (flex) |

This is a useful teaching point: the same component adapts to the space it is given, which a media query cannot do.

## Troubleshooting guide
| Symptom | Likely cause | Fix (Rocky 10 / Kubuntu 26.04) |
| --- | --- | --- |
| Stylelint: `media-feature-range-notation` | Standard config prefers range syntax | Write `@container (width >= 22rem)`; run `npx stylelint --fix style.css` |
| Stylelint: `no-descending-specificity` | Rule order puts a less specific selector after a more specific one | Reorder rules or group `.card` and `.card:hover` together |
| Layout not responsive on phone emulation | Missing viewport meta tag | Ensure `<meta name="viewport" content="width=device-width, initial-scale=1">` |
| Dark mode not testable (Rocky GNOME / Kubuntu Plasma) | Browser follows the desktop theme | Rocky: Settings → Appearance → Dark. Kubuntu: System Settings → Colors & Themes → Breeze Dark. Or Firefox DevTools → rendering emulation |
| Styles not applied | File not found (404) or label problem | `curl -I http://webeng.test/week03/style.css`; Rocky: `restorecon -Rv .` |

## Viva prompts and marking notes
- Ask the student to open DevTools and show which rule wins for `.card:hover` and why (specificity + layer).
- Marking points: valid layout and responsiveness (4), custom properties and dark mode (2), animation + reduced motion (2), lint clean (1), viva (1).

## Answers to review questions
1. Highest to lowest: `#a .b` (1,1,0), `ul li.active` (0,1,2), `a:hover` (0,1,1), `:where(.x)` (0,0,0).
2. Layers let you order whole groups of CSS explicitly so a later layer wins without raising specificity or using `!important`; third-party CSS can sit in a low layer.
3. Grid for two-dimensional layouts such as a page with header/sidebar/content or an auto-fit card gallery; Flexbox for one-dimensional rows or columns such as a navbar or button group.
4. A media query reacts to the viewport; a container query reacts to the size of the containing element, so a component adapts correctly wherever it is placed.
5. `transform` and `opacity` can be handled by the compositor without layout or repaint; animating `left` forces layout on every frame.
