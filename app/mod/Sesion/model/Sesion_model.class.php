<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 25/09/2017
 * Time: 18:30
 */

class Sesion_model extends Sesion
{

    use DbCommon;

    private static $conn;
    private static $tabla = "sesiones";
    private static $id = "idSesion";


    public function __construct($idUser, $signIn, $dtIn, $dtOut = null, $idSesion =null)
    {

        $this->idSesion = $idSesion;
        $this->idUser = $idUser;
        $this->setSignIn($signIn);
        $this->dtIn = $dtIn;
        $this->dtOut = $dtOut;
        $this->setConexion();
        //return $oSesion;


    }


    private function setConexion()
    {
        self::$conn = $GLOBALS{CONN};
        // self::$tabla = TABLA;
        // self::$id = ID;
        // self::$tabla = self::TABLA;
        // self::$id = self::ID;

    }

    public function  getStatusSesion($id){
        $filtro = ['idUser' => $id];
        $ssql = "select * from " . self::$tabla . " where idUser = :idUser and signIn = 1";

        $rs = $this->getRow($ssql,$filtro);
        if(!empty($rs)) {
            $this->setSignIn(true);
        } else {
            $this->setSignIn(false);
        }
        //return $rs;
        return $this->getSignIn();
    }
}