<?php
/*
* Header
* Para cambiar favicon incluir archivos

  assets/meta/favicon16x16
  assets/meta/favicon32x32
  assets/meta/favicon48x48
  assets/meta/favicon64x64
  assets/meta/favicon96x96

  -Se puede utilizar favicon.ai para exportar a pantallas (Adobe Illustrator CC)
*
* Para cambiar screenshot de OG:FB subir un PNG screenshot de medidas 1200px x 630px en assets/meta/screenshot.png
  -Se puede utilizar screenshot.ai para exportar
*/
require_once('functions.php');
$title = i('title');
$classes = array();
if($path = i('path')){
  $classes[] = $path.'_body';
}
if($additionalclasses = i('additionalclasses')){
  $classes = array_merge($additionalclasses, $classes);
}
$scriptsstyles = scriptsstyles(false, 'header');
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <title><?php get_title($title);?></title>
  <meta charset="utf-8" />
  <meta content="width=device-width,initial-scale=1, user-scalable=no" name="viewport" />
  <link rel="icon" type="image/png" href="<?= asset.'/meta/favicon16x16.png';?>" sizes="16x16">
  <link rel="icon" type="image/png" href="<?= asset.'/meta/favicon32x32.png';?>" sizes="32x32">
  <link rel="icon" type="image/png" href="<?= asset.'/meta/favicon48x48.png';?>" sizes="48x48">
  <link rel="icon" type="image/png" href="<?= asset.'/meta/favicon64x64.png';?>" sizes="64x64">
  <link rel="icon" type="image/png" href="<?= asset.'/meta/favicon96x96.png';?>" sizes="96x96">

  <meta name="author" content="Luna Punto" />

  <meta name="keywords" content="<?= implode(',', $keywords);?>" />
  <meta name="description" content="<?= $description;?>" />
  <meta property="og:url"                content="<?= dir;?>" />
  <meta property="og:type"               content="website" />
  <meta property="og:title"              content="<?php get_title($title);?>" />
  <meta property="og:description"        content="<?= $quickdescription;?>" />
  <meta property="og:image"              content="<?= asset.'/meta/screenshot.png';?>" />

  <!-- Incluir Google Analytics -->


  <?= $scriptsstyles;?>
</head>
<body class="<?= array_to_str($classes, ' ');?>">

  <?php
  /*
  * Livereload
  */
  if(!is_production):?>
    <script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
  <?php endif;?>

  <div id="wrapper">
