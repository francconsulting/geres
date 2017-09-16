<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 16/09/2017
 * Time: 12:22
 */

class Sesion_model extends Sesion
{
    use DbCommon;

    private static $conn;
    private static $tabla;



    public function __construct($idSesion, $idUser,$signIn,$dtIn, $dtOut)
    {
        parent::sesion($idSesion, $idUser,$signIn,$dtIn, $dtOut);
        self::setConexion();
    }



    private function setConexion(){
        self::$conn =  $GLOBALS{CONN};
        self::$tabla = TABLA;
    }
}