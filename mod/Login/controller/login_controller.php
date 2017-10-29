<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 16/09/2017
 * Time: 11:51
 */
$GLOBALS["clase"] = ucfirst(str_replace("_controller", "", basename(__FILE__, ".php")));

define("TABLA", "User"); //tabla que se usa en el módulo
define("ID", "idUser"); //identificador único de la tabla

class login_controller
{

    private $login;

    /**
     * login_controller constructor.
     */
    public function __construct()
    {
        //$this->login = Login::login();
        $this->login = new Login_model();

    }

    /**
     * Devuelve el estado de login del usuario
     * @return boolean True cuando esta logado.
     */
    public function getLogeadoStatus()
    {
        $logeado = $this->login->getLogeado();
        return $logeado;
    }

    /**
     * Devuelve los datos del usuario logado
     * @return array
     */
    public function getLogeadoDataUser()
    {
        //  var_dump($this->login->getLogIn());
        $dataLogin = $this->login->getDataUser();
        return $dataLogin;
    }

    /**
     * Comprueba la pass introducida en el formulario de acceso
     * coincide con el algoritmo password_verify de PHP
     * @param $input_pass Password introducida en el formulario
     * @param $rs_pass   Password recuperada de la Bd
     * @return bool
     */
    public function getLogeadoPass($input_pass, $rs_pass)
    {
        return $this->login->verifPass($input_pass, $rs_pass);
    }


}


