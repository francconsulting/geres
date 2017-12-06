<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 06/10/2017
 * Time: 19:39
 */
//Util::VariablesServidor();
// si se intenta acceder poniendo la url directamente
// o no esta definida la variable de sesion o esta vacia
// se reenvia al index

if (empty($_POST) || !isset($_SESSION['SesionUID']) || empty($_SESSION['SesionUID']) ) {
    header("location:./index.php");
}
?>