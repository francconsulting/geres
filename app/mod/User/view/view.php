<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 24/08/2017
 * Time: 22:34
 */
ob_start();
//session_start();
//define("PATH",$_SERVER['DOCUMENT_ROOT']);  //TODO raiz del proyecto, QUITADO TEMPORALMENTE
//define ("MODULO",str_replace("view", "", dirname(__FILE__))); //TODO comentado temporalmente
//$cfg = (object) parse_ini_file(PATH.'/geres/app/cfg/config_global.ini');

//require_once (PATH.'/geres/app/lib/common.php'); //TODO quitado tenporalmente


echo Helper::getCss(array('common','js/jQuery-File-Upload/css'));
echo Helper::getJs(array('js/jQuery-3_2_1','js/common',
                            'js/func_async',
                            'js/bsValidator/bootstrapValidator.min',
                            'js/bsValidator/language/es_ES',
                            'mod/User/js/userjs'
));


require_once(PATH . PROJECT . APP . "/mod/Sesion/controller/sesion_controller.php");

require_once (PATH.PROJECT.APP."/mod/User/controller/user_controller.php");
require_once(PATH.PROJECT.APP."/mod/User/model/User.class.php");
require_once(PATH.PROJECT.APP."/mod/User/model/User_model.class.php");

require_once(PATH.PROJECT.APP."/db/db.openconex.inc.php");

$sesion = new sesion_controller('SesionUID');
$us = new user_controller();

if(isset($_POST['accion']) && $sesion->getSignIn()){

   // $sesion->gestionarSesiones();
    $accion = $_POST['accion'];

    if ($accion=='del'){
        //  $us->borrarUser();
    }

    if ($accion=='ver'){
        $rs = $us->getuserForm($_POST['idUser']);
    }

   // $rs = $us->getUserIdObj(303);

$rows = $us->getUserAllObj();
    if (!empty($rows)) {
        //TODO si no hay registro no muestra nada, en el include tambien esta controlado. Decidir si en uno en otro
        include(MODULO . "/view/modules/" . $GLOBALS["clase"] . "module2.php");
    }


}else {

    if (isset($_POST['haccion']) && $_POST['haccion'] == "registrar") {
        include(MODULO . "/view/modules/" . $GLOBALS["clase"] . "form.php");
        echo $_POST['haccion'];
    }
    if(!$sesion->getSignIn()){
        echo "sesion caducada";
    }
    $rows = $us->getUserAllObj();
    $rowsArray = $us->getUserAll(PDO::FETCH_ASSOC);
   // var_dump(($rows));


    foreach ($rowsArray as $item) {
        $datos[] = ($item);
    }
    $data=array("data" => ($datos));
   // echo (json_encode($data));
 //   include(MODULO . "/view/modules/datos.php");
}
//$us->guardarUser();
?>

<?php
//include(MODULO . "/view/modules/" . $GLOBALS["clase"] . "form.php");
$profile = file_get_contents(MODULO . "/view/modules/" .$GLOBALS["clase"] . "form.php",FILE_USE_INCLUDE_PATH);
echo $profile;
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

