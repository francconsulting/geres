<?php

/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 19/02/2017
 * Time: 17:28
 */
class Sesion
{
    private static $instancia = null;
    private $signIn = false;
    private $idUser;
    private $dtIn;
    private $dtOut;
    private $idSesion;

    private function __construct($idSesion, $idUser,$signIn,$dtIn, $dtOut)
    {
        echo "aqui". $idSesion.$idUser.$signIn.$dtIn. $dtOut;
        $this->setSignIn($signIn);
        $this->idUser = $idUser;
        $this->dtIn = $dtIn;
        $this->dtOut = $dtOut;
        $this->idSesion = $idSesion;
    }


    /**
     * Conexion con la base de datos
     * @return null|PDO
     */
    public static function sesion($idSesion, $idUser,$signIn,$dtIn, $dtOut)
    {

        if(!isset(self::$instancia)) {

            $c =__CLASS__;
            self::$instancia = new $c($idSesion, $idUser,$signIn,$dtIn, $dtOut);
        }
        return self::$instancia;

    }

    /**
     * @return mixed
     */
    public static function getSignIn()
    {
        return self::$signIn;
    }

    /**
     * @param mixed $signIn
     */
    private function setSignIn($signIn)
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
        self::setSignIn(true);
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
        self::setSignIn(true);
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