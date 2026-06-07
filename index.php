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
    <div id="home" class="">
        <?php include_once "./inc/header.php"; ?>
        <section class="articles">
            <h1 class="p-2 m-2 d-flex justify-content-center">文章列表</h1>
            <?php 
            $articles = $pdo->query("SELECT * FROM `articles`")->fetchAll(); 

            foreach ($articles as $article) { 
            ?>
                <div class="article-item ml-5 mb-2 mr-2 border">
                    <div class="article-title col-2 m-2">文章標題:<?= $article['article_title']; ?></div>
                    
                    <time datetime="<?= $article['article_date']; ?>" class="article-date col-2 m-2">
                        文章發布日期:<?= $article['article_date']; ?>
                    </time>
                    
                    <div class="article-excerpt col-2 m-2">文章摘要:<?= mb_substr($article['article_content'], 0, 10); ?>...</div>
                    
                    <div class="d-flex justify-content-end m-2 ml-auto">
                        <a href="articles.php?id=<?= $article['id']; ?>" class="artitcle-readmore btn btn-info ">閱讀更多</a>
                    </div>
                </div>
            <?php } ?>
        </section>
        <hr>
        <aside class="notifications ml-5">
            <h1 class="p-2 m-2 d-flex justify-content-center">通知/公告</h1>
            <?php for ($i=0; $i < 6 ; $i++) { ?>
                <div class="notifications-item border p-3 mb-3">
                    <div class="notifications-title">通知標題</div>
                    <div class="notifications-date">通知日期</div>
                </div>
            <?php } ?>
        </aside>
    </div>
</body>
</html>