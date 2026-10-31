| **Week** | 11 | **Time** | 15 minutes |
| --- | --- | --- | --- |
| **Marks** | 6 (8 × 0.5 + 2 × 1) | **Rules** | Closed book |

**Q1.** Which technique best prevents SQL injection? **[0.5]**

- A. Escaping quotes by hand
- B. Prepared statements
- C. Client-side validation
- D. Hiding the form

**Q2.** Which PHP function should hash user passwords? **[0.5]**

- A. `md5()`
- B. `sha1()`
- C. `password_hash()`
- D. `base64_encode()`

**Q3.** Which call should follow a successful login? **[0.5]**

- A. `session_destroy()`
- B. `session_regenerate_id(true)`
- C. `setcookie("login")`
- D. `exit`

**Q4.** Which cookie flag stops JavaScript from reading the cookie? **[0.5]**

- A. `Secure`
- B. `SameSite`
- C. `HttpOnly`
- D. `Path`

**Q5.** What does `SELECT … FOR UPDATE` do inside a transaction? **[0.5]**

- A. Deletes rows
- B. Locks the selected rows until commit
- C. Creates an index
- D. Disables foreign keys

**Q6.** Which function should compare a CSRF token with the expected value? **[0.5]**

- A. `==`
- B. `strcmp`
- C. `hash_equals`
- D. `in_array`

**Q7.** Where should uploaded user files normally be stored? **[0.5]**

- A. Inside `public/` with the original name
- B. Outside the web root with a random name
- C. In a cookie
- D. In the URL

**Q8.** Which production setting keeps stack traces away from visitors? **[0.5]**

- A. `display_errors=1`
- B. `display_errors=0` with `log_errors=1`
- C. `error_reporting=0` only
- D. `short_open_tag=1`

**Q9 (1 mark).** Explain why the checkout page reads product prices from the database inside a transaction instead of trusting the cart.

**Q10 (1 mark).** Write a PDO prepared statement with **named placeholders** that inserts a user’s name and e-mail into `users`, and the call that executes it.
