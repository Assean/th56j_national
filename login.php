<?php
include_once "api/db.php";
$base = "./";
if (isset($_SESSION['user'])) { header("Location: index.php"); exit; }
$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = $_POST['username'] ?? '';
    $p = $_POST['password'] ?? '';
    $chk = $pdo->query("SELECT * FROM `users` WHERE `username`='$u' AND `password`='$p'")->fetch();
    if ($chk) {
        $_SESSION['user'] = $_SESSION['num'] = $chk['username'];
        $_SESSION['user_id'] = $chk['id'];
        header("Location: index.php"); exit;
    }
    $error = "帳號或密碼錯誤，請重新登入";
}
include_once "partials/header.php";
?>
<form method="POST" action="login.php" class="login-form form-group w-50 m-auto">
    <h2 class="text-center">會員登入</h2>
    <?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <div class="my-2"><label>帳號：</label><input type="text" name="username" class="form-control username-input" required></div>
    <div class="my-2"><label>密碼：</label><input type="password" name="password" class="form-control password-input" required></div>
    <div class="my-2 text-center"><button type="submit" class="login-submit-button btn btn-primary btn-lg">登入</button></div>
    <div class="text-center mt-2">還沒有帳號？<a href="register.php">立即註冊</a></div>
</form>
<?php include_once "partials/footer.php"; ?>
