<?php
session_start();
include_once "api/db.php";
if(!isset($_SESSION['user'])){
?>
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
    <div id="profile-page">
        <?php include_once "./inc/header.php"; ?>
        <section class="profile-header">
            <div>
                <img src="" alt="" class="profile-avatar">
                <input type="file">
            </div>
            <div class="profile-username"></div>
            <div class="profile-bio"></div>
            <textarea name="" id="" class="profile-bio-input"></textarea>
        </section>
    </div>
</body>
</html>
<?php }else{
    header("location:./index.php");
 } ?>