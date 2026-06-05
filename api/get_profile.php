<?php include_once "db.php";
header("Content-Type: application/json");
$row=$pdo->query("SELECT * FROM users WHERE username='{$_SESSION['user']}'")->fetch(PDO::FETCH_ASSOC);
unset($row['password']);
echo json_encode($row);
