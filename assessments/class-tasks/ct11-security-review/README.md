# CT-11 (Week 11, 30 min, pairs, CLO_3): Security Review

List every vulnerability in the snippet and rewrite it securely with PDO.

```php
<?php
session_start();
$email = $_POST['email'];
$pw = md5($_POST['password']);
$r = mysqli_query($db, "SELECT * FROM users WHERE email='$email' AND pw='$pw'");
if (mysqli_num_rows($r) > 0) { $_SESSION['user'] = $email; echo "Welcome " . $_GET['name']; }
```

**Deliverable:** vulnerability table (issue, impact, fix) and corrected code.

Solution: `solution/` (written notes in [`instructor/class-task-solutions.md`](../../../instructor/class-task-solutions.md)).
