<?php

/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 30/07/2017
 * Time: 14:11
 */
//Control para evitar ejecutar el script directamente
if(empty(defined("DIRMOD"))){ echo "No está permitida la ejecucion del script";}
class User_model extends User

{
    //metodos genericos, comunes a todas las clases
    use DbCommon;
    use ClassCommon;

    // Definicion de variables genericas usada en el trait DbCommon
    private static $conn;
    private static $tabla;
    private static $id;

    //Definicion de variables de la clase
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
        //llamada al constructor padre
        parent::__construct($sNombre, $Apellidos , $sPassword, $aRol,  $sAvatar, $idUser);
        $this->sEmail = $sEmail;
        $this->sTelefono1 = $sTelefono1;
        $this->sTelefono2 = $sTelefono2;
        $this->sDireccion = $sDireccion;
        $this->sCodigoPostal = $sCodigoPostal;
        $this->cGenero = $cGenero;
        $this->setConexion();
    }

    /**
     * Obtener el email
     * @return mixed
     */
    public function getEmail()
    {
        return $this->sEmail;
    }

    /**
     * Establecer  el email
     * @param String|null $sEmail
     */
    public function setEmail($sEmail)
    {
        $this->sEmail = $sEmail;
    }

    /**
     * Obtener el telefono1
     * @return mixed
     */
    public function getTelefono1()
    {
        return $this->sTelefono1;
    }

    /**
     * Establecer el telefono1
     * @param mixed $sTelefono1
     */
    public function setTelefono1($sTelefono1)
    {
        $this->sTelefono1 = $sTelefono1;
    }

    /**
     * Obtener el telefono2
     * @return mixed
     */
    public function getTelefono2()
    {
        return $this->sTelefono2;
    }

    /**
     * Establecer el telefono2
     * @param mixed $sTelefono2
     */
    public function setTelefono2($sTelefono2)
    {
        $this->sTelefono2 = $sTelefono2;
    }

    /**
     * Obtener la direccion
     * @return mixed
     */
    public function getDireccion()
    {
        return $this->sDireccion;
    }

    /**
     * Establecer la direccion
     * @param mixed $sDireccion
     */
    public function setDireccion($sDireccion)
    {
        $this->sDireccion = $sDireccion;
    }

    /**
     * Obtener el codigo postal
     * @return mixed
     */
    public function getCodigoPostal()
    {
        return $this->sCodigoPostal;
    }

    /**
     * Establecer el codigo postal
     * @param mixed $sCodigoPostal
     */
    public function setCodigoPostal($sCodigoPostal)
    {
        $this->sCodigoPostal = $sCodigoPostal;
    }

    /**
     * Obtener el genero
     * @return null
     */
    public function getGenero()
    {
        return $this->cGenero;
    }

    /**
     * Establecer el genero
     * @param null $sGenero
     */
    public function setGenero($cGenero)
    {
        $this->cGenero = $cGenero;
    }





}