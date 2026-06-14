<?php
include_once "db.php";
if (!$pdo->query("SELECT 1 FROM `users` WHERE `username` = '{$_POST['username']}' AND `password` = '{$_POST['password']}'")->fetchColumn()) 
    exit("<script>alert('登入失敗，帳號或密碼錯誤');location.href='../login.php';</script>");

$_SESSION['user'] = $_POST['username'];
exit("<script>alert('登入成功');location.href='../index.php';</script>");