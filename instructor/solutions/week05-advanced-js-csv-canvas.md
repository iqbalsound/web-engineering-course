# Week 5 solutions: Advanced JavaScript, CSV and Canvas / 3D

## Expected results and evidence
| Check | Expected result / model evidence |
| --- | --- |
| Page load | Table with 3 rows; row 3 e-mail shows “⚠ invalid”; grades A, B, A |
| Edit marks of row 1 to 150 | Message “Marks must be 0-100”; value returns to 88 |
| Edit marks of row 2 to 95 | Grade becomes A |
| Export CSV | File `students-out.csv` with quoted name preserved (below) |
| 2D square and 3D cube | Both rotate; cube uses `MeshNormalMaterial` (multi-coloured faces) |
| Compressed transfer | Bundle (Three.js dominates) drops to roughly one quarter to one third of its raw size with `DEFLATE` |

**Expected students-out.csv (PapaParse uses CRLF line endings)**

```
id,name,email,marks
1,Ayesha Khan,ayesha@hamdard.edu.pk,88
2,"Siddiqui, Bilal",bilal@hamdard.edu.pk,95
3,Hira Ali,hira.hamdard.edu.pk,91
```


## Troubleshooting guide
| Symptom | Likely cause | Fix (Rocky 10 / Kubuntu 26.04) |
| --- | --- | --- |
| `Failed to resolve import "papaparse"` | Dependencies not installed | `npm install papaparse three` in `~/webeng/week05` |
| Blank page after deployment | Build used the wrong base path | `npx vite build --base=/week05/` and redeploy; check the 404s in DevTools |
| `students.csv` 404 after deployment | Fetched with an absolute `/students.csv` | Use `import.meta.env.BASE_URL + "students.csv"` (as supplied) |
| Build error: top-level await not available | Older Vite default target | Add `export default { build: { target: "es2022" } }` in `vite.config.js` (not needed on current Vite) |
| Cube not drawn | WebGL disabled in the VM | Enable 3D acceleration in the hypervisor; check `about:support` → WebGL |
| Rocky: Apache 403 on `assets/` | rsync kept wrong labels | `sudo restorecon -Rv /var/www/webeng/week05` |
| Compression test shows no reduction | `mod_deflate` rule not loaded | Rocky: file in `/etc/httpd/conf.d/`, `systemctl reload httpd`. Kubuntu: `a2enmod deflate`, reload |

## Viva prompts and marking notes
- Ask the student to show the event-delegation listener and explain why one listener on `tbody` is better than one per cell.
- Ask why the e-mail regex is “pragmatic” and what else is required to prove an address (confirmation mail).
- Marking points: CSV load/edit/export (4), validation and class design (2), canvas/3D (2), build and deploy (1), viva (1).

## Answers to review questions
1. `class Shape { area() { return 0; } } class Circle extends Shape { constructor(r) { super(); this.r = r; } area() { return Math.PI * this.r ** 2; } } class Rect extends Shape { constructor(w, h) { super(); this.w = w; this.h = h; } area() { return this.w * this.h; } }` Looping over `[new Circle(2), new Rect(2, 3)]` and calling `area()` runs a different method for each object.
2. `#private` fields are enforced by the language (access from outside is a `SyntaxError`); an underscore is only a naming convention that anyone can ignore.
3. `Promise.all` starts the operations together, so total time is the slowest one, not the sum; it rejects as soon as one rejects (use `allSettled` to collect every result).
4. Quoted fields may contain commas, newlines or doubled quotes. `2,"Siddiqui, Bilal",x,74` split on commas gives five fields instead of four.
5. `$("#id")` → `document.querySelector("#id")`; `.on("click", fn)` → `addEventListener("click", fn)`; `$.get(url)` → `await fetch(url)`; `.addClass("a")` → `classList.add("a")`.
