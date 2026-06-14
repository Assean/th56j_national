<?php include_once "api/db.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FunTech</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/index.css">
    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
</head>
<body>
    <?php include_once "./inc/header.php"; ?>
    <form action="./api/register.php" class="login-form m-5" method="post">
        <h2 class="login d-flex justify-content-center m-4">會員註冊</h2>
        <div class="username d-flex justify-content-center m-4">
            <label for="username" class="m-2">帳號</label>
            <input type="text" class="username-input w-25 form-control" name="username">
        </div>
        <div class="email d-flex justify-content-center m-4">
            <label for="email" class="m-2">電子郵件</label>
            <input type="email" class="email-input w-25 form-control" name="email">
        </div>
        <div class="password d-flex justify-content-center m-4">
            <label for="password" class="m-2">密碼</label>
            <input type="password" class="password-input w-25 form-control" name="password">
        </div>
        <div class="chack_password d-flex justify-content-center m-4">
            <label for="chack_password" class="m-2">確認密碼</label>
            <input type="password" class="chack_password-input w-25 form-control" name="check_password">
        </div>
        <div class="submit d-flex justify-content-center m-4">
            <!-- <label for="sub送出t">送出</label> -->
            <input type="submit" class="submit-input btn btn-warning w-25" name="submit" vaule="送出">
        </div>
    </form>
    <!-- <form action="" method="post"></form> -->
</body>
</html>