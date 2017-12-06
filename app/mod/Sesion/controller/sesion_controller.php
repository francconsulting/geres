<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 16/09/2017
 * Time: 11:51
 */
if(empty(defined("DIRMOD"))){ echo "No está permitida la ejecucion del script";}
$GLOBALS["clase"] = ucfirst(str_replace("_controller", "", basename(__FILE__, ".php")));
define('timeOut',$cfg->Sesion['timeOut']);



class sesion_controller
{


    use \DbCommon;

    private $oSesion;
   // private $idSesion;
    private static $conn;
    private static $tabla = "sesiones";
    private static $id = "idSesion";

    /**
     * sesion_controller constructor.
     */
    //public function __construct($idUser, $dtIn, $bSignIn = null, $dtOut = null)
    public function __construct($idSesion)
    {
        $this->oSesion = Sesion::getSesionObj($idSesion);
        $this->oSesion->gestionarSesiones();
    }


   /* private function setConexion()
    {
        self::$conn = $GLOBALS{CONN};
        // self::$tabla = TABLA;
        // self::$id = ID;
        // self::$tabla = self::TABLA;
        // self::$id = self::ID;

    }
*/

    public function getSesionObj(){
        return $this->oSesion;
    }
    public function gestionarSesiones()
    {
       return $this->oSesion->gestionarSesiones();
    }

    public function getSignIn()
    {
        return $this->oSesion->getSignIn();
    }

    public function signOutSesion(){
        return $this->oSesion->signOutSesion();
    }




//TODO Eliminar desde aqui hacia el final

    public function getStatusSesion($id)
    {
        $filtro = ['idUser' => $id];
        $ssql = "select * from " . self::$tabla . " where idUser = :idUser and signIn = 1";

        $rs = $this->getRow($ssql, $filtro);

        if (!empty($rs)) {
            $this->oSesion->setSignIn($rs['signIn']);
            $this->oSesion->setDtIn(date('Y-m-d H:i:s'));
        } else { //no tiene sesion activa
         /*   if(isset($_SESSION['SesionUID'])) {
                session_unset();
                session_destroy();
            }*/
            $this->oSesion->setSignIn(0);
            $this->oSesion->setDtIn(date('Y-m-d H:i:s'));
        }
        //return $rs;
        return $this->oSesion->getSignIn();
    }

    public function updateSesion($id)
    { //todo hacerlo como updateAllSesion??????
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

        $ssql = "Update sesiones Set dtOut = :dtOut, signIn = :signIn where (TIMESTAMPDIFF(SECOND,dtIn,NOW()))>" . timeOut . " and isNull(dtOut)";

        try {
            $rst = self::$conn->getConn()->prepare($ssql);
            foreach ($parametros as $k => $v) {
                $rst->bindParam(":{$k}", $parametros[$k]); //para usar el parametro KEY ($k)
            }
            $rst->execute();
        }catch (PDOException $e){
           echo  $e->getCode();
        }
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
 //Todo Eliminar hasta aqui porque esta en Sesion.class
}
