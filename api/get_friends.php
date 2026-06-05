<?php include_once "db.php";
header("Content-Type: application/json");
$my=$_SESSION['user_id'];

$fRows=$pdo->query("SELECT * FROM friends WHERE (requester_id='$my' OR addressee_id='$my') AND status='accept'")->fetchAll();
$friends=[];
foreach($fRows as $f){
  $fid=($f['requester_id']==$my)?$f['addressee_id']:$f['requester_id'];
  $u=$pdo->query("SELECT id,username,header FROM users WHERE id='$fid'")->fetch(PDO::FETCH_ASSOC);
  $friends[]=$u;
}

$inRows=$pdo->query("SELECT * FROM friends WHERE addressee_id='$my' AND status='pending'")->fetchAll();
$incoming=[];
foreach($inRows as $r){
  $u=$pdo->query("SELECT id,username,header FROM users WHERE id='{$r['requester_id']}'")->fetch(PDO::FETCH_ASSOC);
  $incoming[]=$u;
}

$outRows=$pdo->query("SELECT * FROM friends WHERE requester_id='$my' AND status='pending'")->fetchAll();
$outgoing=[];
foreach($outRows as $r){
  $u=$pdo->query("SELECT id,username,header FROM users WHERE id='{$r['addressee_id']}'")->fetch(PDO::FETCH_ASSOC);
  $outgoing[]=$u;
}

echo json_encode(compact('friends','incoming','outgoing'));
