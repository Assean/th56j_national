<?php include_once "db.php";
$users=$pdo->query("SELECT * FROM `users` WHERE `username` LIKE '%{$_GET['search']}%'")->fetchAll();
$users=array_filter($users,fn($u)=>$u['username']!==$_SESSION['num']);
if($users) foreach($users as $u):?>
<div class="search-result-item d-flex justify-content-between my-1 col-md-10">
  <div class="result-username"><?=$u['username']?></div>
  <a href="javascript:loadpage('front/friend-profile-page.php?id=<?=$u['id']?>')" class="view-profile-link">查看個人頁面</a>
</div>
<?php else:?>
<div class="search-result-item d-flex justify-content-between my-1 col-md-10">
  <div class="result-username">查無符合的好友名單</div>
  <a href="#" class="view-profile-link"></a>
</div>
<?php endif;
