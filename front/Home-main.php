<nav id="content-tabs" class="d-flex justify-content-center mb-3">
    <a href="#" class="btn btn-outline-info mx-2" data-target="articles">文章</a>
    <a href="#" class="btn btn-outline-info mx-2" data-target="notifications">公告</a>
</nav>

<section class="articles p-3 rounded my-3" data-btn="articles" date-btn="articles">
    <h1 class="d-flex justify-content-center mb-4 mt-3">文章列表</h1>
    <?php
        $dbPath = __DIR__ . "/../api/db.php";
        
        if (file_exists($dbPath)) {
            include_once $dbPath;
        } else {
            echo "<div class='text-center text-danger p-4'>資料庫設定檔遺失，請檢查路徑：{$dbPath}</div>";
        }

        if (isset($pdo)) {
            $articles = $pdo->query("SELECT `articles`.*, `users`.`username` FROM `articles` LEFT JOIN `users` ON `articles`.`user_id`=`users`.`id` ORDER BY `articles`.`created_at` DESC LIMIT 10")->fetchAll();
            
            if(count($articles) > 0):
                foreach($articles as $article):
    ?>
    <article class="article-item w-100 border rounded p-3 my-2">
        <div class='d-flex justify-content-between'>
            <div class="article-title text-md bolder"><?=htmlspecialchars($article['title']);?></div>
            <time datetime="" class="article-date text-sm"><?=date("Y-m-d H:i:s", strtotime($article['created_at']));?></time>
        </div>
        <div class="article-excerpt"><?=htmlspecialchars(mb_substr($article['content'], 0, 50));?>...</div>
        <div class='d-flex justify-content-between align-items-center'>
            <small class="text-muted">by <?=htmlspecialchars($article['username'] ?? '未知作者');?></small>
            <a href="javascript:loadpage('./front/article.php?id=<?=$article['id'];?>')" class="article-readmore btn btn-outline-primary btn-sm">More</a>
        </div>
    </article>
    <?php
                endforeach;
            else:
    ?>
    <div class="text-center text-muted p-4">目前尚無文章</div>
    <?php 
            endif;
        }
    ?>
</section>

<aside class="notifications border m-3 p-3 rounded" data-btn="notifications" date-btn="notifications">
    <h1 class="d-flex justify-content-center">公告事項</h1>
    <?php for($i=1; $i<6;$i++):;?>
    <div class="notification-item border-bottom my-1 bg-gray-100 p-2 rounded">
        <div class="notification-title text-lg p-2 m-2">公告事項:<?=$i;?></div>
        <time datetime="" class="notification-date"><?=date("Y-m-d H:i:s");?></time>
    </div>
    <?php endfor;?>
</aside>

<script>
    (function() {
        $('[data-btn="notifications"], [date-btn="notifications"]').hide();
        $('#content-tabs a').removeClass('active').eq(0).addClass('active');

        $('#content-tabs a').off('click').on('click', function(e) {
            e.preventDefault();
            
            $('#content-tabs a').removeClass('active');
            $(this).addClass('active');
            
            var targetName = $(this).attr('data-target');
            
            $('[data-btn], [date-btn]').hide();
            $('[data-btn="' + targetName + '"], [date-btn="' + targetName + '"]').show();
        });
    })();
</script>