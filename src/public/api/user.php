<?php
$method = $_SERVER['REQUEST_METHOD'];
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
$res = null;

$t = $_GET['t'] ?? null;
if( $t !== '$2y$12$sQkktWRb4MPjGBVhWL64fuxpFSCzfwBypHF3MeEYCf15xS5DCCdjO' ){
  echo json_encode($res);
  exit;
}

switch ($method) {
  case 'GET':
    $res = [
      'data'=> [
        'user'=>[
          'name'=> '許毅達',
          'votes'=> 10,
          'avatar'=> '',
          'fav_peoples'=> [
            [
              'name'=> '王小明',
              'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            ],
            [
              'name'=> '王小明',
              'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            ],
            [
              'name'=> '王小明',
              'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            ],
            [
              'name'=> '王小明',
              'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            ]
          ],
          'daily_quests'=>[
            [
              'title'=> '每天登入',
              'reward'=> 3,
              'description'=> '說明說明說明說明說明說明說明說明說明',
              'is_done'=> true,
            ],
            [
              'title'=> '每日小遊戲',
              'reward'=> 3,
              'description'=> '說明說明說明說明說明說明說明說明說明',
              'is_done'=> false,
            ],
            [
              'title'=> '點擊活動BN',
              'reward'=> 3,
              'description'=> '說明說明說明說明說明說明說明說明說明',
              'is_done'=> true,
            ]
          ],
          'vote_logs'=> [
            [
              'name'=> '陳小明',
              'time'=> '2024/07/12/ 10:50:42',
              'votes'=> 10,
            ],
            [
              'name'=> '陳小明',
              'time'=> '2024/07/12/ 10:50:42',
              'votes'=> 10,
            ],
            [
              'name'=> '陳小明',
              'time'=> '2024/07/12/ 10:50:42',
              'votes'=> 10,
            ],
            [
              'name'=> '陳小明',
              'time'=> '2024/07/12/ 10:50:42',
              'votes'=> 10,
            ],
            [
              'name'=> '陳小明',
              'time'=> '2024/07/12/ 10:50:42',
              'votes'=> 10,
            ],
            [
              'name'=> '陳小明',
              'time'=> '2024/07/12/ 10:50:42',
              'votes'=> 10,
            ],
          ],
        ]
      ]
    ];
  break;

  case 'POST':
    $action = $_REQUEST['action'] ?? null;
    switch ($action) {
      case 'addFav': // 加入最愛
        if( !empty($_REQUEST['name']) ){
          $res = [
            'success'=> true
          ];
        }
      case 'removeFav': // 移除最愛
        if( !empty($_REQUEST['name']) ){
          $res = [
            'success'=> true
          ];
        }
      break;
      case 'share':
        $res = [
          'success'=> true,
          'data'=> [
            'user'=> [ // 任何互動的 api，如果需要更新 user，就增加 'data['user']' 這個欄位，內部結構和 GET user 的一摸一樣，前端接到就會複寫
              'votes'=> 15,
              // ... 其他需要複寫 user 的欄位
            ]
          ]
        ];
      break;
      case 'vote':
        if( !empty($_REQUEST['name']) && !empty($_REQUEST['votes']) ){
          $res = [
            'success'=> true,
            'data'=> [
              'user'=> [ // 任何互動的 api，如果需要更新 user，就增加 'data['user']' 這個欄位，內部結構和 GET user 的一摸一樣，前端接到就會複寫
                'votes'=> 10,
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