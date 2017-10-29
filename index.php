<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 24/08/2017
 * Time: 22:34
 */
$accion ="";

define("PATH",$_SERVER['DOCUMENT_ROOT']);  //TODO raiz del proyecto
define ("MODULO",str_replace("view", "", dirname(__FILE__)));

//libreria con varias funcionalidades comunes a todas las paginas
require_once (PATH.'/geres/app/lib/common.php');

//limpiar las sesiones iniciales
unset($_SESSION['signIn']);
unset($_SESSION['SesionUID']);

//si he pasado por el login
if(isset($_POST['accion'])){
    //apertura de conexion con bd
    require_once(PATH.PROJECT.APP."/db/db.openconex.inc.php");

    //incluir modulo del login
    require_once(PATH.PROJECT.APP."/mod/Login/controller/login_controller.php");
    require_once(PATH.PROJECT.APP."/mod/Login/model/Login.class.php");
    require_once(PATH.PROJECT.APP."/mod/Login/model/Login_model.class.php");

    $accion = $_POST['accion'];

    //accion de signIn
    if ($accion=='acceder'){

        $login = new login_controller();
        $result = $login->getLogeadoDataUser(); //comprobar el usuario del formulario en la bd

        $msg ='usuario o password incorrectos';

        if(!isset( $_SESSION['signIn'])) {  //si no esta establecida la sesion establecerla
            $_SESSION['signIn'] = $login->getLogeadoStatus();  //obtener el estado de logeo  True o False
        }
        // var_dump($_SESSION);
        if(!empty($result)){  //si hay datos en la bd, continuamos con mas comprobaciones

            $valido = $login->getLogeadoPass($_POST['pass'], $result['sPassword']);  //comprobar si los datos del form son correctos

            $_SESSION['signIn'] = $valido; //establecer la sesion

            if ($valido){ //si el acceso es correcto
                array_unshift($result, $result['logado']=true, $result['msg']=null); //añadir al principio del array result estado y mensaje

                $sUsuario =    $result['sNombre']." ".$result['sApellidos'];
                $sesion = Sesion::sesion($result['idUser'], 1, $sUsuario,'SesionUID', date('Y-m-d H:i:s'),$result['sAvatar']);

                Sesion::setSesionObj('SesionUID', $sesion); //crear la variable de sesion y serializarla
                //       print_r(Sesion::getSesionObj('SesionUID'));

            }else{
                //cuando el acceso no es correcto
                unset($result);  //limpiar el array result
                array_push($result, $result['logado']=false,$result['msg']=$msg);  //añadir al principio del array result estado y mensaje
            }
            echo json_encode($result);  //devolver el array result en formato json

        }else{ //si no hay usuario en la bd
            array_push($result, $result['logado']=false,$result['msg']=$msg);     //añadir al principio del array result estado y mensaje
            echo json_encode($result); //devolver el array result en formato json
        }
    //cuando se implemente el poder registrarse el propio usuario  si no esta dado de alta en la bd
    }else if($accion=='registrar') {
        echo json_encode(array(True,"Redirigiendo al registro"));
    }
        ob_end_flush();

     //cerrar la conexion con la bd
        ${CONN} = Db::cerrar();

// si no he pasado por el login
}else {
    //autocargar las librerias css y js necesarioas
    echo Helper::getCss(array('common'));
    echo Helper::getJs(array('js/jQuery-3_2_1', 'js/common', 'js/func_async', 'mod/Login/js/loginjs'));

    //modulo del login
    require_once(PATH . PROJECT . APP . "/mod/Login/controller/login_controller.php");  //todo crear la raiz

   //incluir el formulario inicial
    include(PATH . PROJECT . APP . "/mod/Login/view/modules/" . $GLOBALS["clase"] . "form.php");
}

?>

