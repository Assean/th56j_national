<div class="modal" tabindex="-1" id="article">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">文章標題:很好玩</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <article class="article-item w-100 border rounded p-3 my-2">
            <div class='d-flex justify-content-between'>
                <div class="article-title text-md bolder">很好玩</div>
                <time datetime="" class="article-date text-sm"><?=date("Y-m-d H:i:s");?></time>
            </div>
            <div class="article-excerpt">有好好的遊戲......</div>
            <div class='text-right'>
                <!-- <a href="./front/modal/home.php" class="article-readmore btn btn-outline-primary btn-sm">More</a> -->
            </div>
        </article>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">ej0 1u4</button> -->
      </div>
    </div>
  </div>
</div>
    <script>
    $(function(){
        
        $("#article").on("hide.bs.modal show.bs.modal", function(a){
            if(a.type === "hide"){
                document.activeElement.blur();
            }
        });
    })
    </script>