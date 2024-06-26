<?php
$method = $_SERVER['REQUEST_METHOD'];
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
$res = null;

switch ($method) {
  case 'GET':
    $perPage = $_GET['per_page'] ?? 3; // 指定一頁幾則，非必填，預設 3
    $page = $_GET['page'] ?? 1; // 指定第幾頁，非必填，預設 1
    $res = [
      'data'=> [
        'list'=> [
          [
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'title'=> '【原子少年2】EP3花絮｜當週人氣倒數懲罰 殘酷2選1', // youtube 標題為後台上稿
            'date'=> '2024.07.07',
            'excerpts'=> '文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要',
          ],
          [
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'title'=> '【原子少年2】EP3花絮｜當週人氣倒數懲罰 殘酷2選1', // youtube 標題為後台上稿
            'date'=> '2024.07.07',
            'excerpts'=> '文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要',
          ],
          [
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'title'=> '【原子少年2】EP3花絮｜當週人氣倒數懲罰 殘酷2選1', // youtube 標題為後台上稿
            'date'=> '2024.07.07',
            'excerpts'=> '文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要',
          ],
          [
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'title'=> '【原子少年2】EP3花絮｜當週人氣倒數懲罰 殘酷2選1', // youtube 標題為後台上稿
            'date'=> '2024.07.07',
            'excerpts'=> '文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要',
          ],
          [
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'title'=> '【原子少年2】EP3花絮｜當週人氣倒數懲罰 殘酷2選1', // youtube 標題後台上稿
            'date'=> '2024.07.07',
            'excerpts'=> '文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要',
          ],
          [
            'yt_url'=> 'https://youtu.be/T_lC2O1oIew?si=C1NQZLgsYD76uGm3',
            'title'=> '【原子少年2】EP3花絮｜當週人氣倒數懲罰 殘酷2選1', // youtube 標題為後台上稿
            'date'=> '2024.07.07',
            'excerpts'=> '文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要',
          ],
        ],
        'pagination'=> [
          'total'=> 27,
        ]
      ]
    ];
    break;
}

echo json_encode($res);
exit;