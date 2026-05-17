<?php include "db.php";

$bio=$_POST['text'];
echo $pdo->exec("UPDATE `users` SET `bio`='$bio' WHERE `username`='{$_SESSION['login']}'");