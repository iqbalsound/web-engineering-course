# Week 5: Advanced JavaScript: OOP, Async, CSV Data and Canvas / 3D

| Syllabus lectures | CLO | PLO | Bloom | Assessment |
| --- | --- | --- | --- | --- |
| Lec 9–10 | CLO_2 | PLO_5 | C3 (Applying) | A2 issued (formative, 0 marks in OBE) |

## Lab: CSV Student Explorer and Rotating 3D Cube (Vite Build)

Build a Vite project that loads a CSV file, validates e-mail addresses, lets users edit marks in an HTML table, exports the result and shows a Three.js rotating cube; deploy the production build on Apache.

### Free and open-source tools
- Vite (MIT) for dev server and production build
- PapaParse (MIT) for CSV
- Three.js (MIT) for 3D
- Node.js 24 LTS

### Deliverables
- Vite project in `~/webeng/week05` (source, not in web root)
- Production build copied to `/var/www/webeng/week05/`
- Editable table with e-mail validation and CSV export
- Rotating cube and rotating 2D square on the same page

### Contents of this folder
- [`lecture-notes.md`](lecture-notes.md) – the week's theory
- [`rocky10.md`](rocky10.md) – step-by-step lab, **Version A (Rocky Linux 10)**
- [`kubuntu2604.md`](kubuntu2604.md) – step-by-step lab, **Version B (Kubuntu 26.04 LTS)**
- `code/index.html`
- `code/main.js`
- `code/package.json`
- `code/public/students.csv`

`code/` holds the reference source files exactly as printed in the lab manual (they are the files the labs ask you to create).


### Verification checklist
| # | Check | Expected Result |
| --- | --- | --- |
| 1 | Open `http://webeng.test/week05/` | Table with 3 rows; row 3 shows “⚠ invalid” |
| 2 | Edit marks to 150 | Message “Marks must be 0-100”, value reverts |
| 3 | Edit marks to 95 | Grade changes to A |
| 4 | Click Export CSV | `students-out.csv` downloads with the edited marks; the quoted name stays intact |
| 5 | Cube and square | Both rotate continuously |
| 6 | Compression test | Transferred size is much smaller than the file size on disk |

### Stretch goals
- Add Vitest unit tests for the `Student` class.
- Save edits to `localStorage` and reload.
- Replace the cube with a loaded glTF model.

### Additional work
#### Assignment A2 (CLO_2, formative) – issued this week, due Week 6

Extend the CSV explorer with sorting by column, a text filter, a count of invalid e-mails and an `AbortController` timeout on the CSV request. Submit the Git repository link and the `dist` folder.

### Review questions
1. Show how method overriding provides polymorphism using two classes of your own.
2. Why is a `#private` field better than an underscore prefix?
3. What does `await Promise.all([...])` do differently from awaiting each promise in turn?
4. Why is splitting CSV text on commas unsafe? Give an example row.
5. Map three jQuery calls to their modern equivalents.

---
Instructor solutions: [`instructor/solutions/week05-advanced-js-csv-canvas.md`](../../instructor/solutions/week05-advanced-js-csv-canvas.md)
