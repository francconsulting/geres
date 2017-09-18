/**
 * Created by fmbv on 24/08/2017.
 */
//document.write('en common.js hola');

/*$(document).ready(function () {

});
*/



function cambiarTitulo(titulo){
    $("title")[0].innerHTML=titulo;
}

/**
 * envio de formulario con js
 * @param formulario
 * @param url
 */
function enviarForm(formulario, url){
    $("#"+formulario).attr("action",url);
    //$("#"+form).submit();  //TODO ->no funciona ??
    document[formulario].submit();
}