# CT-16 (Week 16, 25 min, pairs, CLO_1–3): Compose Review

Find and fix at least six problems in this Compose file.

```
services:
  db:
    image: mariadb
    environment:
      MARIADB_ROOT_PASSWORD: root
    ports:
      - "3306:3306"
  web:
    build: .
    ports:
      - "80:80"
    depends_on:
      - db
```

**Deliverable:** corrected `compose.yaml` and a list of changes with reasons.

Solution: `solution/` (written notes in [`instructor/class-task-solutions.md`](../../../instructor/class-task-solutions.md)).
