<?php
define("PATH",$_SERVER['DOCUMENT_ROOT']);  //TODO raiz del proyecto
require_once (PATH.'/geres/app/lib/common.php');
require(PATH.PROJECT.APP."/db/Db.php");

require_once (PATH.PROJECT.APP."/mod/residente/controller/residente_controller.php");  //todo crear la raiz
require_once(PATH.PROJECT.APP."/mod/User/model/User.class.php");
require_once(PATH.PROJECT.APP."/mod/User/model/User_model.class.php");

require_once(PATH.PROJECT.APP."/db/db.openconex.inc.php");


$us = new residente_controller();


if(!isset($_POST['accion'])) {
    $rowsArray = $us->getUserAll(PDO::FETCH_ASSOC);
    $data['data'] = '';
    if($rowsArray) {
        $i = 1;
        foreach ($rowsArray as $item) {
            array_unshift($item, $item['num'] = $i);
            $datos[] = $item;
            $i += 1;
        }
        //$data = array("data" => $datos);
        $data['data'] = $datos;
    }
    echo(json_encode($data));
}else{

        if ($_POST['accion'] == 'del') {
            $us->borrarUser();
            $datos['exito'] = true;
            echo json_encode($datos);
        }
        if ($_POST['accion'] == 'update') {
            //  $datos = (object) $_POST['datos'];
            if ($_POST['idUser'] == '') {
                $us->guardarUser($_POST['sNombre'], $_POST['sApellidos'], crypt($_POST['sPassword'], Util::getSalt()),
                    $_POST['aRol'],
                    $_POST['sEmail'], $_POST['sTelefono1'], $_POST['sTelefono2'], $_POST['sDireccion'],
                    $_POST['sCodigoPostal'], $_POST['cGenero']);

                //$us->registrarUser($_POST['sNombre'],$_POST['sApellidos'],crypt($_POST['sPassword'],Util::getSalt()), $_POST['aRol'],$_POST['sEmail'],null);
                $datos['exito'] = true;
                // var_dump($datos);
            } else {
                $us->actualizarUser();
                $datos['exito'] = true;
            }
            echo json_encode($datos);
        }

    if ($_POST['accion'] == 'upload') {
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {

            //obtenemos el archivo a subir
            $file = $_FILES['fAvatar']['name'];

            //comprobamos si existe un directorio para subir el archivo
            //si no es así, lo creamos
            if(!is_dir(PATH.PROJECT.APP."/images/avatar/"))
                mkdir(PATH.PROJECT.APP."/images/avatar/", 0777);

            //comprobamos si el archivo ha subido
            if ($file && move_uploaded_file($_FILES['fAvatar']['tmp_name'],PATH.PROJECT.APP."/images/avatar/".$file))
            {
                sleep(3);//retrasamos la petición 3 segundos
               // echo $file;//devolvemos el nombre del archivo para pintar la imagen
                $datos['exito'] = true;
                $datos['avatar'] = PROJECT.APP."/images/avatar/".$file;
            }
        }else{
            throw new Exception("Error Processing Request", 1);
        }

        echo json_encode($datos);
    }
}
/*var_dump($_POST);
var_dump($_FILES);*/
?>