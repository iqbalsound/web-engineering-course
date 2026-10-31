# Week 4: JavaScript Fundamentals (ES2025 and Beyond) – lecture notes

### 4.1 How JavaScript Runs

JavaScript is single-threaded and event-driven. Engines (V8 in Chrome and Node.js, SpiderMonkey in Firefox, JavaScriptCore in Safari) compile it just-in-time. The same language runs in the **browser** (DOM, `fetch`, Web APIs) and on the **server** (Node.js, also Deno and Bun) with different libraries. The ECMAScript standard is updated every year (“ES2025” etc.).

### 4.2 Variables, Types and Hoisting

```
const PI = 3.14159;          // cannot be reassigned
let count = 0;               // block scoped, reassignable
// var is function-scoped and hoisted: avoid it
console.log(typeof 42, typeof 'a', typeof true, typeof undefined, typeof null, typeof {}, typeof 10n);
// number string boolean undefined object(!) object bigint   (Symbol is the 8th type)
console.log(a); var a = 1;   // undefined (declaration hoisted)
console.log(b); let b = 1;   // ReferenceError (temporal dead zone)
```

Equality: always use `===`. Falsy values: `false, 0, -0, 0n, "", null, undefined, NaN`. Useful operators: `??` (null/undefined fallback), `?.` (optional chaining), `**` (power), `&&=`, `||=`, `??=`.

### 4.3 Control Flow

```
for (let i = 0; i < 10; i++) { if (i % 2) continue; if (i > 6) break; console.log(i); }
for (const x of [10, 20]) console.log(x);          // iterate values
for (const k in { a: 1 }) console.log(k);          // iterate keys
let n = 3; while (n--) console.log(n);
switch (grade) { case 'A': case 'B': msg = 'good'; break; default: msg = 'review'; }
```

### 4.4 Functions and Closures

```
function add(a, b = 0) { return a + b; }
const mul = (a, b) => a * b;                 // arrow function (lexical this)
const sum = (...nums) => nums.reduce((s, n) => s + n, 0);
function counter() { let c = 0; return () => ++c; }   // closure keeps c alive
const next = counter(); next(); next();                // 2
```

### 4.5 Arrays and Objects

```
const nums = [5, 3, 8];
nums.map(n => n * 2); nums.filter(n => n > 4); nums.reduce((a, b) => a + b, 0);
nums.toSorted((a, b) => a - b);          // non-mutating (ES2023)
nums.at(-1); nums.findLast(n => n < 8);
Object.groupBy(items, i => i.category);  // ES2024

const user = { name: 'Sara', address: { city: 'Karachi' } };
const { name, address: { city } } = user;          // destructuring
const copy = { ...user, name: 'Ali' };             // spread
Object.entries(user); structuredClone(user);

const acct = { _bal: 0, get balance() { return this._bal; },
               set balance(v) { if (v < 0) throw new RangeError('negative'); this._bal = v; } };
```

Newer built-ins to know: `Set` methods (`union`, `intersection`), iterator helpers (`.map()` / `.take()` on iterators), `Promise.withResolvers()` and the `Temporal` date API (shipping in current runtimes; check support before relying on it).

### 4.6 Modules and the DOM

```
// math.js
export const sq = n => n * n;
// app.js  (load with <script type="module" src="app.js"></script>)
import { sq } from './math.js';
document.querySelector('#out').textContent = sq(7);
document.querySelector('button').addEventListener('click', e => console.log(e.type));
```

> **Security:** Never build HTML by concatenating user input into `innerHTML` (XSS). Use `textContent` or create elements.
