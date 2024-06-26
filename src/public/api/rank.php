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
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'name'=> '王一一',
            'tag_id'=> 'boyz010',
            'votes'=> '19786',
            'rank'=> 1,
          ],
          [
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'name'=> '王一二',
            'tag_id'=> 'boyz011',
            'votes'=> 19786,
            'rank'=> 2,
          ],
          [
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'name'=> '王一二',
            'tag_id'=> 'boyz012',
            'votes'=> 19786,
            'rank'=> 3,
          ],
          [
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'name'=> '王一二',
            'tag_id'=> 'boyz013',
            'votes'=> 19786,
          ],
          [
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'name'=> '王一二',
            'tag_id'=> 'boyz014',
            'votes'=> 19786,
          ],
          [
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'name'=> '王一二',
            'tag_id'=> 'boyz015',
            'votes'=> 19786,
          ],
          [
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'name'=> '王一二',
            'tag_id'=> 'boyz016',
            'votes'=> 19786,
          ],
          [
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'name'=> '王一二',
            'tag_id'=> 'boyz017',
            'votes'=> 19786,
          ],
          [
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'name'=> '王一二',
            'tag_id'=> 'boyz018',
            'votes'=> 19786,
          ],
          [
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'name'=> '王一二',
            'tag_id'=> 'boyz019',
            'votes'=> 19786,
          ]
        ],
        'team'=> [ // 團體排行
          [
            'id'=> 5,
            'votes'=> 0,
          ],
          [
            'id'=> 3,
            'votes'=> 0,
          ],
          [
            'id'=> 2,
            'votes'=> 0,
          ],
          [
            'id'=> 4,
            'votes'=> 0,
          ],
          [
            'id'=> 6,
            'votes'=> 0,
          ],
          [
            'id'=> 1,
            'votes'=> 0,
          ]
        ],
        'social'=> [ // 社群排行
          [
            'name'=> '王三四',
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'votes'=> 13333,
            'href'=> 'https://google.com',
            'href_target'=> '_blank',
            'rank'=> 1,
          ],
          [
            'name'=> '王三四',
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'votes'=> 13333,
            'href'=> 'https://google.com',
            'href_target'=> '_blank',
            'rank'=> 2,
          ],
          [
            'name'=> '王三四',
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'votes'=> 13333,
            'href'=> 'https://google.com',
            'href_target'=> '_blank',
            'rank'=> 3,
          ],
          [
            'name'=> '王三四',
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'votes'=> 13333,
            'href'=> 'https://google.com',
            'href_target'=> '_blank',
            'rank'=> 4,
          ],
          [
            'name'=> '王三四',
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'votes'=> 13333,
            'href'=> 'https://google.com',
            'href_target'=> '_blank',
            'rank'=> 5,
          ],
          [
            'name'=> '王三四',
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'votes'=> 13333,
            'href'=> 'https://google.com',
            'href_target'=> '_blank',
            'rank'=> 6,
          ],
          [
            'name'=> '王三四',
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'votes'=> 13333,
            'href'=> 'https://google.com',
            'href_target'=> '_blank',
            'rank'=> 7,
          ],
          [
            'name'=> '王三四',
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'votes'=> 13333,
            'href'=> 'https://google.com',
            'href_target'=> '_blank',
            'rank'=> 8,
          ],
          [
            'name'=> '王三四',
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'votes'=> 13333,
            'href'=> 'https://google.com',
            'href_target'=> '_blank',
            'rank'=> 9,
          ],
          [
            'name'=> '王三四',
            'img'=> '/atomboyz/assets/img/rank_img_personal.png',
            'votes'=> 13333,
            'href'=> 'https://google.com',
            'href_target'=> '_blank',
            'rank'=> 10,
          ],
        ],
        'sale'=> [ // 銷售排行
          [
            'img'=> '/atomboyz/assets/img/rank_img_sale.png', // 614 * 614
            'name'=> '原子少年2 全彩全開海報',
            'price_string'=> 'NT$1,000 ~ NT$1,500', // 如果是銷售排行的話，帶價錢，設計稿的價錢會有區間，所以此欄位傳處理過的字串
            'href'=> 'https://google.com',
            'href_target'=> '_blank',
          ],
          [
            'img'=> '/atomboyz/assets/img/rank_img_sale.png', // 614 * 614
            'name'=> '原子少年2 全彩全開海報',
            'price_string'=> 'NT$1,000 ~ NT$1,500', // 如果是銷售排行的話，帶價錢，設計稿的價錢會有區間，所以此欄位傳處理過的字串
            'href'=> 'https://google.com',
            'href_target'=> '_blank',
          ],
          [
            'img'=> '/atomboyz/assets/img/rank_img_sale.png', // 614 * 614
            'name'=> '原子少年2 全彩全開海報',
            'price_string'=> 'NT$1,000 ~ NT$1,500', // 如果是銷售排行的話，帶價錢，設計稿的價錢會有區間，所以此欄位傳處理過的字串
            'href'=> 'https://google.com',
            'href_target'=> '_blank',
          ],
          [
            'img'=> '/atomboyz/assets/img/rank_img_sale.png', // 614 * 614
            'name'=> '原子少年2 全彩全開海報',
            'price_string'=> 'NT$1,000 ~ NT$1,500', // 如果是銷售排行的話，帶價錢，設計稿的價錢會有區間，所以此欄位傳處理過的字串
            'href'=> 'https://google.com',
            'href_target'=> '_blank',
          ],
          [
            'img'=> '/atomboyz/assets/img/rank_img_sale.png', // 614 * 614
            'name'=> '原子少年2 全彩全開海報',
            'price_string'=> 'NT$1,000 ~ NT$1,500', // 如果是銷售排行的話，帶價錢，設計稿的價錢會有區間，所以此欄位傳處理過的字串
            'href'=> 'https://google.com',
            'href_target'=> '_blank',
          ]
        ],
      ]
    ];
  break;
}

echo json_encode($res);
exit;