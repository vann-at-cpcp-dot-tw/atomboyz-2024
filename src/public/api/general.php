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
        'countdown_end_time'=> '2024-06-30-16-25-59', // 首頁的倒數目標時間，格式：YYYY-MM-DD-HH-MM-SS
        'exclude_teams'=> [4, 5],
        'global_alert'=> '<div>
          <img src="/atomboyz/assets/img/pic1.jpg"/><br/><p>通知內容通知內容通知內容通知內容通知內容通知內容通知內容通知內容通知內容通知內容通知內容通知內容通知內容通知內容</p>
        </div>', // 全站蓋板燈箱通知
        'home_carousel'=> [ // 首頁第一個輪播圖
          [
            'img'=> '/atomboyz/assets/img/carousel_item.jpg', // 844 * 704
            'href'=> 'http://google.com.tw',
            'name'=> 'bn-1', // 因埋點需求加入 banner 名稱
          ],
          [
            'img'=> '/atomboyz/assets/img/carousel_item.jpg',
            'href'=> 'http://google.com.tw',
            'name'=> 'bn-2', // 因埋點需求加入 banner 名稱
          ],
          [
            'img'=> '/atomboyz/assets/img/carousel_item.jpg',
            'href'=> 'http://google.com.tw',
            'name'=> 'bn-3', // 因埋點需求加入 banner 名稱
          ],
          [
            'img'=> '/atomboyz/assets/img/carousel_item.jpg',
            'href'=> 'http://google.com.tw',
            'name'=> 'bn-4', // 因埋點需求加入 banner 名稱
          ],
        ],
        'rank_summary'=> [
          'team_champion'=> 1,
          'team_popular'=> 2,
        ],
        'home_kv_banner'=> '',
        'home_kv_banner_m'=> '',
        'home_bottom_banner'=> '/atomboyz/assets/img/pic1.jpg', // 首頁最後一張 banner
        'terms'=> [
          'voteinfo'=> '<div>111222</div>', // 投票說明
          'rules'=> '<div>333444</div>', // 活動辦法
          'notice'=> '<div>555666</div>' // 注意事項
        ],
        'extra_float_btn'=> [
          [
            'bg'=> '/atomboyz/assets/img/pic1.jpg',
            'text'=> '按鈕1',
            'href'=> 'http://google.com/',
            'href_target'=> '_blank'
          ],
          [
            'bg'=> '/atomboyz/assets/img/pic2.jpg',
            'text'=> '按鈕2',
            'href'=> 'http://google.com/',
            'href_target'=> '_blank'
          ],
        ],
        'can_play_game'=> false,
      ]
    ];
  break;
}

echo json_encode($res);
exit;