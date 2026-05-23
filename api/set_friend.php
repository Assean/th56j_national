<?php
header("Content-Type: application/json");
include_once "db.php";
$my=$_SESSION['user_id'];
$friend=$_GET['friend_id'];
$action=$_GET['action'];

$relation = $pdo->query("SELECT * FROM `friends` WHERE 
    (requester_id='$my' AND addressee_id='$friend') OR 
    (requester_id='$friend' AND addressee_id='$my')")->fetch();

switch($action){
    case "apply":
        $pdo->exec("insert into `friends` (`requester_id`,`addressee_id`,`status`) values('$my','$friend','pending')");
        echo json_encode(['success'=>true,'message'=>'好友申請已送出']);
        break;
    case 'accept':
        $pdo->exec("update `friends` set `status`='accept' where `id`='{$relation['id']}'");
        echo json_encode(['success'=>true,'message'=>'好友申請已接受']);
        break;
    case 'cancel':
        $pdo->exec("DELETE from `friends` where `id`='{$relation['id']}'");
        echo json_encode(['success'=>true,'message'=>'好友申請已取消']);
        break;
    case 'reject':
        $pdo->exec("DELETE from `friends` where `id`='{$relation['id']}'");
        echo json_encode(['success'=>true,'message'=>'好友申請已拒絕']);
        break;
    case 'remove':
        $pdo->exec("DELETE from `friends` where `id`='{$relation['id']}'");
        echo json_encode(['success'=>true,'message'=>'好友已移除']);
        break;
}