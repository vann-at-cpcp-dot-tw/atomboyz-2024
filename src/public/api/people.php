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
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'name'=> '王一一',
            'tag_id'=> 'boyz001',
            'description'=> '個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述',
            'votes'=> 1234567,
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'hidoi_url'=> 'https://google.com',
            'can_vote'=> true, // 此人是否可以投票
            'situation_key'=> 1,
            'team'=> 1,
          ],
          [
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'name'=> '王一二',
            'tag_id'=> 'boyz002',
            'description'=> '個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述',
            'votes'=> 1234567,
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'hidoi_url'=> 'https://google.com',
            'can_vote'=> true,
            'situation_key'=> 1,
            'team'=> 1,
          ],
          [
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'name'=> '王一三',
            'tag_id'=> 'boyz003',
            'description'=> '個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述',
            'votes'=> 1234567,
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'hidoi_url'=> 'https://google.com',
            'can_vote'=> true,
            'situation_key'=> 1,
            'team'=> 2,
          ],
          [
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'name'=> '王一四',
            'tag_id'=> 'boyz004',
            'description'=> '個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述',
            'votes'=> 1234567,
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'hidoi_url'=> 'https://google.com',
            'can_vote'=> true,
            'situation_key'=> 1,
            'team'=> 2,
          ],
          [
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'name'=> '王一五',
            'tag_id'=> 'boyz005',
            'description'=> '個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述',
            'votes'=> 1234567,
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'hidoi_url'=> 'https://google.com',
            'can_vote'=> true,
            'situation_key'=> 1,
            'team'=> 3,
          ],
          [
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'name'=> '王一六',
            'tag_id'=> 'boyz006',
            'description'=> '個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述',
            'votes'=> 1234567,
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'hidoi_url'=> 'https://google.com',
            'can_vote'=> true,
            'situation_key'=> 1,
            'team'=> 3,
          ],
          [
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'name'=> '王一七',
            'tag_id'=> 'boyz007',
            'description'=> '個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述',
            'votes'=> 1234567,
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'hidoi_url'=> 'https://google.com',
            'can_vote'=> true,
            'situation_key'=> 1,
            'team'=> 4,
          ],
          [
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'name'=> '王一八',
            'tag_id'=> 'boyz008',
            'description'=> '個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述',
            'votes'=> 1234567,
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'hidoi_url'=> 'https://google.com',
            'can_vote'=> true,
            'situation_key'=> 1,
            'team'=> 4,
          ],
          [
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'name'=> '王一九',
            'tag_id'=> 'boyz009',
            'description'=> '個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述',
            'votes'=> 1234567,
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'hidoi_url'=> 'https://google.com',
            'can_vote'=> true,
            'situation_key'=> 1,
            'team'=> 5,
          ],
          [
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'name'=> '王二一',
            'tag_id'=> 'boyz010',
            'description'=> '個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述',
            'votes'=> 1234567,
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'hidoi_url'=> 'https://google.com',
            'can_vote'=> true,
            'situation_key'=> 1,
            'team'=> 5,
          ],
          [
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'name'=> '王二二',
            'tag_id'=> 'boyz011',
            'description'=> '個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述',
            'votes'=> 1234567,
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'hidoi_url'=> 'https://google.com',
            'can_vote'=> true,
            'situation_key'=> 1,
            'team'=> 6,
          ],
          [
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'name'=> '王二三',
            'tag_id'=> 'boyz012',
            'description'=> '個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述',
            'votes'=> 1234567,
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'hidoi_url'=> 'https://google.com',
            'can_vote'=> true,
            'situation_key'=> 1,
            'team'=> 6,
          ],
          [
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'name'=> '王二四',
            'tag_id'=> 'boyz013',
            'description'=> '個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述',
            'votes'=> 1234567,
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'hidoi_url'=> 'https://google.com',
            'can_vote'=> true,
            'situation_key'=> 3, // 3 是待定
            'team'=> 6,
          ],
          [
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'name'=> '王二五',
            'tag_id'=> 'boyz014',
            'description'=> '個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述',
            'votes'=> 1234567,
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'hidoi_url'=> 'https://google.com',
            'can_vote'=> false,
            'situation_key'=> 3, // 3 是待定
            'team'=> 6,
          ],
          [
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'name'=> '王二六',
            'tag_id'=> 'boyz015',
            'description'=> '個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述',
            'votes'=> 1234567,
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'hidoi_url'=> 'https://google.com',
            'can_vote'=> false,
            'situation_key'=> 2, // 2 是淘汰
            'team'=> 6,
          ],
          [
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'name'=> '王二七',
            'tag_id'=> 'boyz016',
            'description'=> '個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述個人描述',
            'votes'=> 1234567,
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'hidoi_url'=> 'https://google.com',
            'can_vote'=> false,
            'situation_key'=> 2, // 2 是淘汰
            'team'=> 6,
          ],
        ]
      ]
    ];
  break;
}

echo json_encode($res);
exit;