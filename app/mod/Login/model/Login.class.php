<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 17/09/2017
 * Time: 10:09
 */

class Login
{
    /* private static $conn;
     private static $tabla;
     private static $id;*/

    private $logeado;
    private static $instancia = null;


    private function __construct()
    {
        //$this->setLogeado(false);
    }

    /**
     * Creacion de una sola instancia de Login
     * @return null
     */
    public static function login()
    {
        if (!isset(self::$instancia)) {
            $c = __CLASS__;
            self::$instancia = new $c();
        }
        return self::$instancia;
    }

    /**
     * Obtener el estado de logeo del usuario
     * @return boolean
     */
    public function getLogeado()
    {
        return $this->logeado;
    }

    /**
     * Establecer el estado de logeo del usuario
     * @param boolean $logeado
     */
    public function setLogeado($logeado)
    {
        $this->logeado = $logeado;
    }

}