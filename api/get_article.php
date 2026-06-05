<?php include_once "db.php";
header("Content-Type: application/json");
$id=(int)$_GET['id'];
$row=$pdo->query("SELECT * FROM articles WHERE id='$id'")->fetch(PDO::FETCH_ASSOC);
echo json_encode($row);
