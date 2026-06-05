<?php include_once "db.php";
header("Content-Type: application/json");
$user=$pdo->query("SELECT id FROM users WHERE username='{$_SESSION['user']}'")->fetch();
$rows=$pdo->query("SELECT * FROM articles WHERE user_id='{$user['id']}' ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($rows);
