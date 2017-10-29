<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 16/08/2017
 * Time: 20:58
 *
 * vista del modulo user
 */

require_once ("/app/lib/cabecera.php");

?>


<!--<form action="" id="frmCuerpo" name="frmCuerpo" method="post">-->
<!--<div id="contenido">-->

    <?php
    if (!empty($_POST)) {
        require_once("/app/mod/".$_POST['hmod']."/view/view.php");

    }
        ?>

<!--</div>-->
    <?php

    require_once (PATH . PROJECT . APP. "/tpl/tpl.php");
   // include_once (PATH . PROJECT . APP ."/lib/footerForm.php");

?>
