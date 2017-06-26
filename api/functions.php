<?php
require_once dirname(__DIR__).'/global/funcs.php';
$db = new db;

/*
* () checkclientkc
* Revisa los valores de killclient.
* @uses class killLP
* @params $_REQUEST - clientid varchar (obligatorio)
* @returns (obj) {msg (string), error (bool), kill (bool), clientid (int) }
*/
function checkclientkc(){
  $client = v('clientid', $_REQUEST);
  $kill = new killLP($client);
  return $kill->result();
}
/*
* () closeclient
* Devuelve un booleano determinando si el cliente está en el blacklist.
* @parent checkclientkc()
* @params $_REQUEST - clientid varchar (obligatorio)
* @returns (bool) ¿el cliente está en el blacklist? true : false
*/
function closeclient(){
  $killresult = checkclientkc();
  $iskill = $killresult->kill;
  echo $iskill;
  die();
}
