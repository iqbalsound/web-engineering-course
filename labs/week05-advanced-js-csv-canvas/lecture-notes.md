# Week 5: Advanced JavaScript: OOP, Async, CSV Data and Canvas / 3D – lecture notes

### 5.1 Classes, Inheritance and Polymorphism

```
class Person {
  #cnic;                                   // private field
  static count = 0;
  constructor(name, cnic) { this.name = name; this.#cnic = cnic; Person.count++; }
  get masked() { return '*****-*******-' + this.#cnic.slice(-1); }
  describe() { return `Person ${this.name}`; }
}
class Student extends Person {
  constructor(name, cnic, marks) { super(name, cnic); this.marks = marks; }
  describe() { return `${super.describe()} (marks ${this.marks})`; }   // overriding = polymorphism
}
for (const p of [new Person('Ali', '42101-1234567-1'), new Student('Sara', '42101-7654321-9', 88)])
  console.log(p.describe());                // each object answers in its own way
```

Prefer **composition over inheritance** when behaviour is shared across unrelated classes (for example a `Serializable` helper object). JavaScript uses prototypes underneath; `class` is syntax over them.

### 5.2 Exceptions

```
class ValidationError extends Error {
  constructor(field, msg, options) { super(msg, options); this.name = 'ValidationError'; this.field = field; }
}
try { throw new ValidationError('email', 'Invalid e-mail'); }
catch (e) { if (e instanceof ValidationError) console.warn(e.field, e.message); else throw e; }
finally { console.log('always runs'); }
```

### 5.3 Asynchronous JavaScript

Browsers and Node.js never block on I/O. Work is queued and the **event loop** runs callbacks when the call stack is empty. Evolution: callbacks → Promises → `async/await`.

```
async function loadCsv(url) {
  const ctrl = new AbortController();
  const t = setTimeout(() => ctrl.abort(), 5000);
  try {
    const res = await fetch(url, { signal: ctrl.signal });
    if (!res.ok) throw new Error(`HTTP ${res.status}`);
    return await res.text();
  } finally { clearTimeout(t); }
}
const [a, b] = await Promise.all([loadCsv('a.csv'), loadCsv('b.csv')]);   // parallel
```

### 5.4 Regular Expressions and E-mail Validation

```
const EMAIL = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;     // pragmatic, not RFC-complete
EMAIL.test('ali@hamdard.edu.pk');                    // true
'2026-10-29'.match(/(?<y>\d{4})-(?<m>\d{2})-(?<d>\d{2})/).groups.y;   // named groups
```

> **Industry practice:** No regular expression can prove that a mailbox exists. Use `type="email"` for UX, a light regex for sanity and a **confirmation e-mail** (Week 13) for truth. Beware catastrophic backtracking on user-supplied patterns.

### 5.5 CSV Files and Editable Tables

CSV looks trivial but has quoting rules (commas and newlines inside quotes, doubled quotes). Never split on commas manually; use a parser such as **PapaParse**. Edit cells with `contenteditable` or `<input>` elements, validate on `change` and export with a `Blob` and a temporary download link.

### 5.6 Canvas 2D and 3D

```
const ctx = canvas.getContext('2d'); let angle = 0;
function frame() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  ctx.save(); ctx.translate(150, 150); ctx.rotate(angle += 0.02);
  ctx.fillStyle = 'teal'; ctx.fillRect(-40, -40, 80, 80); ctx.restore();
  requestAnimationFrame(frame);
}
frame();
```

3D in the browser uses **WebGL / WebGPU**. Libraries such as **Three.js** provide a scene graph (scene, camera, mesh = geometry + material, renderer) and hide the low-level API.

### 5.7 jQuery as Legacy Knowledge

| jQuery | Modern equivalent |
| --- | --- |
| `$("#id")`, `$(".c")` | `document.querySelector("#id")`, `querySelectorAll(".c")` |
| `$(el).on("click", fn)` | `el.addEventListener("click", fn)` |
| `$(el).addClass("on")` | `el.classList.add("on")` |
| `$.ajax()` / `$.get()` | `fetch()` + `await res.json()` |
| `$(el).hide()` / `.fadeIn()` | `el.hidden = true`; CSS transitions |

Event delegation (one listener on a parent that inspects `event.target`) is still essential: `table.addEventListener("click", e => { const b = e.target.closest("button[data-del]"); … })`.
