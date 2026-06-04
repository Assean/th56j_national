<?php include_once "../api/db.php"; ?>
<ul class="nav nav-tabs mb-3" id="homeTabs">
  <li class="nav-item"><a class="nav-link active" href="#" data-target="articles">📰 文章</a></li>
  <li class="nav-item"><a class="nav-link" href="#" data-target="notifications">📢 公告</a></li>
</ul>

<section class="articles" data-section="articles">
  <h4 class="mb-3">文章列表</h4>
  <?php
  $arts=$pdo->query("SELECT a.*,u.username FROM `articles` a LEFT JOIN `users` u ON a.user_id=u.id ORDER BY a.created_at DESC LIMIT 10")->fetchAll();
  foreach($arts as $a):?>
  <div class="card mb-3 article-item border-0 shadow-sm">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-start mb-1">
        <h6 class="article-title card-title font-weight-bold mb-0"><?=htmlspecialchars($a['title'])?></h6>
        <small class="text-muted ml-2"><time class="article-date"><?=date("Y-m-d H:i",strtotime($a['created_at']))?></time></small>
      </div>
      <p class="article-excerpt card-text text-muted small mb-2"><?=htmlspecialchars(mb_substr($a['content'],0,60))?>...</p>
      <div class="d-flex justify-content-between align-items-center">
        <small class="text-secondary">by <?=htmlspecialchars($a['username']??'未知作者')?></small>
        <a href="javascript:loadpage('front/article.php?id=<?=$a['id']?>')" class="article-readmore btn btn-outline-primary btn-sm">閱讀更多</a>
      </div>
    </div>
  </div>
  <?php endforeach;
  if(!$arts):?><div class="text-center text-muted py-5"><i class="h4">📭</i><p>目前尚無文章</p></div><?php endif;?>
</section>

<aside class="notifications d-none" data-section="notifications">
  <h4 class="mb-3">公告事項</h4>
  <?php for($i=1;$i<6;$i++):?>
  <div class="notification-item card mb-2 border-left border-warning" style="border-left-width:4px!important">
    <div class="card-body py-2">
      <div class="d-flex justify-content-between align-items-center">
        <span class="notification-title font-weight-bold">📌 公告事項 <?=$i?></span>
        <small class="text-muted"><time class="notification-date"><?=date("Y-m-d H:i:s")?></time></small>
      </div>
    </div>
  </div>
  <?php endfor;?>
</aside>

<script>
$('#homeTabs a').on('click',function(e){
  e.preventDefault();
  $('#homeTabs a').removeClass('active');$(this).addClass('active');
  var t=$(this).data('target');
  $('[data-section]').addClass('d-none');$('[data-section="'+t+'"]').removeClass('d-none');
});
</script>
