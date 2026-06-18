<?php
session_start();
$dsn="mysql:host=localhost;charset=utf8;dbname=db21";
$pdo=new PDO($dsn,"admin","1234");