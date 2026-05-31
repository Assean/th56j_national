<?php
include_once "api/db.php";
$base = "./";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user       = $pdo->query("SELECT * FROM `users` WHERE `username`='{$_SESSION['user']}'")->fetch();
$userHeader = (!empty($user['header'])) ? "./img/{$user['header']}" : "./img/default_header.jpg";

$msg = "";

// 處理頭像上傳
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['header']) && $_FILES['header']['error'] === 0) {
    $file    = $_FILES['header'];
    $ext_map = ['image/jpeg' => '.jpg', 'image/png' => '.png', 'image/gif' => '.gif'];
    $ext     = $ext_map[$file['mime_type']] ?? '.jpg';
    // 使用 finfo 偵測 MIME
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($file['tmp_name']);
    $ext   = $ext_map[$mime] ?? '.jpg';

    // 刪除舊頭像
    $oldHeader = $pdo->query("SELECT `header` FROM `users` WHERE `username`='{$_SESSION['user']}'")->fetchColumn();
    if ($oldHeader && file_exists("./img/$oldHeader")) {
        unlink("./img/$oldHeader");
    }

    $filename = $_SESSION['user'] . $ext;
    $filepath = "./img/$filename";
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        $pdo->exec("UPDATE `users` SET `header`='$filename' WHERE `username`='{$_SESSION['user']}'");
        $userHeader = $filepath;
        $msg = "頭像更新成功！";
    } else {
        $msg = "頭像上傳失敗";
    }
    // 重整避免 F5 重送
    header("Location: profile.php?msg=" . urlencode($msg));
    exit;
}

// 處理個人簡介更新
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bio'])) {
    $bio = $_POST['bio'];
    $pdo->exec("UPDATE `users` SET `bio`='$bio' WHERE `username`='{$_SESSION['user']}'");
    header("Location: profile.php?msg=" . urlencode("簡介更新成功！"));
    exit;
}

if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}

// 重新取得使用者資料
$user       = $pdo->query("SELECT * FROM `users` WHERE `username`='{$_SESSION['user']}'")->fetch();
$userHeader = (!empty($user['header'])) ? "./img/{$user['header']}" : "./img/default_header.jpg";
$articles   = $pdo->query("SELECT * FROM `articles` WHERE `user_id`='{$user['id']}' ORDER BY `created_at` DESC")->fetchAll();

include_once "partials/header.php";
?>

<div id="profile-page">
    <?php if ($msg): ?>
        <div class="alert alert-info text-center"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <section class="profile-header w-100 p-3 border rounded mb-2 text-center">
        <!-- 頭像上傳表單 -->
        <form method="POST" action="profile.php" enctype="multipart/form-data">
            <label for="header" style="cursor:pointer" title="點擊更換頭像">
                <img src="<?= htmlspecialchars($userHeader) ?>" class="profile-avatar" style="width:128px;">
                <input type="file" name="header" id="header" accept="image/*" style="display:none"
                       onchange="this.form.submit()">
            </label>
        </form>
        <div class="profile-username"><?= htmlspecialchars($_SESSION['user']) ?></div>

        <!-- 個人簡介更新表單 -->
        <form method="POST" action="profile.php" class="d-inline">
            <div class="profile-bio m-auto col-md-8 form-group border rounded bg-info text-white p-2">
                <input type="text" name="bio" class="form-control text-dark"
                       value="<?= htmlspecialchars($user['bio'] ?? '') ?>"
                       placeholder="尚未填寫自我介紹">
                <button type="submit" class="btn btn-light btn-sm mt-1">更新簡介</button>
            </div>
        </form>
    </section>

    <div class="text-center my-2">
        <a href="add-article.php" class="btn btn-primary new-post-link">✏️ 發表文章</a>
    </div>

    <hr>

    <section class="profile-articles my-2">
        <h3 class="text-center">我的文章</h3>
        <?php if (count($articles) > 0): ?>
            <?php foreach ($articles as $article): ?>
            <div class="article-item my-2 p-2 border rounded d-flex justify-content-between">
                <div class="col-md-10 d-flex justify-content-between">
                    <span class="article-title"><?= htmlspecialchars($article['title']) ?></span>
                    <a href="article.php?id=<?= $article['id'] ?>" class="article-readmore">閱讀文章</a>
                </div>
                <time class="article-date col-md-2 text-right text-sm">
                    <?= date("Y-m-d", strtotime($article['created_at'])) ?>
                </time>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-article-message text-center p-3">目前尚無文章</div>
        <?php endif; ?>
    </section>
</div>

<?php include_once "partials/footer.php"; ?>
