<?php

/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 19/02/2017
 * Time: 13:57
 */

class Db
{

  /*  const HOST = "localhost";
    const USER = "root";
    const PASS = "";
    const DB = "gestres";
*/
   // const DNS = "mysql:host=".self::HOST.";dbname=".self::DB;


    private  $conn;
    private static $instancia = null;
    private $errorConn;

    private $rowCount;


    private function __construct() {

        $cfg = (object) parse_ini_file(PATH.PROJECT.APP.'/cfg/config_bd.ini');

        $opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        try {
            //$this->conn = new PDO(self::DNS, self::USER, self::PASS, $opc);
          //  $this->conn = new PDO("mysql:host=".self::HOST.";dbname=".self::DB, self::USER, self::PASS, $opc);
            $this->conn = new PDO("mysql:host=".$cfg->host.";  dbname=".$cfg->db, $cfg->user, $cfg->pass,  $opc);

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Can change to PDO::ERRMODE_SILENT
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // For security!

        } catch (PDOException $e) {
            $this->errorConn= "Error = {$e->getCode()} <br/>Linea {$e->getLine()} .-mensaje = {$e->getMessage()}";
            $this->conn = null;

        }
        return $this->conn;
    }

    public function getPropClass(){
        return get_class_vars(__CLASS__);
    }

    public function getPropObj(){
        return get_object_vars($this);
    }


    /**
     * @return null
     */
    public function getConn()
    {
        return $this->conn;
    }

    /**
     * @return mixed
     */
    public function getErrorConn()
    {
        return $this->errorConn;
    }

    /**
     * @return mixed
     */
    public function getRowCount()
    {
        return $this->rowCount;
    }

    /**
     * @param mixed $rowCount
     */
    public function setRowCount($rowCount)
    {
        $this->rowCount = $rowCount;
    }



    /**
     * Conexion con la base de datos
     * @return null|PDO
     */
    public static function conex()
    {
        if(!isset(self::$instancia)) {
            $c =__CLASS__;
            self::$instancia = new $c;
        }
        return self::$instancia;

    }

    final public function __clone() {
        throw new Exception('Solo se permite una instancia');
    }
    final public function wakeup() {
        throw new Exception('Solo se permite una instancia');
    }

    /**
     * Libera los recursos
     * @return null
     */
    public static function cerrar()
    {
        return null;
    }

    /**
     * Preparar la realizacion de una transaccion
     * @param $conn link de conexion
     * @return boolean True en caso de exito o False en caso de error
     */
    public function beginTransaction(){
        return $this->conn->beginTransaction();
    }

    /**
     * Confirmar la ejecucion de una transaccion
     * @param $conn link de conexion
     * @return boolean True en caso exito o False en caso de error
     */
    public function commit(){
        return $this->conn->commit();
    }

    /**
     * Revertir la transaccion pendienten de ejecutar
     * @param $conn link de conexion
     * @return mixed True en caso exito o False en caso de error
     */
    public function rollBack(){
        return $this->conn->rollBack();
    }

    /**
     * Permite obtener los drivers disponibles.
     * @param $conn link de conexion
     * @return array con los drivers disponibles. Si no hay drivers disponibles devuelve el array vacio.
     */
    public function getDriver(){
        return $this->conn->getAvailableDrivers();
    }

    /**
     * Obtener el ultimo Id de la fila insertada
     * @param $conn link de conexion
     * @param null $name nombre de la secuencia de objetos a devolver
     * @return mixed
     */
    public function lastInsertId($name=null){
        return $this->conn->lastInsertId($name);
    }

