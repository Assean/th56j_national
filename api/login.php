<?php include_once "db.php";

$chk = $pdo->query("SELECT count(*) FROM `users` WHERE `username`='{$_POST['username']}' && `password`='{$_POST['password']}'")->fetchColumn();

if ($chk) {
    $_SESSION['user'] = $_POST['username'];
    $_SESSION['num'] = $_POST['username'];   // ✅ 加上 =
    $_SESSION['user_id'] = $pdo->query("SELECT `id` FROM `users` WHERE `username` = '{$_POST['username']}' && `password` = '{$_POST['password']}'")->fetchColumn();  // ✅ 改成 password
    echo $chk;
} else {
    echo 0;
}