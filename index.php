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
    <div id="home">
        <?php include_once "./inc/header.php"; ?>
        <section class="articles" class="">
            <h1 class="p-2 m-2 d-flex justify-content-center">文章列表</h1>
            <?php for ($i=0; $i < 10; $i++) { ?>
                <div class="article-item ml-5 mb-2 mr-2 border">
                    <div class="article-title">文章標題</div>
                    <time datetime="" class="article-date">文章發布日期</time>
                    <div class="article-excerpt">文章摘要</div>
                    <a href="" class="actitcle-readmore">閱讀更多</a>
                </div>
            <?php } ?>
        </section>
        <hr>
        <aside class="notifications ml-5">
            <h1 class="p-2 m-2 d-flex justify-content-center">通知/公告</h1>
            <?php for ($i=0; $i < 5; $i++) { ?>
                <div class="notifications-item border p-3 mb-3">
                    <div class="notifications-title">通知標題</div>
                    <div class="notifications-date">發布日期</div>
                </div>
            <?php } ?>
        </aside>
    </div>
</body>
</html>