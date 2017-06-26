<?php
require_once dirname(__DIR__).'/global/funcs.php';
$db = new db;

function perro(){
  print_r($_GET);
  echo json_encode('hola');
}
