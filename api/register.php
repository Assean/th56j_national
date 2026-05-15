<?php include_once "db.php";

/* $_POST['username']
$_POST['password']
$_POST['email']
 */

$sql="INSERT INTO `users` (`username`,`password`,`email`) VALUES('{$_POST['username']}','{$_POST['password']}','{$_POST['email']}')";
echo $pdo->exec($sql);