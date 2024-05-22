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
        'list'=> [
          [
            'img'=> '/assets/img/rank_img_sale.png', // 614 * 614
            'name'=> '原子少年2 全彩全開海報',
            'price_string'=> 'NT$1,000 ~ NT$1,500',
            'href'=> 'https://google.com',
            'description'=> '原子少年2限量周邊收藏只有這次手刀加入購物車',
          ],
          [
            'img'=> '/assets/img/rank_img_sale.png', // 614 * 614
            'name'=> '原子少年2 全彩全開海報',
            'price_string'=> 'NT$1,000 ~ NT$1,500',
            'href'=> 'https://google.com',
            'description'=> '原子少年2限量周邊收藏只有這次手刀加入購物車',
          ],
          [
            'img'=> '/assets/img/rank_img_sale.png', // 614 * 614
            'name'=> '原子少年2 全彩全開海報',
            'price_string'=> 'NT$1,000 ~ NT$1,500',
            'href'=> 'https://google.com',
            'description'=> '原子少年2限量周邊收藏只有這次手刀加入購物車',
          ],
          [
            'img'=> '/assets/img/rank_img_sale.png', // 614 * 614
            'name'=> '原子少年2 全彩全開海報',
            'price_string'=> 'NT$1,000 ~ NT$1,500',
            'href'=> 'https://google.com',
            'description'=> '原子少年2限量周邊收藏只有這次手刀加入購物車',
          ],
          [
            'img'=> '/assets/img/rank_img_sale.png', // 614 * 614
            'name'=> '原子少年2 全彩全開海報',
            'price_string'=> 'NT$1,000 ~ NT$1,500',
            'href'=> 'https://google.com',
            'description'=> '原子少年2限量周邊收藏只有這次手刀加入購物車',
          ],
          [
            'img'=> '/assets/img/rank_img_sale.png', // 614 * 614
            'name'=> '原子少年2 全彩全開海報',
            'price_string'=> 'NT$1,000 ~ NT$1,500',
            'href'=> 'https://google.com',
            'description'=> '原子少年2限量周邊收藏只有這次手刀加入購物車',
          ],
          // [
          //   'img'=> '/assets/img/rank_img_sale.png', // 614 * 614
          //   'name'=> '原子少年2 全彩全開海報',
          //   'price_string'=> 'NT$1,000 ~ NT$1,500',
          //   'href'=> 'https://google.com',
          //   'description'=> '原子少年2限量周邊收藏只有這次手刀加入購物車',
          // ]
        ]
      ]
    ];
  break;
}

echo json_encode($res);
exit;