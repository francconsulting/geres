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


    public static function login(){
        if (!isset(self::$instancia)) {
            $c = __CLASS__;
            self::$instancia = new $c();
        }
        return self::$instancia;
}
    /**
     * @return mixed
     */
    public function getLogeado()
    {
        return $this->logeado;
    }

    /**
     * @param mixed $logeado
     */
    public function setLogeado($logeado)
    {
        $this->logeado = $logeado;
    }


   /* public function  getLogIn(){
        $filtro = ['nombre' => $_POST['usuario']];
        self::setConexion();
        $ssql = "select * from " . self::$tabla . " where sNombre = :nombre";
        $rs = self::$conn->select($ssql,$filtro);
        if ($rs) {
            $rs = $rs->fetch(PDO::FETCH_ASSOC);
            $this->setLogeado(true);
        }
        else {
            $rs =  null;
        }
        //return json_encode($rs);
        return ($rs);
    }



    private function setConexion(){
        self::$conn =  $GLOBALS{CONN};
        self::$tabla = TABLA;
        self::$id = ID;
    }
   */
}