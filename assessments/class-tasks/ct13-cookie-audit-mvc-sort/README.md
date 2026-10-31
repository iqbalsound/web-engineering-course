# CT-13 (Week 13, 25 min, pairs, CLO_1/3): Cookie Audit and MVC Card Sort

(a) Criticise each header and propose a fix. (b) Assign each snippet to Model, View or Controller: `SELECT * FROM notes`, `<h1><?= esc($title) ?></h1>`, `$this->request->getPost("title")`, `$validationRules = [...]`, `return view("notes/index")`, `<form method="post">`, `redirect()->to("/notes")`, `$model->paginate(5)`, `password_hash($pw, PASSWORD_DEFAULT)`.

```
1) Set-Cookie: sid=abc123; Path=/
2) Set-Cookie: theme=dark; Max-Age=2592000; Path=/; SameSite=Lax
3) Set-Cookie: auth=1; Domain=.example.pk; Secure
```

**Deliverable:** annotated headers and a three-column table of snippets.

Solution: `solution/` (written notes in [`instructor/class-task-solutions.md`](../../../instructor/class-task-solutions.md)).
