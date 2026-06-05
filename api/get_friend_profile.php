<?php include_once "db.php";
header("Content-Type: application/json");
$id=(int)$_GET['id'];
$my=$_SESSION['user_id'];

$user=$pdo->query("SELECT id,username,header,bio FROM users WHERE id='$id'")->fetch(PDO::FETCH_ASSOC);
$articles=$pdo->query("SELECT * FROM articles WHERE user_id='$id' ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);

$rel=$pdo->query("SELECT * FROM friends WHERE (requester_id='$my' AND addressee_id='$id') OR (requester_id='$id' AND addressee_id='$my')")->fetch();
$relation=[
  'exists'=>!empty($rel),
  'isRequester'=>(!empty($rel)&&$rel['requester_id']==$my&&$rel['status']=='pending'),
  'isAddressee'=>(!empty($rel)&&$rel['addressee_id']==$my&&$rel['status']=='pending'),
  'isFriend'=>(!empty($rel)&&$rel['status']=='accept'),
];

echo json_encode(compact('user','articles','relation'));
