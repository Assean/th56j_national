<?php include "db.php";
echo $pdo->exec("UPDATE `users` SET `bio`='{$_POST['text']}' WHERE `username`='{$_SESSION['user']}'");
