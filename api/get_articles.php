<?php include_once "db.php";
header("Content-Type: application/json");
$rows=$pdo->query("SELECT articles.*,users.username FROM articles LEFT JOIN users ON articles.user_id=users.id ORDER BY articles.created_at DESC LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($rows);
