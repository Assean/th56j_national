<?php 
    include "../api/db.php";
    // 修正：$_SESWSION -> $_SESSION
    $user=$pdo->query("SELECT * FROM `users` WHERE `username`='{$_SESSION['user']}'")->fetch();
    $userHeader=(!empty($user['header']))?"./img/{$user['header']}":"./img/default_header.jpg";
?>
<div id="profile-page">
    <section class="profile-header w-100 p-3 border rounded mb-2 text-center">
        <label for="header">
            <!-- 修正：使用變量 $userHeader 而不是寫死的路徑 -->
            <img src="<?= $userHeader ?>" class="profile-avater" style="width:128px;">
            <!-- <input type="file" name="header" id="header" hidden> -->
            <input type="file" name="header" id="header" style="display:none">
        </label>
        <div class="profile-username"><?=$_SESSION['user']?></div>
        <div class="profile-bio m-auto col-md-8 form-group border rounded bg-info text-white p-2">
            <span class="show-bio"><?=($user['bio']!=='')?$user['bio']:'尚未填寫自我介紹';?></span>
            <input type='text' name="bio" id="bio" class="profile-bio-input w-100 form-control" value="" style="display:none">
        </div>
    </section>
<script>

    $(".show-bio").on("click",function(){
        let bioText=($(".show-bio").text()!=="尚未填寫自我介紹")?$(".show-bio").text():'';
        $(".profile-bio-input").val(bioText);
        $(".show-bio,.profile-bio-input").toggle();
    });

    $(".profile-bio-input").on("keydown",function(e){
        if(e.key==='Enter'){
            let text=$(".profile-bio-input").val();
            if(text==$(".show-bio").text()){
                alert("簡介文字沒有修改")
            }else{
                $.post("./api/update_bio.php",{text},function(res){
                    if(parseInt(res)){
                        $(".show-bio").text(text).show();
                        $(".profile-bio-input").hide();
                    }else{
                        alert('簡介更新失敗');
                    }
                })
            }
        }
    })
</script>

    <a href="javascript:loadpage('./front/add-article.php')" class="new-post-link">發表文章</a>
    
    <form action="" class="article-create-form col-md-12 m-auto border rounded form-group d-none">
        <div class='p-2'>
            <label for="">標題：</label>
            <input type="text" class="article-title-input form-control">
        </div>
        <div class='p-2'>
            <label for="">文章內容：</label>
            <textarea name="" id="" class="article-content-input form-control"></textarea>
        </div>
        <div class="text-center p-2">
            <button class="article-submit-button btn btn-primary">發佈</button>
        </div>
    </form>

    <hr>

    <section class="profile-articles my-2">
        <h3 class="text-center">我的文章</h3>
        <?php 
            $articles=$pdo->query("SELECT * FROM `articles` WHERE `user_id`='{$user['id']}';")->fetchAll();
            if(count($articles)>0):;?>

        <!--文章項目-->
        <?php foreach($articles as $article):;?>
        <div class="article-item my-2 p-2 border rounded d-flex justify-content-between">
            <div class="col-md-10 d-flex justify-content-between">
                <span class="article-title"><?=$article['title'];?></span>
                <a href="javascript:loadpage('./front/article.php?id=<?=$article['id'];?>')" class="article-readmore">閱讀文章</a>
            </div>
            <time datetime="" class="article-date col-md-2 text-right text-sm"><?= date("Y-m-d",strtotime($article['created_at'])); ?></time>
        </div>
        <?php endforeach;?>
        <?php else:;?>
        <!--暫代文字-->
        <div class="empty-article-message text-2xl col-md-8 p-3 bolder text-center m-auto">目前尚無文章</div>
        <?php endif;?>
    </section>
    </div>

    <script>
        $("#header").on("change",function(){
            let file = this.files[0]
            if(!file){return}
            let reader=new FileReader();
            reader.onload=function(e){
                let imgString=e.target.result;
                console.log(imgString)
                $.post("./api/update_avatar.php",{imgString},function(res){
                    if(parseInt(res)){
                        $(".profile-avater").attr("src",imgString);
                    }else{
                        alert("頭像上傳失敗")
                    }
                })
            }
            reader.readAsDataURL(file)
            console.log(this.files[0])
        })
    </script>