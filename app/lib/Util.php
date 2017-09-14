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
public static function  getSalt($tipoHash='$6$rounds=5000$'){
    $caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890./";
    $salt = "";
    for ($i = 5; $i < 30; $i++) {
        $salt .= $caracteres[rand(0,63)];
    };
    return $tipoHash.$salt;
}


    /**
     * Encriptar cadena para añadir seguridad
     * @param $cadena  String de caracteres a encriptar
     * @param $key     String para usar para encriptar
     * @return string  Cadena encritada
     */
public static function encriptar($cadena, $key=null){
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
    public static function desencriptar ($cadena,$key=null) {
        $output = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256,
            md5($key), base64_decode($cadena), MCRYPT_MODE_CBC,
            md5(md5($key))), "\0");
        return $output;
    }


    //PARA MOSTRAR TODAS LAS VARIABLES DEL SERVIDOR

    public static function VariablesServidor(){
        $VariablesServidor= "<b><u><br>VARIABLES DE SERVIDOR<br></u></b>";
        foreach ($_SERVER as $VServidorName=>$VServidorValor){
            $VariablesServidor=$VariablesServidor. "<span style='font-size:12px;font-family:calibri;verdana'><b>".$VServidorName."</b> = ".$VServidorValor."</span><br>";
        }
        echo $VariablesServidor;
    }


    /**
     * obtener url externa
     * @param $url
     * @return mixed|string
     */
 public static function file_get_contents_curl($url) {
        if (strpos($url,'http://') !== FALSE) {
            $fc = curl_init();
            curl_setopt($fc, CURLOPT_URL,$url);
            curl_setopt($fc, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($fc, CURLOPT_HEADER,0);
            curl_setopt($fc, CURLOPT_VERBOSE,0);
            curl_setopt($fc, CURLOPT_SSL_VERIFYPEER,FALSE);
            curl_setopt($fc, CURLOPT_TIMEOUT,30);
            $res = curl_exec($fc);
            curl_close($fc);
        }
        else $res = file_get_contents($url);
        return $res;
    }

}