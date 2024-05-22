<?php
$method = $_SERVER['REQUEST_METHOD'];
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
$res = null;

switch ($method) {
  case 'GET':
    $res = [
      'data'=> [
        'name'=> '許毅達',
        'votes'=> 10,
        'avatar'=> '',
        'fav_peoples'=> [
          [
            'name'=> '王小明',
            'img'=> '/assets/img/rank_img_personal.png',
          ],
          [
            'name'=> '王小明',
            'img'=> '/assets/img/rank_img_personal.png',
          ],
          [
            'name'=> '王小明',
            'img'=> '/assets/img/rank_img_personal.png',
          ],
          [
            'name'=> '王小明',
            'img'=> '/assets/img/rank_img_personal.png',
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
    ];
  break;
}

echo json_encode($res);
exit;