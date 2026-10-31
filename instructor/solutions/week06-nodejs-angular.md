# Week 6 solutions: Node.js and Angular

## Expected results and evidence
| Check | Expected result / model evidence |
| --- | --- |
| `curl -s http://127.0.0.1:3000/api/courses \| jq .` | Array of 2 courses (ids 1 and 2) |
| Valid POST | `HTTP/1.1 201 Created`, body with `"id": 3` |
| POST with invalid JSON (`-d x`) | `400` (`{"error":"bad json"}`) |
| POST with `credits` 0 | `400` (`{"error":"invalid"}`) |
| API console | One line per request such as `2026-10-30T09:10:11.000Z GET /api/courses` |
| `node ../compare.js` (run inside `api/`) | Lines `cb N`, `promise N` and `await N` with the same N (order may vary) |
| Angular page | Filter narrows rows; “Total credits” follows the filter; added course appears immediately |

**Valid POST and result**

```
curl -si -X POST -H 'Content-Type: application/json' \
  -d '{"code":"SEWE-7000","title":"Cloud","credits":3}' http://127.0.0.1:3000/api/courses
HTTP/1.1 201 Created
...
{"id":3,"code":"SEWE-7000","title":"Cloud","credits":3}
```


## Troubleshooting guide
| Symptom | Likely cause | Fix (Rocky 10 / Kubuntu 26.04) |
| --- | --- | --- |
| `compare.js` cannot find `package.json` | It reads `package.json` from the current directory | Run it from `~/webeng/week06/api` with `node ../compare.js` |
| `NG0201: No provider for HttpClient` | `provideHttpClient()` missing | Add it to `app.config.ts` providers |
| Browser console: CORS error | API did not send the headers or was not running | Check the server and `curl -sI -X OPTIONS` output; keep `Access-Control-Allow-Origin` |
| `Can't bind to 'ngModel'` | `FormsModule` not imported | Add `FormsModule` to the component `imports` |
| Template file not found | Older CLI naming (`app.component.*`) | Use the names your CLI generated, or update the paths in `@Component` |
| Form fields do not clear (zoneless apps) | Plain object changed outside Angular’s tracking | Make `draft` a `signal` or reset it in the same tick as a signal update |
| Port 3000 in use | Previous server still running | `ss -tlnp \| grep 3000`, then `kill %1` or the PID |

## Viva prompts and marking notes
- Ask the student to explain, using the lab code, why the API keeps working while one request waits for the body (`for await`).
- Ask where the deployed Angular page runs (browser) versus where the API runs (Node) and why CORS is needed.
- Marking points: API (3), Angular app (3), deployment (1), callback/promise/await comparison (2), viva (1).

## Answers to review questions
1. Node runs JavaScript on one thread. A long synchronous loop keeps the event loop from running any other callback, so all other requests wait. Use worker threads, child processes or split the work.
2. Use an `EventEmitter` for repeated notifications with several independent listeners (log + e-mail on every order). Use a Promise for one result that completes once.
3. AngularJS 1.x is an old JavaScript framework (scopes, controllers, digest cycle) and is end-of-life. Current Angular is TypeScript-based with components, dependency injection, a CLI, signals, ahead-of-time compilation and standalone components.
4. `computed()` creates a derived, memoised signal that tracks its dependencies automatically and recalculates only when they change, avoiding repeated work in the template.
5. The page origin (`webeng.test`) differs from the API origin (`127.0.0.1:3000`). The browser’s same-origin policy blocks the response unless the API opts in with CORS headers.
