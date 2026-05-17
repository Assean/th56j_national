<?php  include_once '../api/db.php';

$article=$pdo->query("SELECT * FROM `articles` WHERE `id`='{$_GET['id']}'")->fetch();
?>

<div id="article">
    <header class="article-header">
        <h3 class="article-title text-center"><?=$article['title'];?></h3>
        <time datetime="" class="article-date d-block w-100 text-right">發文日期：<?=date("Y-m-d",strtotime($article['created_at']));?></time>
    </header>
    <section class="article-body col-md-10 m-auto" >
       <?php echo nl2br($article['content']);?>
    </section>
</div>