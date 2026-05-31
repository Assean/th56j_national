<?php include_once "db.php";
$check_username="SELECT * FROM `users` WHERE `username` = '{$_POST['username']}'";
$check_username_num=$pdo->query($check_username)->fetchColumn();
if($check_username_num>0){
    echo "<script>";
    echo "alert('帳號已存在');";
    echo "location.href=('javascript:loadpage('./front/register.php')')";
    echo "</script>";
}else{
    $sql="INSERT INTO `users` (`username`,`password`,`email`) VALUES('{$_POST['username']}','{$_POST['password']}','{$_POST['email']}')";
    echo $pdo->exec($sql);
}