<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 06/08/2017
 * Time: 14:29
 */

trait DbCommon
{
    /**
     * Estaclecer los parametros con la
     * bade de datos.
     * Parametros $tabla y $id establecidos en el
     * controlador de la clase.
     * El parametro $conn definido en db.openconex.inc.php
     */
     private function setConexion(){
          self::$conn =  $GLOBALS{CONN};
          self::$tabla = TABLA;
          self::$id = ID;
      }

      /**
       * Obtener el id del usuario que
       * inserta el registro
       * @return string
       */
    public function getIdA()
    {
        return $this->idA;
    }

    /**
     * Establecer el id del usuario que
     * inserta el registro
     * @param string $idA
     */
    public function setIdA($idA)
    {
        $this->idA = $idA;
    }

    /**
     * Obtener el id del usuario que
     * actualiza el registro
     * @return string
     */
    public function getIdU()
    {
        return $this->idU;
    }

    /**
     * Establecer el id del usuario que
     * actualiza el registro
     * @param string $idU
     */
    public function setIdU($idU)
    {
        $this->idU = $idU;
    }

    /**
     * Obtener la fecha y hora de
     * insercion del registro
     * @return string
     */
    public function getDtA()
    {
        return $this->dtA;
    }

    /**
     * Establecer la fecha y hora de
     * insercion del registro
     * @param string $dtA
     */
    public function setDtA($dtA)
    {
        $this->dtA = $dtA;
    }

    /**
     * Obtener la fecha y hora de
     * actualizacion del registro
     * @return string
     */
    public function getDtU()
    {
        return $this->dtU;
    }

    /**
     * Establecer la fecha y hora de
     * actualizacion del registro
     * @param string $dtU
     */
    public function setDtU($dtU)
    {
        $this->dtU = $dtU;
    }

    /**
     * Obtener el estado del registro
     * Registro activo  Si, inactivo = No
     * @return string
     */
    public function getCActivo()
    {
        return $this->cActivo;
    }

    /**
     * Establecer el estado del registro
     * Registro activo  Si, inactivo = No
     * @param string $cActivo
     */
    public function setCActivo($cActivo)
    {
        $this->cActivo = $cActivo;
    }

    /**
     * Obtener si esta borrado el registro
     * Registro borrado = Si, no borrado = No
     * @return string
     */
    public function getCBorrado()
    {
        return $this->cBorrado;
    }

    /**
     * Establecer si esta borrado el registro
     * Registro borrado = Si, no borrado = No
     * @param string $cBorrado
     */
    public function setCBorrado($cBorrado)
    {
        $this->cBorrado = $cBorrado;
    }

    /**
     * Obtener  los campos y
     * las propiedades de la tabla
     * @return mixed
     */
    public function getTableMeta()
    {
        self::setConexion();
        $ssql = "describe " . self::$tabla;
        $rs = self::$conn->select($ssql);

        if ($rs) {
            $rs = $rs->fetchAll(PDO::FETCH_OBJ);
        }
        return $rs;
    }

    /**
     * Establece las propiedades del log cuando se inserta o actualiza
     * @param $parametros
     * @param $accion
     * @return array
     */
    public function propiedades_log_action($parametros, $accion)
    {
        //cuando se inserta se añaden todos los parametros
        if ($accion == 'insert') {
            $array_log = array('idA'      => 51, //TODO cambiar el numero por el id del usuario logado
                               'idU'      => 60,
                               'dtA'      => date('Y-m-d H:i:s'),
                               'dtU'      => date('Y-m-d H:i:s'),
                               'cActivo'  => 'Si',
                               'cBorrado' => 'No'
            );
        //cuando es distinto a insertar solo se actualizan los datos del registro
        } else {
            $array_log = array('idU' => 1, 'dtU' => date('Y-m-d H:i:s')); //TODO cambiar el numero por el id del usuario logado
        }
        //unir el array log al array pasado con los parametros de manipulacion del registro
        $array_result = array_merge($parametros, $array_log);

        //establecer los valores del log del registro en las propiedades del objeto
        foreach ($array_log as $prop => $valor) {
            $this->__set($prop, $valor);
        }
        return $array_result;
    }

