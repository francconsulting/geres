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
        //include(MODULO."/view/modules/".$GLOBALS["clase"]."module.php");

        return $rows;
    }

    public function getUserIdObj($id){
        $rows = User_model::getIdObj($id);
        //include(MODULO."/view/modules/".$GLOBALS["clase"]."module.php");
        return $rows;
    }

    public function getUserAll($limit_inf=null,$limit_sup=null){
        $rows = User_model::getAll($limit_inf,$limit_sup);
       // include(MODULO."/view/modules/".$GLOBALS["clase"]."module.php");
        return $rows;
    }
    public function getuserForm($id){
        if (!empty($id)){     $rows = User_model::getIdObj($id);}
        include(MODULO."/view/modules/".$GLOBALS["clase"]."form.php");

    }


    public function guardarUser($sNombre, $sApellidos, $sPass, $aRol, $sEmail,
                                $sTelefono1, $sTelefono2, $sDireccion,
                                $sCodigoPostal, $cGenero, $sAvatar = "avatar_h1")
    {
        $usu = new User_model($sNombre, $sApellidos, $sPass, $aRol, $sEmail, $sTelefono1,
                             $sTelefono2, $sDireccion,$sCodigoPostal, $cGenero, $sAvatar );

        $usu->guardar();
       /* $usu->setIdUser($usu->getlastInsertId());  //guardar el ultimo id insertado
        $this->getUserAllObj();*/
    }

    public function actualizarUser(){

        $datos = (object) $_POST;

        $usu = User_model::getIdObj($datos->idUser);
        $usu->setNombre($datos->sNombre);
        $usu->setApellidos($datos->sApellidos);
        if(empty($datos->sPassword)){
            $usu->setPass( $usu->getPass());
        }else {
            $usu->setPass(crypt($datos->sPassword, Util::getSalt()));
        }
        $usu->setARol($datos->aRol);

        $usu->setEmail($datos->sEmail);
        $usu->setTelefono1($datos->sTelefono1);
        $usu->setTelefono2($datos->sTelefono2);
        $usu->setDireccion($datos->sDireccion);
        $usu->setCodigoPostal($datos->sCodigoPostal);
        $usu->setGenero($datos->cGenero);
        $usu->setAvatar($datos->sAvatar);

        return $usu->guardar();
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

    public function registrarUser($sNombre, $sApellidos, $sPass, $aRol,
                                    $sEmail, $sTelefono1, $sTelefono2, $sDireccion,
                                    $sCodigoPostal, $cGenero, $sAvatar = "avatar_h1")
    {
        $usu = new User_model($sNombre,$sApellidos,$sPass,$aRol,$sAvatar,
                            $sTelefono1, $sTelefono2, $sDireccion,
                             $sCodigoPostal, $cGenero, $sEmail,nul);
        $res =$usu->guardar();
        return $res;
    }

}


//$usuarios = new user_controller();
//$rs = $usuarios->getAllObj();



?>

