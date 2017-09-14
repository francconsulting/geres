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
     * @return string
     */
    public function getIdA()
    {
        return $this->idA;
    }

    /**
     * @param string $idA
     */
    public function setIdA($idA)
    {
        $this->idA = $idA;
    }

    /**
     * @return string
     */
    public function getIdU()
    {
        return $this->idU;
    }

    /**
     * @param string $idU
     */
    public function setIdU($idU)
    {
        $this->idU = $idU;
    }

    /**
     * @return string
     */
    public function getDtA()
    {
        return $this->dtA;
    }

    /**
     * @param string $dtA
     */
    public function setDtA($dtA)
    {
        $this->dtA = $dtA;
    }

    /**
     * @return string
     */
    public function getDtU()
    {
        return $this->dtU;
    }

    /**
     * @param string $dtU
     */
    public function setDtU($dtU)
    {
        $this->dtU = $dtU;
    }

    /**
     * @return string
     */
    public function getCActivo()
    {
        return $this->cActivo;
    }

    /**
     * @param string $cActivo
     */
    public function setCActivo($cActivo)
    {
        $this->cActivo = $cActivo;
    }

    /**
     * @return string
     */
    public function getCBorrado()
    {
        return $this->cBorrado;
    }

    /**
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

        if ($accion == 'insert') {
            $array_log = array('idA'      => 51,
                               'idU'      => 60,
                               'dtA'      => date('Y-m-d H:i:s'),
                               'dtU'      => date('Y-m-d H:i:s'),
                               'cActivo'  => 'Si',
                               'cBorrado' => 'No'
            );
        } else {
            $array_log = array('idU' => 1, 'dtU' => date('Y-m-d H:i:s'));
        }

        $array_result = array_merge($parametros, $array_log);

        foreach ($array_log as $prop => $valor) { //establecer valores de log del registro
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

    public function guardar()
    {
        // $this->propiedades_log();
        $parametros = parent::getPropObj();  //array con los pares clave-valor de las propiedades
        //$parametros = array_merge($parametros, self::propiedades_log());

        var_dump($parametros);
        if (!$this->{ID}) {
            $parametros = $this->propiedades_log_action($parametros, "insert");
            var_dump($parametros);
            echo "insertttttttttt";
            $rs = self::$conn->insert(self::$tabla, $parametros, "test");
            $this->setIdUser(self::$conn->lastInsertId());
        } else {
            var_dump($parametros);
            echo "updatessssssss";
            $parametros = $this->propiedades_log_action($parametros, "update");

            $rs = self::$conn->update(self::$tabla, $parametros, array(ID => $this->{ID}));
        }
        return $rs;
    }

    /**
     * Deshabilita el registro
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
     * oculta el registro
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

    public static function getIdObj($id)
    {
        self::setConexion();


        $ssql = "select * from " . self::$tabla . " where " . ID . " =" . $id;
        $ssql .= " and cActivo = 'Si' and cBorrado = 'No'; ";
        $rs = self::$conn->select($ssql);

        if ($rs) {
            $rs = $rs->fetch(PDO::FETCH_OBJ);
            //return new self($rs['sNombre'], $rs['sApellidos'], $rs['sPassword'], $rs['aRol'],
            //    $rs['idA'], $rs['idU'], $rs['idUser'], $rs['dtA'], $rs['dtU'],$rs['cActivo'], $rs['cBorrado']);
            //$props = get_class_vars(get_parent_class());

            $obj = new self();            //TODO cambiar nombre variable

            $props = parent::getPropClass();  //array con las propiedades de la clase
            $props = array_merge($props, self::propiedades_log());

            foreach (array_keys($props) as $prop) {
                $obj->__set($prop, $rs->$prop);  //TODO cambiar nombre variable
            }

            $rs = $obj;

        } else {
            $rs = null;
        }
        return $rs;
    }

    public static function getRowCount(){
        $rowCount = self::$conn->getRowCount();
        return $rowCount;
    }

    /**
     * Consulta que devuelve los registros como un array de objeto
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
        $props = array_merge($props, self::propiedades_log());

        $result = new ArrayObject();
        if ($rs) {
            $rs = $rs->fetchAll(PDO::FETCH_OBJ);
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
     * ARRAY
     * @param $idUser
     * @return null
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
     * ARRAY
     * @return null
     */
    public static function getAll($limit_inf = null, $limit_sup = null)
    {
        self::setConexion();
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
            $rs = $rs->fetchAll();
        } else {
            $rs = null;
        }
        return $rs;
    }


}

?>