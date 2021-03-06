<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 24/09/2017
 * Time: 13:46
 */

class Login_model extends Login
{
    use \DbCommon;

    private static $conn;
    private static $tabla;
    private static $id;

    /**
     * Login_model constructor.
     * Llamada al constructor padre y
     * establecer los parametros para la conexion
     * con la base de datos
     */
    public function __construct()
    {
        parent::login();
        $this->setConexion(); //establecer los parametros usados en la conexion
    }


    /**
     * Obtener datos de la base de datos según los
     * datos introducidos en el formulario
     * @return null/array con datos del recordset
     */
    public function getDataUser()
    {
        $filtro = ['nombre' => $_POST['usuario']];
        $ssql = "select * from " . self::$tabla . " where sNombre = :nombre";

        $rs = $this->getRow($ssql, $filtro);
        if (!empty($rs)) {
            $this->setLogeado(true);
        } else {
            $this->setLogeado(false);
        }
        return $rs;
    }

    /**
     * Comprobacion y verificacion del password
     * introducido en el formulario
     * @param $input_pass Password introducido
     * @param $rs_pass  Password en la bd
     * @return bool
     */
    public function verifPass($input_pass, $rs_pass)
    {
        $valido = password_verify($input_pass, $rs_pass);
        $this->setLogeado($valido);
        return $valido;

    }
}