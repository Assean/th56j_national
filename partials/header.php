<!DOCTYPE html>
<html lang="zh-TW">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FunTech</title>
<link rel="stylesheet" href="<?= $base ?>assets/css/bootstrap.css">
</head>
<body>
<div id="home" class="container">
<header class="site-header d-flex p-3 justify-content-between border-bottom">
    <div class="brand" style="border:1px solid #ccc;width:30px;height:30px;background:green">
        <a href="<?= $base ?>index.php" class="brand-link">
            <!-- $base = "./"; -->
            <img src="<?= $base ?>assets/img/logo.png" alt="FunTech" style="width:100%;height:100%;object-fit:cover">
        </a>
    </div>
    <nav class="main-nav">
        <a href="<?= $base ?>index.php" class="btn btn-info mx-2 home-link">首頁</a>
        <a href="<?= $base ?>games.php" class="btn btn-info mx-2 games-link">遊戲</a>
        <a href="<?= $base ?>friends.php" class="btn btn-info mx-2 friends-link">好友</a>
    </nav>
    <?php if (!isset($_SESSION['user'])){ ?>
    <div class="user-area">
        <a href="<?= $base ?>login.php" class="btn btn-primary mx-2 login-link">登入</a>
        <a href="<?= $base ?>register.php" class="btn btn-success mx-2 register-link">註冊</a>
    </div>
    <?php }else{ ?>
    <div class="user-badge">
        <a href="<?= $base ?>profile.php" class="btn btn-success mx-2 profile-link">個人頁面入口</a>
        <a href="<?= $base ?>api/logout.php" class="btn btn-success mx-2 logout-link">登出</a>
    </div>
    <?php } ?>
</header>
<div id="content" class="p-2">
