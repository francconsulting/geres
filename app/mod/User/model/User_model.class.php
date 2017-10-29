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
    use ClassCommon;
    /**
     * Guardar los datos del usuario en la tabla
     */
    private static $conn;
    private static $tabla;
    private static $id;

    private $sEmail;
    private $sTelefono1;
    private $sTelefono2;
    private $sDireccion;
    private $sCodigoPostal;
    private $cGenero;



    public function __construct($sNombre = null, $Apellidos = null , $sPassword = null,
        $aRol = null,  $sEmail = null, $sTelefono1 = null, $sTelefono2 = null,
        $sDireccion = null, $sCodigoPostal = null, $cGenero = null, $sAvatar = null, $idUser=null)
    {

        parent::__construct($sNombre, $Apellidos , $sPassword, $aRol, $cGenero, $sAvatar, $idUser);
        $this->sEmail = $sEmail;
        $this->sTelefono1 = $sTelefono1;
        $this->sTelefono2 = $sTelefono2;
        $this->sDireccion = $sDireccion;
        $this->sCodigoPostal = $sCodigoPostal;
        $this->cGenero = $cGenero;
        $this->setConexion();
    }

    private function setConexion(){
        self::$conn =  $GLOBALS{CONN};
        self::$tabla = TABLA;
        self::$id = ID;
    }

    /**
     * @return null
     */
    public function getEmail()
    {
        return $this->sEmail;
    }

    /**
     * @param null $sEmail
     */
    public function setEmail($sEmail)
    {
        $this->sEmail = $sEmail;
    }

    /**
     * @return mixed
     */
    public function getTelefono1()
    {
        return $this->sTelefono1;
    }

    /**
     * @param mixed $sTelefono1
     */
    public function setTelefono1($sTelefono1)
    {
        $this->sTelefono1 = $sTelefono1;
    }

    /**
     * @return mixed
     */
    public function getTelefono2()
    {
        return $this->sTelefono2;
    }

    /**
     * @param mixed $sTelefono2
     */
    public function setTelefono2($sTelefono2)
    {
        $this->sTelefono2 = $sTelefono2;
    }

    /**
     * @return mixed
     */
    public function getDireccion()
    {
        return $this->sDireccion;
    }

    /**
     * @param mixed $sDireccion
     */
    public function setDireccion($sDireccion)
    {
        $this->sDireccion = $sDireccion;
    }

    /**
     * @return mixed
     */
    public function getCodigoPostal()
    {
        return $this->sCodigoPostal;
    }

    /**
     * @param mixed $sCodigoPostal
     */
    public function setCodigoPostal($sCodigoPostal)
    {
        $this->sCodigoPostal = $sCodigoPostal;
    }

    /**
     * @return null
     */
    public function getGenero()
    {
        return $this->cGenero;
    }

    /**
     * @param null $sGenero
     */
    public function setGenero($cGenero)
    {
        $this->cGenero = $cGenero;
    }





}