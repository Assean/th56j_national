<?php
include_once "db.php";
// 確認密碼是否一致
if($_POST['password'] != $_POST['check_password']){
    echo "<script>";
    echo "alert('註冊失敗，密碼不一致');";
    echo "location.href='../register.php';";
    echo "</script>";
    exit;
}
// 判斷帳戶是否已存在
$check_username="SELECT * FROM `users` WHERE `username` = '{$_POST['username']}'";
$check_username_num=$pdo->query($check_username)->fetchColumn();
if($check_username_num > 0){
    echo "<script>";
    echo "alert('註冊失敗，帳戶已註冊');";
    echo "location.href='../register.php';";
    echo "</script>";
    exit;
}
// 寫入資料庫
$sql = "INSERT INTO `users` (`username`, `email`, `password`) 
        VALUES ('{$_POST['username']}', '{$_POST['email']}', '{$_POST['password']}');";
$rows = $pdo->exec($sql);
// 註冊成功之回應訊息
echo "<script>";
echo "alert('註冊成功');";
echo "location.href='../login.php';";
echo "</script>";
