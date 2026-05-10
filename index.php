<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FunTech</title><link rel="stylesheet" href="./assets/css/bootstrap.css">
</head>
<body>
    <div id="home">
        <header class="site-header">
            <div class="brand">
                <a href="" class="brand-link"></a>
                <nav class="main-nav">
                    <a href="" class="home-link">首頁</a>
                    <a href="" class="games-link">遊戲</a>
                    <a href="" class="friends-link">好友</a>
                </nav>
            </div>
            <?php session_start();
                  if (isset($_SESSION['user'])) {
            ?>
            <div class="site-header user-area">
                <a href="" class="login-link">登入</a>
                <a href="" class="register-link">註冊</a>
                <?php } else { ?>
                <div class="user-badge">
                    <a href="" class="profile-link">個人頁面入口</a>
                    <a href="" class="logout-link">登出</a>
                </div>
                <?php } ?>
            </div>
            <section class="articles">
                <article class="article-item">
                    <div class="article-title"></div>
                    <time datetime="" class="article-data"></time>
                    <div class="article-excerpt"></div>
                </article>
            </section>
            <aside class="notifications">
                <div class="notifications-item">
                    <div class="notifications-title"></div>
                    <time datetime="" class="notifications-data"></time>
                </div>
            </aside>
        </header>
    </div>
</body>
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/jquery-3.7.1.min.js"></script>
</html>