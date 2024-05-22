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
        'countdown_end_time'=> '2024-06-30-00-00', // 首頁的倒數目標時間，格式：YYYY-MM-DD-HH-MM
        'coming_soon_end_time'=> '2024-06-25-00-00', // 預熱頁的倒數目標時間，格式：YYYY-MM-DD-HH-MM
        'global_alert'=> '<div>
          <img src="/assets/img/pic1.jpg"/><br/><p>通知內容通知內容通知內容通知內容通知內容通知內容通知內容通知內容通知內容通知內容通知內容通知內容通知內容通知內容</p>
        </div>', // 全站蓋板燈箱通知
        'home_carousel'=> [ // 首頁第一個輪播圖
          [
            'img'=> '/assets/img/carousel_item.jpg', // 844 * 704
            'href'=> 'http://google.com.tw',
          ],
          [
            'img'=> '/assets/img/carousel_item.jpg',
            'href'=> 'http://google.com.tw',
          ],
          [
            'img'=> '/assets/img/carousel_item.jpg',
            'href'=> 'http://google.com.tw',
          ],
          [
            'img'=> '/assets/img/carousel_item.jpg',
            'href'=> 'http://google.com.tw',
          ],
        ],
        'rank_summary'=> [
          'team_champion'=> [ // 當前冠軍團
            'img'=> '/assets/img/pic1.jpg' // 2640 * 1320
          ],
          'team_popular'=> [ // 當前人氣團
            'img'=> '/assets/img/pic1.jpg' // 2640 * 1320
          ]
        ],
        'home_bottom_banner'=> '/assets/img/pic1.jpg', // 首頁最後一張 banner
      ]
    ];
  break;
}

echo json_encode($res);
exit;