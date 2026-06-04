<?php include_once "db.php";
$u=$_POST['username'];$p=$_POST['password'];
$row=$pdo->query("SELECT `id` FROM `users` WHERE `username`='$u' AND `password`='$p'")->fetch();
if($row){
  $_SESSION['user']=$_SESSION['num']=$u;
  $_SESSION['user_id']=$row['id'];
  echo 1;
}else echo 0;
