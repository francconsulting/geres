<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 05/11/2017
 * Time: 11:19
 *
 * Proposito: Devolver los datos, normalmente bajo peticiones Ajax
 */

/** Establecer Constantes y carga de clases generales. */
define("PATH",$_SERVER['DOCUMENT_ROOT']);  //TODO raiz del proyecto
require_once (PATH.'/geres/app/lib/common.php');
/**  --------------//-------------------  */

/** Clases de acceso a datos */
require_once(PATH.PROJECT.APP."/db/Db.php");
require_once(PATH.PROJECT.APP."/db/db.openconex.inc.php");
/** -----------------//--------------------- */

require_once(PATH . PROJECT . APP . "/mod/Sesion/controller/sesion_controller.php");
$sesion = new sesion_controller('SesionUID');

$datos = array();

if($sesion->getSignIn()) {  //si esta logado el usuario

    /** carga de clases para manipular usuarios */
    require_once (PATH.PROJECT.APP."/mod/User/controller/user_controller.php");
    require_once(PATH.PROJECT.APP."/mod/User/model/User.class.php");
    require_once(PATH.PROJECT.APP."/mod/User/model/User_model.class.php");

    $usuario = new user_controller();
    $datos["signIn"] = $sesion->getSignIn();
    $datos['exito'] = false;

    if (!isset($_POST['accion'])) { //cuando se realiza la carga de la pagina
        $rowsArray = $usuario->getUserAll(PDO::FETCH_ASSOC); //obtener todos los usuario de la tabla
        //usar el bucle para añadirle un elemento con la numeracion de orden al array de cada registro
        $items =  [];
        if (!empty($rowsArray)) {
            $i = 1;
            foreach ($rowsArray as $item) {
                array_unshift($item, $item['num'] = $i);
                $items[] = $item;
                $i += 1;
            }
        }
        $datos['exito'] = true;
        $datos['data'] = $items;

        //  $datos['data'] = $rowsArray;  //si no se usa la numeracion se puede usar esta linea y eliminar el bucle anterior

    } else {
        if ($_POST['accion'] == 'del') { //accion para borrar usuario
            if(!empty($usuario->borrarUser())) {
                $datos['exito'] = true;
            }
        }
        if ($_POST['accion'] == 'update') { //accion para insertar/actualizar usuario
            //si no se recoge id de usuario es insert
            if ($_POST['idUser'] == '') {
                if(!empty($usuario->guardarUser($_POST['sNombre'], $_POST['sApellidos'], crypt($_POST['sPassword'], Util::getSalt()),
                    $_POST['aRol'], $_POST['sEmail'], $_POST['sTelefono1'], $_POST['sTelefono2'], $_POST['sDireccion'],
                    $_POST['sCodigoPostal'], $_POST['cGenero'], $_POST['sAvatar']))) {
                    $datos['exito'] = true;
                }
            }
            // cuando lleva un id del formulario estamos actualizando
            else {
                if (!empty($usuario->actualizarUser())) {
                    $datos['exito'] = true;
                }
            }

              // var_dump($_POST);
        }

        //accion para cargar la imagen del avatar
        if ($_POST['accion'] == 'upload') {
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

                //obtenemos el archivo a subir
                $file = $_FILES['fAvatar']['name'];

                //comprobamos si existe un directorio para subir el archivo
                //si no es así, lo creamos
                if (!is_dir(PATH . PROJECT . APP . "/images/avatar/")) {
                    mkdir(PATH . PROJECT . APP . "/images/avatar/", 0777); //le damos todos los permisos
                }

                //comprobamos si el archivo ha subido
                if ($file && move_uploaded_file($_FILES['fAvatar']['tmp_name'],
                        PATH . PROJECT . APP . "/images/avatar/" . $file)) {
                    sleep(3);//retrasamos la petición 3 segundos
                    // echo $file;//devolvemos el nombre del archivo para pintar la imagen
                    $datos['exito'] = true;
                    $datos['avatar'] = PROJECT . APP . "/images/avatar/" . $file;
                }
            } else {
                throw new Exception("Error al procesar la petición", 1);
            }
        }
    }
}else{
    // $datos = array("signIn"=>$sesion->getSignIn());
    $datos['signIn'] = $sesion->getSignIn();
    $datos['exito'] = false;

}
echo json_encode($datos);
/*var_dump($_POST);  var_dump($_FILES);*/
?>