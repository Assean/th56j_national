<?php
include_once "../api/db.php";
$friend = $pdo->query("SELECT * FROM `users` WHERE `id`='{$_GET['id']}'")->fetch();
$userHeader = (!empty($friend['header'])) ? "./img/{$friend['header']}" : "./img/default_header.jpg";
?>
<div class="row justify-content-center mt-4">
  <div class="col-md-8">
    <div class="card shadow border-0 mb-4">
      <div class="card-body text-center p-4">
        <img src="<?= $userHeader ?>" class="profile-avatar mb-2" style="width:100px;height:100px">
        <h5 class="font-weight-bold mt-2"><?= htmlspecialchars($friend['username']) ?></h5>
        <div class="badge badge-info p-2 mt-1"><?= ($friend['bio'] !== '') ? htmlspecialchars($friend['bio']) : '尚未填寫自我介紹' ?></div>
        <div class="mt-3">
          <?php
          $my = $_SESSION['user_id'];
          $relation = $pdo->query("SELECT * FROM `friends` WHERE (`requester_id`='$my' AND `addressee_id`='{$friend['id']}') OR (`requester_id`='{$friend['id']}' AND `addressee_id`='$my')")->fetch();
          $is_relation = !empty($relation);
          $is_requester = ($is_relation && $relation['requester_id'] == "$my" && $relation['status'] == 'pendding');
          $is_addressee = ($is_relation && $relation['addressee_id'] == "$my" && $relation['status'] == 'pendding');
          $is_friend = ($is_relation && $relation['status'] == 'accept');
          ?>
          <?php if (!$is_relation): ?>
            <button class="btn btn-primary" onclick="setFriend('apply',<?= $friend['id'] ?>)">＋ 申請好友</button>
          <?php elseif ($is_requester): ?>
            <button class="btn btn-outline-secondary" onclick="setFriend('cancel',<?= $friend['id'] ?>)">取消申請</button>
          <?php elseif ($is_addressee): ?>
            <button class="btn btn-success mr-2" onclick="setFriend('accept',<?= $friend['id'] ?>)">接受好友</button>
            <button class="btn btn-outline-warning" onclick="setFriend('reject',<?= $friend['id'] ?>)">拒絕</button>
          <?php elseif ($is_friend): ?>
            <span class="badge badge-success p-2 mr-2">✓ 已是好友</span>
            <button class="btn btn-outline-danger btn-sm" onclick="setFriend('remove',<?= $friend['id'] ?>)">取消好友</button>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <h5 class="font-weight-bold mb-3">📝 TA 的文章</h5>
    <?php
    $articles = $pdo->query("SELECT * FROM `articles` WHERE `user_id`='{$friend['id']}'")->fetchAll();
    if (count($articles) > 0):
      foreach ($articles as $article):
    ?>
    <div class="card mb-2 border-0 shadow-sm article-item">
      <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">
        <div>
          <span class="font-weight-bold"><?= htmlspecialchars($article['title']) ?></span>
          <small class="text-muted ml-2"><?= date("Y-m-d", strtotime($article['created_at'])) ?></small>
        </div>
        <a href="javascript:loadpage('./front/article.php?id=<?= $article['id'] ?>')" class="btn btn-outline-secondary btn-sm">閱讀</a>
      </div>
    </div>
    <?php endforeach; else: ?>
    <div class="text-center text-muted py-4">目前尚無文章</div>
    <?php endif; ?>
  </div>
</div>

<script>
function setFriend(action,friend_id){
  $.get("./api/set_friend.php",{action,friend_id},function(res){
    if(res.success){alert(res.message);loadpage('./front/friend-profile-page.php?id='+friend_id);}
    else{alert("操作失敗");}
  });
}
</script>
