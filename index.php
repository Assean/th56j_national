<?php include_once "api/db.php"; ?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FunTech</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="./assets/css/index.css">
<script src="assets/js/jquery-3.7.1.min.js"></script>
<script src="assets/js/index.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm sticky-top">
  <a class="navbar-brand d-flex align-items-center" href="./index.php">
    <img src="./assets/img/logo.png" alt="FunTech" width="36" height="36" class="rounded-circle mr-2" style="object-fit:cover">
    <span class="font-weight-bold">FunTech</span>
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNav">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="mainNav">
    <ul class="navbar-nav mx-auto">
      <li class="nav-item"><a class="nav-link" href="javascript:loadpage('./front/Home-main.php')">🏠 首頁</a></li>
      <li class="nav-item"><a class="nav-link" href="javascript:loadpage('./front/games.php')">🎮 遊戲</a></li>
      <li class="nav-item"><a class="nav-link" href="javascript:loadpage('./front/friends-page.php')">👥 好友</a></li>
    </ul>
    <div class="d-flex">
      <?php if (!isset($_SESSION['user'])): ?>
        <a href="javascript:loadpage('./front/login.php')" class="btn btn-outline-light btn-sm mr-2">登入</a>
        <a href="javascript:loadpage('./front/register.php')" class="btn btn-success btn-sm">註冊</a>
      <?php else: ?>
        <a href="javascript:loadpage('./front/profile-page.php')" class="btn btn-outline-light btn-sm mr-2">個人頁面</a>
        <a href="./api/logout.php" class="btn btn-danger btn-sm">登出</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
<div id="home" class="container-fluid px-0">
  <div id="content" class="p-3"></div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<script>loadpage("./front/Home-main.php");</script>
</body>
</html>
