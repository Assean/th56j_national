<?php include_once "db.php";
$f = "user_1." . pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
move_uploaded_file($_FILES['avatar']['tmp_name'], "../assets/img/profile/$f");
$pdo->prepare("UPDATE users SET avatar=? WHERE id=1")->execute([$f]);