    /**
     * funcion para hacer el select
     * @param $conn Link de conexion
     * @param $ssql Instrucion sql a ejecutar
     * @param null $parametros condiciones del filtro
     * @param bool $asoc Si se usan parametros con sustitucion de nombre o con signos de ?
     *              cuando se usen consultas con ? debemos pasar el parametro $asoc como false
     * @return null o el objeto del recordset
     */
    public function select($ssql, $parametros = null, $asoc = true)
    {
        //echo $ssql;
        $rst = $this->conn->prepare($ssql);
        //echo $ssql;
        if ($parametros) {
            $iCon = 1;
            foreach ($parametros as $k => $v) {
                if ($asoc) {
                    $rst->bindParam(":{$k}", $parametros[$k]); //para usar el parametro KEY ($k)
                } else {
                    $rst->bindParam($iCon, $parametros[$k]);
                    $iCon++;
                }
            }
        }
        $rst->execute();
        if ($rst->rowCount() > 0) {
            //$rst = $rst ->fetch();  //asociacion de registros
            //La asociacion de registros se hace en db.traits
            return $rst;
        } else {
            return $rst = null;
        }
    }


    /**
     * funcion para hacer el Insert
     * @param $conn Link de conexion
     * @param $tabla String con el nombre de la tabla donde insertar los valores
     * @param $parametros array con los campos y valores a insertar
     * @param bool $asoc Si se usan parametros con sustitucion de nombre o con signos de ?
     * @param $debug    String para ver la instruccion sql en pantalla. Si se pasa el parametro 'test'
     *                  muestra la instruccion sql.
     * @return null
     */
    public function insert($tabla, $parametros, $asoc = true, $debug = null)
    {
  //      var_dump($parametros);
        list($campos, $param) = call_user_func_array('self::prepararParam', array($parametros, $asoc));
        $ssql = "insert into {$tabla} (" . implode(',', $campos) . ") values ({$param})";
       $arg = func_num_args();  // numero de argumentos pasados
       if ($arg>3 && func_get_arg($arg-1) == 'test'){echo $ssql."<br />";}  //si el ultimo parametros es la cadena 'test' muestra la instruccion sql

        try {
            $rst =  $this->conn->prepare($ssql);
            $iCon = 1;
            foreach ($parametros as $k => $v) {
                if ($asoc) {
                    $rst->bindParam(":{$k}", $parametros[$k]); //para usar el parametro KEY ($k)
                } else {
                    $rst->bindParam($iCon, $parametros[$k]);
                    $iCon++;
                }
            }
            if ($rst->execute()) {
                // $msg = "Se han insertado " . $rst->rowCount() . " registros";
                // $rst = null; //liberar recursos
                $msg = null;
            }
        } catch (PDOException $e) {
            $this->errorConn="<strong>Se ha producido un error nº: </strong>{$e->getCode()} <br/> <strong>Descripción: </strong>{$e->getMessage()}";
            $rst = null;

        }
        return $rst;
    }


    /**
     * funcion para hacer el Borrado de registros
     * @param $conn Link de conexion
     * @param $tabla String con el nombre de la tabla donde insertar los valores
     * @param null $parametros array con los campos y valores  condiciones del filtro a borrar
     * @param bool $asoc Si se usan parametros con sustitucion de nombre o con signos de ?
     * @return null
     */
    public function delete($tabla, $parametros = null, $asoc = true)
    {
        $ssql = "Delete from {$tabla} ";
        if ($parametros) {
            $ssql .= " where ";

            list($campos, $param) = call_user_func_array('self::prepararParam', array($parametros, $asoc));
            var_dump($campos);
            var_dump($param);
            if (!$asoc) {
                $param = explode(",", $param);
            }


            for ($i = 0; $i < count($campos); $i++) {
                if (!$asoc) {
                    $ssql .= "{$campos[$i]} = {$param[$i]} and ";
                } else {
                    $ssql .= "{$campos[$i]} =  :$campos[$i] and ";
                }
            }
            $ssql = substr($ssql, 0, -4);

        }
        $iCon = 1;
        try {
            $rst = $this->conn->prepare($ssql);
            foreach ($parametros as $k => $v) {
                if ($asoc) {
                    $rst->bindParam(":{$k}", $parametros[$k]); //para usar el parametro KEY ($k)
                } else {
                    $rst->bindParam($iCon, $parametros[$k]);
                    $iCon++;
                }
            }
            if ($rst->execute()) {
                // $msg = "Se han borrado " . $rst->rowCount() . " registros";
                $msg = null;
            }
        } catch (PDOException $e) {
            $rst = null;
            die($msg = "<div class='msg error centrar'><strong>Se ha producido un error nº: </strong>{$e->getCode()} <br/> <strong>Descripción: </strong>{$e->getMessage()}</div>");
        }
        var_dump($ssql);
        return $rst;
    }

