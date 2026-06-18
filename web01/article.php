<?php 
include_once "inc/header.php";
$article = $pdo->query("SELECT * FROM `articles` WHERE `id` = {$_GET['id']}")->fetch();
?>

<div id="article" class="m-5">
    <header class="article-header border mb-5">
        <h1 class="article-title d-flex justify-content-center">文章標題: <?=$article['title']?></h1>
        <time class="article-date d-flex justify-content-end">文章發布時間:<?=$article['created_at']?></time>
    </header>
    <section class="article-body d-flex justify-content-center">
        <?=$article['content']; ?>
    </section>
</div>