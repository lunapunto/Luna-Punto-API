<?php
/*
* Template file
*
*  Estructura $q:
*  Title - Determina el título de la página (ver get_title() en global/prefuncs.php)
*  Path - Añade el nombre del archivo único. Accesible vía body.template_body
*  Additionalclasses - Clases adicionales para body en un array
*/
require_once 'functions.php';
$q = array(
  'title'             => 'Template',
  'path'              => 'template',
  'additionalclasses' => array('nocol', 'tworows')
);
get_header($q);
?>


<?php get_footer($q);?>
