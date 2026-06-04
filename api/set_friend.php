<?php
header("Content-Type: application/json");
include_once "db.php";
$my=$_SESSION['user_id'];$friend=$_GET['friend_id'];$action=$_GET['action'];
$rel=$pdo->query("SELECT * FROM `friends` WHERE (requester_id='$my' AND addressee_id='$friend') OR (requester_id='$friend' AND addressee_id='$my')")->fetch();
$msgs=['apply'=>'好友申請已送出','accept'=>'好友申請已接受','cancel'=>'好友申請已取消','reject'=>'好友申請已拒絕','remove'=>'好友已移除'];
switch($action){
  case 'apply': $pdo->exec("INSERT INTO `friends`(`requester_id`,`addressee_id`,`status`)VALUES('$my','$friend','pending')"); break;
  case 'accept': $pdo->exec("UPDATE `friends` SET `status`='accept' WHERE `id`='{$rel['id']}'"); break;
  default: $pdo->exec("DELETE FROM `friends` WHERE `id`='{$rel['id']}'");
}
echo json_encode(['success'=>true,'message'=>$msgs[$action]]);
