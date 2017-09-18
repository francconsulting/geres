<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 24/08/2017
 * Time: 22:34
 */
ob_start();
$accion ="";

define("PATH",$_SERVER['DOCUMENT_ROOT']);  //TODO raiz del proyecto
define ("MODULO",str_replace("view", "", dirname(__FILE__)));

$cfg = (object) parse_ini_file(PATH.'/geres/app/cfg/config_global.ini');
require_once (PATH.'/geres/app/lib/common.php');

//echo Util::VariablesServidor();
if(isset($_POST['accion'])){
    require_once(PATH . PROJECT . APP . "/mod/Login/controller/login_controller.php");  //todo crear la raiz
    /*require_once(PATH.PROJECT.APP."/mod/Login/model/Login.class.php");
    require_once(PATH.PROJECT.APP."/mod/Login/model/Login_model.class.php");
    */
    require_once(PATH . PROJECT . APP . "/db/db.openconex.inc.php");
    $accion = $_POST['accion'];

    if ($accion=='acceder'){
           $login = new login_controller();
           $result =  $login->getLogin();
            if(!empty($result)){
                array_unshift($result, true);
                echo json_encode($result);

               // password_verify($password, $hash);
            }else{
                echo json_encode(array(false,"El usuario o password incorrectos"));
            }

          // echo $result->sNombre;

    }

}else {


    echo Helper::getCss(array('common'));
    echo Helper::getJs(array('js/jQuery-3_2_1', 'js/common', 'js/func_async', 'mod/Login/js/loginjs'));


    require_once(PATH . PROJECT . APP . "/mod/Login/controller/login_controller.php");  //todo crear la raiz
    /*require_once(PATH.PROJECT.APP."/mod/Login/model/Login.class.php");
    require_once(PATH.PROJECT.APP."/mod/Login/model/Login_model.class.php");
    */
    require_once(PATH . PROJECT . APP . "/db/db.openconex.inc.php");



//if(!empty($rows)) {             //TODO si no hay registro no muestra nada, en el include tambien esta controlado. Decidir si en uno en otro
    include(MODULO . "/view/modules/" . $GLOBALS["clase"] . "form.php");

    ob_end_flush();
    /******
     * cerrar conexion con bd
     */
    ${CONN} = Db::cerrar();
}


?>