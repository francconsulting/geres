<?php

/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 23/07/2017
 * Time: 19:10
 */
class Util
{


    /**
     *
     * @return string
     */
    public static function getSalt($tipoHash = '$6$rounds=5000$')
    {
        $caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890./";
        $salt = "";
        for ($i = 5; $i < 30; $i++) {
            $salt .= $caracteres[rand(0, 63)];
        };
        return $tipoHash . $salt;
    }


    /**
     * Encriptar cadena para añadir seguridad
     * @param $cadena  String de caracteres a encriptar
     * @param $key     String para usar para encriptar
     * @return string  Cadena encritada
     */
    public static function encriptar($cadena, $key = null)
    {
        $output = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key),
            $cadena, MCRYPT_MODE_CBC, md5(md5($key))));
        return $output;
    }

    /**
     * Desencriptar una cadena encriptada
     * @param $cadena  String a desencriptar
     * @param $key     String a usar para desencriptar
     * @return string  cadena desencriptada
     */
    public static function desencriptar($cadena, $key = null)
    {
        $output = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256,
            md5($key), base64_decode($cadena), MCRYPT_MODE_CBC,
            md5(md5($key))), "\0");
        return $output;
    }


    //PARA MOSTRAR TODAS LAS VARIABLES DEL SERVIDOR

    public static function VariablesServidor()
    {
        $VariablesServidor = "<b><u><br>VARIABLES DE SERVIDOR<br></u></b>";
        foreach ($_SERVER as $VServidorName => $VServidorValor) {
            $VariablesServidor = $VariablesServidor . "<span style='font-size:12px;font-family:calibri;verdana'><b>" . $VServidorName . "</b> = " . $VServidorValor . "</span><br>";
        }
        echo $VariablesServidor;
    }


    //Métodos para manejo de fecha
   public static function fecha($fecha){

        $fecha=str_replace("'","",$fecha);
        $fecha=explode("-",$fecha);

        $dia=$fecha[0];
        $mes=$fecha[1];
        $anio=substr($fecha[2],0,4);
        $hora=substr($fecha[2],5,2);
        $min=substr($fecha[2],8,2);
        $sec=substr($fecha[2],11,2);
        echo " dia:  ".$fecha[0];
        echo " mes:  ".$fecha[1];
        echo " año:  ". substr($fecha[2],0,4);
        echo " hora: ". substr($fecha[2],5,2);
        echo " min:  ". substr($fecha[2],8,2);
        echo " sec:  ". substr($fecha[2],11,2);
       // echo " ahora: ".now();
        $fecha=array("dia"=>$dia,"mes"=>$mes,"anio"=>$anio,"hora"=>$hora,"min"=>$min,"sec"=>$sec);
        return $fecha;
    }

    /**
     * obtener url externa
     * @param $url
     * @return mixed|string
     */
    public static function file_get_contents_curl($url)
    {
        if (strpos($url, 'http://') !== false) {
            $fc = curl_init();
            curl_setopt($fc, CURLOPT_URL, $url);
            curl_setopt($fc, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($fc, CURLOPT_HEADER, 0);
            curl_setopt($fc, CURLOPT_VERBOSE, 0);
            curl_setopt($fc, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($fc, CURLOPT_TIMEOUT, 30);
            $res = curl_exec($fc);
            curl_close($fc);
        } else {
            $res = file_get_contents($url);
        }
        return $res;
    }

    public static function noCache()
    {
        header("Expires: Tue, 01 Jul 2001 06:00:00 GMT");
        header("Last - Modified:" . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache - Control: no - store, no - cache, must - revalidate");
        header("Cache - Control: post - check = 0, pre - check = 0", false);
        header("Pragma: no - cache");
    }




}