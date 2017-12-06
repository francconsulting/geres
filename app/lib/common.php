<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 10/09/2017
 * Time: 11:41
 */
ob_start();
session_start();


//evitar almacenar user y pass en la cache del navegador del usuario
header("Expires: Sat, 1 Jan 2000 00:00:00 GMT");//fecha en el pasado
header("Last-Modified: ".gmdate( "D, d M Y H:i:s")."GMT");//siempre modificado
header("Cache-Control: no-cache, must-revalidate");//http/1.1
header ("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");  //http/1.0

//cambiar el limitador del cache a 'private'
session_cache_limiter('private');

//cargar las variables del archivo ini.  //TODO Ver como poner esto lo primero
$cfg = (object) parse_ini_file(PATH.'/geres/app/cfg/config_global.ini',true);
//var_dump($cfg);

define ("PROJECT", $cfg->app['project'] );//directorio del proyecto;
define("APP",$cfg->app['app']);  //directorio de la aplicacion
define("DIRMOD",$cfg->app['mod']);  //directorio de la aplicacion



$aCarpetas = explode(',',$cfg->app['classCommon']);

/**
 * Function para cargar autmaticamente las clases
 * @param $class_name
 */
function cargar_clases($class_name){
    global $aCarpetas;

    foreach ($aCarpetas as $aCarpeta) {
        $archivo = PATH.PROJECT.APP.'/'.$aCarpeta.'/'.str_replace('\\', '/', $class_name).'.php';
       //  echo $archivo."<br />";
        if(is_file($archivo)){
            require_once($archivo);
        }
    }
}
spl_autoload_register('cargar_clases');


?>