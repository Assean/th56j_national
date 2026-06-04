<?php
include_once "../api/db.php";
$game=$pdo->query("SELECT * FROM `games` WHERE id='{$_GET['id']}'")->fetch();
$cfg=json_decode(file_get_contents("../games/{$game['id']}/game.json"));
?>
<div id="game-play" class="py-4">
  <h4 class="current-game-title text-center font-weight-bold mb-4">🕹️ <?=htmlspecialchars($game['title'])?></h4>
  <section class="game-area card shadow border-0 rounded-lg overflow-hidden mx-auto mb-4" style="max-width:800px">
    <div class="card-body p-0 bg-dark">
      <iframe src="<?=$cfg->entry->url?>" frameborder="0" scrolling="no" class="game-frame d-block w-100" style="height:600px;overflow:hidden"></iframe>
    </div>
  </section>

  <aside class="game-leaderboard card shadow border-0 rounded-lg mx-auto" style="max-width:800px">
    <div class="card-header bg-primary text-white text-center py-3">
      <h5 class="leaderboard-title m-0 font-weight-bold">🏆 <?=htmlspecialchars($game['title'])?> 排行榜</h5>
    </div>
    <div class="card-body p-0">
      <div class="row text-center bg-light text-muted font-weight-bold py-2 border-bottom mx-0">
        <div class="col-3">排名</div><div class="col-6">玩家</div><div class="col-3">分數</div>
      </div>
      <div id="leaderboard"></div>
    </div>
  </aside>
</div>

<script>
$.get("<?=$cfg->score->pullUrl?>",function(ranks){
  if(ranks.length>0){
    ranks.forEach(function(item,i){
      var b=i===0?'warning':i===1?'light text-dark border':i===2?'danger':'secondary';
      $("#leaderboard").append('<div class="leaderboard-item row text-center align-items-center py-3 border-bottom mx-0">'
        +'<div class="col-3"><span class="player-rank badge badge-pill badge-'+b+' px-3 py-2">'+(i+1)+'</span></div>'
        +'<div class="col-6 font-weight-bold">'+item['玩家名稱']+'</div>'
        +'<div class="col-3 text-primary font-weight-bold">'+item['分數']+'</div>'
        +'</div>');
    });
  }else{
    $("#leaderboard").html('<div class="text-center py-5 text-muted"><p class="mb-1 h5">目前尚無分數紀錄</p><small>快來成為第一名！</small></div>');
  }
});
</script>
