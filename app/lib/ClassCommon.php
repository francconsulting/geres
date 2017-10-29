<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 15/10/2017
 * Time: 16:58
 */

/**
 * Metodos comunes a todas las clases
 * Trait classCommon
 */
trait classCommon
{
    /**
     * Obtener las clases padres de las que extiende
     * @param null $class
     * @param array $plist
     * @return array
     */
    public function getParents($class=null, $plist=array()) {
        $class = $class ? $class : $this;
        $parent = get_parent_class($class);
        if($parent) {
            $plist[] = $parent;
            /*Do not use $this. Use 'self' here instead, or you
             * will get an infinite loop. */
            $plist = self::getParents($parent, $plist);
        }
        return $plist;
    }


    /**
     * Obtener array con pares de clave-valor de las propiedades del objeto
     * @return array
     */
    public function getPropObj(){
        return get_object_vars($this);
    }


    /**
     * Obtener un array con las propiedades de la clase
     * @return array
     */
    public function getPropClass(){
        return get_class_vars(__CLASS__);
    }
}