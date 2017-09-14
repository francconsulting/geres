<?php

/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 22/08/2017
 * Time: 19:16
 */
class Helper
{



    public static function getCss($aClass, $media='screen'){
        $linkCss =null;
        foreach ($aClass as $Class) {
            $linkCss .= "<link rel=\"stylesheet\" href=\"http://{$_SERVER['SERVER_NAME']}".PROJECT.APP."/css/{$Class}.css\" media=\"{$media}\" >";
            //$linkCss .= "<link rel=\"stylesheet\" href=\"../../css/{$Class}.css\" media=\"{$media}\" >";
        }
       return $linkCss;
    }

    public static function getJs($aJs){
        $linkJs = null;
        foreach ($aJs as $Js) {
            $linkJs .= "<script src=\"http://{$_SERVER['SERVER_NAME']}".PROJECT.APP."/{$Js}.js\" ></script>";
        }
        return $linkJs;
    }

}