<?php
/*
* Archivo de prefunciones
* Este archivo se utiliza tanto en admin como en main y sirve para obtener las funciones claves.
*
* Notar que todos los archivos que se tengan que incluir con llamados con require al ser vitales.
*/

// Llama al file configuración
require_once dirname(__DIR__).'/config.php';

// Llama al autoload de composer
require_once dirname(__DIR__).'/vendor/autoload.php';


/* Importa todas las clases del folder Classes */

$allClasses = scandir(dirname(__DIR__).'/classes');

$classes = array_diff($allClasses, array('.', '..'));

foreach($classes as $class){
  $ext = pathinfo($class, PATHINFO_EXTENSION);
  /* Verifica que el archivo sea .php */
  if($ext == 'php'){
    require_once dirname(__DIR__).'/classes/'.$class;
  }
}




/* Partes */

/*
* () get_part
* Obtiene una parte, pasa siempre variables globales $_REQUEST
* Se puede acceder vía $_GET
*
* @params $part (string) [obligatorio] - Nombre de la parte PHP sin extensión
* @params $queries (array) [default array()] - Parámetros adicionales
* @params $dirname (array) [default 'main'] - Directorio donde vive la parte
*
* (string) Devuelve la parte evaluada
*/

function get_part($part,$queries=array(),$dirname='main'){
    $dir = dir;
    $current_server = i('PHP_SELF', $_SERVER);
    $current_server = basename($current_server);
    $queries['current_server'] = $current_server;
    $r = count($_REQUEST) ? $_REQUEST : array();
    $queries = array_merge($queries,$_COOKIE, $_GET);
    $q = http_build_query($queries);
    $uri = $dir.'/'.$dirname.'/'.$part.'.php?'.$q;
    return file_get_contents($uri);
}

/*
* () get_header
* Obtiene el header (header.php)
*
* %parent () get_part
*
* @params $queries (array) [default array()] - Parámetros adicionales
* @params $dirname (array) [default 'main'] - Directorio donde vive el header
*
* (string) Devuelve el header evaluado
*/
function get_header($queries= array(), $dirname = 'main'){
    echo get_part('header',$queries,$dirname);
}

/*
* () get_menu
* Obtiene el menú (menu.php)
*
* %parent () get_part
*
* @params $queries (array) [default array()] - Parámetros adicionales
* @params $dirname (array) [default 'main'] - Directorio donde vive el menú
*
* (string) Devuelve el menú evaluado
*/
function get_menu($queries=array(),$dirname = 'main'){
    echo get_part('menu', $queries,$dirname);
}

/*
* () get_header
* Obtiene el footer (footer.php)
*
* %child () get_part
*
* @params $queries (array) [default array()] - Parámetros adicionales
* @params $dirname (array) [default 'main'] - Directorio donde vive el footer
*
* (string) Devuelve el footer evaluado
*/
function get_footer($query = array(), $dirname='main'){
    echo get_part('footer',$query,$dirname);
}



/* Funciones () -> HTML **/

/*
* () get_title
* Obtiene el título formateado
*
* @params $title (string) [default ''] - Título
*
* (string) Devuelve el título formateado, si no se pasa un string regresa el título del sitio
*/
function get_title($title = ''){
  $subfix = SITENAME;
  $middle = ' '.GLOBAL_SEP.' ';
  if($title){
  $o = $title.$middle.$subfix;
  }else{
  $o = $subfix;
  }
  echo $o;
}

/*
* () scriptstyles
* Obtiene un string HTML con scripts y link's de JS y CSS respectivamente
* Para registrar un estilo utilizar $styles['ID del estilo'] = 'URL DEL ESTILO'
* Para registrar un estilo utilizar $scripts['ID del script'] = 'URL DEL SCRIPTS'
* El output se muestra en el mismo orden en el que se registran.
*
* Por default se añaden los siguientes estilos y fuentes:
  -Material Icons
  -Open Sans Font
  -Roboto Font
  -Materialize CSS
  -main.css (Si $isadmin = false. Disponible en assets/css/main.css)
  -admin.css (Si $isadmin = true. Disponible en assets/css/admin.css)
*
* Por default se añaden los siguientes scripts:
  -jQuery
  -Materialize JS (librería básica, se pueden encontrar adicionales en bower_components/materialize)
  -Velocity JS
  -main.js (Si $isadmin = false. Disponible en assets/js/main.js)
  -admin.js (Si $isadmin = true. Disponible en assets/js/admin.js)
*
* @params $isadmin (bool) [default false] - Determina si el header vive en el admin, si es true para el estilo de Admin
* @params $part (string) [default 'head'] - Determina en qué parte del HTML se hace el output del script. Default 'head'.
*
* (string) Devuelve el header evaluado
*/
function scriptsstyles($isadmin = false, $part = 'header'){
    $bower = dir.'/bower_components';
    $styles = array();
    $scripts = array(
      'header'  => array(),
      'footer'  => array()
    );

    $styles['material_icons'] = 'https://fonts.googleapis.com/icon?family=Material+Icons';
    $styles['open'] = 'https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i';
    $styles['roboto'] = 'https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i';
    $styles['mat'] = $bower.'/materialize/bin/materialize.css';

    $scripts['header']['jquery'] = 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js';
    $scripts['footer']['mat'] = $bower.'/materialize/bin/materialize.js';

    $scripts['footer']['velocity'] = $bower.'/velocity/velocity.min.js';


    if($isadmin){
      $styles['admin'] = css.'/admin.css';
      $scripts['footer']['admin'] = js.'/admin.js';
    }else{
      $styles['master'] = css.'/main.css';
      $scripts['footer']['master'] = js.'/main.js';
    }
    $o = '';
    /*
    * Estilos sólo en header
    */
    if($part == 'header'){
      foreach($styles as $key=>$style){
       $o.= '<link rel="stylesheet" type="text/css" href="'.$style.'" name="'.$key.'"/>';
      }
    }

    foreach($scripts[$part] as $key=>$script){
     $o.= '<script  type="text/javascript" name="'.$key.'" src="'.$script.'"></script>';
    }
    return $o;
}

/* Helpers */

/*
* () i
* Busca un elemento en un array
* Previene un error warning si el elemento no existe
*
* @params $element (mixed) [obligatorio] - Elemento
* @params $array (array) [default $_GET] - Haystack
*
* (mixed) Si no existe devuelve (bool) false, si sí existe devuelve el elemento
*/
function i($element, $array = array()){
  if(!count($array)){
    $array = $_GET;
  }
  if(isset($array[$element])){
    return $array[$element];
  }else{
    return false;
  }
}

/*
* () v
* Busca un elemento en un array
* Previene un error warning si el elemento no existe. A diferencia de i() devuelve siempre un string.
*
* %parent () i
*
* @params $element (mixed) [obligatorio] - Elemento
* @params $array (array) [default $_GET] - Haystack
*
* (string) Si no existe devuelve (string) '', si sí existe devuelve el elemento.
*/
function v($element, $array = array()){
  if(!count($array)){
    $array = $_POST;
  }
  $i = i($element, $array);
  return ( $i ? $i : '');
}
