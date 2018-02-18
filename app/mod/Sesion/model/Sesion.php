<?php

/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 19/02/2017
 * Time: 17:28
 */
class Sesion
{


    use DbCommon;


    private static $conn;
    private static $tabla = "sesiones";
    private static $id = "idSesion";


    private static $instancia = null;

    private $signIn = false;
    private $idUser;
    private $nameUser;
    private $dtIn;
    private $dtOut;
    private $idSesion;
    private $dtUltimoAcceso;
    private $sAvatar;


    private function __construct($idUser,  $signIn, $nameUser, $idSesion, $dtIn, $avatar, $dtOut = null)
    {

         $this->idSesion = $idSesion;
         $this->idUser = $idUser;
         $this->signIn = $signIn;
         $this->dtIn = $dtIn;
         $this->dtOut = $dtOut;
         $this->nameUser = $nameUser;
        $this->dtUltimoAcceso = $dtIn;
        $this->sAvatar = $avatar;
        Sesion::setConexion();
    }

    private function setConexion()
    {
        self::$conn = $GLOBALS{CONN};

    }

    /**
     * Conexion con la base de datos
     * @return null|PDO
     */
    public static function sesion( $idUser, $signIn, $nameUser, $idSesion, $dtIn, $avatar, $dtOut = null)
    {
        if (!isset(self::$instancia)) {
            $c = __CLASS__;
            self::$instancia = new $c( $idUser, $signIn, $nameUser, $idSesion, $dtIn, $avatar, $dtOut = null );
        }
        return self::$instancia;
    }

    /**
     * @return mixed
     */
    public function getIdSesion()
    {
        return $this->idSesion;
    }

    /**
     * @param mixed $idSesion
     */
    public function setIdSesion($idSesion)
    {
        $this->idSesion = $idSesion;
    }



    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param mixed $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return mixed
     */
    public function getNameUser()
    {
        return $this->nameUser;
    }

    /**
     * @param mixed $nameUser
     */
    public function setNameUser($nameUser)
    {
        $this->nameUser = $nameUser;
    }


    /**
     * @return mixed
     */
    public function getDtIn()
    {
        return $this->dtIn;
    }

    /**
     * @param mixed $dtIn
     */
    public function setDtIn($dtIn)
    {
        $this->dtIn = $dtIn;
    }

    /**
     * @return null
     */
    public function getDtOut()
    {
        return $this->dtOut;
    }

    /**
     * @param null $dtOut
     */
    public function setDtOut($dtOut)
    {
        $this->dtOut = $dtOut;
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->sAvatar;
    }

    /**
     * @param mixed $sAvatar
     */
    public function setAvatar($sAvatar)
    {
        $this->sAvatar = $sAvatar;
    }


   /* private function setConexion()
    {
        self::$conn = $GLOBALS{CONN};
        // self::$tabla = TABLA;
        // self::$id = ID;
        // self::$tabla = self::TABLA;
        // self::$id = self::ID;

    }*/

    /**
     * Método mágico para establecer a la propiedad un valor
     * @param $clave    propiedad del objeto
     * @param $valor    valor del objeto
     * @return mixed
     */
    public function __set($clave, $valor)
    {
        return $this->$clave = $valor;
    }

    /**
     * Método mágico para obtener las propiedade sde los objetos
     * @param $clave    propiedad del objeto
     * @return mixed
     */
    public function __get($clave)
    {
        return $this->$clave;
    }

    /**
     * Obtener un array con las propiedades de la clase
     * @return array
     */
    public function getPropClass()
    {
        return get_class_vars(__CLASS__);
    }

    /**
     * Obtener array con pares de clave-valor de las propiedades del objeto
     * @return array
     */
    public function getPropObj()
    {
        return get_object_vars($this);
    }

    /**
     * @return string
     */
    public static function getTabla()
    {
        return self::$tabla;
    }

    /**
     * @return string
     */
    public static function getId()
    {
        return self::$id;
    }


