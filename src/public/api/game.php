<?php
$method = $_SERVER['REQUEST_METHOD'];
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
$res = null;

switch ($method) {
  case 'GET':
   $res = [
    'code'=> 1, // 1=抽獎成功，2=今天玩過了，3=非開放時間
    'data'=> [
      'reward'=> 2, // 1～5 如果是抽獎成功的話，要帶 reward 這個欄位，是抽獎結果 1-5 票
    ]
  ];
  break;
}

echo json_encode($res);
exit;