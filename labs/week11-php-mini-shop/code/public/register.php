<?php
declare(strict_types=1);
require __DIR__ . '/../src/bootstrap.php';
$errors = []; $old = ['name' => '', 'email' => '']; $done = isset($_GET['ok']);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old['name'] = trim((string)($_POST['name'] ?? ''));
    $old['email'] = trim((string)($_POST['email'] ?? ''));
    $pass = (string)($_POST['password'] ?? '');
    $cap = strtoupper(trim((string)($_POST['captcha'] ?? '')));
    $expected = (string)($_SESSION['captcha'] ?? '');
    unset($_SESSION['captcha']);                                   // single use
    if ($expected === '' || !hash_equals($expected, $cap)) { $errors[] = 'CAPTCHA is incorrect.'; }
    if (mb_strlen($old['name']) < 3) { $errors[] = 'Name must have at least 3 characters.'; }
    if (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) { $errors[] = 'E-mail is not valid.'; }
    if (strlen($pass) < 10) { $errors[] = 'Password must have at least 10 characters.'; }
    $avatar = null;
    if (!$errors && ($_FILES['avatar']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
        $avatar = saveAvatar($_FILES['avatar'], $errors);
    }
    if (!$errors) {
        try {
            $st = db()->prepare('INSERT INTO users (name, email, password_hash, avatar) VALUES (:n, :e, :p, :a)');
            $st->execute([':n' => $old['name'], ':e' => $old['email'], ':p' => password_hash($pass, PASSWORD_DEFAULT), ':a' => $avatar]);
            header('Location: register.php?ok=1'); exit;
        } catch (PDOException $ex) {
            if ($ex->getCode() === '23000') { $errors[] = 'E-mail is already registered.'; } else { throw $ex; }
        }
    }
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><title>Register</title></head><body><main>
<h1>Create account</h1>
<?php if ($done): ?><p role="status">Account created.</p><?php endif; ?>
<?php foreach ($errors as $m): ?><p role="alert" style="color:#b00020"><?= e($m) ?></p><?php endforeach; ?>
<form method="post" enctype="multipart/form-data">
  <p><label>Name <input name="name" required value="<?= e($old['name']) ?>"></label></p>
  <p><label>E-mail <input name="email" type="email" required value="<?= e($old['email']) ?>"></label></p>
  <p><label>Password <input name="password" type="password" minlength="10" required autocomplete="new-password"></label></p>
  <p><label>Avatar <input name="avatar" type="file" accept="image/png,image/jpeg,image/webp"></label></p>
  <p><img src="captcha.php" alt="CAPTCHA code"> <label>Type the code <input name="captcha" required autocomplete="off"></label></p>
  <button>Register</button>
</form></main></body></html>
