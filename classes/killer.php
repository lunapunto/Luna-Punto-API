<?php

class killLP{
  public $db;
  public $clientexists;
  public $killclient;
  public $error = false;
  public $msg = '';
  public $clientid = 0;
  public function __construct($clientid){
    global $db;
    $this->db = $db;

    $exists = $db->fetch('SELECT * FROM lpkiller WHERE clientid="'.$clientid.'"');

    if(count($exists)){
      $client = $exists;
      $this->msg = "Client ID #".$client['ID']."";
      $this->clientid = $client['ID'];
      $this->killclient = $client['killclient'] == 0 ? false : true;
    }else{
      $id = $db->i('lpkiller', array('clientid'=>$clientid));
      $this->clientid = $id;
      $this->error = true;
      $this->msg = "New Client Added #".$id."";
      $this->killclient = false;
    }
  }

  public function result(){
    $o = array(
      'msg'       => $this->msg,
      'error'     => $this->error,
      'clientid'  => $this->clientid,
      'kill'      => $this->killclient
    );
    $o = (object) $o;
    return $o;
  }

}
