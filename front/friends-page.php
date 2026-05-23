<?php
include_once "../api/db.php";

if(!isset($_SESSION['user'])){
    echo "<script>";
    echo "loadpage('./front/login.php')";
    echo "</script>";
}

?>


<div id="friends-page">
    <div class="friend-search-section border rounded p-3 ">
        <form action="" class="friend-search-form form-group d-flex align-items-center">
            <label for="" class='mx-2'>搜尋使用者</label>
            <input type="text" name='search' id='search' class="search-input form-control col-md-7">
            <button type='button' class="search-submit-button btn btn-primary mx-2">尋找</button>
        </form>
        <div class="search-result-list my-2">
             <div class="text-center">搜尋好友結果區</div>
        </div>
    </div>

    <script>
        $(".search-submit-button").on("click",function(){
            let search=$("#search").val();
            //console.log(search)
            $.get("./api/search_users.php",{search},function(friends){
                //console.log(friends)
                $(".search-result-list").html(friends)
            })
        })
    </script>

    <div class="friend-list-section w-100 border rounded p-3 my-2">
        <h3 class="section-title text-center">好友列表</h3>
        <div class="d-flex flex-wrap p-3">
            <?php
            $friends=$pdo->query("select * from `friends` 
                                   where (`requester_id`='{$_SESSION['user_id']}' OR 
                                          `addressee_id`='{$_SESSION['user_id']}') AND 
                                          `status`='accept'")->fetchAll();
            foreach($friends as $friend):
                $friend_id=($friend['requester_id']==$_SESSION['user_id'])?$friend['addressee_id']:$friend['requester_id'];
                $friend_info=$pdo->query("select * from `users` where `id`='$friend_id'")->fetch();
            
            ;?>
            <div class="friend-item col-md-3 p-2 text-center" onclick="loadpage('./front/friend-profile-page.php?id=<?=$friend_id;?>')">
                <img src="./img/<?=$friend_info['header'];?>" style="width:64px;" class="friend-avatar">
                <div class="friend-name mx-3"><?=$friend_info['username'];?></div>
            </div>
            <?php endforeach ;?>
        </div>
    </div>
    <div class="incoming-requests-section border rounded p-3 my-2 ">
        <h3 class="section-title text-center">收到的好友申請</h3>
        <div class="d-flex flex-wrap p-3">
            <?php
            $addressee=$pdo->query("select * from `friends` 
                                   where  `addressee_id`='{$_SESSION['user_id']}' AND 
                                          `status`='pending'")->fetchAll();
            foreach($addressee as $addr):
                $requester_id=$addr['requester_id'];
                $requester_info=$pdo->query("select * from `users` where `id`='$requester_id'")->fetch();
                
                ;?>
            <div class="request-item col-md-3 p-2 text-center">
                <img src="./img/<?=$requester_info['header'];?>" style="width:64px;" class="request-avatar">
                <div class="request-username"><?=$requester_info['username'];?></div>
                <div>
                    <button class="accept-request-button btn btn-success btn-sm" onclick="setFriend('accept',<?=$requester_id;?>)">接受好友</button>
                    <button class="reject-request-button btn btn-warning btn-sm" onclick="setFriend('reject',<?=$requester_id;?>)">拒絕好友</button>
                </div>
            </div>
            <?php endforeach;?>
        </div>
    </div>
    <div class="sent-requests-section border rounded p-3 my-2">
        <h3 class="section-title text-center">發送的好友申請</h3>
        <div class="d-flex flex-wrap p-3">
        <?php
            $requesters=$pdo->query("select * from `friends` 
                                   where  `requester_id`='{$_SESSION['user_id']}' AND 
                                          `status`='pending'")->fetchAll();
            foreach($requesters as $requester):
                $addressee_id=$requester['addressee_id'];
                $addressee_info=$pdo->query("select * from `users` where `id`='$addressee_id'")->fetch();
                ;?>
            <div class="request-item col-md-3 p-2 text-center">
                <img src="./img/<?=$addressee_info['header'];?>" style="width:64px" class="request-avatar">
                <div class="request-username"><?=$addressee_info['username'];?></div>
                <button class="cancel-request-button btn btn-warning btn-sm" onclick="setFriend('cancel',<?=$addressee_info['id'];?>)">取消好友申請</button>
            </div>
            <?php endforeach;?>
        </div>
    </div>
    
</div>

<script>
function setFriend(action,friend_id){
 $.get("./api/set_friend.php",{action,friend_id},function(res){
    //console.log(res)
    if(res.success){
        alert(res.message)
        loadpage(`./front/friends-page.php`);
    }else{
        alert("操作失敗")
    }
 })
}
</script>