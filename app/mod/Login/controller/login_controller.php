<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 16/09/2017
 * Time: 11:51
 */
$GLOBALS["clase"] = ucfirst(str_replace("_controller","",basename(__FILE__,".php")));

define("TABLA","User");
define("ID", "idUser");

class login_controller
{
    private static $conn;
    private static $tabla;
    private static $id;

    public function getLogin(){
        $filtro = ['nombre' => $_POST['usuario']];
        self::setConexion();
        $ssql = "select * from " . self::$tabla . " where sNombre = :nombre";
        $rs = self::$conn->select($ssql,$filtro);
        if ($rs) {
            $rs = $rs->fetch(PDO::FETCH_ASSOC);
        }
        else {
            $rs =  null;
        }
             //return json_encode($rs);
             return ($rs);
    }

    public function verifPass(){

    }

    private function setConexion(){
        self::$conn =  $GLOBALS{CONN};
        self::$tabla = TABLA;
        self::$id = ID;
    }
}


