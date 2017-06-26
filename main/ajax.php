<?php
/*
* Ajax Call
* Llama a cualquier función de functions.php (incluída global/funcs.php y global/prefuncs.php)
* Llama sólo si existe la función
*/
require_once 'functions.php';
$action = i('action', $_REQUEST);
if($action && function_exists($action)){
  call_user_func($action);
}
die();
