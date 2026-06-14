<?php
include_once '../api/db.php';
$st = $pdo->prepare('UPDATE users SET bio=? WHERE id=?');
echo $st->execute([$_POST['bio'], $_SESSION['user_id']]);