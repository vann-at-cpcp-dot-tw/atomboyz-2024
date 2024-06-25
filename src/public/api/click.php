<?php
$method = $_SERVER['REQUEST_METHOD'];
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
$res = null;

switch ($method) {
  case 'POST':
    $action = $_REQUEST['action'] ?? null;

    switch ($action) {
      case 'bn': // 點擊 BN
        if( isLogin() ){
          $res = [
            'success'=> true,
            'data'=> [
              'user'=> [ // 任何互動的 api，如果需要更新 user，就增加 'data['user']' 這個欄位，內部結構和 GET user 的一摸一樣，前端接到就會複寫
                'votes'=> 15,
                // ... 其他需要複寫 user 的欄位
              ]
            ]
          ];
        }
      break;
    }

  break;
}


echo json_encode($res);
exit;