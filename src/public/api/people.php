<?php
$method = $_SERVER['REQUEST_METHOD'];
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
$res = null;

switch ($method) {
  case 'GET':
    $orderby = $_GET['orderby'] ?? 'rank';  // 銷售商品列表排序，如果 orderby 傳 'rank', 則表示用銷售量排序
    $order = $_GET['order'] ?? 'DESC'; // 排序方式, 預設 DESC
    $res = [
      'data'=> [
        'list'=> [
          [
            'img'=> '/assets/img/rank_img_personal.png', // 340 * 340
            'name'=> '王一一',
            'description'=> '個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述',
            'votes'=> 1234567,
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'hidoi_url'=> 'https://google.com',
            'can_vote'=> true, // 此人是否可以投票
            'team'=> 1,
          ],
          [
            'img'=> '/assets/img/rank_img_personal.png', // 340 * 340
            'name'=> '王一二',
            'description'=> '個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述',
            'votes'=> 1234567,
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'hidoi_url'=> 'https://google.com',
            'can_vote'=> true,
            'team'=> 1,
          ],
          [
            'img'=> '/assets/img/rank_img_personal.png', // 340 * 340
            'name'=> '王一三',
            'description'=> '個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述',
            'votes'=> 1234567,
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'hidoi_url'=> 'https://google.com',
            'can_vote'=> true,
            'team'=> 2,
          ],
          [
            'img'=> '/assets/img/rank_img_personal.png', // 340 * 340
            'name'=> '王一四',
            'description'=> '個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述',
            'votes'=> 1234567,
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'hidoi_url'=> 'https://google.com',
            'can_vote'=> true,
            'team'=> 2,
          ],
          [
            'img'=> '/assets/img/rank_img_personal.png', // 340 * 340
            'name'=> '王一五',
            'description'=> '個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述',
            'votes'=> 1234567,
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'hidoi_url'=> 'https://google.com',
            'can_vote'=> true,
            'team'=> 3,
          ],
          [
            'img'=> '/assets/img/rank_img_personal.png', // 340 * 340
            'name'=> '王一六',
            'description'=> '個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述',
            'votes'=> 1234567,
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'hidoi_url'=> 'https://google.com',
            'can_vote'=> true,
            'team'=> 3,
          ],
          [
            'img'=> '/assets/img/rank_img_personal.png', // 340 * 340
            'name'=> '王一七',
            'description'=> '個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述',
            'votes'=> 1234567,
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'hidoi_url'=> 'https://google.com',
            'can_vote'=> true,
            'team'=> 4,
          ],
          [
            'img'=> '/assets/img/rank_img_personal.png', // 340 * 340
            'name'=> '王一八',
            'description'=> '個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述',
            'votes'=> 1234567,
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'hidoi_url'=> 'https://google.com',
            'can_vote'=> true,
            'team'=> 4,
          ],
          [
            'img'=> '/assets/img/rank_img_personal.png', // 340 * 340
            'name'=> '王一九',
            'description'=> '個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述',
            'votes'=> 1234567,
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'hidoi_url'=> 'https://google.com',
            'can_vote'=> true,
            'team'=> 5,
          ],
          [
            'img'=> '/assets/img/rank_img_personal.png', // 340 * 340
            'name'=> '王二一',
            'description'=> '個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述',
            'votes'=> 1234567,
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'hidoi_url'=> 'https://google.com',
            'can_vote'=> true,
            'team'=> 5,
          ],
          [
            'img'=> '/assets/img/rank_img_personal.png', // 340 * 340
            'name'=> '王二二',
            'description'=> '個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述',
            'votes'=> 1234567,
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'hidoi_url'=> 'https://google.com',
            'can_vote'=> true,
            'team'=> 6,
          ],
          [
            'img'=> '/assets/img/rank_img_personal.png', // 340 * 340
            'name'=> '王二三',
            'description'=> '個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述',
            'votes'=> 1234567,
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'hidoi_url'=> 'https://google.com',
            'can_vote'=> true,
            'team'=> 6,
          ],
          [
            'img'=> '/assets/img/rank_img_personal.png', // 340 * 340
            'name'=> '王二四',
            'description'=> '個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述',
            'votes'=> 1234567,
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'hidoi_url'=> 'https://google.com',
            'can_vote'=> true,
            'team'=> -1, // -1 是待定
          ],
          [
            'img'=> '/assets/img/rank_img_personal.png', // 340 * 340
            'name'=> '王二五',
            'description'=> '個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述',
            'votes'=> 1234567,
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'hidoi_url'=> 'https://google.com',
            'can_vote'=> false,
            'team'=> -1, // -1 是待定
          ],
          [
            'img'=> '/assets/img/rank_img_personal.png', // 340 * 340
            'name'=> '王二六',
            'description'=> '個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述',
            'votes'=> 1234567,
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'hidoi_url'=> 'https://google.com',
            'can_vote'=> false,
            'team'=> -2, // -2 是淘汰
          ],
          [
            'img'=> '/assets/img/rank_img_personal.png', // 340 * 340
            'name'=> '王二七',
            'description'=> '個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述',
            'votes'=> 1234567,
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'hidoi_url'=> 'https://google.com',
            'can_vote'=> false,
            'team'=> -2, // -2 是淘汰
          ],
        ]
      ]
    ];
  break;
}

echo json_encode($res);
exit;