<header class="site-header">
    <div class="brand m-3">
        <a href="index.php" class="brand-link m-2">
            <img src="./assets/img/logo.png" alt="LOGO" style="width: 45px;height: 45px;border-radius: 10px;border: 1.5px solid chocolate;">
        </a>
        <nav class="amin-nav d-flex justify-content-center">
            <a href="index.php" class="home-link btn btn-info p-2 m-2">首頁</a>
            <a href="games.php" class="games-link btn btn-info p-2 m-2">遊戲</a>
            <a href="frieds.php" class="frieds-link btn btn-info p-2 m-2">好友</a>
        </nav>
    </div>
    <div class="user-area d-flex justify-content-end">
        <?php if(!isset($_SESSION['user'])){ ?>
            <a href="login.php" class="login-link btn btn-info p-2 m-2">登入</a>
            <a href="register.php" class="register-link btn btn-info p-2 m-2">註冊</a>
            <?php }else{ ?>
            <a href="profile.php" class="profile-link btn btn-info p-2 m-2">個人頁面入口</a>
            <a href="logout.php" class="logout-link btn btn-info p-2 m-2">登出</a>
        <?php } ?>
    </div>
</header>