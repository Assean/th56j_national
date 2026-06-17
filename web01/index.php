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
        <section class="articles">
            <article class="article-item">
                <div class="article-title">文章標題:</div>
                <time datetime="" class="article-date">發布日期:</time>
                <div class="article-excerpt">文章摘要:</div>
                <a href="article?id=" class="article-readmore">閱讀更多</a>
            </article>
        </section>
        <aside class="notifications">
            <div class="notifications-item">
                <div class="notifications-titile"></div>
                <time datetime="" class="notifications-date"></time>
            </div>
        </aside>
    </div>
</body>
</html>