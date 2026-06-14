<?php include_once "api/db.php"; ?>
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
    <?php include_once "inc/header.php" ?>
    <?php
        $id = $_GET['id'];
        $article = $pdo->query("SELECT * FROM `articles` WHERE `id` = {$id}")->fetch();
    ?>
    <div id="article">
        <header class="article-header m-5">
            <h1 class="article-title d-flex justify-content-center border"><?= $article['article_title']; ?></h1>
            <time datetime="<?= $article['article_date']; ?>" class="article-date d-flex justify-content-end">
                <?= $article['article_date']; ?>
            </time>
        </header>
        <section class="article-body text-break border m-5 p-4">
            <?= $article['article_content']; ?>
        </section>
    </div>
</body>
</html>