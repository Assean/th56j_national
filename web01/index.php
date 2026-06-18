<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FunTech</title>
</head>
<body>
    <div id="home">
        <?php include_once "inc/header.php"; ?>
        <section class="articles m-5">
            <?php 
            $articles = $pdo->query("SELECT * FROM `articles`")->fetchAll();
            foreach($articles as $article){
                ?>
                <article class="article-item border m-3 p-2">
                    <div class="article-title">文章標題:<?=$article['title']?></div>
                    <time datetime="" class="article-date">發布日期:<?=$article['created_at']?></time>
                    <div class="article-excerpt">文章摘要:<?=mb_strimwidth($article['content'],0,50,'...')?></div>
                    <a href="article.php?id=<?=$article['id']?>" class="article-readmore d-flex justify-content-end">閱讀更多</a>
                </article>
            <?php } ?>
        </section>
        <aside class="notifications">
            <div class="notifications-item">
                <div class="notifications-titile">通知標題</div>
                <time datetime="" class="notifications-date">發布日期</time>
            </div>
        </aside>
    </div>
</body>
</html>