    /**
     * @return null
     */
    public function getSignIn()
    {
        return $this->signIn;
    }

    /**
     * @param mixed $signIn
     */
    public function setSignIn($signIn)
    {
        $this->signIn = $signIn;
    }

    /**
     * @return mixed
     */
    public function getDtUltimoAcceso()
    {
        return $this->dtUltimoAcceso;
    }

    /**
     * @param mixed $dtUltimoAcceso
     */
    public function setDtUltimoAcceso($dtUltimoAcceso)
    {
        $this->dtUltimoAcceso = $dtUltimoAcceso;
    }




    /**
     * Establecer la sesion usando un objeto
     * @param $sSesion Nombre de la sesion
     * @param $oObj Objeto a serializar
     */
    public static function setSesionObj($sSesion, $oObj)
    {
        $_SESSION[$sSesion] = serialize($oObj);
    }


    /**
     * Deserializar un objeto de una sesion
     * @param $sSesion  Nombre de la sesion
     * @return mixed objeto
     */
    public static function getSesionObj($sSesion)
    {
        return unserialize($_SESSION[$sSesion]);
    }

    /**
     * Establece una sesion pasando el par nombre=valor
     * @param $sSesion nombre de la sesion
     * @param $valor valor de la sesion
     */
    public static function setSesion($sSesion, $valor)
    {
       // self::setSignIn(true);
        $_SESSION[$sSesion] = $valor;
    }

    /**
     * Obtiene el valor de la sesion
     * @param $sSesion  nombre de la sesion
     * @return null valor de la sesion
     */

    public static function getSesion($sSesion)
    {
        if (isset($_SESSION[$sSesion])) {
            $sesion = $_SESSION[$sSesion];
        } else {
            $sesion = null;
        }
        return $sesion;
    }

    /**
     * Elimina la sesion pasada por parametro
     * @param $sSesion nombre de la sesion a eliminar
     */
    public static function delSesion($sSesion)
    {
        unset($_SESSION[$sSesion]);
    }

    /**
     * Eliminar todas las sesiones
     */
    public static function delSesionAll()
    {
        self::setSignIn(false);
        unset($_SESSION); //borrar el array de sesiones
        session_destroy(); //destruir toda la información asociada a la sesion
    }

    /**
     * Redireccion a la pagina principal cuando no esta logado el usuario
     *
     */
    public static function logOut()
    {
        if (empty(self::getSignIn())) {
            header("Location:" . PATH . "index.php");
        }
    }

    /**
     * Imprime los datos de la sesion que se pasa por parametro
     * @param $sSesion nombre de la sesion
     * @return string datos con los datos de la sesion
     */
    public static function printSesion($sSesion)
    {
        $imprimir = "<p>Tu sesión es <strong>" . $sSesion[0] . "</strong> y la hora de acceso ha sido <strong>" . $sSesion[1] . "</strong></p>";
        return $imprimir;
    }


    /**
     * Obtener la cookie pasada por paramentro
     * @param $sCookie nombre de la cookie
         * @return null  valor de la cookie
     */
    public static function getCookie($sCookie)
    {
        if (isset($_COOKIE[$sCookie])) {
            $variable = $_COOKIE[$sCookie];
        } else {
            $variable = null;
        };
        return $variable;
    }


