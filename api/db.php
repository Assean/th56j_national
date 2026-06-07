<?php
$dsn="mysql:host=localhost;charset=utf8;dbname=dbsv1";
$pdo=new PDO($dsn,'root','');
date_default_timezone_set("Asia/Taipei");
session_start();