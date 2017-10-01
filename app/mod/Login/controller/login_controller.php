<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 16/09/2017
 * Time: 11:51
 */
$GLOBALS["clase"] = ucfirst(str_replace("_controller","",basename(__FILE__,".php")));

define("TABLA","User");
define("ID", "idUser");

class login_controller
{

   private $login;

   public function __construct()
   {
       //$this->login = Login::login();
       $this->login = new Login_model();

   }

    public function getLogeadoStatus(){
        $logeado =  $this->login->getLogeado();
        return $logeado;
    }

    public function getLogeadoDataUser(){
      //  var_dump($this->login->getLogIn());

        $dataLogin = $this->login->getDataUser();

        return $dataLogin;
    }

    public function getLogeadoPass($input_pass, $rs_pass){
        return $this->login->verifPass($input_pass, $rs_pass);
    }




}


