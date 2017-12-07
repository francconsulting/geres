<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 23/07/2017
 * Time: 13:38
 */
//Control para evitar ejecutar el script directamente
if(empty(defined("DIRMOD"))){ echo "No está permitida la ejecucion del script";}
//Setear en la variable el Nombre de la clase
$GLOBALS["clase"] = ucfirst(str_replace("_controller","",basename(__FILE__,".php")));

define("TABLA","user"); //tabla de la bd para manipular datos
define("ID", "idUser"); //campo que vamos a usar como clave de la tabla


class user_controller{



    public function __construct()
    {
        //TODO poner aqui los 2 require de la linea 20 y 21 o hacer un script que carge los archivos
    }

    /**
     * Obtener los registros de usuarios. Cada registro son devuelto como objetos.
     * Los limites tienen funcionalidad para paginar lista de registros
     * @param int $limit_inf  limite inferior para limitar la consulta
     * @param int $limit_sup   limite superior para limitar la consulta
     * @return ArrayObject
     */
    public function getUserAllObj($limit_inf=null,$limit_sup=null){
        $rows = User_model::getAllObj($limit_inf,$limit_sup);
        return $rows;
    }

    /**
     * Obtener un registro concreto como objeto
     * @param $id   identificador del registro a devolver
     * @return null|object
     */
    public function getUserIdObj($id){
        $row = User_model::getIdObj($id);
        return $row;
    }

    /**
     * Obtener los registros de usuarios. Cada registro son devuelto según
     * el parametro indicado.
     * @param null $tipoAsoc  Tipo de asociacion de como se devuelven los registros.
     *                        Por defecto, como array asociativo (PDO::FETCH_ASSOC)
     * @param null $limit_inf Limite inferior para limitar la consulta
     * @param null $limit_sup Limite superior para limitar la consulta
     * @return Array|null
     */
    public function getUserAll($tipoAsoc=null,$limit_inf=null,$limit_sup=null){
        $rows = User_model::getAll($tipoAsoc,$limit_inf,$limit_sup);
        return $rows;
    }

   //TODO para eliminar porque parece que no se usa
   /* public function getuserForm($id){
        if (!empty($id)){     $rows = User_model::getIdObj($id);}
        include(MODULO."/view/modules/".$GLOBALS["clase"]."form.php");

    }*/


    /**
     * Guardar un nuevo usuario que se cree
     * @param $sNombre  Nombre del usuario
     * @param $sApellidos   Apellidos del usuario
     * @param $sPass    Password del usuario
     * @param $aRol     Rol/Permisos del usuario
     * @param $sEmail   Email del usuario
     * @param $sTelefono1   Telefono1 del usuario
     * @param $sTelefono2   Telefono2 del usuario
     * @param $sDireccion   Direccion del usuario
     * @param $sCodigoPostal    Cod.Postal del usuario
     * @param $cGenero      Sexo del usuario
     * @param $sAvatar   Avatar del usuario
     * @return boolean
     */
    public function guardarUser($sNombre, $sApellidos, $sPass, $aRol, $sEmail,
                                $sTelefono1, $sTelefono2, $sDireccion,
                                $sCodigoPostal, $cGenero, $sAvatar)
    {
        $usuario = new User_model($sNombre, $sApellidos, $sPass, $aRol, $sEmail, $sTelefono1,
                             $sTelefono2, $sDireccion,$sCodigoPostal, $cGenero, $sAvatar );
        return $usuario->guardar();
    }

    /**
     * Actualizar los datos del usuario
     * @return boolean
     */
    public function actualizarUser(){
        //convertir en objeto el array POST
        $datos = (object) $_POST;

        //Guardar los datos del usuario
        $usuario = User_model::getIdObj($datos->idUser);
        //Establecer los nuevos valores
        $usuario->setNombre($datos->sNombre);
        $usuario->setApellidos($datos->sApellidos);
        if(empty($datos->sPassword)){
            $usuario->setPass( $usuario->getPass());
        }else {
            $usuario->setPass(crypt($datos->sPassword, Util::getSalt()));
        }
        $usuario->setARol($datos->aRol);
        $usuario->setEmail($datos->sEmail);
        $usuario->setTelefono1($datos->sTelefono1);
        $usuario->setTelefono2($datos->sTelefono2);
        $usuario->setDireccion($datos->sDireccion);
        $usuario->setCodigoPostal($datos->sCodigoPostal);
        $usuario->setGenero($datos->cGenero);
        $usuario->setAvatar($datos->sAvatar);

        return $usuario->guardar();
    }

    /**
     * Borrar el usuario (en realidad lo que hace es
     * actualizar el registro estableciendo el valor del
     * campo cBorrado a 'Si'
     * @return boolean
     */
    public function borrarUser(){
        //obtener el usuario a borrar
        $usuario = User_model::getIdObj($_POST['idUser']);
        return $usuario->borrar();
    }

    /**
     * Eliminar el registro de la tabla
     * @return boolean
     */
    public function eliminarUser(){
        //obtener el usuario a borrar
        $usu = User_model::getIdObj($_POST['idUser']);
        return  $usu->eliminar();
    }

    /**
     * //TODO método inactivo
     * Registra un nuevo usuario desde el formulario de registro
     * @param $sNombre
     * @param $sApellidos
     * @param $sPass
     * @param $aRol
     * @param $sEmail
     * @param $sTelefono1
     * @param $sTelefono2
     * @param $sDireccion
     * @param $sCodigoPostal
     * @param $cGenero
     * @param string $sAvatar
     * @return mixed
     */
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


?>

