<?php
include "../api/db.php";
$user = $pdo->query("SELECT * FROM `users` WHERE `username`='{$_SESSION['user']}'")->fetch();
$userHeader = (!empty($user['header'])) ? "./img/{$user['header']}" : "./img/default_header.jpg";
?>
<div class="row justify-content-center mt-4">
  <div class="col-md-8">
    <div class="card shadow border-0 mb-4">
      <div class="card-body text-center p-4">
        <label for="header" class="cursor-pointer" title="點擊更換頭像" style="cursor:pointer">
          <img src="<?= $userHeader ?>" class="profile-avatar mb-2" style="width:100px;height:100px">
          <div class="small text-muted">點擊更換頭像</div>
          <input type="file" id="header" style="display:none">
        </label>
        <h5 class="font-weight-bold mt-2"><?= htmlspecialchars($_SESSION['user']) ?></h5>
        <div class="d-inline-block bg-info text-white rounded px-3 py-2 mt-1" style="cursor:pointer">
          <span class="show-bio"><?= ($user['bio'] !== '') ? htmlspecialchars($user['bio']) : '尚未填寫自我介紹' ?></span>
          <input type="text" id="bio" class="form-control d-none" value="">
        </div>
        <div class="small text-muted mt-1">點擊簡介可編輯，按 Enter 儲存</div>
      </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="font-weight-bold mb-0">📝 我的文章</h5>
      <a href="javascript:loadpage('./front/add-article.php')" class="btn btn-primary btn-sm">✏️ 發表文章</a>
    </div>

    <?php
    $articles = $pdo->query("SELECT * FROM `articles` WHERE `user_id`='{$user['id']}'")->fetchAll();
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
    <div class="text-center text-muted py-4">目前尚無文章，快來發表第一篇吧！</div>
    <?php endif; ?>
  </div>
</div>

<script>
$(".show-bio").on("click",function(){
  var t=$(".show-bio").text()!=="尚未填寫自我介紹"?$(".show-bio").text():'';
  $("#bio").val(t);
  $(".show-bio,#bio").toggleClass("d-none");
});
$("#bio").on("keydown",function(e){
  if(e.key==='Enter'){
    var text=$(this).val();
    if(text===$(".show-bio").text()){alert("簡介文字沒有修改");}
    else{
      $.post("./api/update_bio.php",{text},function(res){
        if(parseInt(res)){$(".show-bio").text(text).removeClass("d-none");$("#bio").addClass("d-none");}
        else{alert("簡介更新失敗");}
      });
    }
  }
});
$("#header").on("change",function(){
  var file=this.files[0];
  if(!file)return;
  var reader=new FileReader();
  reader.onload=function(e){
    $.post("./api/update_avatar.php",{imgString:e.target.result},function(res){
      if(parseInt(res)){$(".profile-avatar").attr("src",e.target.result);}
      else{alert("頭像上傳失敗");}
    });
  };
  reader.readAsDataURL(file);
});
</script>
