<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 16/08/2017
 * Time: 20:58
 *
 * vista del modulo user
 */
define("PATH", $_SERVER['DOCUMENT_ROOT']);  //TODO raiz del proyecto
//require_once("/app/lib/cabecera.php");
require_once(PATH . '/geres/app/lib/common.php');  //TODO ver como hacer esto global
require_once(PATH.PROJECT.APP."/lib/cabecera.php");
require_once(PATH . PROJECT . APP . "/mod/Sesion/controller/sesion_controller.php");
require_once(PATH . PROJECT . APP . "/db/db.openconex.inc.php");

$sesion = new sesion_controller('SesionUID');
//cargar la vista del modulo pasado por POST cuando se ha realizado el envio de formulario
define("MODULO", PATH . PROJECT . APP . DIRMOD . "/" . $_POST['hmod']);
//TODO PARA ELIMINAR DESDE AQUI
/********************************
if (!empty($_POST)) {
   // require_once("/app/mod/" . $_POST['hmod'] . "/view/view.php"); //TODO el original
}
 ************************************/
//TODO eliminad hasta aqui

//cargar el dashboard
    require_once(PATH . PROJECT . APP . DIRTEMPLATE. "/tpl.php");


// TODO include_once (PATH . PROJECT . APP ."/lib/footerForm.php");
ob_end_flush();
/******
 * cerrar conexion con bd
 */
${CONN} = Db::cerrar();
?>
