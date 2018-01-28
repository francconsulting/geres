<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 24/08/2017
 * Time: 22:34
 */
//ob_start();
//session_start();
//define("PATH",$_SERVER['DOCUMENT_ROOT']);  //TODO raiz del proyecto, QUITADO TEMPORALMENTE
//define ("MODULO",str_replace("view", "", dirname(__FILE__))); //TODO comentado temporalmente
//$cfg = (object) parse_ini_file(PATH.'/geres/app/cfg/config_global.ini');

//require_once (PATH.'/geres/app/lib/common.php'); //TODO quitado tenporalmente

$GLOBALS["clase"] = "User";
//setcookie('COOKIE-SESION',md5(APP.DIRMOD.$GLOBALS["clase"]),-1,'/');
setCookie('PATHMOD',Crypto::cryptoJsAesEncrypt('', APP.DIRMOD."\\".$GLOBALS["clase"]));
// cargar los css y js generales necesarios para el funcionamiento del módulo
echo Helper::getCss(array('common', 'js/jQuery-File-Upload/css'));
echo Helper::getJs(array(
    'js/jQuery-3_2_1',
    'js/common',
    'js/func_async',
    'js/bsValidator/bootstrapValidator.min',
    'js/bsValidator/language/es_ES',
    DIRMOD.'/'.$GLOBALS['clase'].'/js/userjs',
    'js/cryptojs-aes-php-js/aes',
    'js/cryptojs-aes-php-js/aes-json-format'
));

//TODO eliminar hasta el final porque no hace falta
/**********************************************/
//require_once(PATH . PROJECT . APP . "/mod/Sesion/controller/sesion_controller.php");
//require_once(PATH . PROJECT . APP . "/mod/User/controller/user_controller.php");
/*require_once(PATH . PROJECT . APP . "/mod/User/model/User.class.php");
require_once(PATH . PROJECT . APP . "/mod/User/model/User_model.class.php");*/
//require_once(PATH . PROJECT . APP . "/db/db.openconex.inc.php");


//$sesion = new sesion_controller('SesionUID');
//$us = new user_controller();
/*****************************************************/
//TODO hasta aqui eliminar

//vista principal a cargar
include(MODULO . "/view/modules/" . $GLOBALS["clase"] . "lista.php");

//obtener el contenido de la pagina con el formulario popup
$profile = file_get_contents(PATH.PROJECT.APP. DIRTEMPLATE. "/modal_tpl.php", FILE_USE_INCLUDE_PATH);
echo $profile;


ob_end_flush();
/******
 * cerrar conexion con bd
 */
${CONN} = Db::cerrar();

?>

