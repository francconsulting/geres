<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 10/09/2017
 * Time: 11:41
 */

define ("PROJECT", $cfg->project );//directorio del proyecto;
define("APP",$cfg->app);  //directorio de la aplicacion

$aCarpetas = explode(',',$cfg->classCommon);

function cargar_clases($class_name){

    global $aCarpetas;

    foreach ($aCarpetas as $aCarpeta) {
        $archivo = PATH.PROJECT.APP.'/'.$aCarpeta.'/'.str_replace('\\', '/', $class_name).'.php';
        // echo $archivo;
        if(is_file($archivo)){
            require_once($archivo);
        }
    }
}
spl_autoload_register('cargar_clases');

?>