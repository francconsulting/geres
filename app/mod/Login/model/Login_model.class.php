<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 24/09/2017
 * Time: 13:46
 */

class Login_model extends Login
{
    use \DbCommon;

    private static $conn;
    private static $tabla;
    private static $id;

    /**
     * Login_model constructor.
     */
    public function __construct()
    {
        parent::login();
        $this->setConexion();
    }

    private function setConexion(){
        self::$conn =  $GLOBALS{CONN};
        self::$tabla = TABLA;
        self::$id = ID;
    }



    public function  getDataUser(){
        $filtro = ['nombre' => $_POST['usuario']];
        $ssql = "select * from " . self::$tabla . " where sNombre = :nombre";

        $rs = $this->getRow($ssql,$filtro);
        if(!empty($rs)) {
            $this->setLogeado(true);
        } else {
            $this->setLogeado(false);
        }
        return $rs;

    }

    public function verifPass($input_pass, $rs_pass){
        $valido = password_verify($input_pass, $rs_pass);
        $this->setLogeado($valido);
        return $valido;

    }
}