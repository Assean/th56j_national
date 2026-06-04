<?php include_once "db.php";
$u=$_POST['username'];
if($pdo->query("SELECT COUNT(*) FROM `users` WHERE `username`='$u'")->fetchColumn()){
  echo 0;
}else{
  echo $pdo->exec("INSERT INTO `users`(`username`,`password`,`email`)VALUES('$u','{$_POST['password']}','{$_POST['email']}')");
}
