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
    // 使用 IIFE (立即執行函數) 建立獨立作用域，徹底避免變數名稱衝突
    (function() {
        // 1. 預設初始狀態：隱藏公告區塊，並將第一個按鈕（文章）設為 active
        $('[data-btn="notifications"], [date-btn="notifications"]').hide();
        $('#content-tabs a').removeClass('active').eq(0).addClass('active');

        // 2. 頁籤點擊切換邏輯 (先 off 再 on，防止 AJAX 重複綁定事件)
        $('#content-tabs a').off('click').on('click', function(e) {
            e.preventDefault();
            
            // 切換按鈕的 active 樣式
            $('#content-tabs a').removeClass('active');
            $(this).addClass('active');
            
            // 取得點擊的目標 (articles 或 notifications)
            var targetName = $(this).attr('data-target');
            
            // 隱藏所有區塊，只顯示對應的目標區塊 (相容 data-btn 與 date-btn 屬性)
            $('[data-btn], [date-btn]').hide();
            $('[data-btn="' + targetName + '"], [date-btn="' + targetName + '"]').show();
        });
    })();

    // 3. 閱讀更多 Modal 功能 (同樣加上 .off() 確保動態載入不失效)
    $(".article-readmore").off("click").on("click", function(e) {
        e.preventDefault();
        var $a = $(this);
        $.get("./front/modal/home.php", function(modal) {
            $("#article").remove(); 
            $("body").append(modal);
            $("#article").modal("show");
            $("#article").off("hide.bs.modal").on("hide.bs.modal", function(){
                $a.focus();
            });
        });
    });
</script>