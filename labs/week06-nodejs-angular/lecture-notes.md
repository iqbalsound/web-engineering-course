# Week 6: Node.js and Modern Angular – lecture notes

### 6.1 Node.js Architecture

Node.js embeds the **V8** engine and **libuv**, a C library that provides the event loop, a thread pool and asynchronous I/O. JavaScript runs on one thread; blocking I/O is delegated to the OS or the pool, and completion callbacks are queued. Therefore never run long CPU loops in a request handler.

| Event-loop phase | What runs |
| --- | --- |
| timers | `setTimeout`, `setInterval` callbacks |
| poll | I/O callbacks (network, files) |
| check | `setImmediate` callbacks |
| between phases | `process.nextTick` and Promise microtasks |

### 6.2 Core Modules, Events and Callbacks

| Concept | Example | When used |
| --- | --- | --- |
| Callback | `fs.readFile(p, (err, data) => …)` | Legacy APIs; error-first convention |
| Promise | `const data = await fs.promises.readFile(p)` | One-off async result (preferred) |
| Event | `emitter.on("order", fn)` | Repeated notifications, many listeners |

```
import { EventEmitter } from 'node:events';
import { readFile } from 'node:fs/promises';
const bus = new EventEmitter();
bus.on('order', (id) => console.log('log order', id));
bus.on('order', (id) => console.log('email for', id));
bus.emit('order', 101);                      // both listeners run synchronously
console.log((await readFile('package.json', 'utf8')).length);
```

Useful built-ins: `node:fs`, `node:path`, `node:os`, `node:http`, `node:crypto`, `node:stream`, `node:test`, global `fetch`, and the `--watch` flag for auto-restart.

### 6.3 Angular vs AngularJS

The syllabus lists “Angular JS”. **AngularJS (1.x)** is a different, obsolete framework (end-of-life since January 2022). Today’s **Angular** is a TypeScript framework maintained by Google with a CLI, dependency injection, routing, forms and an HTTP client. Current Angular favours **standalone components** (no NgModules), **signals** for reactivity and built-in control flow (`@if`, `@for`).

```
@Component({ selector: 'app-root', imports: [FormsModule], templateUrl: './app.html' })
export class App {
  items = signal<string[]>(['A', 'B']);
  q = signal('');
  shown = computed(() => this.items().filter(i => i.includes(this.q())));   // auto-updates
}
// template:  @for (i of shown(); track i) { <li>{{ i }}</li> } @empty { <li>none</li> }
```

| Angular building block | Purpose |
| --- | --- |
| Component | Class + template + styles; the unit of UI |
| Signal / computed / effect | Fine-grained reactive state |
| Service + `inject()` | Shared logic and data access via dependency injection |
| `HttpClient` | Typed HTTP calls returning Observables |
| Router | URL ↔ component mapping, lazy loading |
| Pipes | Template formatting (`date`, `currency`, `uppercase`) |

> **Best practice:** Avoid touching the DOM directly with `document.querySelector` inside Angular. Bind data in templates; if you must use the DOM use `ElementRef` / `Renderer2`, which keeps the code testable and safe from XSS.
