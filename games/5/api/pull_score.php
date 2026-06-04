<?php
header('Content-Type: application/json; charset=utf-8');
$gid=5;
try {
  $pdo=new PDO('mysql:host=localhost;dbname=db21;charset=utf8mb4','root','');
  $s=$pdo->prepare('SELECT player_name,score FROM scores WHERE game_id=? ORDER BY score DESC,created_at ASC');
  $s->execute([$gid]);
  echo json_encode(array_map(fn($r)=>['玩家名稱'=>$r['player_name'],'分數'=>(int)$r['score']],$s->fetchAll()),JSON_UNESCAPED_UNICODE);
}catch(Throwable $e){http_response_code(500);echo json_encode(['error'=>'無法取得分數資料'],JSON_UNESCAPED_UNICODE);}
