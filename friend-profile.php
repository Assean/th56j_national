<?php
include_once "api/db.php";
$base = "./";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: friends.php");
    exit;
}

$fid    = (int)$_GET['id'];
$friend = $pdo->query("SELECT * FROM `users` WHERE `id`='$fid'")->fetch();

if (!$friend) {
    header("Location: friends.php");
    exit;
}

$userHeader = (!empty($friend['header'])) ? "./img/{$friend['header']}" : "./img/default_header.jpg";
$my         = (int)$_SESSION['user_id'];

// 好友關係
$relation = $pdo->query("SELECT * FROM `friends` WHERE
    (requester_id='$my' AND addressee_id='$fid') OR
    (requester_id='$fid' AND addressee_id='$my')")->fetch();

$is_relation  = !empty($relation);
$is_requester = ($is_relation && $relation['requester_id'] == $my && $relation['status'] == 'pending');
$is_addressee = ($is_relation && $relation['addressee_id'] == $my && $relation['status'] == 'pending');
$is_friend    = ($is_relation && $relation['status'] == 'accept');

$articles = $pdo->query("SELECT * FROM `articles` WHERE `user_id`='$fid'")->fetchAll();

include_once "partials/header.php";
?>

<div id="profile-page">
    <section class="profile-header w-100 p-3 border rounded mb-2 text-center">
        <img src="<?= htmlspecialchars($userHeader) ?>" class="profile-avater" style="width:128px;">
        <div class="profile-username"><?= htmlspecialchars($friend['username']) ?></div>
        <div class="profile-bio m-auto col-md-8 form-group border rounded bg-info text-white p-2">
            <span class="show-bio">
                <?= ($friend['bio'] !== '') ? htmlspecialchars($friend['bio']) : '尚未填寫自我介紹' ?>
            </span>
        </div>
    </section>

    <div class="profile-content">
        <section class="articles my-2 border rounded p-3">
            <?php if (count($articles) > 0): ?>
                <?php foreach ($articles as $article): ?>
                <article class="article-item my-2">
                    <div class="d-flex justify-content-between w-100">
                        <div class="article-title bolder"><?= htmlspecialchars($article['title']) ?></div>
                        <time class="article-date text-sm"><?= date("Y-m-d", strtotime($article['created_at'])) ?></time>
                    </div>
                    <div class="d-flex w-100 pl-3">
                        <div class="article-excerpt"><?= htmlspecialchars(mb_substr($article['content'], 0, 30)) ?>...</div>
                        <a href="article.php?id=<?= $article['id'] ?>" class="article-readmore ml-2">閱讀更多</a>
                    </div>
                </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-article-message">目前尚無文章</div>
            <?php endif; ?>
        </section>
    </div>

    <div class="profile-friend-actions my-2">
        <?php if (!$is_relation): ?>
            <a href="friends.php?action=apply&friend_id=<?= $fid ?>" class="btn btn-primary">申請好友</a>
        <?php elseif ($is_requester): ?>
            <a href="friends.php?action=cancel&friend_id=<?= $fid ?>" class="btn btn-primary">取消申請好友</a>
        <?php elseif ($is_addressee): ?>
            <a href="friends.php?action=accept&friend_id=<?= $fid ?>" class="btn btn-success">接受好友</a>
            <a href="friends.php?action=reject&friend_id=<?= $fid ?>" class="btn btn-warning">拒絕好友</a>
        <?php elseif ($is_friend): ?>
            <a href="friends.php?action=remove&friend_id=<?= $fid ?>" class="btn btn-danger">取消好友</a>
        <?php endif; ?>
    </div>

    <div class="text-center mt-3">
        <a href="friends.php" class="btn btn-secondary">← 返回好友列表</a>
    </div>
</div>

<?php include_once "partials/footer.php"; ?>
