<?php include_once "db.php";
header("Content-Type: application/json");
$id=(int)$_GET['id'];
$game=$pdo->query("SELECT * FROM games WHERE id='$id'")->fetch(PDO::FETCH_ASSOC);
$setting=json_decode(file_get_contents("../games/{$id}/game.json"));
$game['entryUrl']=$setting->entry->url;
$game['pullUrl']=$setting->score->pullUrl;
echo json_encode($game);
