<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 16/08/2017
 * Time: 20:58
 *
 * vista del modulo user
 */
//Util::VariablesServidor();


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title></title>


</head>
<body>
Index dentro de mod
<div id="contenido">
    <?php require_once("/view/view.php"); ?>

    </div>

</body>
</html>

<script>
    cambiarTitulo('<?php echo $GLOBALS['clase']?>');
</script>
