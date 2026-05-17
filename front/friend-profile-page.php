<div id="profile-page">
    <section class="profile-header w-100 p-3 border rounded mb-2 text-center">
        <img src="./img/user_05.jpg" class="profile-avater" style='width:128px'>
        <div class="profile-username">username</div>
        <div class="profile-bio m-auto col-md-8">簡介</div>
    </section>

<div class="profile-content">
    <section class="articles my-2 border rounded p-3">
        <?php for($i=0;$i<5;$i++):?>
        <article class="article-item my-2">
            <div class='d-flex justify-content-between w-100'>
                <div class="article-title">文章標題</div>
                <time datetime="" class="article-date text-sm"><?= date("Y-m-d H:i:s"); ?></time>
            </div>
            <div class='d-flex w-100'>
                <div class="article-excerpt">摘要...</div>
                <a href="javascript:loadpage('')" class="article-readmore">閱讀更多</a>
            </div>
        </article>
        <?php endfor;?>
        <div class="empty-article-message">目前尚無文章</div>
    </section>    
</div>
<div class="profile-friend-actions">
    <button class="btn btn-success">接受好友</button>
    <button class="btn btn-warning">拒絕好友</button>
    <button class="btn btn-warning">取消好友</button>
</div>
</div>
