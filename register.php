<?php
include_once "api/db.php";
$base = "./";

if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username    = $_POST['username']    ?? '';
    $email       = $_POST['email']       ?? '';
    $password    = $_POST['password']    ?? '';
    $chkpassword = $_POST['chkpassword'] ?? '';

    if ($password !== $chkpassword) {
        $error = "密碼不一致，請重新輸入";
    } else {
        $exists = $pdo->query("SELECT COUNT(*) FROM `users` WHERE `username`='$username'")->fetchColumn();
        if ($exists > 0) {
            $error = "帳號已存在，請更換帳號名稱";
        } else {
            $pdo->exec("INSERT INTO `users` (`username`,`password`,`email`)
                        VALUES('$username','$password','$email')");
            header("Location: login.php?registered=1");
            exit;
        }
    }
}

include_once "partials/header.php";
?>

<form method="POST" action="register.php" class="register-form form-group w-50 m-auto">
    <h2 class="text-center">會員註冊</h2>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <div class="my-2">
        <label>帳號</label>
        <input type="text" name="username" class="form-control username-input" required>
    </div>
    <div class="my-2">
        <label>電子郵件</label>
        <input type="email" name="email" class="form-control email-input" required>
    </div>
    <div class="my-2">
        <label>密碼</label>
        <input type="password" name="password" class="form-control password-input" required>
    </div>
    <div class="my-2">
        <label>確認密碼</label>
        <input type="password" name="chkpassword" class="form-control password-confirm-input" required>
    </div>
    <div class="text-center my-1">
        <button type="submit" class="register-submit btn btn-primary">註冊</button>
    </div>
    <div class="text-center mt-2">
        已有帳號？<a href="login.php">立即登入</a>
    </div>
</form>

<?php include_once "partials/footer.php"; ?>
