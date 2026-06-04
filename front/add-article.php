<div class="row justify-content-center mt-4">
  <div class="col-md-8">
    <div class="card shadow border-0">
      <div class="card-header bg-white border-bottom"><h5 class="mb-0 font-weight-bold">✏️ 發表文章</h5></div>
      <div class="card-body p-4">
        <form class="article-create-form">
          <div class="form-group"><label class="font-weight-bold">標題</label><input type="text" class="article-title-input form-control" placeholder="請輸入文章標題"></div>
          <div class="form-group"><label class="font-weight-bold">文章內容</label><textarea class="article-content-input form-control" style="height:280px" placeholder="請輸入文章內容..."></textarea></div>
          <div class="text-right">
            <button class="btn btn-secondary mr-2" onclick="history.back()">取消</button>
            <button type="button" class="article-submit-button btn btn-primary">🚀 發佈</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
$(".article-submit-button").on("click",function(){
  $.post("api/add_article.php",{title:$(".article-title-input").val(),content:$(".article-content-input").val()},function(r){
    if(parseInt(r)){alert("發表成功");loadpage('front/article.php?id='+r);}
    else alert("發表失敗");
  });
});
</script>
