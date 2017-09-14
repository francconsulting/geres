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

$cfg = (object) parse_ini_file(PATH.'/gestrest/app/cfg/config_global.ini');
require_once (PATH.'/gestrest/app/lib/common.php');






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
echo Helper::getJs(array('js/jQuery-3_2_1','js/common','js/func_async','mod/User/js/userjs'));







require_once (PATH.PROJECT.APP."/mod/User/controller/user_controller.php");  //todo crear la raiz
require_once(PATH.PROJECT.APP."/mod/User/model/User.class.php");
require_once(PATH.PROJECT.APP."/mod/User/model/User_model.class.php");

require_once(PATH.PROJECT.APP."/db/db.openconex.inc.php");
//echo Util::VariablesServidor();

$us = new user_controller();



/*

     $doc = file_get_contents("index.php");
     $dom = new DOMDocument();
     $dom->loadHTML($doc);
$html = $dom->getElementsByTagName('html');
$html = $html->item(0);
     $head = $dom->getElementsByTagName('head');

     $head = $head->item(0);
     $link = new DOMElement("link");
     $html->insertBefore($link);
     $link->setAttribute('href', 'http://localhost/gestrest/app/css/common.css');
     $link->setAttribute('rel', 'stylesheet');

     $link = $dom->getElementsByTagName('link');
     $link = $link->item(0);

     echo $dom->saveHTML();
*/



//crear vista y cargar plantilla
//$view = new view('mi usuario');


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
$rs = $us->getUserAllObj(5,15);
//}









//$rs = $us->getuserForm();
/*
var_dump($_POST);
var_dump(empty($_POST['txtNombre']));
if (!empty($_POST)){
    if(!empty($_POST['idUser'])){
       // $us->borrarUser();
        $us->eliminarUser();
    }
    if(!empty($_POST['txtNombre'])) {
        $us->guardarUser();
    }
}else{
    $us->getUserAllObj();
}
*/


//$pag = $view->load_content($rs); //cargar el contenido
//$view->render($pag);                //render (mostrar) el contenido



ob_end_flush();
/******
 * cerrar conexion con bd
 */
${CONN}=Db::cerrar();










?>