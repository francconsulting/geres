<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 23/07/2017
 * Time: 13:38
 */

if(empty(defined("DIR_BASE"))){
   // header("location:http://localhost/gestrest/index.php");
}  //si no esta definido el directorio es que estas entrando directamente al script controlador y no es posible
//require_once("./db/Db.class.php");
//require_once("./db/Db.traits.php");

//require_once("./lib/Util.class.php");

$GLOBALS["clase"] = ucfirst(str_replace("_controller","",basename(__FILE__,".php")));

define("TABLA","user");
define("ID", "idUser");

/*require_once("./model/".$GLOBALS["clase"].".class.php");
require_once("./model/".$GLOBALS["clase"]."_model.class.php");*/

//require_once("./db/db.openconex.inc.php");

//class_alias("User_model","Usuario");



class user_controller{

    public function __construct()
    {
        //TODO poner aqui los 2 require de la linea 20 y 21 o hacer un script que carge los archivos
    }

    public function getUserAllObj($limit_inf=null,$limit_sup=null){
        $rows = User_model::getAllObj($limit_inf,$limit_sup);
        include(MODULO."/view/modules/".$GLOBALS["clase"]."module.php");
    }

    public function getUserIdObj($id){
        $rows = User_model::getIdObj($id);
        include(MODULO."/view/modules/".$GLOBALS["clase"]."module.php");
    }

    public function getUserAll(){
        $rows = User_model::getAll();
        include(MODULO."/view/modules/".$GLOBALS["clase"]."module.php");
    }
    public function getuserForm($id){
        if (!empty($id)){     $rows = User_model::getIdObj($id);}
        include(MODULO."/view/modules/".$GLOBALS["clase"]."form.php");

    }


    public function guardarUser(){
        $usu = new User_model($_POST['txtNombre'],$_POST['txtApellidos'],$_POST['txtRol']);
        $usu->guardar();
        $this->getUserAllObj();
    }

    public function borrarUser(){
        $usu = User_model::getIdObj($_POST['idUser']);
        $usu->borrar();
      //  $this->getUserAllObj();
    }

    public function eliminarUser(){
        $usu = User_model::getIdObj($_POST['idUser']);
            $usu->eliminar();
       //  $this->getUserAllObj();
    }


}


//$usuarios = new user_controller();
//$rs = $usuarios->getAllObj();



?>

