<?php
include_once "db.php";

$user = $pdo->query("select * from users WHERE `username` = '{$_POST['username']}' AND `password` = '{$_POST['password']}'")->fetch();

if (!isset($user['id'])) 
    exit("<script>alert('登入失敗，帳號或密碼錯誤');location.href='../login.php';</script>");

$_SESSION['user_id']  = $user['id'];
$_SESSION['user'] = $_POST['username'];
exit("<script>alert('登入成功');location.href='../index.php';</script>");