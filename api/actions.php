<?php
require_once 'functions.php';
header('Content-Type: application/json');
$action = i('action', $_REQUEST);
if($action && function_exists($action)){
  call_user_func($action);

  if(json_last_error() !== JSON_ERROR_NONE){
    $o = array(
      'msg'   => "JSON Format Error: ".json_last_error_msg().".",
      'error' => 'LP505'
    );

    echo json_encode($o);
  }

}else{
  $o = array(
    'msg'   => "The function doesn't exists.",
    'error' => 'LP404'
  );

  echo json_encode($o);
}