    /**
     * funcion para hacer la Actualizacion de resitros
     * @param $conn Link de conexion
     * @param $tabla String con el nombre de la tabla donde insertar los valores
     * @param $parametros array con los campos y valores a actualizar
     * @param null $filtro array con la condiciones del filtro (cuando el valor es ISNULL o NOT ISNULL la instruccion se reestructura
     * @param bool $asoc Si se usan parametros con sustitucion de nombre o con signos de ?
     * @return null
     */
    public function update($tabla, $parametros, $filtro = null, $asoc = true)
    {
        list($campos, $param) = call_user_func_array('self::prepararParam', array($parametros, $asoc));

        if (!$asoc) {
            $param = explode(",", $param);
        }

        $ssql = "Update {$tabla} Set ";
        for ($i = 0; $i < count($campos); $i++) {
            if (!$asoc) {
                $ssql .= "{$campos[$i]} = {$param[$i]},";
            } else {
                $ssql .= "{$campos[$i]} =  :$campos[$i],";
            }
        }
        $ssql = substr($ssql, 0, -1);
        if ($filtro) {
            var_dump($filtro);
            list($filtroCamp, $filtroParam) = call_user_func_array('self::prepararParam', array($filtro, $asoc));

            if (!$asoc) {
                $filtroParam = explode(",", $filtroParam);
            }
            for ($i = 0; $i < count($filtroCamp); $i++) {
                if ($i == 0) {
                    $ssql .= " where ";
                }
                if (!$asoc) {
                    $ssql .= "{$filtroCamp[$i]} = {$filtroParam[$i]} and ";
                } else {
                    if (stripos(strtoupper($filtro[$filtroCamp[$i]]), 'NULL')){
                        $ssql .= $filtro[$filtroCamp[$i]]."({$filtroCamp[$i]}) and ";
                    }else {
                        $ssql .= "{$filtroCamp[$i]} =  :$filtroCamp[$i]Filtro and ";
                   }
                }

            }
            $ssql = substr($ssql, 0, -4);
        }
        echo $ssql;

        $iCon = 1;
        try {
            var_dump($this->conn);
            $rst = $this->conn->prepare($ssql);
            foreach ($parametros as $k => $v) {
                if ($asoc) {
                    $rst->bindParam(":{$k}", $parametros[$k]); //para usar el parametro KEY ($k)
                } else {
                    $rst->bindParam($iCon, $parametros[$k]);
                    $iCon++;
                }
            }
            foreach ($filtro as $k => $v) {
                if (stripos(strtoupper($v), "NULL") == 0 ) {

                    if ($asoc) {
                        $rst->bindParam(":{$k}Filtro", $filtro[$k]); //para usar el parametro KEY ($k)
                    } else {
                        $rst->bindParam($iCon, $filtro[$k]);
                        $iCon++;
                    }
                }
            }

            if ($rst->execute()) {
                //$msg = "Se han actualizado " . $rst->rowCount() . " registros";
                $msg = null;
            }
        } catch (PDOException $e) {
            $rst = null;
            die($msg = "<div class='msg error centrar'><strong>Se ha producido un error nº: </strong>{$e->getCode()} <br/> <strong>Descripción: </strong>{$e->getMessage()}</div>");
        }
        return $rst;
    }


    /**
     * Preparar los parametros para incrustarlos en el SQL
     * para poder insertar los valores en la BD
     * @param $array con los pares campos<>valor
     * @return array multidimensional con el nombre de los campos, valores y parametros
     */
    private static function prepararParam($array, $tipo = true)
    {
        $campos = array();
        // $datos = array();
        $parametros = "";
        foreach ($array as $key => $valor) {
            $campos[] = $key;
            //      $datos[]=$valor;

                if ($tipo) {
                    $parametros .= ":{$key},";
                } else {
                    $parametros .= "?,";
                }

        }
        $parametros = substr($parametros, 0, -1);

        return array($campos, $parametros);
    }




}

?>