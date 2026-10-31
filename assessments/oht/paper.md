| **Marks** | 10 | **CLO** | CLO_2 |
| --- | --- | --- | --- |
| **Time** | 60 minutes | **Covers** | Weeks 9–11 (PHP, SQL, PDO, sessions) |

**Q1 (2 marks).** Given `$sales = ["Mon" => [120, 80], "Tue" => [200, 150, 50], "Wed" => []];` write PHP that prints each day’s total and then the name of the day with the highest total. An empty day has total 0.

**Q2 (3 marks).** Using `products(id, category_id, name, price, stock)` and `categories(id, name)` write SQL for: (a) product name and category name for products costing more than 1000, highest price first **[1]**; (b) category names with the number of products whose stock is below 20, only categories with at least one such product **[1]**; (c) add a unique `sku VARCHAR(20)` column, then raise prices in category “Stationery” by 10% **[1]**.

**Q3 (3 marks).** Fill in the six blanks (0.5 mark each).

```
$st = db()->prepare('SELECT id, password_hash FROM users WHERE email = ____(1)____');
$st->execute([ ____(2)____ ]);
$u = $st->fetch();
if ($u && ____(3)____($_POST['password'], $u['password_hash'])) {
    ____(4)____(true);
    $_SESSION['uid'] = ____(5)____($u['id']);
    header('Location: products.php');
    ____(6)____;
}
```

**Q4 (2 marks).** (a) Name two cookie flags and state what each protects against **[1]**. (b) Why does the logout form carry a CSRF token **[1]**?
