<?php
include_once "api/db.php";
$base = "./";
include_once "partials/header.php";

// 決定目前顯示的分頁
$tab = isset($_GET['tab']) ? $_GET['tab'] : 'articles';
?>

<nav id="content-tabs" class="d-flex justify-content-center mb-3">
    <a href="index.php?tab=articles"
       class="btn btn-outline-info mx-2 <?= $tab === 'articles' ? 'active' : '' ?>">文章</a>
    <a href="index.php?tab=notifications"
       class="btn btn-outline-info mx-2 <?= $tab === 'notifications' ? 'active' : '' ?>">公告</a>
</nav>

<?php if ($tab === 'articles'): ?>
<section class="articles p-3 rounded my-3">
    <h1 class="d-flex justify-content-center mb-4 mt-3">文章列表</h1>
    <?php
    $articles = $pdo->query("SELECT `articles`.*, `users`.`username`
                              FROM `articles`
                              LEFT JOIN `users` ON `articles`.`user_id` = `users`.`id`
                              ORDER BY `articles`.`created_at` DESC
                              LIMIT 10")->fetchAll();
    if (count($articles) > 0):
        foreach ($articles as $article):
    ?>
    <article class="article-item w-100 border rounded p-3 my-2">
        <div class="d-flex justify-content-between">
            <div class="article-title text-md bolder"><?= htmlspecialchars($article['title']) ?></div>
            <time class="article-date text-sm"><?= date("Y-m-d H:i:s", strtotime($article['created_at'])) ?></time>
        </div>
        <div class="article-excerpt"><?= htmlspecialchars(mb_substr($article['content'], 0, 50)) ?>...</div>
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">by <?= htmlspecialchars($article['username'] ?? '未知作者') ?></small>
            <a href="article.php?id=<?= $article['id'] ?>" class="article-readmore btn btn-outline-primary btn-sm">More</a>
        </div>
    </article>
    <?php
        endforeach;
    else:
    ?>
    <div class="text-center text-muted p-4">目前尚無文章</div>
    <?php endif; ?>
</section>

<?php else: ?>
<aside class="notifications border m-3 p-3 rounded">
    <h1 class="d-flex justify-content-center">公告事項</h1>
    <?php for ($i = 1; $i < 6; $i++): ?>
    <div class="notification-item border-bottom my-1 bg-gray-100 p-2 rounded">
        <div class="notification-title text-lg p-2 m-2">公告事項：<?= $i ?></div>
        <time class="notification-date"><?= date("Y-m-d H:i:s") ?></time>
    </div>
    <?php endfor; ?>
</aside>
<?php endif; ?>

<?php include_once "partials/footer.php"; ?>
