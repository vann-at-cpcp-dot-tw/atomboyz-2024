<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
$requestMethod = $_SERVER['REQUEST_METHOD'];
$json = json_decode(file_get_contents('php://input'));
$action = $_REQUEST['action'] ?? $json->action ?? null;
$res =  null;
$t = $_GET['t'] ?? null;
$userT = '$2y$12$sQkktWRb4MPjGBVhWL64fuxpFSCzfwBypHF3MeEYCf15xS5DCCdjO';

function isLogin(){
  global $userT, $t;
  return $t ===  $userT;
}

function needLogin(){
  global $userT, $t;
  if( $t !==  $userT ){
    $res = 'not login';
    echo json_encode($res);
    exit;
  }
}

switch (strtok($_SERVER["REQUEST_URI"], '?')) {
  default:
    require __DIR__ . strtok($_SERVER["REQUEST_URI"], '?') . '.php';
  break;
}

exit(json_encode($res));