<?php
include_once "api/db.php";
$base = "./";
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) { header("Location: games.php"); exit; }
$id   = (int)$_GET['id'];
$game = $pdo->query("SELECT * FROM `games` WHERE `id`='$id'")->fetch();
$cfg  = json_decode(file_get_contents("./games/{$game['id']}/game.json"));
$scoreFile = "./games/{$game['id']}/scores.json";
$ranks  = file_exists($scoreFile) ? (json_decode(file_get_contents($scoreFile), true) ?? []) : [];
$badges = ['badge-warning', 'badge-light text-dark border', 'badge-danger'];
include_once "partials/header.php";
?>
<div id="game-play" class="container py-5">
    <h2 class="current-game-title text-center font-weight-bold mb-4 text-dark"><?= htmlspecialchars($game['title']) ?></h2>
    <section class="game-area mb-5">
        <div class="card shadow-sm border-0 rounded-lg overflow-hidden mx-auto" style="max-width:800px;">
            <div class="card-body p-0 bg-dark">
                <iframe src="<?= htmlspecialchars($cfg->entry->url) ?>" frameborder="0" scrolling="no" class="game-frame d-block w-100" style="height:600px;overflow:hidden;"></iframe>
            </div>
        </div>
    </section>
    <aside class="game-leaderboard">
        <div class="card shadow border-0 rounded-lg mx-auto" style="max-width:800px;">
            <div class="card-header bg-primary text-white text-center py-3">
                <h3 class="leaderboard-title h4 m-0 font-weight-bold">🏆 <?= htmlspecialchars($game['title']) ?> 風雲排行榜</h3>
            </div>
            <div class="card-body p-0">
                <div class="d-flex text-center bg-light text-muted font-weight-bold py-2 border-bottom">
                    <div class="col-3">排名</div><div class="col-6">玩家名稱</div><div class="col-3">分數</div>
                </div>
                <div id="leaderboard" class="list-group list-group-flush">
                    <?php if ($ranks):
                        $c0 = $cfg->score->columns[0];
                        $c1 = $cfg->score->columns[1];
                        foreach ($ranks as $i => $item):
                            $badge = $badges[$i] ?? 'badge-secondary';
                    ?>
                    <div class="leaderboard-item list-group-item list-group-item-action d-flex text-center align-items-center py-3">
                        <div class="player-rank col-3"><span class="badge badge-pill <?= $badge ?> px-3 py-2" style="font-size:1rem;"><?= $i+1 ?></span></div>
                        <div class="player-name col-6 font-weight-bold text-dark"><?= htmlspecialchars($item[$c0] ?? '') ?></div>
                        <div class="player-score col-3 text-primary font-weight-bold" style="font-size:1.1rem;"><?= htmlspecialchars($item[$c1] ?? '') ?></div>
                    </div>
                    <?php endforeach; else: ?>
                    <div class="leaderboard-empty text-center py-5 text-muted">
                        <h5 class="font-weight-bold">目前尚無分數紀錄</h5>
                        <p class="mb-0 text-black-50">趕快來成為第一個上榜的玩家吧！</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </aside>
    <div class="text-center mt-4"><a href="games.php" class="btn btn-secondary">← 返回遊戲列表</a></div>
</div>
<?php include_once "partials/footer.php"; ?>
