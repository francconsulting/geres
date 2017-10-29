<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 16/09/2017
 * Time: 11:51
 */
define("PATH",$_SERVER['DOCUMENT_ROOT']);  //TODO raiz del proyecto
define ("MODULO",str_replace("view", "", dirname(__FILE__)));

$cfg = (object) parse_ini_file(PATH.'/geres/app/cfg/config_global.ini');

require_once (PATH.'/geres/app/lib/common.php');
require_once(PATH.PROJECT.APP."/db/db.openconex.inc.php");
        $conn = Db::conex();
        $filtro = ['nombre' => $_POST['usuario']];
        $ssql = "select * from User where sNombre = :nombre";
        $rs = $conn->select($ssql,$filtro);
        if ($rs) {
            $rs = $rs->fetch(PDO::FETCH_ASSOC);

            $rs = json_encode($rs);

            echo $rs;
        } else {
            $rs = null;
        }


//print  json_encode($rs);





