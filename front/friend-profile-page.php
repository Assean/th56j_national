<?php
include_once "../api/db.php";
$friend=$pdo->query("SELECT * FROM `users` WHERE id='{$_GET['id']}'")->fetch();
$avatar=!empty($friend['header'])?"img/{$friend['header']}":"img/default_header.jpg";
$my=$_SESSION['user_id'];$fid=$friend['id'];
$rel=$pdo->query("SELECT * FROM `friends` WHERE (requester_id='$my' AND addressee_id='$fid') OR (requester_id='$fid' AND addressee_id='$my')")->fetch();
$is_req=($rel&&$rel['requester_id']==$my&&$rel['status']=='pending');
$is_addr=($rel&&$rel['addressee_id']==$my&&$rel['status']=='pending');
$is_friend=($rel&&$rel['status']=='accept');
?>
<div id="profile-page" class="row justify-content-center mt-4">
  <div class="col-md-8">
    <section class="profile-header card shadow border-0 mb-4">
      <div class="card-body text-center p-4">
        <img src="<?=$avatar?>" class="profile-avatar mb-2" style="width:100px;height:100px">
        <h5 class="profile-username font-weight-bold mt-2"><?=htmlspecialchars($friend['username'])?></h5>
        <div class="profile-bio badge badge-info p-2 mt-1"><?=($friend['bio']!=='')?htmlspecialchars($friend['bio']):'尚未填寫自我介紹'?></div>
        <div class="profile-friend-actions mt-3">
          <?php if(!$rel):?>
            <button class="btn btn-primary" onclick="setFriend('apply',<?=$fid?>)">＋ 申請好友</button>
          <?php elseif($is_req):?>
            <button class="cancel-request-button btn btn-outline-secondary" onclick="setFriend('cancel',<?=$fid?>)">取消申請</button>
          <?php elseif($is_addr):?>
            <button class="accept-request-button btn btn-success mr-2" onclick="setFriend('accept',<?=$fid?>)">接受好友</button>
            <button class="reject-request-button btn btn-outline-warning" onclick="setFriend('reject',<?=$fid?>)">拒絕</button>
          <?php elseif($is_friend):?>
            <span class="badge badge-success p-2 mr-2">✓ 已是好友</span>
            <button class="btn btn-outline-danger btn-sm" onclick="setFriend('remove',<?=$fid?>)">取消好友</button>
          <?php endif;?>
        </div>
      </div>
    </section>

    <h5 class="font-weight-bold mb-3">📝 TA 的文章</h5>
    <section class="profile-content"><section class="articles">
      <?php
      $arts=$pdo->query("SELECT * FROM `articles` WHERE user_id='$fid'")->fetchAll();
      if($arts) foreach($arts as $a):?>
      <div class="card mb-2 border-0 shadow-sm article-item">
        <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">
          <div>
            <span class="article-title font-weight-bold"><?=htmlspecialchars($a['title'])?></span>
            <small class="text-muted ml-2"><time class="article-date"><?=date("Y-m-d",strtotime($a['created_at']))?></time></small>
          </div>
          <a href="javascript:loadpage('front/article.php?id=<?=$a['id']?>')" class="article-readmore btn btn-outline-secondary btn-sm">閱讀</a>
        </div>
      </div>
      <?php endforeach; else:?>
      <div class="text-center text-muted py-4">目前尚無文章</div>
      <?php endif;?>
    </section></section>
  </div>
</div>

<script>
function setFriend(action,fid){
  $.get("api/set_friend.php",{action,friend_id:fid},function(r){
    if(r.success){alert(r.message);loadpage('front/friend-profile-page.php?id='+fid);}
    else alert("操作失敗");
  });
}
</script>
