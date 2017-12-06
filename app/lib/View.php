<?php

/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 22/08/2017
 * Time: 19:51
 */
class View
{
    private $title;
    private $pag;

    public function __construct($title='Sin Titulo')
    {
        $this->title = $title;
        $this->pag = $this->load_template();

    }



    /* METODO QUE CARGA LAS PARTES PRINCIPALES DE LA PAGINA WEB
     INPUT
     $title | titulo en string del header
     OUTPIT
     $pagina | string que contiene toda el cocigo HTML de la plantilla
     */
    public function load_template($template ='index',$dir_template='template'){
        //$pagina = $this->load_page('./app/User/view/vista.php');
        $this->pag= $this->load_page(PATH.APP.'/'.$dir_template.'/'.$template.'.phtml');

        // $header = $this->load_page('app/views/default/sections/s.header.php');
        //$pagina = $this->replace_content('/\#HEADER\#/ms' ,$header , $pagina);
        $this->pag = $this->replace_content('/\{TITLE\}/ms' ,$this->title , $this->pag);

        //$menu_left = $this->load_page('app/views/default/sections/s.menuizquierda.php');
        //$pagina = $this->replace_content('/\#MENULEFT\#/ms' ,$menu_left , $pagina);
        return $this->pag;
    }

    public function load_content($contenido,$tag = 'CONTENIDO'){
        $this->pag =  $this->replace_content('/\{'.$tag.'\}/ms',$contenido,$this->pag);
        return $this->pag;
    }


    /* METODO QUE CARGA UNA PAGINA DE LA SECCION VIEW Y LA MANTIENE EN MEMORIA
INPUT
$page | direccion de la pagina
OUTPUT
STRING | devuelve un string con el codigo html cargado
*/
    private function load_page($page)
    {
        return file_get_contents($page);
    }


    /* METODO QUE ESCRIBE EL CODIGO PARA QUE SEA VISTO POR EL USUARIO
INPUT
$html | codigo html
OUTPUT
HTML | codigo html
*/
    public function render($html)
    {
        echo $html;
    }

    /* PARSEA LA PAGINA CON LOS NUEVOS DATOS ANTES DE MOSTRARLA AL USUARIO
   INPUT
   $out | es el codigo html con el que sera reemplazada la etiqueta CONTENIDO
   $pagina | es el codigo html de la pagina que contiene la etiqueta CONTENIDO
   OUTPUT
   HTML | cuando realiza el reemplazo devuelve el codigo completo de la pagina
   */
    private function replace_content($in='/\#CONTENIDO\#/ms', $out,$pagina)
    {
        return preg_replace($in, $out, $pagina);
    }

}