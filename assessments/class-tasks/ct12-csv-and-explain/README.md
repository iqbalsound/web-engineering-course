# CT-12 (Week 12, 25 min, individual, CLO_3): CSV and EXPLAIN

(a) Write a PHP CLI script that reads `products.csv` (`category_id,name,price,stock`) with `fgetcsv`, skips malformed lines and prints the total stock value. (b) Decide which of these two plans uses an index and explain why one query cannot.

```
Plan 1: type: ALL    key: NULL            rows: 5008     (LIKE '%12%')
Plan 2: type: range  key: idx_prod_name   rows: 111      (LIKE 'Item 12%')
```

**Deliverable:** script output and a three-sentence explanation.

Solution: `solution/` (written notes in [`instructor/class-task-solutions.md`](../../../instructor/class-task-solutions.md)).
