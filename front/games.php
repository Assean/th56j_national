<?php include_once "../api/db.php"; ?>
<div class="py-4">
  <h4 class="text-center font-weight-bold mb-4">🎮 遊戲列表</h4>
  <div class="row px-2">
    <?php
    $games = $pdo->query("SELECT * FROM `games`")->fetchAll();
    foreach ($games as $game):
    ?>
    <div class="col-12 col-md-6 col-lg-4 mb-4">
      <div class="card h-100 shadow-sm border-0">
        <img src="<?= $game['cover'] ?>" alt="<?= htmlspecialchars($game['title']) ?>" class="card-img-top" style="object-fit:cover;aspect-ratio:16/9">
        <div class="card-body d-flex flex-column">
          <h5 class="card-title font-weight-bold text-center"><?= htmlspecialchars($game['title']) ?></h5>
          <p class="card-text text-muted small flex-grow-1"><?= htmlspecialchars($game['description']) ?></p>
          <a href="javascript:loadpage('./front/game-play.php?id=<?= $game['id'] ?>')" class="btn btn-success btn-block mt-2">▶ 開始遊戲</a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>
