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

define("TABLA","actividad"); //tabla de la bd para manipular datos
define("ID", "idActividad"); //campo que vamos a usar como clave de la tabla


class Actividad_controller{

    public function __construct()
    {
        //TODO poner aqui los 2 require de la linea 20 y 21 o hacer un script que carge los archivos
    }

    /**
     * Obtener los registros de actividades. Cada registro son devuelto como objetos.
     * Los limites tienen funcionalidad para paginar lista de registros
     * @param int $limit_inf  limite inferior para limitar la consulta
     * @param int $limit_sup   limite superior para limitar la consulta
     * @return ArrayObject
     */
    public function getActivityAllObj($limit_inf=null,$limit_sup=null){
        $rows = Actividad_model::getAllObj($limit_inf,$limit_sup);
        return $rows;
    }

    /**
     * Obtener un registro concreto como objeto
     * @param $id   identificador del registro a devolver
     * @return null|object
     */
    public function getActivityIdObj($id){
        $row = Actividad_model::getIdObj($id);
        return $row;
    }

    /**
     * Obtener los registros de actividad. Cada registro son devuelto según
     * el parametro indicado.
     * @param null $tipoAsoc  Tipo de asociacion de como se devuelven los registros.
     *                        Por defecto, como array asociativo (PDO::FETCH_ASSOC)
     * @param null $limit_inf Limite inferior para limitar la consulta
     * @param null $limit_sup Limite superior para limitar la consulta
     * @return Array|null
     */
    public function getActivityAll($tipoAsoc=null,$limit_inf=null,$limit_sup=null){
        $rows = Actividad_model::getAll($tipoAsoc,$limit_inf,$limit_sup);
        return $rows;
    }


    /**
     * Guardar un nuevo registro que se cree
     * @param $sNombre  Nombre actividad
     * @param $sDescripcion   Descripcion de la actividad
     * @return boolean
     */
    public function guardarActividad($sNombre, $sDescripcion)
    {
        $actividad = new Actividad_model($sNombre, $sDescripcion );
        return $actividad->guardar();
    }

    /**
     * Actualizar los datos un registro
     * @return boolean
     */
    public function actualizarActividad(){
        //convertir en objeto el array POST
        $datos = (object) $_POST;

        //Guardar los datos del usuario
        $actividad = Actividad_model::getIdObj($datos->idActividad);
        //Establecer los nuevos valores
        $actividad->setNombre($datos->sNombre);
        $actividad->setDescripcion($datos->sDescripcion);

        return $actividad->guardar();
    }

    /**
     * Borrar la actividad (en realidad lo que hace es
     * actualizar el registro estableciendo el valor del
     * campo cBorrado a 'Si'
     * @return boolean
     */
    public function borrarActividad(){
        //obtener el usuario a borrar
        $actividad = Actividad_model::getIdObj($_POST['idActividad']);
        return $actividad->borrar();
    }

    /**
     * Eliminar el registro de la tabla
     * @return boolean
     */
    public function eliminarActividad(){
        //obtener el usuario a borrar
        $actividad = Actividad_model::getIdObj($_POST['idActividad']);
        return  $actividad->eliminar();
    }


}


?>

