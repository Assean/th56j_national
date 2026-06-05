<?php include_once "db.php";
header("Content-Type: application/json");
$rows=$pdo->query("SELECT * FROM games")->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($rows);
