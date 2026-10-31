# CT-5 (Week 5, 25 min, individual, CLO_2): Async Rewrite

Convert the callback functions to Promises, then to `async/await` with error handling, and load users 1, 2 and 3 concurrently.

```
function wait(ms, cb) { setTimeout(() => cb(null, ms), ms); }
function getUser(id, cb) { wait(100, () => (id > 0 ? cb(null, { id }) : cb(new Error('bad id')))); }
```

**Deliverable:** working code printing the three users and a handled error for id 0.

Solution: `solution/` (written notes in [`instructor/class-task-solutions.md`](../../../instructor/class-task-solutions.md)).
