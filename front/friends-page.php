<?php
include_once "../api/db.php";
if (!isset($_SESSION['user'])) {
  echo "<script>loadpage('./front/login.php')</script>";
  return;
}
?>
<div class="py-4">
  <div class="card shadow border-0 mb-4">
    <div class="card-body">
      <h5 class="font-weight-bold mb-3">🔍 搜尋使用者</h5>
      <div class="input-group">
        <input type="text" id="search" class="form-control" placeholder="輸入帳號或名稱搜尋...">
        <div class="input-group-append">
          <button class="search-submit-button btn btn-primary" type="button">搜尋</button>
        </div>
      </div>
      <div class="search-result-list mt-3"></div>
    </div>
  </div>

  <div class="card shadow border-0 mb-4">
    <div class="card-header bg-white border-bottom"><h5 class="mb-0 font-weight-bold">👥 好友列表</h5></div>
    <div class="card-body">
      <div class="row">
        <?php
        $friends = $pdo->query("SELECT * FROM `friends` WHERE (`requester_id`='{$_SESSION['user_id']}' OR `addressee_id`='{$_SESSION['user_id']}') AND `status`='accept'")->fetchAll();
        foreach ($friends as $friend):
          $friend_id = ($friend['requester_id'] == $_SESSION['user_id']) ? $friend['addressee_id'] : $friend['requester_id'];
          $friend_info = $pdo->query("SELECT * FROM `users` WHERE `id`='$friend_id'")->fetch();
        ?>
        <div class="col-6 col-md-3 mb-3 text-center" style="cursor:pointer" onclick="loadpage('./front/friend-profile-page.php?id=<?= $friend_id ?>')">
          <img src="./img/<?= htmlspecialchars($friend_info['header']) ?>" class="friend-avatar mb-1" style="width:64px;height:64px">
          <div class="small font-weight-bold"><?= htmlspecialchars($friend_info['username']) ?></div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <div class="card shadow border-0 mb-4">
    <div class="card-header bg-white border-bottom"><h5 class="mb-0 font-weight-bold">📥 收到的好友申請</h5></div>
    <div class="card-body">
      <div class="row">
        <?php
        $addressee = $pdo->query("SELECT * FROM `friends` WHERE `addressee_id`='{$_SESSION['user_id']}' AND `status`='pending'")->fetchAll();
        foreach ($addressee as $addr):
          $requester_info = $pdo->query("SELECT * FROM `users` WHERE `id`='{$addr['requester_id']}'")->fetch();
        ?>
        <div class="col-6 col-md-3 mb-3 text-center">
          <img src="./img/<?= htmlspecialchars($requester_info['header']) ?>" class="request-avatar mb-1" style="width:64px;height:64px">
          <div class="small font-weight-bold mb-1"><?= htmlspecialchars($requester_info['username']) ?></div>
          <button class="btn btn-success btn-sm mr-1" onclick="setFriend('accept',<?= $addr['requester_id'] ?>)">接受</button>
          <button class="btn btn-outline-warning btn-sm" onclick="setFriend('reject',<?= $addr['requester_id'] ?>)">拒絕</button>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <div class="card shadow border-0">
    <div class="card-header bg-white border-bottom"><h5 class="mb-0 font-weight-bold">📤 發送的好友申請</h5></div>
    <div class="card-body">
      <div class="row">
        <?php
        $requesters = $pdo->query("SELECT * FROM `friends` WHERE `requester_id`='{$_SESSION['user_id']}' AND `status`='pending'")->fetchAll();
        foreach ($requesters as $requester):
          $addressee_info = $pdo->query("SELECT * FROM `users` WHERE `id`='{$requester['addressee_id']}'")->fetch();
        ?>
        <div class="col-6 col-md-3 mb-3 text-center">
          <img src="./img/<?= htmlspecialchars($addressee_info['header']) ?>" class="request-avatar mb-1" style="width:64px;height:64px">
          <div class="small font-weight-bold mb-1"><?= htmlspecialchars($addressee_info['username']) ?></div>
          <button class="btn btn-outline-danger btn-sm" onclick="setFriend('cancel',<?= $addressee_info['id'] ?>)">取消申請</button>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>

<script>
$(".search-submit-button").on("click",function(){
  $.get("./api/search_users.php",{search:$("#search").val()},function(friends){
    $(".search-result-list").html(friends);
  });
});
function setFriend(action,friend_id){
  $.get("./api/set_friend.php",{action,friend_id},function(res){
    if(res.success){alert(res.message);loadpage('./front/friends-page.php');}
    else{alert("操作失敗");}
  });
}
</script>
