<?php

/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 30/07/2017
 * Time: 14:11
 */

class User_model extends User
{
    use DbCommon;
    /**
     * Guardar los datos del usuario en la tabla
     */
    private static $conn;
    private static $tabla;
    private static $id;

    public function __construct($sNombre = null, $Apellidos = null , $sPassword = null,
        $aRol = null, $idUser=null)
    {

        parent::__construct($sNombre, $Apellidos , $sPassword, $aRol, $idUser);

        $this->setConexion();
    }

    private function setConexion(){
        self::$conn =  $GLOBALS{CONN};
        self::$tabla = TABLA;
        self::$id = ID;
    }



}