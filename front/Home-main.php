<nav id="content-tabs">
    <a href="#" class="d-block btn btn-outline-info mx-2 m-2" data-target="articles">文章</a>
    <a href="#" class="d-block btn btn-outline-info mx-2 m-2" data-target="notifications">公告</a>
</nav>

<section class="articles p-3 rounded my-3" date-btn="articles">
    <h1 class="d-flex justify-content-center mb-4 mt-3">文章列表</h1>
    <?php for($i=1; $i<6;$i++):;?>
    <article class="article-item w-100 border rounded p-3 my-2">
        <div class='d-flex justify-content-between'>
            <div class="article-title text-md bolder"><?=$i;?>. 很好玩</div>
            <time datetime="" class="article-date text-sm"><?=date("Y-m-d H:i:s");?></time>
        </div>
        <div class="article-excerpt">有好好的遊戲......</div>
        <div class='text-right'>
            <a href="#" class="article-readmore btn btn-outline-primary btn-sm">More</a>
        </div>
    </article>
    <?php endfor;?>
</section>

<aside class="notifications border m-3 p-3 rounded" date-btn="notifications">
    <h1 class="d-flex justify-content-center">公告事項</h1>
    <?php for($i=1; $i<6;$i++):;?>
    <div class="notification-item border-bottom my-1 bg-gray-100 p-2 rounded">
        <div class="notification-title text-lg p-2 m-2">公告事項:<?=$i;?></div>
        <time datetime="" class="notification-date"><?=date("Y-m-d H:i:s");?></time>
    </div>
    <?php endfor;?>
</aside>

<script>
    const btns = document.querySelectorAll('#content-tabs a');
    const sections = document.querySelectorAll('[date-btn]');
    document.querySelector('[date-btn="notifications"]').style.display = 'none';
    btns[0].classList.add('active');

    btns.forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            
            btns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            
            const targetName = btn.getAttribute('data-target');
            
            sections.forEach(sec => {
                sec.style.display = (sec.getAttribute('date-btn') === targetName) ? 'block' : 'none';
            });
        });
    });
</script>