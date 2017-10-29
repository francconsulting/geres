<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 12/10/2017
 * Time: 11:22
 */
define("PATH",$_SERVER['DOCUMENT_ROOT']);  //TODO raiz del proyecto
define ("MODULO",str_replace("view", "", dirname(__FILE__)));

require_once (PATH.'/geres/app/lib/common.php');
require_once(PATH . PROJECT . APP . "/mod/Sesion/controller/sesion_controller.php");
require_once(PATH.PROJECT.APP."/db/db.openconex.inc.php");

$sesion = new sesion_controller('SesionUID');
$sesion->signOutSesion();
header("Location:index.php");
?>