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
      'user'=> [
        'votes'=> 10 // 抽獎成功，返回加總抽獎結果，使用者擁有的「所有」票數
      ]
    ]
  ];
  break;
}

echo json_encode($res);
exit;