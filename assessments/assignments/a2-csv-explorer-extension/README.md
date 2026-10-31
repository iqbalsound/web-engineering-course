| **Course** | SEWE-6109 Web Engineering | **CLO** | CLO_2 (C3) |
| --- | --- | --- | --- |
| **Issued** | Week 5 | **Due** | Week 6 (start of class) |
| **Marks** | 0 in the OBE sheet – formative (graded out of 10 for feedback) | **Mode** | Individual, Git repository + `dist` folder |

Extend the Week 5 CSV explorer. Keep all earlier behaviour and keep the code in ES modules.

| Req. | Requirement | Acceptance test |
| --- | --- | --- |
| R1 | Sort by clicking a column heading; a second click reverses the order; numbers sort numerically | Sort by marks gives 74, 88, 91 then 91, 88, 74 |
| R2 | Text filter above the table matching name or e-mail while typing | Typing “bil” leaves only Bilal |
| R3 | A status line showing the number of invalid e-mail addresses | Initial text “1 invalid e-mail(s)” |
| R4 | The CSV request uses an `AbortController` / `AbortSignal` timeout of 5 seconds and shows a friendly error | Block the file in DevTools: message appears, no console exception |
| R5 | Editing and CSV export still work on the filtered/sorted view | Edit row after sorting changes the correct student |
| R6 | README with commands for your OS, and `vite build` output deployed under `/var/www/webeng/week05a2/` | `curl -I` returns 200 |

| Criterion | Marks | Excellent means |
| --- | --- | --- |
| Sorting and filtering (R1, R2) | 3 | Correct, stable, numeric handling, no data corruption |
| Validation status and error handling (R3, R4) | 3 | Accurate count; timeout and failures handled |
| Editing and export intact (R5) | 2 | Right record edited under any view |
| Build, deployment, README, Git history (R6) | 2 | Reproducible instructions, at least 3 meaningful commits |
