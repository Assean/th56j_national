<?php include_once "db.php";
header("Content-Type: application/json");
$search=$_GET['search'];
$users=$pdo->query("SELECT id,username,header FROM users WHERE username LIKE '%$search%'")->fetchAll(PDO::FETCH_ASSOC);
foreach($users as $k=>$u){
  if($u['username']===$_SESSION['num']) unset($users[$k]);
}
echo json_encode(array_values($users));
