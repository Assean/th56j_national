<ul class="nav nav-tabs mb-3" id="homeTabs">
  <li class="nav-item"><a class="nav-link active" href="#" data-target="articles">📰 文章</a></li>
  <li class="nav-item"><a class="nav-link" href="#" data-target="notifications">📢 公告</a></li>
</ul>

<section data-section="articles">
  <h4 class="mb-3">文章列表</h4>
  <?php
  $dbPath = __DIR__ . "/../api/db.php";
  if (file_exists($dbPath)) include_once $dbPath;
  if (isset($pdo)):
    $articles = $pdo->query("SELECT `articles`.*, `users`.`username` FROM `articles` LEFT JOIN `users` ON `articles`.`user_id`=`users`.`id` ORDER BY `articles`.`created_at` DESC LIMIT 10")->fetchAll();
    if (count($articles) > 0):
      foreach ($articles as $article):
  ?>
  <div class="card mb-3 article-item border-0 shadow-sm">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-start mb-1">
        <h6 class="card-title font-weight-bold mb-0"><?= htmlspecialchars($article['title']) ?></h6>
        <small class="text-muted ml-2 text-nowrap"><?= date("Y-m-d H:i", strtotime($article['created_at'])) ?></small>
      </div>
      <p class="card-text text-muted small mb-2"><?= htmlspecialchars(mb_substr($article['content'], 0, 60)) ?>...</p>
      <div class="d-flex justify-content-between align-items-center">
        <small class="text-secondary">by <?= htmlspecialchars($article['username'] ?? '未知作者') ?></small>
        <a href="javascript:loadpage('./front/article.php?id=<?= $article['id'] ?>')" class="btn btn-outline-primary btn-sm">閱讀更多</a>
      </div>
    </div>
  </div>
  <?php endforeach; else: ?>
  <div class="text-center text-muted py-5"><i class="h4">📭</i><p>目前尚無文章</p></div>
  <?php endif; endif; ?>
</section>

<section data-section="notifications" class="d-none">
  <h4 class="mb-3">公告事項</h4>
  <?php for ($i = 1; $i < 6; $i++): ?>
  <div class="card mb-2 border-left border-warning" style="border-left-width:4px!important">
    <div class="card-body py-2">
      <div class="d-flex justify-content-between align-items-center">
        <span class="font-weight-bold">📌 公告事項 <?= $i ?></span>
        <small class="text-muted"><?= date("Y-m-d H:i:s") ?></small>
      </div>
    </div>
  </div>
  <?php endfor; ?>
</section>

<script>
(function(){
  $('#homeTabs a').on('click',function(e){
    e.preventDefault();
    $('#homeTabs a').removeClass('active');
    $(this).addClass('active');
    var t=$(this).data('target');
    $('[data-section]').addClass('d-none');
    $('[data-section="'+t+'"]').removeClass('d-none');
  });
})();
</script>
