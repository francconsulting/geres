<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 03/08/2017
 * Time: 22:00
 */

define("CONN", "conn");  //definicion del nombre de la varible
//var_dump(CONN);
${CONN} = Db::conex();

//var_dump(${CONN});
if (empty(${CONN}->getConn())){
    die ("Error: no se ha podido conectar con la base de datos.<br/>".${CONN}->getErrorConn());
}

 ?>