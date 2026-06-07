<?php include_once "api/db.php"; ?>
<?php
if(!isset($_SESSION['user'])){
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
    <div id="profile-page">
        <?php include_once "./inc/header.php"; ?>
        <section class="profile-header">
            <h2>個人頁面入口</h2>
            <div>
                <img src="" alt="" class="profile-avatar">
                <input type="file">
            </div>
            <div class="profile-username"></div>
            <div class="profile-bio"></div>
            <textarea name="" id="" class="profile-bio-input"></textarea>
            <a href="CRUD/add-acticle.php">發布文章</a>
        </section>
        <section class="profile-articles">
            <div class="profile-item">
                <div class="acticle-title"></div>
                <time datetime="" class="article-date"></time>
                <a href="" class="article-readmore"></a>
                <p class="empty-article-message">目前尚無文章</p>
            </div>
        </section>
        <table border=2>
            <tr>
                <td>文章標題</td>
                <td>發布日期</td>
                <td>閱讀文章</td>
            </tr>
            <tr>
                <td><?= $article_title="" ?></td>
                <td><?= $article_title="" ?></td>
                <td><?= $article_title="" ?></td>
            </tr>
        </table>
    </div>
</body>
</html>
<?php }else{
    header("location:./index.php");
 } ?>