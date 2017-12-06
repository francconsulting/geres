<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 04/11/2017
 * Time: 12:58
 */

define("PATH",$_SERVER['DOCUMENT_ROOT']);  //TODO raiz del proyecto
require_once (PATH.'/geres/app/lib/common.php');
require(PATH.PROJECT.APP."/db/Db.php");

require_once(PATH.PROJECT.APP."/db/db.openconex.inc.php");

require_once(PATH . PROJECT . APP . "/mod/Sesion/controller/sesion_controller.php");
$sesion = new sesion_controller('SesionUID');

$datos = array("signIn"=>$sesion->getSignIn());
echo json_encode($datos);