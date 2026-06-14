<?php
include_once "api/db.php";
$user_id = 1; // 之後換成 $_SESSION['user_id']
$user = $pdo->query("SELECT avatar FROM users WHERE id = $user_id")->fetch();
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

            <!-- 頭像上傳 -->
            <img id="avatar" src="assets/img/profile/<?= $user['avatar'] ?? 'default.jpg' ?>" class="rounded-circle object-fit-cover" width="150" height="150" onclick="$('#avatar-input').click()">
            <input type="file" accept="image/*" class="d-none" id="avatar-input">

            <div class="profile-username"></div>
            <div class="profile-bio"></div>
            <textarea name="" id="" class="profile-bio-input"></textarea>
            <a href="CRUD/add-article.php">發布文章</a>
        </section>

        <section class="profile-articles">
            <div class="profile-item">
                <div class="acticle-title"></div>
                <time datetime="" class="article-date"></time>
                <a href="" class="article-readmore"></a>
                <p class="empty-article-message">目前尚無文章</p>
            </div>
        </section>

        <table border="2">
            <tr>
                <td>文章標題</td>
                <td>發布日期</td>
                <td>閱讀文章</td>
            </tr>
            <tr>
                <td><?= $article_title = "" ?></td>
                <td><?= $article_date  = "" ?></td>
                <td><?= $article_link  = "" ?></td>
            </tr>
        </table>
    </div>
        <script>
            $('#avatar-input').on('change', function () {
                const f = this.files[0], fd = new FormData(); fd.append('avatar', f);
                $('#avatar').attr('src', URL.createObjectURL(f));
                $.ajax({url:'api/upload-avatar.php',type:'POST',data:fd,processData:!1,contentType:!1});
            });
        </script>
</body>
</html>