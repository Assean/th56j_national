<?php
include_once "api/db.php";
$base = "./";
if (!isset($_SESSION['user'])) { header("Location: login.php"); exit; }
$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = $_POST['title']   ?? '';
    $content = $_POST['content'] ?? '';
    if (!$title || !$content) {
        $error = "標題與內容不能為空";
    } else {
        $uid = $pdo->query("SELECT `id` FROM `users` WHERE `username`='{$_SESSION['user']}'")->fetchColumn();
        $pdo->exec("INSERT INTO `articles` (`title`,`content`,`user_id`) VALUES('$title','$content','$uid')");
        header("Location: article.php?id=".$pdo->lastInsertId()); exit;
    }
}
include_once "partials/header.php";
?>
<form method="POST" action="add-article.php" class="article-create-form col-md-12 m-auto border rounded form-group p-3">
    <h3 class="text-center">發表文章</h3>
    <?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <div class="p-2">
        <label>標題：</label>
        <input type="text" name="title" class="article-title-input form-control" required value="<?= htmlspecialchars($_POST['title'] ?? '') ?>">
    </div>
    <div class="p-2">
        <label>文章內容：</label>
        <textarea name="content" class="article-content-input form-control" style="height:300px" required><?= htmlspecialchars($_POST['content'] ?? '') ?></textarea>
    </div>
    <div class="text-center p-2">
        <button type="submit" class="article-submit-button btn btn-primary">發佈</button>
        <a href="profile.php" class="btn btn-secondary ml-2">取消</a>
    </div>
</form>
<?php include_once "partials/footer.php"; ?>
