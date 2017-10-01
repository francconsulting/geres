<?php

/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 19/02/2017
 * Time: 17:28
 */
class Sesion
{


    /*use DbCommon;*/

   /* private static $conn;
    private static $tabla = "sesiones";
    private static $id = "idSesion";*/


    private static $instancia = null;

    private $signIn = false;
    private $idUser;
    private $dtIn;
    private $dtOut;
    private $idSesion;


    private function __construct($idUser,  $dtIn, $signIn = null, $dtOut = null, $idSesion = null)
    {

         $this->idSesion = $idSesion;
         $this->idUser = $idUser;
         $this->signIn = $signIn;
         $this->dtIn = $dtIn;
         $this->dtOut = $dtOut;

       // $this->setConexion();
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
     * Conexion con la base de datos
     * @return null|PDO
     */
    public static function sesion( $idUser, $signIn, $dtIn, $dtOut = null)
    {
        if (!isset(self::$instancia)) {
            $c = __CLASS__;
            self::$instancia = new $c( $idUser, $signIn, $dtIn, $dtOut = null);
        }
        return self::$instancia;
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

}

?>