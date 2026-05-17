<?php include_once "db.php";

$search=$_GET['search'];

 $sql="select * from `users` where `username` like '%$search%'";
 $users=$pdo->query($sql)->fetchAll();
 //echo json_encode($users);

foreach($users as $idx => $user){
    if($user['username']===$_SESSION['user']){
        unset($users[$idx]);
    }
}

if(count($users)>0):
    foreach($users as $user):
       ?>
       <div class="search-result-item d-flex justify-content-between my-1 col-md-10">
           <div class="result-username"><?=$user['username'];?></div>
           <a href="javascript:loadpage('./front/friend-profile-page.php?id=<?=$user['id'];?>')" 
             class="view-profile-link">查看個人頁面</a>
       </div>
       
    <?php 
    endforeach;
else:?>

<div class="search-result-item d-flex justify-content-between my-1 col-md-10">
           <div class="result-username">查無符合的好友名單</div>
           <a href="#" class="view-profile-link"></a>
       </div>
<?php
endif;
?>
    