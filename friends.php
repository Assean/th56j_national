<?php
include_once "api/db.php";
$base = "./";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$msg = "";

// 處理好友操作（透過 GET 表單）
if (isset($_GET['action']) && isset($_GET['friend_id'])) {
    $action    = $_GET['action'];
    $friend_id = (int)$_GET['friend_id'];
    $my        = (int)$_SESSION['user_id'];

    $relation = $pdo->query("SELECT * FROM `friends` WHERE
        (requester_id='$my' AND addressee_id='$friend_id') OR
        (requester_id='$friend_id' AND addressee_id='$my')")->fetch();

    switch ($action) {
        case 'apply':
            $pdo->exec("INSERT INTO `friends` (`requester_id`,`addressee_id`,`status`)
                        VALUES('$my','$friend_id','pending')");
            $msg = "好友申請已送出";
            break;
        case 'accept':
            if ($relation) {
                $pdo->exec("UPDATE `friends` SET `status`='accept' WHERE `id`='{$relation['id']}'");
            }
            $msg = "好友申請已接受";
            break;
        case 'cancel':
        case 'reject':
        case 'remove':
            if ($relation) {
                $pdo->exec("DELETE FROM `friends` WHERE `id`='{$relation['id']}'");
            }
            $msg = "操作成功";
            break;
    }
    header("Location: friends.php?msg=" . urlencode($msg));
    exit;
}

if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}

// 搜尋使用者
$searchResults = [];
$searchTerm    = "";
if (isset($_GET['search']) && $_GET['search'] !== '') {
    $searchTerm = $_GET['search'];
    $users      = $pdo->query("SELECT * FROM `users` WHERE `username` LIKE '%$searchTerm%'")->fetchAll();
    foreach ($users as $u) {
        if ($u['username'] !== $_SESSION['user']) {
            $searchResults[] = $u;
        }
    }
}

$my = (int)$_SESSION['user_id'];

// 好友列表
$friends = $pdo->query("SELECT * FROM `friends`
                         WHERE (`requester_id`='$my' OR `addressee_id`='$my')
                           AND `status`='accept'")->fetchAll();

// 收到的申請
$incomingRequests = $pdo->query("SELECT * FROM `friends`
                                  WHERE `addressee_id`='$my' AND `status`='pending'")->fetchAll();

// 發出的申請
$outgoingRequests = $pdo->query("SELECT * FROM `friends`
                                  WHERE `requester_id`='$my' AND `status`='pending'")->fetchAll();

include_once "partials/header.php";
?>

<div id="friends-page">

    <?php if ($msg): ?>
        <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <!-- 搜尋使用者 -->
    <div class="friend-search-section border rounded p-3">
        <form method="GET" action="friends.php" class="friend-search-form form-group d-flex align-items-center">
            <label class="mx-2">搜尋使用者</label>
            <input type="text" name="search" id="search" class="search-input form-control col-md-7"
                   value="<?= htmlspecialchars($searchTerm) ?>">
            <button type="submit" class="search-submit-button btn btn-primary mx-2">尋找</button>
        </form>

        <?php if ($searchTerm !== ''): ?>
        <div class="search-result-list my-2">
            <?php if (count($searchResults) > 0): ?>
                <?php foreach ($searchResults as $u): ?>
                <div class="search-result-item d-flex justify-content-between my-1 col-md-10">
                    <div class="result-username"><?= htmlspecialchars($u['username']) ?></div>
                    <a href="friend-profile.php?id=<?= $u['id'] ?>" class="view-profile-link">查看個人頁面</a>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-muted">查無符合的使用者</div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- 好友列表 -->
    <div class="friend-list-section w-100 border rounded p-3 my-2">
        <h3 class="section-title text-center">好友列表</h3>
        <div class="d-flex flex-wrap p-3">
            <?php foreach ($friends as $friend): ?>
                <?php
                $friend_id   = ($friend['requester_id'] == $my) ? $friend['addressee_id'] : $friend['requester_id'];
                $friend_info = $pdo->query("SELECT * FROM `users` WHERE `id`='$friend_id'")->fetch();
                $avatar      = !empty($friend_info['header']) ? "./img/{$friend_info['header']}" : "./img/default_header.jpg";
                ?>
                <div class="friend-item col-md-3 p-2 text-center">
                    <a href="friend-profile.php?id=<?= $friend_id ?>">
                        <img src="<?= htmlspecialchars($avatar) ?>" style="width:64px;" class="friend-avatar">
                        <div class="friend-name mx-3"><?= htmlspecialchars($friend_info['username']) ?></div>
                    </a>
                </div>
            <?php endforeach; ?>
            <?php if (count($friends) === 0): ?>
                <div class="text-muted text-center w-100">尚無好友</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- 收到的好友申請 -->
    <div class="incoming-requests-section border rounded p-3 my-2">
        <h3 class="section-title text-center">收到的好友申請</h3>
        <div class="d-flex flex-wrap p-3">
            <?php foreach ($incomingRequests as $req): ?>
                <?php
                $requester_info = $pdo->query("SELECT * FROM `users` WHERE `id`='{$req['requester_id']}'")->fetch();
                $avatar         = !empty($requester_info['header']) ? "./img/{$requester_info['header']}" : "./img/default_header.jpg";
                ?>
                <div class="request-item col-md-3 p-2 text-center">
                    <img src="<?= htmlspecialchars($avatar) ?>" style="width:64px;" class="request-avatar">
                    <div class="request-username"><?= htmlspecialchars($requester_info['username']) ?></div>
                    <div>
                        <a href="friends.php?action=accept&friend_id=<?= $req['requester_id'] ?>"
                           class="accept-request-button btn btn-success btn-sm">接受好友</a>
                        <a href="friends.php?action=reject&friend_id=<?= $req['requester_id'] ?>"
                           class="reject-request-button btn btn-warning btn-sm">拒絕好友</a>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (count($incomingRequests) === 0): ?>
                <div class="text-muted text-center w-100">沒有待處理的好友申請</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- 發送的好友申請 -->
    <div class="sent-requests-section border rounded p-3 my-2">
        <h3 class="section-title text-center">發送的好友申請</h3>
        <div class="d-flex flex-wrap p-3">
            <?php foreach ($outgoingRequests as $req): ?>
                <?php
                $addressee_info = $pdo->query("SELECT * FROM `users` WHERE `id`='{$req['addressee_id']}'")->fetch();
                $avatar         = !empty($addressee_info['header']) ? "./img/{$addressee_info['header']}" : "./img/default_header.jpg";
                ?>
                <div class="request-item col-md-3 p-2 text-center">
                    <img src="<?= htmlspecialchars($avatar) ?>" style="width:64px;" class="request-avatar">
                    <div class="request-username"><?= htmlspecialchars($addressee_info['username']) ?></div>
                    <a href="friends.php?action=cancel&friend_id=<?= $addressee_info['id'] ?>"
                       class="cancel-request-button btn btn-warning btn-sm">取消好友申請</a>
                </div>
            <?php endforeach; ?>
            <?php if (count($outgoingRequests) === 0): ?>
                <div class="text-muted text-center w-100">沒有發送中的申請</div>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php include_once "partials/footer.php"; ?>
