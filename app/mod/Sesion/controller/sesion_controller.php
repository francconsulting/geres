<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 16/09/2017
 * Time: 11:51
 */
$GLOBALS["clase"] = ucfirst(str_replace("_controller","",basename(__FILE__,".php")));

define("TABLA","sesiones");
define("ID", "idSesion");

class sesion_controller
{
    private $miSesion;

    /**
     * sesion_controller constructor.
     */
    public function __construct(){
       // $this->miSesion = Sesion::sesion("pruebaIdSesion", "idUSUARIO", true, "horaInicio", "HoraFin");
        $this->guardarSesion();
    }


    public function setSesion(){

    }

    public function getSignIn(){
        return $this->miSesion->getSignIn();
    }

    public function guardarSesion(){
        $usu = Sesion::sesion("pruebaIdSesion", "idUSUARIO", true, "horaInicio", "HoraFin");
        $usu->guardar();
        //$this->getUserAllObj();
    }
}
