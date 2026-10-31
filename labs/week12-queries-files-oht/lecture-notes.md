# Week 12: Queries, Result Handling, File Handling and Hourly Test – lecture notes

### 12.1 Executing Queries and Retrieving Results

| PDO call | Returns | Use |
| --- | --- | --- |
| `$pdo->query($sql)` | Statement | Static SQL with no user input |
| `$st = $pdo->prepare(); $st->execute([...])` | Statement | Any SQL containing values |
| `$st->fetch()` | One row or `false` | Single record |
| `$st->fetchAll()` | All rows | Small result sets |
| `$st->fetchColumn()` | First column value | `COUNT(*)`, single value |
| `foreach ($st as $row)` | Streams rows | Large result sets (low memory) |
| `PDO::FETCH_KEY_PAIR`, `FETCH_COLUMN`, `FETCH_CLASS` | Shaped results | Dropdown maps, ID lists, objects |

### 12.2 Search and Pagination

- Build `WHERE` clauses from an **allow-list** of fragments and bind all values.
- Escape LIKE wildcards in user input: `addcslashes($q, "%_\\")`.
- `LIMIT n OFFSET m` is simple but slow for deep pages; **keyset pagination** (`WHERE id > :last ORDER BY id LIMIT n`) scales better.
- Avoid the **N+1 problem** (one query per row); use a JOIN or a single `IN (...)` query.

### 12.3 EXPLAIN and Indexes

`EXPLAIN SELECT …` shows how MariaDB executes a query. Look at `type` (`ALL` = full table scan, `ref` / `range` = index use), `key` (index chosen) and `rows` (estimate). An index on `name` helps `LIKE 'Item 12%'` (prefix match) but not `LIKE '%12%'` (leading wildcard).

### 12.4 File Handling in PHP

| Task | Function |
| --- | --- |
| Whole file | `file_get_contents`, `file_put_contents($f, $data, LOCK_EX)` |
| Line by line | `fopen`, `fgets`, `feof`, `fclose`, `SplFileObject` |
| CSV | `fgetcsv($h, null, ",", "\"", "")`, `fputcsv($h, $row, ",", "\"", "")` |
| Paths / dirs | `basename`, `realpath`, `is_file`, `mkdir`, `scandir`, `glob` |
| Move / delete | `rename`, `copy`, `unlink`, `move_uploaded_file` |
| Output stream | `php://output` for downloads; `readfile` for files |

> **Compatibility:** From PHP 8.4 the CSV functions warn when the `$escape` argument is omitted. Pass all arguments explicitly (as in the lab) so the code runs without deprecations on both PHP 8.3 and 8.5.

Never build a file path from user input without `basename()` and an allow-list; a path such as `../../etc/passwd` is a **path traversal** attack.
