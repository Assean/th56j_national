<?php
session_start();
include_once "api/db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FunTech</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/index.css">
    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
</head>
<body>
    <div id="acticle">
        <header class="acticle-header">
            <h1 class="acticle-title">文章標題</h1>
            <time datetime="" class="acricle-date">文章發布日期</time>
        </header>
        <section class="article-body"></section>
    </div>
</body>
</html>