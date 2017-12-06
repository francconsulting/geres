<?php

/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 23/07/2017
 * Time: 18:04
 */
if(empty(defined("DIRMOD"))){ echo "No está permitida la ejecucion del script";}
class User
{
    //Definición de las propiedades. Coinciden con los nombres de los campo de la tabla usuario
    private $idUser;
    private $sNombre;
    private $sApellidos;
    private $sPassword;
    private $aRol;
    private $sAvatar;


    /**
     * User constructor.
     * @param int $idUser
     * @param string $sNombre
     * @param string $Apellidos
     * @param string $sPassword
     * @param string $aRol
     */
    public function __construct($sNombre = null, $Apellidos = null ,
                                $sPassword = null, $aRol = null, $sAvatar = null,  $idUser=null)
    {
        $this->idUser = $idUser;
        $this->sNombre = $sNombre;
        $this->sApellidos = $Apellidos;
        $this->sPassword = $sPassword;
        $this->aRol = $aRol;
        $this->sAvatar = $sAvatar;
    }


    /**
     * Método mágico para establecer a la propiedad un valor
     * @param $clave    propiedad del objeto
     * @param $valor    valor del objeto
     * @return mixed
     */
    public function __set($clave, $valor){ return $this->$clave=$valor; }

    /**
     * Método mágico para obtener las propiedade de los objetos
     * @param $clave    propiedad del objeto
     * @return mixed
     */
    public function __get($clave){ return $this->$clave; }

    /**
     * Obtener un array con las propiedades de la clase
     * @return array
     */
    public function getPropClass(){
        return get_class_vars(__CLASS__);
    }

    /**
     * Obtener array con pares de clave-valor de las propiedades del objeto
     * @return array
     */
    public function getPropObj(){
        return get_object_vars($this);
    }


    /**
     * Obtener el id de usuario
     * @return int
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Establecer el id de usuario
     * @param int $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * Obtener el nombre
     * @return string
     */
    public function getNombre()
    {
        return $this->sNombre;
    }

    /**
     * Establecer el nombre
     * @param string $sNombre
     */
    public function setNombre($sNombre)
    {
        $this->sNombre = $sNombre;
    }

    /**
     * Obtener los apellidos
     * @return string
     */
    public function getApellidos()
    {
        return $this->sApellidos;
    }

    /**
     * Establecer los apellidos
     * @param string $Apellidos
     */
    public function setApellidos($Apellidos)
    {
        $this->sApellidos = $Apellidos;
    }

    /**
     * Obtener el password
     * @return string
     */
    public function getPass()
    {
        return $this->sPassword;
    }

    /**
     * Establecer el password
     * @param string $sPass
     */
    public function setPass($sPass)
    {
        $this->sPassword = $sPass;
    }

    /**
     * Obtener el rol/permisos del usuario
     * @return string
     */
    public function getARol()
    {
        return $this->aRol;
    }

    /**
     * Establecer el rol/permisos del usuario
     * @param string Separados por comas
     */
    public function setARol($aRol)
    {
        $this->aRol = $aRol;
    }

    /**
     * Obtener la ruta de la imagen del avatar
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->sAvatar;
    }

    /**
     * Establecer la ruta de la imagen del avatar
     * @param mixed $sAvatar
     */
    public function setAvatar($sAvatar)
    {
        $this->sAvatar = $sAvatar;
    }


}