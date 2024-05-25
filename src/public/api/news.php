<?php
$method = $_SERVER['REQUEST_METHOD'];
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
$res = null;

switch ($method) {
  case 'GET':
    if( !empty($_GET['id']) ){ // 如果有帶 ID 表示要查詢特定文章內文
      $res = [
        'data'=> [
          'title'=> '【原子少年2】EP3花絮｜當週人氣倒數懲罰 殘酷2選1',
          'img'=> '/assets/img/news_preview.png', // 預覽圖
          'content'=> '<div>內容內容內容內容內容內容內容</div>',
          'date'=> '2024.07.07',
          'prev_id'=> 3,
          'next_id'=> 5,
          'tags'=> ['標籤1', '標籤2', '標籤3']
        ]
      ];
    }else{ // 否則就是要查列表
      $perPage = $_GET['per_page'] ?? 3; // 指定一頁幾則，非必填，預設 3
      $page = $_GET['page'] ?? 1; // 指定第幾頁，非必填，預設 1
      $res = [
        'data'=> [
          'list'=> [
            [
              'id'=> 1,
              'img'=> '/assets/img/news_preview.png', // 預覽圖，562 * 374
              'title'=> '【原子少年2】EP3花絮｜當週人氣倒數懲罰 殘酷2選1',
              'excerpts'=> '文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要',
              'date'=> '2024.07.07',
            ],
            [
              'id'=> 1,
              'img'=> '/assets/img/news_preview.png', // 預覽圖，562 * 374
              'title'=> '【原子少年2】EP3花絮｜當週人氣倒數懲罰 殘酷2選1',
              'excerpts'=> '文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要',
              'date'=> '2024.07.07',

            ],
            [
              'id'=> 1,
              'img'=> '/assets/img/news_preview.png', // 預覽圖，562 * 374
              'title'=> '【原子少年2】EP3花絮｜當週人氣倒數懲罰 殘酷2選1',
              'excerpts'=> '文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要',
              'date'=> '2024.07.07',

            ],
            [
              'id'=> 1,
              'img'=> '/assets/img/news_preview.png', // 預覽圖，562 * 374
              'title'=> '【原子少年2】EP3花絮｜當週人氣倒數懲罰 殘酷2選1',
              'excerpts'=> '文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要',
              'date'=> '2024.07.07',

            ],
            [
              'id'=> 1,
              'img'=> '/assets/img/news_preview.png', // 預覽圖，562 * 374
              'title'=> '【原子少年2】EP3花絮｜當週人氣倒數懲罰 殘酷2選1',
              'excerpts'=> '文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要',
              'date'=> '2024.07.07',

            ],
            [
              'id'=> 1,
              'img'=> '/assets/img/news_preview.png', // 預覽圖，562 * 374
              'title'=> '【原子少年2】EP3花絮｜當週人氣倒數懲罰 殘酷2選1',
              'excerpts'=> '文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要文章摘要',
              'date'=> '2024.07.07',

            ]
          ],
          'pagination'=> [
            'total'=> 27,
          ]
        ]
      ];
    }
  break;
}

echo json_encode($res);
exit;