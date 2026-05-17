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
        <div class="profile-username">username</div>
        <div class="profile-bio m-auto col-md-8 form-group">
            <textarea name="" id="" class="profile-bio-input w-100 form-control">
                簡介
            </textarea>
        </div>
    </section>

    <a href="" class="new-post-link">發表文章</a>
    
    <form action="" class="article-create-form col-md-12 m-auto border rounded form-group">
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

<section class="profile-articles my-2">
    <h3 class="text-center">我的文章</h3>
    <div class="article-item my-2 p-2 border rounded d-flex justify-content-between">
        <div class="col-md-10 d-flex justify-content-between">
            <span class="article-title">文章標題</span>
            <a href="" class="article-readmore">閱讀文章</a>
        </div>
        <time datetime="" class="article-date col-md-2 text-right text-sm"><?= date("Y-m-d H:i:s"); ?></time>
    </div>
    <div class="article-item my-2 p-2 border rounded d-flex justify-content-between">
        <div class="col-md-10 d-flex justify-content-between">
            <span class="article-title">文章標題</span>
            <a href="" class="article-readmore">閱讀文章</a>
        </div>
        <time datetime="" class="article-date col-md-2 text-right text-sm"><?= date("Y-m-d H:i:s"); ?></time>
    </div>
    <div class="empty-article-message">目前尚無文章</div>
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