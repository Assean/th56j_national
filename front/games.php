<?php include_once "../api/db.php"; ?>
<div id="games" class="container">
    <section class="game-list row p-3">
        <?php 
        $games = $pdo->query("SELECT * FROM `games`")->fetchAll();
        foreach($games as $game): 
        ?>
        <div class="game-item col-12 col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <img src="<?= $game['cover']; ?>" alt="<?= $game['title']; ?>" class="card-img-top" style="object-fit: cover; aspect-ratio: 16/9;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold text-center mb-3"><?= $game['title']; ?></h5>
                    <p class="card-text text-muted mb-4"><?= $game['description']; ?></p>
                    <a href="javascript:loadpage('./front/game-play.php?id=<?= $game['id']; ?>')" class="play-game-link btn btn-lg btn-success mt-auto d-block">
                        開始遊戲
                    </a>
                </div>
                
            </div>
            
        </div>
        <?php endforeach; ?>
    </section>
</div>