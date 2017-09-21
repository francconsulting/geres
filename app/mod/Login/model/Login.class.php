<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 17/09/2017
 * Time: 10:09
 */

class Login
{
    private static $conn;
    private static $tabla;
    private static $id;

    public function __construct()
    {
    }

    public function  getLogIn(){
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

    private function setConexion(){
        self::$conn =  $GLOBALS{CONN};
        self::$tabla = TABLA;
        self::$id = ID;
    }
}