    /**
     * Crear un arrary para usar el log de los registros
     * @return array
     */
    private function propiedades_log()
    {
        $propslog = array('idA'      => null,
                          'idU'      => null,
                          'dtA'      => null,
                          'dtU'      => null,
                          'cActivo'  => null,
                          'cBorrado' => null
        );
        return $propslog;
    }


    /**
     * Guardar los datos de las propiedades del objeto
     * haciendo un insert o un update
     * @param bool $incluirCamposLog  True cuando se quiere usar el log
     * @return mixed
     */
    public function guardar($incluirCamposLog = true)
    {
        //recorre todas las clases padres para obtener las propiedades
        foreach ($this->getParents() as $clase) {
            $parametros = $clase::getPropObj();
        }
        //si la clase actual tiene propiedade a añadir se añade al array de parametros
        if(!empty($this->getPropObj())) {
            $parametros = array_merge($parametros, $this->getPropObj());
        }

        //si se ha pasado un id, hay que hacer un insert
        if (!$this->{self::$id}) {
            if ($incluirCamposLog) {
                $parametros = $this->propiedades_log_action($parametros, "insert");
            }
           //realizar el insert
            $rs = self::$conn->insert(self::$tabla, $parametros, "test");
      //      $this->setIdUser(self::$conn->lastInsertId());     //TODO Pasar esta linea a la clase  usuario
        } else {

            if ($incluirCamposLog) {
                $parametros = $this->propiedades_log_action($parametros, "update");
            }
            //realizar el update
            $rs = self::$conn->update(self::$tabla, $parametros, array(ID => $this->{ID}));
        }
        // var_dump($parametros);
        return $rs;
    }

    /**
     * Obtener el id del ultimo registro insertado
     * @return mixed
     */
    public function getlastInsertId(){
        return self::$conn->lastInsertId();
    }

    /**
     * Obtener el numero de registros afectados
     * @return mixed
     */
    public static function getRowCount(){
        $rowCount = self::$conn->getRowCount();
        return $rowCount;
    }

    /**
     * Alternar el estado del registro,
     * activandolo o desactivandolo
     * @return mixed
     *
     */
    public function toggle_registro()
    {
        ($this->getCActivo() == 'Si') ? $this->setCActivo('No') : $this->setCActivo('Si');
        $rs = self::$conn->update(self::$tabla, array('cActivo' => $this->getCActivo()), array(ID => $this->{ID}));
        return $rs;
    }

    /**
     * Establece la propiedad de borrado,
     * ocultando el registro desde el UI
     * @return mixed
     */
    public function borrar()
    {
        $this->setCBorrado('Si');
        $rs = self::$conn->update(self::$tabla, array('cBorrado' => $this->getCBorrado()), array(ID => $this->{ID}));
        return $rs;
    }

    /**
     * Elimina el registro de la tabla
     * @return mixed
     */
    public function eliminar()
    {
        $rs = self::$conn->delete(self::$tabla, array(ID => $this->{ID}));
        return $rs;
    }

    /**
     * Obtener los datos del ID y
     * devuele un objeto
     * @param $id   Id del elemento de la tabla
     * @return object|null con los datos del elemento
     */
    public static function getIdObj($id)
    {
        //establecer los parametros de conexion
        self::setConexion();

        $ssql = "select * from " . self::$tabla . " where " . ID . " =" . $id;
        $ssql .= " and cActivo = 'Si' and cBorrado = 'No'; ";
        $rs = self::$conn->select($ssql);

        if ($rs) {  //si existe el elemento
            $rs = $rs->fetch(PDO::FETCH_OBJ);   //guardamos en una variable como objeto

            $obj = new self();            //creamos un objeto del tipo en el que estamos

            $props = parent::getPropClass();  //array con las propiedades de la clase
            $props = array_merge($props, self::propiedades_log()); //añadimos a las propiedades del objeto, las propiedade nuevas de log

            foreach (array_keys($props) as $prop) {
                $obj->__set($prop, $rs->$prop);  //establecemos los valores de las propiedades
            }
            $rs = $obj;  //guardamos el objeto en la variable que vamos a devolver
        } else {
            $rs = null;
        }
        return $rs;
    }



