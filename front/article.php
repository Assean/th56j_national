<?php
include_once '../api/db.php';
$article = $pdo->query("SELECT * FROM `articles` WHERE `id`='{$_GET['id']}'")->fetch();
?>
<div class="row justify-content-center mt-4">
  <div class="col-md-8">
    <div class="card shadow border-0">
      <div class="card-body p-4">
        <h3 class="font-weight-bold text-center mb-2"><?= htmlspecialchars($article['title']) ?></h3>
        <p class="text-right text-muted small border-bottom pb-2">發文日期：<?= date("Y-m-d", strtotime($article['created_at'])) ?></p>
        <div class="article-body mt-3" style="line-height:1.8"><?= nl2br(htmlspecialchars($article['content'])) ?></div>
        <!-- <div class="mt-4 text-center"> -->
          <!-- <a href="javascript:history.back()" class="btn btn-outline-secondary btn-sm">← 返回</a> -->
        <!-- </div> -->
      </div>
    </div>
  </div>
</div>
