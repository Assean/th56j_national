<?php include_once "../api/db.php";
$friend=$pdo->query("SELECT * FROM `users` WHERE `id`='{$_GET['id']}'")->fetch();
$userHeader=(!empty($friend['header']))?"./img/{$friend['header']}":"./img/default_header.jpg";
?>



<div id="profile-page">
    <section class="profile-header w-100 p-3 border rounded mb-2 text-center">
        <img src="<?=$userHeader;?>" class="profile-avater" style='width:128px'>
        <div class="profile-username"><?=$friend['username'];?></div>
        <div class="profile-bio m-auto col-md-8 form-group border rounded bg-info text-white p-2">
        <span class="show-bio"><?=($friend['bio']!=='')?$friend['bio']:'尚未填寫自我介紹';?></span>
        </div>
    </section>

<div class="profile-content">
    <section class="articles my-2 border rounded p-3">
        <?php 
            $articles=$pdo->query("SELECT * FROM `articles` WHERE `user_id`='{$friend['id']}';")->fetchAll();
            if(count($articles)>0):
            foreach($articles as $article):;?>

        <article class="article-item my-2">
            <div class='d-flex justify-content-between w-100'>
                <div class="article-title bolder"><?=$article['title'];?></div>
                <time datetime="" class="article-date text-sm"><?= date("Y-m-d",strtotime($article['created_at'])); ?></time>
            </div>
            <div class='d-flex w-100 pl-3'>
                <div class="article-excerpt"><?=mb_substr($article['content'],0,30);?>...</div>
                <a href="javascript:loadpage('./front/article.php?id=<?=$article['id'];?>')" class="article-readmore">閱讀更多</a>
            </div>
        </article>
        <?php 
            endforeach;  else:;?>
            <div class="empty-article-message">目前尚無文章</div>
             <?php endif;?>
    </section>    
</div>
<div class="profile-friend-actions">
    <?php 
    /**
     * 使用者ID
     * 1.關係 relation
     * 2.狀態 status
     *   等待中
     *    己接受
     * 3.已是好友
     */
    $my=$_SESSION['user_id'];
    $relation=$pdo->query("select * from `friends` where 
                            (`requester_id`='$my' AND `addressee_id`='{$friend['id']}') OR 
                            (`requester_id`='{$friend['id']}' AND `addressee_id`='$my')")->fetch();

    $is_relation=(empty($relation))?false:true;
    $is_requester=($is_relation && $relation['requester_id']=="$my" && $relation['status']=='pendding')?true:false;                    
    $is_addressee=($is_relation && $relation['addressee_id']=="$my" && $relation['status']=='pendding')?true:false;
    $is_friend=($is_relation && $relation['status']=='accept')?true:false;

    ?>
    <?php if(!$is_relation):;?>
    <button class="btn btn-primary" onclick="setFriend('apply',<?=$friend['id'];?>)">申請好友</button>
    <?php elseif($is_requester):;?>
    <button class="btn btn-primary" onclick="setFriend('cancel',<?=$friend['id'];?>)">取消申請好友</button>
    <?php elseif($is_addressee):;?>
    <button class="btn btn-success" onclick="setFriend('accept',<?=$friend['id'];?>)">接受好友</button>
    <button class="btn btn-warning" onclick="setFriend('reject',<?=$friend['id'];?>)">拒絕好友</button>
    <?php elseif($is_friend):;?>
    <button class="btn btn-danger" onclick="setFriend('remove',<?=$friend['id'];?>)">取消好友</button>
    <?php endif;?>
</div>
</div>


<script>
function setFriend(action,friend_id){
 $.get("./api/set_friend.php",{action,friend_id},function(res){
    //console.log(res)
    if(res.success){
        alert(res.message)
        loadpage(`./front/friend-profile-page.php?id=${friend_id}`);
    }else{
        alert("操作失敗")
    }
 })
}
</script>