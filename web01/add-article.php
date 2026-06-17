<?php include_once "inc/header.php" ?>
<?php
$id = $_SESSION['user'];
?>

<form action="./api/add-article.php" method="post" class="article-create-form">
    <div class="article-title">
        <label for="">文章標題</label>
        <input type="text" class="article-title-input">
    </div>
    <div class="article-content">
        <label for="">文章內容</label>
        <textarea name="" id="" class="article-content-input"></textarea>
    </div>
    <button class="article-submit-button">發表文章</button>
</form>