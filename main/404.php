<?php
/*
* 404 File
*/
require_once 'functions.php';
$q = array(
  'title'             => 'Página no encontrada',
  'path'              => '404',
  'additionalclasses' => array()
);
get_header($q);
?>

<?php get_footer($q);?>
