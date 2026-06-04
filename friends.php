<?php
include_once "api/db.php";
$base = "./";
if (!isset($_SESSION['user'])) { header("Location: login.php"); exit; }
$my = (int)$_SESSION['user_id'];

if (isset($_GET['action'], $_GET['friend_id'])) {
    $fid      = (int)$_GET['friend_id'];
    $relation = $pdo->query("SELECT * FROM `friends` WHERE (requester_id='$my' AND addressee_id='$fid') OR (requester_id='$fid' AND addressee_id='$my')")->fetch();
    switch ($_GET['action']) {
        case 'apply':
            $pdo->exec("INSERT INTO `friends` (`requester_id`,`addressee_id`,`status`) VALUES('$my','$fid','pending')");
            $msg = "好友申請已送出"; break;
        case 'accept':
            if ($relation) $pdo->exec("UPDATE `friends` SET `status`='accept' WHERE `id`='{$relation['id']}'");
            $msg = "好友申請已接受"; break;
        default:
            if ($relation) $pdo->exec("DELETE FROM `friends` WHERE `id`='{$relation['id']}'");
            $msg = "操作成功"; break;
    }
    header("Location: friends.php?msg=" . urlencode($msg)); exit;
}

$msg        = $_GET['msg'] ?? '';
$searchTerm = '';
$searchResults = [];
if (!empty($_GET['search'])) {
    $searchTerm = $_GET['search'];
    foreach ($pdo->query("SELECT * FROM `users` WHERE `username` LIKE '%$searchTerm%'")->fetchAll() as $u) {
        if ($u['username'] !== $_SESSION['user']) $searchResults[] = $u;
    }
}

$friends = $pdo->query("SELECT u.*, IF(f.requester_id='$my',f.addressee_id,f.requester_id) AS fid
    FROM `friends` f JOIN `users` u ON u.id=IF(f.requester_id='$my',f.addressee_id,f.requester_id)
    WHERE (f.requester_id='$my' OR f.addressee_id='$my') AND f.status='accept'")->fetchAll();

$incomingRequests = $pdo->query("SELECT u.*, f.requester_id AS rid FROM `friends` f
    JOIN `users` u ON u.id=f.requester_id
    WHERE f.addressee_id='$my' AND f.status='pending'")->fetchAll();

$outgoingRequests = $pdo->query("SELECT u.*, f.addressee_id AS aid FROM `friends` f
    JOIN `users` u ON u.id=f.addressee_id
    WHERE f.requester_id='$my' AND f.status='pending'")->fetchAll();

include_once "partials/header.php";
?>
<div id="friends-page">
    <?php if ($msg): ?><div class="alert alert-success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>

    <div class="friend-search-section border rounded p-3">
        <form method="GET" action="friends.php" class="friend-search-form form-group d-flex align-items-center">
            <label class="mx-2">搜尋使用者</label>
            <input type="text" name="search" id="search" class="search-input form-control col-md-7" value="<?= htmlspecialchars($searchTerm) ?>">
            <button type="submit" class="search-submit-button btn btn-primary mx-2">尋找</button>
        </form>
        <?php if ($searchTerm): ?>
        <div class="search-result-list my-2">
            <?php if ($searchResults): foreach ($searchResults as $u): ?>
            <div class="search-result-item d-flex justify-content-between my-1 col-md-10">
                <div class="result-username"><?= htmlspecialchars($u['username']) ?></div>
                <a href="friend-profile.php?id=<?= $u['id'] ?>" class="view-profile-link">查看個人頁面</a>
            </div>
            <?php endforeach; else: ?><div class="text-muted">查無符合的使用者</div><?php endif; ?>
        </div>
        <?php endif; ?>
    </div>

    <div class="friend-list-section w-100 border rounded p-3 my-2">
        <h3 class="section-title text-center">好友列表</h3>
        <div class="d-flex flex-wrap p-3">
            <?php if ($friends): foreach ($friends as $f):
                $avatar = !empty($f['header']) ? "./img/{$f['header']}" : "./img/default_header.jpg"; ?>
            <div class="friend-item col-md-3 p-2 text-center">
                <a href="friend-profile.php?id=<?= $f['fid'] ?>">
                    <img src="<?= htmlspecialchars($avatar) ?>" style="width:64px;" class="friend-avatar">
                    <div class="friend-name mx-3"><?= htmlspecialchars($f['username']) ?></div>
                </a>
            </div>
            <?php endforeach; else: ?><div class="text-muted text-center w-100">尚無好友</div><?php endif; ?>
        </div>
    </div>

    <div class="incoming-requests-section border rounded p-3 my-2">
        <h3 class="section-title text-center">收到的好友申請</h3>
        <div class="d-flex flex-wrap p-3">
            <?php if ($incomingRequests): foreach ($incomingRequests as $req):
                $avatar = !empty($req['header']) ? "./img/{$req['header']}" : "./img/default_header.jpg"; ?>
            <div class="request-item col-md-3 p-2 text-center">
                <img src="<?= htmlspecialchars($avatar) ?>" style="width:64px;" class="request-avatar">
                <div class="request-username"><?= htmlspecialchars($req['username']) ?></div>
                <div>
                    <a href="friends.php?action=accept&friend_id=<?= $req['rid'] ?>" class="accept-request-button btn btn-success btn-sm">接受好友</a>
                    <a href="friends.php?action=reject&friend_id=<?= $req['rid'] ?>" class="reject-request-button btn btn-warning btn-sm">拒絕好友</a>
                </div>
            </div>
            <?php endforeach; else: ?><div class="text-muted text-center w-100">沒有待處理的好友申請</div><?php endif; ?>
        </div>
    </div>

    <div class="sent-requests-section border rounded p-3 my-2">
        <h3 class="section-title text-center">發送的好友申請</h3>
        <div class="d-flex flex-wrap p-3">
            <?php if ($outgoingRequests): foreach ($outgoingRequests as $req):
                $avatar = !empty($req['header']) ? "./img/{$req['header']}" : "./img/default_header.jpg"; ?>
            <div class="request-item col-md-3 p-2 text-center">
                <img src="<?= htmlspecialchars($avatar) ?>" style="width:64px;" class="request-avatar">
                <div class="request-username"><?= htmlspecialchars($req['username']) ?></div>
                <a href="friends.php?action=cancel&friend_id=<?= $req['aid'] ?>" class="cancel-request-button btn btn-warning btn-sm">取消好友申請</a>
            </div>
            <?php endforeach; else: ?><div class="text-muted text-center w-100">沒有發送中的申請</div><?php endif; ?>
        </div>
    </div>
</div>
<?php include_once "partials/footer.php"; ?>
