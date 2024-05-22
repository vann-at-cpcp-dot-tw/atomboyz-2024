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
        'personal'=> [ // 個人排行
          [
            'img'=> '/assets/img/rank_img_personal.png',
            'name'=> '王一二',
            'votes'=> 19786,
          ],
          [
            'img'=> '/assets/img/rank_img_personal.png',
            'name'=> '王一二',
            'votes'=> 19786,
          ],
          [
            'img'=> '/assets/img/rank_img_personal.png',
            'name'=> '王一二',
            'votes'=> 19786,
          ],
          [
            'img'=> '/assets/img/rank_img_personal.png',
            'name'=> '王一二',
            'votes'=> 19786,
          ],
          [
            'img'=> '/assets/img/rank_img_personal.png',
            'name'=> '王一二',
            'votes'=> 19786,
          ],
          [
            'img'=> '/assets/img/rank_img_personal.png',
            'name'=> '王一二',
            'votes'=> 19786,
          ],
          [
            'img'=> '/assets/img/rank_img_personal.png',
            'name'=> '王一二',
            'votes'=> 19786,
          ],
          [
            'img'=> '/assets/img/rank_img_personal.png',
            'name'=> '王一二',
            'votes'=> 19786,
          ],
          [
            'img'=> '/assets/img/rank_img_personal.png',
            'name'=> '王一二',
            'votes'=> 19786,
          ],
          [
            'img'=> '/assets/img/rank_img_personal.png',
            'name'=> '王一二',
            'votes'=> 19786,
          ]
        ],
        'team'=> [ // 團體排行
          [
            'id'=> 5,
            'votes'=> 988889
          ],
          [
            'id'=> 3,
            'votes'=> 988888
          ],
          [
            'id'=> 2,
            'votes'=> 988887
          ],
          [
            'id'=> 4,
            'votes'=> 988886
          ],
          [
            'id'=> 6,
            'votes'=> 988885
          ],
          [
            'id'=> 1,
            'votes'=> 988884
          ]
        ],
        'social'=> [ // 社群排行
          [
            'name'=> '王三四',
            'img'=> '/assets/img/rank_img_personal.png',
            'votes'=> 13333,
          ],
          [
            'name'=> '王三四',
            'img'=> '/assets/img/rank_img_personal.png',
            'votes'=> 13333,
          ],
          [
            'name'=> '王三四',
            'img'=> '/assets/img/rank_img_personal.png',
            'votes'=> 13333,
          ],
          [
            'name'=> '王三四',
            'img'=> '/assets/img/rank_img_personal.png',
            'votes'=> 13333,
          ],
          [
            'name'=> '王三四',
            'img'=> '/assets/img/rank_img_personal.png',
            'votes'=> 13333,
          ],
          [
            'name'=> '王三四',
            'img'=> '/assets/img/rank_img_personal.png',
            'votes'=> 13333,
          ],
          [
            'name'=> '王三四',
            'img'=> '/assets/img/rank_img_personal.png',
            'votes'=> 13333,
          ],
          [
            'name'=> '王三四',
            'img'=> '/assets/img/rank_img_personal.png',
            'votes'=> 13333,
          ],
          [
            'name'=> '王三四',
            'img'=> '/assets/img/rank_img_personal.png',
            'votes'=> 13333,
          ],
          [
            'name'=> '王三四',
            'img'=> '/assets/img/rank_img_personal.png',
            'votes'=> 13333,
          ],
        ],
        'sale'=> [ // 銷售排行
          [
            'img'=> '/assets/img/rank_img_sale.png', // 614 * 614
            'name'=> '原子少年2 全彩全開海報',
            'price_string'=> 'NT$1,000 ~ NT$1,500', // 如果是銷售排行的話，帶價錢，設計稿的價錢會有區間，所以此欄位傳處理過的字串
            'href'=> 'https://google.com' // 如果是銷售排行的話，帶商品連結
          ],
          [
            'img'=> '/assets/img/rank_img_sale.png', // 614 * 614
            'name'=> '原子少年2 全彩全開海報',
            'price_string'=> 'NT$1,000 ~ NT$1,500', // 如果是銷售排行的話，帶價錢，設計稿的價錢會有區間，所以此欄位傳處理過的字串
            'href'=> 'https://google.com' // 如果是銷售排行的話，帶商品連結
          ],
          [
            'img'=> '/assets/img/rank_img_sale.png', // 614 * 614
            'name'=> '原子少年2 全彩全開海報',
            'price_string'=> 'NT$1,000 ~ NT$1,500', // 如果是銷售排行的話，帶價錢，設計稿的價錢會有區間，所以此欄位傳處理過的字串
            'href'=> 'https://google.com' // 如果是銷售排行的話，帶商品連結
          ],
          [
            'img'=> '/assets/img/rank_img_sale.png', // 614 * 614
            'name'=> '原子少年2 全彩全開海報',
            'price_string'=> 'NT$1,000 ~ NT$1,500', // 如果是銷售排行的話，帶價錢，設計稿的價錢會有區間，所以此欄位傳處理過的字串
            'href'=> 'https://google.com' // 如果是銷售排行的話，帶商品連結
          ],
          [
            'img'=> '/assets/img/rank_img_sale.png', // 614 * 614
            'name'=> '原子少年2 全彩全開海報',
            'price_string'=> 'NT$1,000 ~ NT$1,500', // 如果是銷售排行的話，帶價錢，設計稿的價錢會有區間，所以此欄位傳處理過的字串
            'href'=> 'https://google.com' // 如果是銷售排行的話，帶商品連結
          ]
        ],
      ]

    ];
  break;
}

echo json_encode($res);
exit;