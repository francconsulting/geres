<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 24/08/2017
 * Time: 22:34
 */
ob_start();


define("PATH",$_SERVER['DOCUMENT_ROOT']);  //TODO raiz del proyecto
define ("MODULO",str_replace("view", "", dirname(__FILE__)));

$cfg = (object) parse_ini_file(PATH.'/geres/app/cfg/config_global.ini');
require_once (PATH.'/geres/app/lib/common.php');


/*$carpetas = array('db','lib');
define("CARPETAS", json_encode($carpetas));
function cargar_clases($class_name){
    $aCarpetas = json_decode(CARPETAS);
    foreach ($aCarpetas as $aCarpeta) {
        $archivo = PATH.PROJECT.APP.'/'.$aCarpeta.'/'.str_replace('\\', '/', $class_name).'.php';
       // echo $archivo;
        if(is_file($archivo)){
            require_once($archivo);
        }
    }
}
spl_autoload_register('cargar_clases');
*/

echo Helper::getCss(array('common'));
echo Helper::getJs(array('js/jQuery-3_2_1','js/common','js/func_async'));


require_once (PATH.PROJECT.APP."/mod/Sesion/controller/Sesion_controller.php");
require_once(PATH.PROJECT.APP."/mod/Sesion/model/Sesion.class.php");



require_once(PATH.PROJECT.APP."/db/db.openconex.inc.php");
//echo Util::VariablesServidor();
//if (!isset($sesion)) {
$sesion = new sesion_controller();
var_dump($sesion);
var_dump($sesion->getSignIn());
$sesion->guardarSesion();

    echo "   hola:".$sesion->getSignIn();

//}
var_dump($sesion);
echo "Sesion:". $sesion->getSignIn();


    /*
if(isset($_POST['accion'])){
    $accion = $_POST['accion'];

    if ($accion=='del'){
        $us->borrarUser();
        //$rs = $us->getUserAllObj();
    }
    if ($accion=='ver'){
        $rs = $us->getuserForm($_POST['idUser']);
    }

   // $rs = $us->getUserIdObj(303);
}//else{
$rows = $us->getUserAllObj(5,5);

if(!empty($rows)) {             //TODO si no hay registro no muestra nada, en el include tambien esta controlado. Decidir si en uno en otro
    include(MODULO . "/view/modules/" . $GLOBALS["clase"] . "module.php");
}

//}

*/


ob_end_flush();
/******
 * cerrar conexion con bd
 */
${CONN}=Db::cerrar();










?>