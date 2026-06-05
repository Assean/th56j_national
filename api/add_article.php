<?php include_once "db.php";

$title=$_POST['title'];
$content=$_POST['content'];
$user=$pdo->query("SELECT * FROM `users` WHERE `username`='{$_SESSION['user']}'")->fetch();

$pdo->exec("INSERT INTO `articles` (`title`,`content`,`user_id`) 
                      VALUES('{$title}','{$content}','{$user['id']}')");
echo $pdo->lastInsertId();