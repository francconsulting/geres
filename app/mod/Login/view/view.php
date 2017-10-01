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
    require_once(PATH . PROJECT . APP . "/db/db.openconex.inc.php");
    require_once(PATH . PROJECT . APP . "/mod/Login/controller/login_controller.php");  //todo crear la raiz
    require_once(PATH.PROJECT.APP."/mod/Login/model/Login.class.php");
    require_once(PATH.PROJECT.APP."/mod/Login/model/Login_model.class.php");


    $accion = $_POST['accion'];

    if ($accion=='acceder'){
        require_once(PATH . PROJECT . APP . "/mod/Sesion/controller/sesion_controller.php");
        require_once(PATH.PROJECT.APP."/mod/Sesion/model/Sesion.class.php");
        require_once(PATH.PROJECT.APP."/mod/Sesion/model/Sesion_model.class.php");

           $login = new login_controller();
           $result = $login->getLogeadoDataUser();

            $msg ='usuario o password incorrectos';

       // Sesion::setSesion('signIn', false);

            if(!isset( $_SESSION['signIn'])) {
                $_SESSION['signIn'] = $login->getLogeadoStatus();
            }
 //    var_dump($_SESSION);
            if(!empty($result)){
               // echo implode($result);
              //  array_unshift($result, true);
                $valido = $login->getLogeadoPass($_POST['pass'], $result['sPassword']);
                $_SESSION['signIn'] = $valido;
                if ($valido){

                    array_unshift($result, $result['logado']=true, $result['msg']=null); //TODO cambiar true por metodo que lo obtiene en clase Login


                    $sesion = new sesion_controller($result['idUser'],date('Y-m-d H:i:s'));
                Sesion::setSesionObj('SesionUID', $sesion->getSesionObj());
   //       print_r(Sesion::getSesionObj('SesionUID'));
   //      var_dump($_SESSION);
//TODO  crear aqui variable de sesion

                }else{

                    unset($result);
                    array_push($result, $result['logado']=false,$result['msg']=$msg);  //TODO cambiar false por metodo que lo obtiene en clase Login

                }
                echo json_encode($result);

            }else{
                //echo json_encode(array($result['logado']=false,"El usuario o password incorrectos"));
                array_push($result, $result['logado']=false,$result['msg']=$msg);           //TODO cambiar false por metodo que lo obtiene en clase Login
                echo json_encode($result);
            }

          /*  if (!$_SESSION['signIn']){
                session_unset();
                session_destroy();
            }
          */
          // echo $result->sNombre;

    }else if($accion=='registrar') {
        echo json_encode(array(True,"Redirigiendo al registro"));
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