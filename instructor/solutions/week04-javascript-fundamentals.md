# Week 4 solutions: JavaScript Fundamentals

## Expected results and evidence
| Check | Expected result / model evidence |
| --- | --- |
| `node --test` | `# tests 3`, `# pass 3`, `# fail 0` (verified on Node 22; same on Node 24) |
| `npx eslint .` | No problems (node_modules is ignored by default) |
| `npx prettier --check .` | “All matched files use Prettier code style!” after `npx prettier --write .` |
| UI: add Bus 100 (travel), Lunch 300 (food), Taxi 400 (travel) | Summary: `Total 800 → frugal \| {"travel":500,"food":300}` |
| Empty title or amount ≤ 0 | Alert “title required” / “amount must be > 0” |
| `curl -sI .../app.js \| grep -i content-type` | `text/javascript` (Apache default for `.js`) |

**Expected node --test summary**

```
✔ addExpense validates input
✔ totalsByCategory groups amounts
✔ grade thresholds
ℹ tests 3
ℹ pass 3
ℹ fail 0
```


## Troubleshooting guide
| Symptom | Likely cause | Fix (Rocky 10 / Kubuntu 26.04) |
| --- | --- | --- |
| `Cannot use import statement outside a module` | `"type": "module"` missing | `npm pkg set type=module` |
| Browser: module blocked / MIME error | Opened with `file://` | Always open `http://webeng.test/week04/` |
| ESLint: `document is not defined` | Browser globals not declared | Keep the `globals` block in `eslint.config.js` |
| Edits to JS not visible | Browser cache | Hard reload Ctrl+Shift+R; DevTools → Network → Disable cache |
| Rocky: 403 on newly copied files | Wrong SELinux label after `mv` | `sudo restorecon -Rv /var/www/webeng/week04` |

## Viva prompts and marking notes
- Ask the student to predict the output of `console.log(a); var a = 1;` and the `let` equivalent.
- Ask why `addExpense` returns a new array instead of mutating the old one (testability, no hidden side effects).
- Marking points: tests pass (3), lint/format clean (2), working UI (3), explanation of closures/hoisting (1), documentation (1).

## Answers to review questions
1. `var` declarations are hoisted and initialised to `undefined`, so `console.log(a); var a = 1` prints `undefined`. `let`/`const` are hoisted but remain in the temporal dead zone until their declaration, so the same code throws `ReferenceError`.
2. `==` coerces types, `===` does not. `0 == ""` is `true`; `0 === ""` is `false`.
3. The returned function keeps a reference to the variable `c` of its outer scope after `counter()` has finished; nothing else can reach `c`, so it acts as private state.
4. `const out = []; for (const n of nums) if (n > 4) out.push(n * 2);` becomes `const out = nums.filter(n => n > 4).map(n => n * 2);`.
5. Pure functions are deterministic and free of I/O, so assertions are simple and fast; DOM code needs a browser or a simulated environment.