    public function gestionarSesiones()
    {
       // $this->oSesion = self::getSesionObj($sesion)
        //$hora =  ($this->getDtIn());

   //TODO     $this->updateAllSesion(); //actualizar todas las sesiones de los usuarios en la tabla


 //       echo strtotime(date('Y-m-d H:i:s')) - strtotime($this->getDtIn())." ".(date('Y-m-d H:i:s'))." - ". ($this->getDtIn());

        if ($this->getStatusSesion($this->getIdUser())>0) {
             $hora = $this->getDtIn();
            $intervalo = strtotime(date('Y-m-d H:i:s')) - strtotime($hora);
     //       var_dump("Logado???".$this->getStatusSesion($this->getIdUser()));




            if ($intervalo > timeOut) {
    //            var_dump($intervalo. " ".date('Y-m-d H:i:s'). " " .$hora);
                //TODO ->si vengo del index o del login
                if (isset($_SESSION['signIn'])) {
//var_dump("xxxxxxxxxxxxxxx1");
                    //actualizar sesion
                    $this->setDtIn(date('Y-m-d H:i:s'));
                    $this->setDtIn(date('Y-m-d H:i:s'));
                 //   $this->updateSesion($this->getIdUser());
                    //todo crear variable de sesion
                } else {      //si  he cargado una pagina cualquiera
                    /* $this->setSignIn(0); //logado false
                     $this->setDtOut(date('Y-m-d H:i:s'));
                     $this->updateSesion($this->getIdUser());
                     */
                    // $this->guardar(false);
//var_dump("xxxxxxxxxx2".$this->getDtIn());
                    $this->setSignIn(0); //logado false
                    $this->setDtOut(date('Y-m-d H:i:s'));
                    $this->updateSesion($this->getIdUser());
                    if(strripos($_SERVER['PHP_SELF'],'page')>0) {
                        header("Location:index.php");
                    }else {
                       //echo "<script>$(location).attr('href', 'index.php')</script>";

                    }
                    //todo redirigir al index
                }
              self::setSesionObj('SesionUID', $this);

            } else {
//var_dump("xxxxxxxxxxxx3");
                //Todo ->no ha caducado la sesion  por tanto hay que actualizar
                $this->setDtIn(date('Y-m-d H:i:s'));
                $this->setDtOut(null);
              self::setSesionObj('SesionUID', $this);
            //    $this->updateSesion($this->getIdUser());


            }

        } else {

            //TODO ->si vengo del index o del login
            if (isset($_SESSION['signIn'])) {
 //   var_dump("xxxxxxxxxx4");
                $this->setSignIn(1);
                $this->setDtIn(date('Y-m-d H:i:s'));
                $this->newSesion($this->getIdUser());
            } else {
    //var_dump("FUERAAAAA --> 5");
             //  var_dump(strripos($_SERVER['PHP_SELF'],'page'));
 //   var_dump($this);
                $this->setSignIn(0);
                $this->setDtOut(date('Y-m-d H:i:s'));
                $this->updateSesion($this->getIdUser());
                if(strripos($_SERVER['PHP_SELF'],'page')>0) {
                    header("Location:index.php");
                }
                //todo redirigir al index cuando es ajax


            }
        self::setSesionObj('SesionUID', $this);
        }

  //      var_dump($this);
        $_SESSION['signIn']=false;
        unset($_SESSION['signIn']);
       // var_dump($this);
        return $this;
    }

    public function getStatusSesion($id)
    {
        $filtro = ['idUser' => $id];
        $ssql = "select * from " . self::$tabla . " where idUser = :idUser and signIn = 1";

        $rs = $this->getRow($ssql, $filtro);

        if (!empty($rs)) {
            $this->setSignIn($rs['signIn']);
         //   $this->setDtIn(date('Y-m-d H:i:s'));
        } else { //no tiene sesion activa
            /*   if(isset($_SESSION['SesionUID'])) {
                   session_unset();
                   session_destroy();
               }*/
            $this->setSignIn(0);
           // $this->setDtIn(date('Y-m-d H:i:s'));
        }
        //return $rs;
        return $this->getSignIn();
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
            $this->setConexion();
            $rst = self::$conn->getConn()->prepare($ssql);
            foreach ($parametros as $k => $v) {
                $rst->bindParam(":{$k}", $parametros[$k]); //para usar el parametro KEY ($k)
            }
            $rst->execute();
        }catch (PDOException $e){
            echo  $e->getCode();
        }
    }

    public function signOutSesion()
    {
        $this->setSignIn(0); //logado false
        $this->setDtIn($this->dtUltimoAcceso);
        $this->setDtOut(date('Y-m-d H:i:s'));
        $this->updateSesion($this->getIdUser());
    }

}

?>