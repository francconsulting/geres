<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 13/08/2017
 * Time: 19:55
 */

//var_dump($rows->getPropObj()['idUser']);
//foreach ($rows->getPropObj() as $key => $value){
 //   echo $key." ".$value ."<br/>";

//}
//var_dump($rows);
/*if (isset($rows)) {
    echo $rows->idUser;
}*/
?>
<div id="containerUser" >
    <div id="contentUser">
        <input id="cerrar-modal" name="modal" type="radio" />    <label for="cerrar-modal"> X </label>
        Nombre:<input type="text" id="txtNombre" name="txtNombre" value="<?php if(isset($rows)){echo $rows->sNombre;} ?>" >
    Apellido:<input type="text" id="txtApellidos" name="txtApellidos" value="<?php if(isset($rows)){echo $rows->sApellidos;}?>">
    Rol:<input type="text" id="txtRol" name="txtRol" value="<?php if(isset($rows)){echo $rows->aRol;}?>">
    <input type="hiddenn" id="idUser" name="idUser" value="<?php if(isset($rows)){echo $rows->idUser;}?>">
    <input type="submit" id="btnAceptar" value="Aceptar">
    <input type="button" id="btnVolver" value="volver" >
    </div>
</div>



