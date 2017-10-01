<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 16/09/2017
 * Time: 11:51
 */
$GLOBALS["clase"] = ucfirst(str_replace("_controller", "", basename(__FILE__, ".php")));
define('timeOut', 10);


//define("TABLA","sesiones");
//define("ID", "idSesion");

class sesion_controller
{


    use DbCommon;

    private $oSesion;
    private static $conn;
    private static $tabla = "sesiones";
    private static $id = "idSesion";

    /**
     * sesion_controller constructor.
     */
    public function __construct($idUser, $dtIn, $bSignIn = null, $dtOut = null)
    {
        // $this->miSesion = Sesion::sesion("pruebaIdSesion", "idUSUARIO", true, "horaInicio", "HoraFin");

        $this->oSesion = Sesion::sesion($idUser, $dtIn, $bSignIn = null, $dtOut = null);
        // $this->guardarSesion();
        $this->setConexion();
        $this->gestionarSesiones();
    }


    private function setConexion()
    {
        self::$conn = $GLOBALS{CONN};
        // self::$tabla = TABLA;
        // self::$id = ID;
        // self::$tabla = self::TABLA;
        // self::$id = self::ID;

    }

    public function gestionarSesiones()
    {
        $this->updateAllSesion(); //actualizar todas las sesiones de los usuarios en la tabla

        if ($this->getStatusSesion($this->oSesion->getIdUser())) {
            $hora = $this->oSesion->getDtIn();
            $intervalo = strtotime(date('Y-m-d H:i:s')) - strtotime($hora);
            if ($intervalo > timeOut) {
                //TODO ->si vengo del index o del login
                if (!isset($_SESSION['signIn'])) {
                    //actualizar sesion
                    $this->oSesion->setDtIn(date('Y-m-d H:i:s'));
                    $this->updateSesion($this->oSesion->getIdUser());
                    //todo crear variable de sesion
                } else {      //si  he cargado una pagina cualquiera
                    $this->oSesion->setSignIn(0); //logado false
                    $this->oSesion->setDtOut(date('Y-m-d H:i:s'));
                    $this->updateSesion($this->oSesion->getIdUser());

                    // $this->guardar(false);
                    //todo redirigir al index
                }


            } else {
                //Todo ->no ha caducado la sesion  por tanto hay que actualizar
                $this->oSesion->setDtIn(date('Y-m-d H:i:s'));
                $this->oSesion->setDtOut(null);
                $this->updateSesion($this->oSesion->getIdUser());
            }

        } else {
            //TODO ->si vengo del index o del login
            if (!isset($_SESSION['signIn'])) {
                $this->oSesion->setSignIn(1);
                $this->oSesion->setDtIn(date('Y-m-d H:i:s'));
                $this->newSesion($this->oSesion->getIdUser());
            } else {
                //todo redirigir al index
            }
        }

    }

    public function getStatusSesion($id)
    {
        $filtro = ['idUser' => $id];
        $ssql = "select * from " . self::$tabla . " where idUser = :idUser and signIn = 1";

        $rs = $this->getRow($ssql, $filtro);

        if (!empty($rs)) {
            echo "aqui ".$rs['signIn'];
            $this->oSesion->setSignIn($rs['signIn']);
            $this->oSesion->setDtIn(date('Y-m-d H:i:s'));
        } else { //no tiene sesion activa
            session_unset();
            session_destroy();
            $this->oSesion->setSignIn(0);
            $this->oSesion->setDtIn(date('Y-m-d H:i:s'));
        }
        //return $rs;
        return $this->oSesion->getSignIn();
    }

    public function updateSesion($id)
    {
        $filtro = [
            'idUser' => $id,
            'dtOut'  => 'isNull'
        ];
        $parametros = [
            'dtOut'  => $this->getDtOut(),
            'signIn' => $this->getSignIn(),
            'dtIn'   => $this->getDtIn()
        ];

        $rs = self::$conn->update(self::$tabla, $parametros, $filtro);

        var_dump($rs);
    }

    public function newSesion($id)
    {

        $parametros = [
            'dtIn'   => $this->getDtIn(),
            'signIn' => $this->getSignIn(),
            'idUser' => $id
        ];

        $rs = self::$conn->insert(self::$tabla, $parametros);
    }


    public function updateAllSesion()
    {
        $parametros = [
            'dtOut'  => date('Y-m-d H:i:s'),
            'signIn' => 0,
        ];
        //$rs = self::$conn->update(self::$tabla, $parametros ,$filtro);

        $ssql = "Update sesiones Set dtOut = :dtOut, signIn = :signIn where (TIMESTAMPDIFF(SECOND,dtIn,NOW()))>" . timeOut . " and isNull(dtOut)";

        $rst = self::$conn->getConn()->prepare($ssql);
        foreach ($parametros as $k => $v) {
            $rst->bindParam(":{$k}", $parametros[$k]); //para usar el parametro KEY ($k)
        }
        var_dump($rst->execute());
    }

    public function getSignIn()
    {
        return $this->oSesion->getSignIn();
    }

    public function getDtIn()
    {
        return $this->oSesion->getDtIn();
    }

    public function getDtOut()
    {
        return $this->oSesion->getDtOut();
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
