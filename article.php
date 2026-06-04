<?php
include_once "api/db.php";
$base = "./";
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) { header("Location: index.php"); exit; }
$article = $pdo->query("SELECT * FROM `articles` WHERE `id`='".(int)$_GET['id']."'")->fetch();
if (!$article) { header("Location: index.php"); exit; }
include_once "partials/header.php";
?>
<div id="article-content">
    <header class="article-header">
        <h1 class="article-title text-center"><?= htmlspecialchars($article['title']) ?></h1>
        <time class="article-date d-block w-100 text-right">發文日期：<?= date("Y-m-d", strtotime($article['created_at'])) ?></time>
    </header>
    <section class="article-body col-md-10 m-auto"><?= nl2br(htmlspecialchars($article['content'])) ?></section>
    <div class="text-center my-3"><a href="index.php" class="btn btn-secondary">← 返回文章列表</a></div>
</div>
<?php include_once "partials/footer.php"; ?>
