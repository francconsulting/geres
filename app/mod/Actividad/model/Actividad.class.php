<?php

/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 23/07/2017
 * Time: 18:04
 */
if(empty(defined("DIRMOD"))){ echo "No está permitida la ejecucion del script";}
class Actividad
{
    //Definición de las propiedades. Coinciden con los nombres de los campo de la tabla usuario
    private $idActividad;
    private $sNombre;
    private $sDescripcion;


    /**
     * Actividad constructor.
     * @param null $sNombre    String, Nombre de la actividad
     * @param null $sDescripcion String, Descripcion de la activiadad
     * @param null $idActividad Integer, identificador de la activadd
     */
    public function __construct($sNombre = null, $sDescripcion = null , $idActividad=null)
    {
        $this->idActividad = $idActividad;
        $this->sNombre = $sNombre;
        $this->sDescripcion = $sDescripcion;
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
     * Obtener el id de la actividad
     * @return int
     */
    public function getIdActividad()
    {
        return $this->idActividad;
    }

    /**
     * Establecer el id de la actividad
     * @param int $idActividad
     */
    public function setIdActividad($idActividad)
    {
        $this->idActividad = $idActividad;
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
     * Obtener la descripcion de la activadad
     * @return string
     */
    public function getDescripcion()
    {
        return $this->sDescripcion;
    }

    /**
     * Establecer la descripcion de la actividad
     * @param string $sActividad
     */
    public function setDescripcion($sActividad)
    {
        $this->sDescripcion = $sActividad;
    }



}