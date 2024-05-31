<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
$requestMethod = $_SERVER['REQUEST_METHOD'];
$json = json_decode(file_get_contents('php://input'));
$action = $_REQUEST['action'] ?? $json->action ?? null;
$res =  null;

switch (strtok($_SERVER["REQUEST_URI"], '?')) {
  default:
    require __DIR__ . strtok($_SERVER["REQUEST_URI"], '?') . '.php';
  break;
}

exit(json_encode($res));