<?php
include_once '../api/db.php';
$a=$pdo->query("SELECT * FROM `articles` WHERE `id`='{$_GET['id']}'")->fetch();
?>
<div id="article" class="row justify-content-center mt-4">
  <div class="col-md-8">
    <div class="card shadow border-0">
      <div class="card-body p-4">
        <header class="article-header">
          <h1 class="article-title font-weight-bold text-center mb-2"><?=htmlspecialchars($a['title'])?></h1>
          <p class="text-right text-muted small border-bottom pb-2">發文日期：<time class="article-date"><?=date("Y-m-d",strtotime($a['created_at']))?></time></p>
        </header>
        <section class="article-body mt-3" style="line-height:1.8"><?=nl2br(htmlspecialchars($a['content']))?></section>
      </div>
    </div>
  </div>
</div>
