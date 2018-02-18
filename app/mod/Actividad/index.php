<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 24/08/2017
 * Time: 22:34
 */

$GLOBALS["clase"] = "Actividad";
//setcookie('COOKIE-SESION',md5(APP.DIRMOD.$GLOBALS["clase"]),-1,'/');
setCookie('PATHMOD',Crypto::cryptoJsAesEncrypt('', APP.DIRMOD."\\".$GLOBALS["clase"]));
// cargar los css y js generales necesarios para el funcionamiento del módulo
echo Helper::getCss(array('common', 'js/jQuery-File-Upload/css'));
echo Helper::getJs(array(
    'js/jQuery-3_2_1',
    'js/common',
    'js/func_async',
    'js/bsValidator/bootstrapValidator.min',
    'js/bsValidator/language/es_ES',
    DIRMOD.'/'.$GLOBALS['clase'].'/js/actividadjs',
    'js/cryptojs-aes-php-js/aes',
    'js/cryptojs-aes-php-js/aes-json-format',
    'js/ckeditor/ckeditor',
    'js/ckeditor/adapters/jquery'
));


//vista principal a cargar
include(MODULO . "/view/list.php");

//obtener el contenido de la pagina con el formulario popup
$profile = file_get_contents(PATH.PROJECT.APP. DIRTEMPLATE. "/modal_tpl.php", FILE_USE_INCLUDE_PATH);
echo $profile;


ob_end_flush();
/******
 * cerrar conexion con bd
 */
${CONN} = Db::cerrar();

?>

