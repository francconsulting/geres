<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 03/08/2017
 * Time: 22:00
 */

define("CONN", "conn");  //definicion del nombre de la varible

${CONN} = Db::conex(); //Apertura de la conexion

if (empty(${CONN}->getConn())){

    if(isset($_POST['accion'])) {
        $msg = "Error: no se ha podido conectar con la base de datos";
        array_push($result, $result['logado'] = false, $result['msg'] = $msg);
        echo json_encode($result);
        die();
    }
    /*
      die ("<div class=\"alert alert-danger alert-dismissible\">Error: no se ha podido conectar con la base de datos.<br/>".${CONN}->getErrorConn()."</div>");
    */
}

 ?>