<?php
include_once "db.php";
if ($_POST['password'] != $_POST['check_password']) 
    exit("<script>alert('註冊失敗，密碼不一致');location.href='../register.php';</script>");

if ($pdo->query("SELECT 1 FROM `users` WHERE `username` = '{$_POST['username']}'")->fetchColumn()) 
    exit("<script>alert('註冊失敗，帳戶已註冊');location.href='../register.php';</script>");

$pdo->exec("INSERT INTO `users` (`username`, `email`, `password`) 
            VALUES ('{$_POST['username']}', '{$_POST['email']}', '{$_POST['password']}')");
exit("<script>alert('註冊成功');location.href='../login.php';</script>");