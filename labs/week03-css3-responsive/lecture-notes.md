# Week 3: CSS3: Selectors, Modern Layout and Responsive Design – lecture notes

### 3.1 Ways to Insert CSS

| Method | Syntax | Use |
| --- | --- | --- |
| External | `<link rel="stylesheet" href="style.css">` | Default for real projects (cacheable) |
| Internal | `<style>…</style>` in head | Single page demos, critical CSS |
| Inline | `style="color:red"` | Avoid; highest specificity, hard to maintain |

### 3.2 Selectors, Specificity and the Cascade

A rule has a selector and declarations: `selector { property: value; }`. When rules conflict the browser decides by (1) origin and `!important`, (2) **cascade layer** order, (3) **specificity** (id > class/attribute/pseudo-class > element), (4) source order.

```
@layer reset, base, components;       /* later layers win */
@layer base { a { color: var(--link); } }
.card { padding: 1rem; &:hover { box-shadow: 0 2px 8px #0003; } }   /* native nesting */
li:first-child { font-weight: 700; }
.list:has(> li.active) { border-color: teal; }       /* parent selector */
:where(h1, h2, h3) { margin-block: 0.5em; }          /* zero specificity */
```

### 3.3 Box Model, Units and Custom Properties

- `box-sizing: border-box` makes `width` include padding and border; set it globally.
- Units: `rem` (root font size), `em`, `%`, `vw/vh`, `dvh` (mobile-safe viewport), `ch`; fluid type with `clamp(1rem, 2vw + .5rem, 2rem)`.
- Colour: `rgb()`, `hsl()`, `oklch()` for perceptual uniformity, `color-mix(in oklch, red, blue)`.
- Custom properties: `:root { --brand: #0f766e; }` then `color: var(--brand)`; they cascade and can change at runtime (dark mode).

### 3.4 Flexbox and Grid

| Feature | Flexbox | Grid |
| --- | --- | --- |
| Dimension | One-dimensional (row **or** column) | Two-dimensional (rows **and** columns) |
| Best for | Navbars, button rows, centring | Page layouts, card galleries |
| Key properties | `display:flex; gap; justify-content; align-items; flex-wrap` | `display:grid; grid-template-columns; gap; grid-area; repeat(auto-fit, minmax())` |

```
.cards { display: grid; gap: 1rem;
         grid-template-columns: repeat(auto-fit, minmax(16rem, 1fr)); }
.nav   { display: flex; gap: 1rem; justify-content: space-between; align-items: center; }
```

The old “clearfix” hack (`.clearfix::after { content:""; display:table; clear:both }`) existed because floated children collapse their parent. Today `display: flow-root`, Flexbox or Grid replace it.

### 3.5 Responsive Design: Media and Container Queries

```
@media (min-width: 48rem) { .layout { grid-template-columns: 1fr 3fr; } }   /* mobile-first */
@media (prefers-color-scheme: dark) { :root { --bg: #0b1220; --fg: #e5e7eb; } }
@media (prefers-reduced-motion: reduce) { * { animation: none !important; } }
.card-wrap { container-type: inline-size; }
@container (min-width: 28rem) { .card { display: flex; } }               /* component-level */
```

### 3.6 Transitions, Animations and Loaders

```
.btn { transition: transform .2s ease, background-color .2s; }
.btn:hover { transform: translateY(-2px); }
@keyframes spin { to { transform: rotate(360deg); } }
.loader { width: 2rem; aspect-ratio: 1; border: .3rem solid #ddd; border-top-color: var(--brand);
          border-radius: 50%; animation: spin 1s linear infinite; }
```

Animate only `transform` and `opacity` for smooth 60 fps rendering; animating `width` or `top` triggers layout. Text effects such as `text-shadow: 1px 1px 2px #0005;` and borders such as `border: 2px solid` complete the syllabus list.
