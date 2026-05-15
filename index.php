<?php include_once "api/db.php"; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>FunTech</title>
        <link rel="stylesheet" href="./assets/css/bootstrap.css">
        <script src="assets/js/jquery-3.7.1.min.js"></script>
        <script src="assets/js/index.js"></script>
                     
</head>
<body>
<div id="home" class='container'>
    <header class="site-header d-flex p-3 justify-content-between border-bottom">
        <div class="brand" style='border:1px solid #ccc;width:30px;height:30px;background:green'>
            <a href="./index.php" class="brand-link">
                <img src="./assets/img/logo.png" alt="FunTech" style='width:100%;height:100%;object-fit:cover'>
            </a>
        </div>
        <nav class="main-nav">
            <a href="javascript:loadpage('./front/Home-main.php')" class="btn btn-info mx-2 home-link">首頁</a>
            <a href="javascript:loadpage('./front/games.php')" class="btn btn-info mx-2 games-link">遊戲</a>
            <a href="javascript:loadpage('./front/friends-page.php')" class="btn btn-info mx-2 friends-link">好友</a>
        </nav>
        <?php if (!isset($_SESSION['user'])) { ?>
            <div class="user-area">
                <a href="javascript:loadpage('./front/login.php')" class="btn btn-primary mx-2 login-link">登入</a>
                <a href="javascript:loadpage('./front/register.php')" class="btn btn-success mx-2 register-link">註冊</a>
            </div>
        <?php } else { ?>
            <div class="user-badge">
                <a href="javascript:loadpage('./front/profile.php')" class="btn btn-success mx-2 profile-link">個人頁面入口</a>
                <a href="javascript:loadpage('./api/logout.php')" class="btn btn-success mx-2 logout-link">登出</a>
            </div>
        <?php } ?>
    </header>
    <div id="content" class="p-2"></div>
</div>
<script src="assets/js/bootstrap.js"></script>
<script>
    loadpage("./front/Home-main.php");
</script>
</body>
</html>