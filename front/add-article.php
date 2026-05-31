<div class="row justify-content-center mt-4">
  <div class="col-md-8">
    <div class="card shadow border-0">
      <div class="card-header bg-white border-bottom">
        <h5 class="mb-0 font-weight-bold">✏️ 發表文章</h5>
      </div>
      <div class="card-body p-4">
        <div class="form-group">
          <label class="font-weight-bold">標題</label>
          <input type="text" id="title" class="form-control" placeholder="請輸入文章標題">
        </div>
        <div class="form-group">
          <label class="font-weight-bold">文章內容</label>
          <textarea id="post" class="form-control" style="height:280px" placeholder="請輸入文章內容..."></textarea>
        </div>
        <div class="text-right">
          <button class="btn btn-secondary mr-2" onclick="history.back()">取消</button>
          <button class="btn btn-primary" type="button" onclick="send()">🚀 發佈</button>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
function send(){
  $.post("./api/add_article.php",{title:$("#title").val(),content:$("#post").val()},function(res){
    if(parseInt(res)){alert("發表成功");loadpage('./front/article.php?id='+res);}
    else{alert("發表失敗");}
  });
}
</script>
