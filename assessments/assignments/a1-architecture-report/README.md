# Assignment A1: Architecture of an Online University Portal

| **Course** | SEWE-6109 Web Engineering | **CLO** | CLO_1 (C2) |
| --- | --- | --- | --- |
| **Issued** | Week 1 | **Due** | Week 2 (start of class) |
| **Marks** | 4 | **Mode** | Individual, PDF, 2 pages + appendix |

**Scenario.** Hamdard University wants a web portal where students view timetables and results, register for courses and pay fees, and where staff upload marks. Peak load is at the start of each semester.

## Task 1 – Architectures (1.5 marks)

1. Draw a **two-tier** and a **three-tier** architecture for the portal. Label every box with the component and the technology you would choose (browser, web server, application runtime, database).
2. In a table give three advantages and three drawbacks of each style for this scenario.
3. State which architecture you choose and give two reasons (security, scalability, maintenance or cost).

## Task 2 – MVC for “Register for a course” (1 mark)

1. List at least two models, two views and one controller with a one-line responsibility each.
2. Write the numbered flow of one request, from the browser through the router, controller and model to the view, and mark which tier each step happens in.

## Task 3 – HTTP evidence (1 mark)

Use the captures from Lab 1. For each of a 200, a 404 and a 304 response give the request line, the two most important headers and what the status means. Explain how caching (the 304) would help the portal at peak load.

## Task 4 – Presentation and references (0.5 marks)

Clear diagrams, correct terminology, at least two cited sources (RFC or MDN count) and no copied text.

## Marking Rubric

| Criterion | Marks | Excellent means |
| --- | --- | --- |
| Architecture diagrams and comparison | 1.5 | Correct tiers, justified technologies, balanced pros/cons, clear choice |
| MVC mapping and request flow | 1 | Responsibilities correct, tiers identified, flow complete |
| HTTP evidence | 1 | Three genuine captures, accurate meaning, caching argument |
| Presentation, references, honesty | 0.5 | Neat, cited, original |
