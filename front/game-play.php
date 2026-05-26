<?php
include_once "../api/db.php";
$game = $pdo->query("SELECT * FROM `games` WHERE `id`='{$_GET['id']}'")->fetch();
$game_setting = json_decode(file_get_contents("../games/{$game['id']}/game.json"));
?>

<div id="game-play" class="container mt-4">
    <h2 class="current-game-title text-center fw-bold mb-4"><?= $game['title']; ?></h2>
    
    <div class="row g-4">
        
        <section class="game-area col-12 col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0"> 
                    <iframe 
                        src="<?= $game_setting->entry->url; ?>" 
                        frameborder="0" 
                        class="game-frame w-100 rounded" 
                        style="height: 500px; min-height: 50vh;">
                    </iframe>
                </div>
            </div>
        </section>

        <aside class="game-leaderboard col-12 col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-dark text-white text-center fw-bold py-3">
                    <i class="bi bi-trophy"></i> <?= $game['title']; ?> 風雲排行榜
                </div>
                
                <ul class="list-group list-group-flush">
                    
                    <li class="list-group-item d-flex justify-content-between bg-light fw-bold text-muted small">
                        <span>名次</span>
                        <span>玩家名稱</span>
                        <span>分數</span>
                    </li>
                    
                    <li class="leaderboard-item list-group-item d-flex justify-content-between align-items-center">
                        <span class="player-rank badge bg-warning text-dark rounded-pill">1</span>
                        <span class="player-name">待載入...</span>
                        <span class="player-score fw-bold text-danger">0</span>
                    </li>
                    
                    <li class="leaderboard-empty list-group-item text-center text-muted py-5">
                        目前尚無分數紀錄
                    </li>
                </ul>
            </div>
        </aside>
        
    </div>
</div>