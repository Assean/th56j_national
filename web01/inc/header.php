<?php include_once "api/db.php"; ?>
<link rel="stylesheet" href="assets/css/bootstrap.css">
<script src="assets/js/jquery-3.7.1.min.js"></script>
<script src="assets/js/bootstrap.js"></script>

<!-- 頁首/導覽列 -->
<div class="site-header m-3">
    <div class="brand">
        <a href="index.php" class="brand-link">
            <img class="" src="./assets/img/logo.png" alt="" style="width: 50px;height: 50px;">
        </a>
    </div>
    <nav class="main-nav d-flex justify-content-center">
        <a href="./index.php" class="home-link btn btn-info m-2">首頁</a>
        <a href="./games.php" class="games-link btn btn-info m-2">遊戲</a>
        <a href="./friends.php" class="friends-link btn btn-info m-2">好友</a>
    </nav>
    <?php if(!isset($_SESSION['user'])){ ?>
    <div class="user-area d-flex justify-content-end">
            <a href="./login.php" class="login-link btn btn-info m-2">登入</a>
            <a href="./register.php" class="register-link btn btn-info m-2">註冊</a>
        <?php }else{ ?>
            <div class="badge d-flex justify-content-end">
                <a href="./profile.php" class="profile-link btn btn-info m-2">個人頁面入口</a>
                <a href="./api/logout.php" class="logout-link btn btn-info m-2">登出</a>
            </div>
        <?php } ?>
    </div>
</div>