    /**
     * Devuelve los registros como un array de objeto
     * @param null $limit_inf limite inferior o cantidad de registros a devolver cuando $limit_sup es null
     * @param null $limit_sup cantidad de registros a devolver
     * @return array|ArrayObject|null
     */
    public static function getAllObj($limit_inf = null, $limit_sup = null)
    {
        self::setConexion();
        //recoger el total de registros
        $ssql = "select count(*) from " . self::$tabla. " where cActivo = 'Si' and cBorrado = 'No' ";
        $rs = self::$conn->select($ssql);
        self::$conn->setRowCount($rs->fetch()[0]);  //almacenar la cuenta total de registros


        $ssql = "select  * from " . self::$tabla;
        $ssql .= " where cActivo = 'Si' and cBorrado = 'No' ";

        //establecer los limites de registros a devolver
        if (!is_null($limit_inf)) {
            if ($limit_inf > 0 && is_null($limit_sup) || !is_null($limit_sup)) {
                $ssql .= " limit {$limit_inf}";
            }
            if (!is_null($limit_sup)) {
                $ssql .= ",{$limit_sup} ";
            }
        }


        $rs = self::$conn->select($ssql);

        $props = parent::getPropClass();  //array de la lista de propiedades
        $props = array_merge($props, self::propiedades_log());  //añadir las propiedades de log

        if ($rs) {
            $result = new ArrayObject(); //creacion de un array de objetos
            $rs = $rs->fetchAll(PDO::FETCH_OBJ); //guardar todos los registros como objetos en una variable

            //recorrer cada objeto y guardarlo en un array de objetos para devolverlo del tipo usado
           foreach ($rs as $row) {
                $obj = new self();
                foreach (array_keys($props) as $prop) {
                    $obj->__set($prop, $row->$prop);
                }
                $result[] = $obj;
            }
            $rs = $result;
        } else {
            $rs = null;
        }
        return $rs;
    }

    /**
     * Obtener el registro como un array
     * @param $id elemento a devolver
     * @return null|array
     */
    public static function getId($id)
    {
        self::setConexion();
        $ssql = "select * from " . self::$tabla . " where " . ID . " =" . $id;
        $rs = self::$conn->select($ssql);
        if ($rs) {
            $rs = $rs->fetch();
        } else {
            $rs = null;
        }
        return $rs;
    }


    /**
     * Obtener todos los registro como elementos de un array
     * @param int $tipoAsoc Tipo de asociacion de los registros
     * @param null $limit_inf limite inferior o cantidad de registros a devolver cuando $limit_sup es null
     * @param null $limit_sup cantidad de registros a devolver
     * @return null
     */
    public static function getAll($tipoAsoc = PDO::FETCH_ASSOC, $limit_inf = null, $limit_sup = null )
    {
        self::setConexion();
        //recoger el total de registros
        $ssql = "select count(*) from " . self::$tabla. " where cActivo = 'Si' and cBorrado = 'No' ";
        $rs = self::$conn->select($ssql);
        self::$conn->setRowCount($rs->fetch()[0]);  //almacenar la cuenta total de registros


        $ssql = "select * from " . self::$tabla;
        $ssql .= " where cActivo = 'Si' and cBorrado = 'No' ";

        if (!is_null($limit_inf)) {
            if ($limit_inf > 0 && is_null($limit_sup) || !is_null($limit_sup)) {
                $ssql .= " limit {$limit_inf}";
            }
            if (!is_null($limit_sup)) {
                $ssql .= ",{$limit_sup} ";
            }
        }

        $rs = self::$conn->select($ssql);

        if ($rs) {
            $rs = $rs->fetchAll($tipoAsoc);
        } else {
            $rs = null;
        }
        return $rs;
    }


    /**
     * Obtener los registros de una consulta pasada por parametro
     * @param $ssql instruccion sql
     * @param array $param parametros de la consulta
     * @param boolean $asoc  Si se usan parametros con sustitucion de nombre o con signos de ?
     * @return null
     */
    public static function getRow($ssql,$param=null,$asoc=null)
    {
        self::setConexion();
        $rs = self::$conn->select($ssql,$param,$asoc);
        if ($rs) {
            $rs = $rs->fetch();
        } else {
            $rs = null;
        }
        return $rs;
    }

}

?>