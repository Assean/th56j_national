<?php
include_once "../api/db.php";
if(!isset($_SESSION['user'])){echo "<script>loadpage('front/login.php')</script>";return;}
$my=$_SESSION['user_id'];
?>
<div id="friends-page" class="py-4">
  <div class="friend-search-section card shadow border-0 mb-4">
    <div class="card-body">
      <h5 class="font-weight-bold mb-3">🔍 搜尋使用者</h5>
      <form class="friend-search-form">
        <div class="input-group">
          <input type="text" class="search-input form-control" placeholder="輸入帳號或名稱搜尋...">
          <div class="input-group-append"><button class="search-submit-button btn btn-primary" type="button">搜尋</button></div>
        </div>
      </form>
      <div class="search-result-list mt-3"></div>
    </div>
  </div>

  <div class="friend-list-section card shadow border-0 mb-4">
    <div class="card-header bg-white border-bottom"><h5 class="section-title mb-0 font-weight-bold">👥 好友列表</h5></div>
    <div class="card-body"><div class="row">
      <?php
      $friends=$pdo->query("SELECT * FROM `friends` WHERE (requester_id='$my' OR addressee_id='$my') AND status='accept'")->fetchAll();
      foreach($friends as $f):
        $fid=($f['requester_id']==$my)?$f['addressee_id']:$f['requester_id'];
        $fi=$pdo->query("SELECT * FROM `users` WHERE id='$fid'")->fetch();?>
      <div class="col-6 col-md-3 mb-3 text-center friend-item" style="cursor:pointer" onclick="loadpage('front/friend-profile-page.php?id=<?=$fid?>')">
        <img src="img/<?=htmlspecialchars($fi['header'])?>" class="friend-avatar mb-1" style="width:64px;height:64px">
        <div class="friend-name small font-weight-bold"><?=htmlspecialchars($fi['username'])?></div>
      </div>
      <?php endforeach;?>
    </div></div>
  </div>

  <div class="incoming-requests-section card shadow border-0 mb-4">
    <div class="card-header bg-white border-bottom"><h5 class="section-title mb-0 font-weight-bold">📥 收到的好友申請</h5></div>
    <div class="card-body"><div class="row">
      <?php
      $incoming=$pdo->query("SELECT * FROM `friends` WHERE addressee_id='$my' AND status='pending'")->fetchAll();
      foreach($incoming as $req):
        $ri=$pdo->query("SELECT * FROM `users` WHERE id='{$req['requester_id']}'")->fetch();?>
      <div class="col-6 col-md-3 mb-3 text-center request-item">
        <img src="img/<?=htmlspecialchars($ri['header'])?>" class="request-avatar mb-1" style="width:64px;height:64px">
        <div class="request-username small font-weight-bold mb-1"><?=htmlspecialchars($ri['username'])?></div>
        <button class="accept-request-button btn btn-success btn-sm mr-1" onclick="setFriend('accept',<?=$req['requester_id']?>)">接受</button>
        <button class="reject-request-button btn btn-outline-warning btn-sm" onclick="setFriend('reject',<?=$req['requester_id']?>)">拒絕</button>
      </div>
      <?php endforeach;?>
    </div></div>
  </div>

  <div class="sent-requests-section card shadow border-0">
    <div class="card-header bg-white border-bottom"><h5 class="section-title mb-0 font-weight-bold">📤 發送的好友申請</h5></div>
    <div class="card-body"><div class="row">
      <?php
      $sent=$pdo->query("SELECT * FROM `friends` WHERE requester_id='$my' AND status='pending'")->fetchAll();
      foreach($sent as $s):
        $ai=$pdo->query("SELECT * FROM `users` WHERE id='{$s['addressee_id']}'")->fetch();?>
      <div class="col-6 col-md-3 mb-3 text-center request-item">
        <img src="img/<?=htmlspecialchars($ai['header'])?>" class="request-avatar mb-1" style="width:64px;height:64px">
        <div class="request-username small font-weight-bold mb-1"><?=htmlspecialchars($ai['username'])?></div>
        <button class="cancel-request-button btn btn-outline-danger btn-sm" onclick="setFriend('cancel',<?=$ai['id']?>)">取消申請</button>
      </div>
      <?php endforeach;?>
    </div></div>
  </div>
</div>

<script>
$(".search-submit-button").on("click",function(){
  $.get("api/search_users.php",{search:$(".search-input").val()},function(r){$(".search-result-list").html(r);});
});
function setFriend(action,fid){
  $.get("api/set_friend.php",{action,friend_id:fid},function(r){
    if(r.success){alert(r.message);loadpage('front/friends-page.php');}
    else alert("操作失敗");
  });
}
</script>
