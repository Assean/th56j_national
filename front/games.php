<?php include_once "../api/db.php";
$games=$pdo->query("SELECT * FROM `games`")->fetchAll();?>
<div id="games" class="py-4">
  <h4 class="text-center font-weight-bold mb-4">🎮 遊戲列表</h4>
  <section class="game-list row px-2">
    <?php foreach($games as $g):?>
    <div class="col-12 col-md-6 col-lg-4 mb-4">
      <div class="game-item card h-100 shadow-sm border-0">
        <img src="<?=$g['cover']?>" alt="<?=htmlspecialchars($g['title'])?>" class="game-cover card-img-top" style="object-fit:cover;aspect-ratio:16/9">
        <div class="card-body d-flex flex-column">
          <h5 class="game-title card-title font-weight-bold text-center"><?=htmlspecialchars($g['title'])?></h5>
          <p class="game-description card-text text-muted small flex-grow-1"><?=htmlspecialchars($g['description'])?></p>
          <a href="javascript:loadpage('front/game-play.php?id=<?=$g['id']?>')" class="play-game-link btn btn-success btn-block mt-2">▶ 開始遊戲</a>
        </div>
      </div>
    </div>
    <?php endforeach;?>
  </section>
</div>
