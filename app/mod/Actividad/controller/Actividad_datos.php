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
    require_once (PATH.PROJECT.APP."/mod/Actividad/controller/Actividad_controller.php");
    require_once(PATH.PROJECT.APP."/mod/Actividad/model/Actividad.class.php");
    require_once(PATH.PROJECT.APP."/mod/Actividad/model/Actividad_model.class.php");

    $actividad = new Actividad_controller();
    $datos["signIn"] = $sesion->getSignIn();
    $datos['exito'] = false;

    if (!isset($_POST['accion'])) { //cuando se realiza la carga de la pagina
        $rowsArray = $actividad->getActivityAll(PDO::FETCH_ASSOC); //obtener todos los usuario de la tabla
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
            if(!empty($actividad->borrarActividad())) {
                $datos['exito'] = true;
            }
        }
        if ($_POST['accion'] == 'update') { //accion para insertar/actualizar usuario
            //si no se recoge id de usuario es insert
            if ($_POST['idActividad'] == '') {
                if(!empty($actividad->guardarActividad($_POST['sNombre'], $_POST['sDescripcion']))) {
                    $datos['exito'] = true;
                }
            }
            // cuando lleva un id del formulario estamos actualizando
            else {
                if (!empty($actividad->actualizarActividad())) {
                    $datos['exito'] = true;
                }
            }
            //   var_dump($datos);
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