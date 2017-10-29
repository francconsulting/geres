<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 16/09/2017
 * Time: 11:51
 */
$GLOBALS["clase"] = ucfirst(str_replace("_controller","",basename(__FILE__,".php")));
define ('timeOut',10);


//define("TABLA","sesiones");
//define("ID", "idSesion");

class sesion_controller
{

    private $oSesion;

    /**
     * sesion_controller constructor.
     */
    public function __construct($idUser, $bSignIn, $dtIn, $dtOut = null)
    {
        // $this->miSesion = Sesion::sesion("pruebaIdSesion", "idUSUARIO", true, "horaInicio", "HoraFin");

        $this->oSesion = new Sesion_model($idUser, $bSignIn, $dtIn);
        // $this->guardarSesion();
        //var_dump($this->oSesion);

    }


    public function setSesion()
    {

    }

    public function getSignIn()
    {
        return $this->oSesion->getSignIn();
    }


    public function guardarSesion()
    {

        $this->oSesion->guardar(false);


        //      var_dump($this->miSesion);
        //  echo $this->miSesion->getTabla();
        return $this->oSesion;
    }

    public function getStatus()
    {
        return $this->oSesion->getStatusSesion($this->oSesion->getIdUser());
    }
}
