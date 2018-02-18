<?php

/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 30/07/2017
 * Time: 14:11
 */
//Control para evitar ejecutar el script directamente
if(empty(defined("DIRMOD"))){ echo "No está permitida la ejecucion del script";}
class Actividad_model extends Actividad

{
    //metodos genericos, comunes a todas las clases
    use DbCommon;
    use ClassCommon;

    // Definicion de variables genericas usada en el trait DbCommon
    private static $conn;
    private static $tabla;
    private static $id;

    //Definicion de variables de la clase  //TODO Eliminar estas variables
    private $sEmail;
    private $sTelefono1;
    private $sTelefono2;
    private $sDireccion;
    private $sCodigoPostal;
    private $cGenero;



    public function __construct($sNombre = null, $sDescripcion = null , $idActividad = null)
    {
        //llamada al constructor padre
        parent::__construct($sNombre, $sDescripcion, $idActividad);

        $this->setConexion(); //conexion en el trait DbCommon
    }





}