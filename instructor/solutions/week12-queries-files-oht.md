# Week 12 solutions: Queries, File Handling and Hourly Test

## Expected results and evidence
| Check | Expected result / model evidence |
| --- | --- |
| First `EXPLAIN` (no index) for `LIKE 'Item 12%'` | `type = ALL`, `key = NULL`, `rows` ≈ 5008 |
| `EXPLAIN` after `CREATE INDEX idx_prod_name` | `type = range`, `key = idx_prod_name`, `rows` ≈ 100–120 (exact matches: 111) |
| `EXPLAIN` with `LIKE '%12%'` | `type = ALL` – a leading wildcard cannot use the index |
| `search.php?q=Item 12` | 111 result(s), page 1 of 12 |
| `curl export.php \| wc -l` | 5009 lines (header + 5008 products) before any import |
| Import `sample-import.csv` (bad row 3) | “Line 4 is invalid.” and “Import cancelled; nothing saved.” (line numbers are zero-based plus one; header is line 1) |
| Import after deleting the bad row | “2 products imported.” and export now has 5011 lines |
| `php bin/thumbs.php` | `<name>.jpg -> thumb OK` per image; WebP files ≤ 200 px in `storage/thumbs` |

**Sample EXPLAIN output (abridged)**

```
-- before index
type: ALL   possible_keys: NULL   key: NULL   rows: 5008   Extra: Using where
-- after index
type: range possible_keys: idx_prod_name  key: idx_prod_name  rows: 111  Extra: Using where; Using index condition
-- LIKE '%12%'
type: ALL   key: NULL   rows: 5008
```


## Troubleshooting guide
| Symptom | Likely cause | Fix (Rocky 10 / Kubuntu 26.04) |
| --- | --- | --- |
| `seq_1_to_5000` table does not exist | Sequence engine plugin not loaded | `sudo mariadb -e "INSTALL SONAME 'ha_sequence'"` or generate rows with a recursive CTE |
| Export prints “Deprecated: the $escape parameter…” | Called `fputcsv` without the 5th argument on PHP 8.4+ | Pass `',', '"', ''` explicitly (as supplied) |
| Import says “Upload a CSV smaller than 1 MB” | No file, PHP limit, or wrong field name | Field must be `csv`; check `upload_max_filesize` |
| Thumbnails: “FAILED” | GD built without WebP or unsupported file | `php -r 'print_r(gd_info());'`; install `php-gd`; use a JPEG/PNG test image |
| Search shows 0 results with `%` or `_` typed | Wildcards escaped by `addcslashes` | This is correct behaviour; test with normal text |
| Rocky: thumbnails cannot be written by Apache | Label on `storage/thumbs` | Relabel with `semanage fcontext` and `restorecon` as in Week 10 |

## Viva prompts and marking notes
- Ask the student to explain why prefix search can use the index but a contains search cannot.
- Ask what would happen if the import were not wrapped in a transaction.
- Marking points: search/pagination (3), EXPLAIN evidence (2), CSV import/export (3), thumbnails (1), viva (1).

## Answers to review questions
1. A B-tree index is sorted by the beginning of the value. With a known prefix the server can jump to a range; with a leading wildcard every entry must be checked.
2. `fetchAll()` for small, bounded lists (dropdowns). Iterate the statement for large results to keep memory use low.
3. A transaction makes the import all-or-nothing, so one bad row cannot leave half-imported, inconsistent data.
4. Path traversal uses names such as `../../etc/passwd` to leave the intended folder. `basename()`, an allow-list and a `realpath()` prefix check prevent it.
5. N+1: one query for 20 orders plus one per order for its items = 21 queries. Use a JOIN or one `WHERE order_id IN (…)` query.
