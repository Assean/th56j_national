<?php include_once "db.php";
$uid=$pdo->query("SELECT `id` FROM `users` WHERE `username`='{$_SESSION['user']}'")->fetchColumn();
$pdo->exec("INSERT INTO `articles`(`title`,`content`,`user_id`)VALUES('{$_POST['title']}','{$_POST['content']}','$uid')");
echo $pdo->lastInsertId();
