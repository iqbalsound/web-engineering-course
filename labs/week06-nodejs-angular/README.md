# Week 6: Node.js and Modern Angular

| Syllabus lectures | CLO | PLO | Bloom | Assessment |
| --- | --- | --- | --- | --- |
| Lec 11–12 | CLO_2 | PLO_5 | C3 (Applying) | A2 due |

## Lab: Node REST API and Angular Course Dashboard

Create a no-dependency Node.js JSON API with event logging, then an Angular app that lists, filters and adds courses using signals and HttpClient. Build and deploy the Angular app on Apache.

### Free and open-source tools
- Node.js 24 LTS (`node:http`, `node:events`)
- Angular CLI (MIT) via `npx @angular/cli@latest`
- curl, jq for API testing

### Deliverables
- `api/server.js` running on port 3000 with GET and POST `/api/courses`
- Angular app in `~/webeng/week06/dashboard`
- Production build deployed to `/var/www/webeng/week06/`
- Callback-vs-promise comparison file `compare.js`

### Contents of this folder
- [`lecture-notes.md`](lecture-notes.md) – the week's theory
- [`rocky10.md`](rocky10.md) – step-by-step lab, **Version A (Rocky Linux 10)**
- [`kubuntu2604.md`](kubuntu2604.md) – step-by-step lab, **Version B (Kubuntu 26.04 LTS)**
- `code/README-dashboard.md`
- `code/api/package.json`
- `code/api/server.js`
- `code/compare.js`
- `code/dashboard-overlay/src/app/app.config.ts`
- `code/dashboard-overlay/src/app/app.html`
- `code/dashboard-overlay/src/app/app.ts`

`code/` holds the reference source files exactly as printed in the lab manual (they are the files the labs ask you to create).


### Verification checklist
| # | Check | Expected Result |
| --- | --- | --- |
| 1 | `curl http://127.0.0.1:3000/api/courses` | JSON array with 2 courses |
| 2 | POST with invalid body | `400` and `{"error":"invalid"}` or `bad json` |
| 3 | API console | One log line per request produced by the EventEmitter listener |
| 4 | `node compare.js` | Three outputs (cb, promise, await) show the same length |
| 5 | Angular page | Table shows courses, filter box narrows rows, total credits updates, adding a course appears at once |
| 6 | Deployed build | `http://webeng.test/week06/` loads and lists courses while the API is running |

### Stretch goals
- Add routing with a lazy-loaded “About” page.
- Replace `node:http` with Fastify or Hono and compare code size.
- Add a Vitest/Jasmine test for the `filtered` computed signal.


### Review questions
1. Explain why one slow synchronous loop blocks every user of a Node.js server.
2. When would you choose an `EventEmitter` over a Promise?
3. List three differences between AngularJS 1.x and current Angular.
4. What does `computed()` do and why is it better than recalculating in the template?
5. Why does the browser need the `Access-Control-Allow-Origin` header in this lab?

---
Instructor solutions: [`instructor/solutions/week06-nodejs-angular.md`](../../instructor/solutions/week06-nodejs-angular.md)
