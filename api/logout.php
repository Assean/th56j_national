<?php
include_once "db.php";
unset($_SESSION['user']);
unset($_SESSION['user_id']);
unset($_SESSION['num']);
session_destroy();
header("Location: ../index.php");
exit;
