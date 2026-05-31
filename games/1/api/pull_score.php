<?php
// ----------------------------------------------------------------------
// 排行榜分數 API（練習用模擬端點）
// 對應遊戲：#1 數字挑戰
// game.json 的 score.pullUrl 會指向本檔案。
// 回傳：JSON 陣列，每筆 = 一位玩家的分數紀錄。
//   [ { "玩家名稱": "...", "分數": 0 }, ... ]
// ----------------------------------------------------------------------
header('Content-Type: application/json; charset=utf-8');

$game_id = 1;   // 本資料夾對應的遊戲 id

try {
    $dsn = 'mysql:host=localhost;dbname=db21;charset=utf8mb4';
    $pdo = new PDO($dsn, 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    // 分數由高到低排序；同分時較早建立者排前面
    $stmt = $pdo->prepare(
        'SELECT player_name, score
           FROM scores
          WHERE game_id = ?
          ORDER BY score DESC, created_at ASC'
    );
    $stmt->execute([$game_id]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $data = [];
    foreach ($rows as $row) {
        $data[] = [
            '玩家名稱' => $row['player_name'],
            '分數'     => (int) $row['score'],
        ];
    }

    echo json_encode($data, JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    // 基本錯誤處理：回傳 500 與錯誤訊息
    http_response_code(500);
    echo json_encode(
        ['error' => '無法取得分數資料'],
        JSON_UNESCAPED_UNICODE
    );
}
