<?php
declare(strict_types=1);
require __DIR__ . '/../src/bootstrap.php';
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $st = db()->prepare('SELECT id, password_hash FROM users WHERE email = ?');
    $st->execute([trim((string)($_POST['email'] ?? ''))]);
    $u = $st->fetch();
    if ($u && password_verify((string)($_POST['password'] ?? ''), $u['password_hash'])) {
        session_regenerate_id(true);                         // prevents session fixation
        $_SESSION['uid'] = (int)$u['id'];
        redirect('products.php');
    }
    $err = 'E-mail or password incorrect.';
}
page_start('Login');
if ($err) { echo '<p role="alert" style="color:#b00020">' . e($err) . '</p>'; }
?>
<form method="post"><?= csrf_field() ?>
  <p><label>E-mail <input type="email" name="email" required></label></p>
  <p><label>Password <input type="password" name="password" required></label></p>
  <button>Login</button></form>
<?php page_end();
