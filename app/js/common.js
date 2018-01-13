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
 * Evitar el envio del formulario pasado por parametros
 * @param idForm    Id del formulario
 */
function noSubmit(idForm) {
    $("#" + idForm).submit(function (evt) {
        evt.preventDefault();
    });
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

/**
 * Capturar todos los elementos del formulario para
 * almacenarlos en un objeto. Se pasa como parametro
 * el id del formulario y los tipos de elementos a capturar.
 * P.Ej. getElementForm('#myForm input');
 * @param formulario   idFormulario
 * @returns {Object}
 */
function getElementForm(formulario) {
    var datos = new Object();
    $(formulario).each(function (index, element) {
        //console.log(index+ "  "+ element.id+" : " +element.value);        // nombre = eval(element.id);
        datos[element.id] = element.value;
    });
    return datos;
}



var menu = function (){
    $(".sidebar-menu a").on('click', function(evt){
       console.log($(this).data().modulo.toUpperCase());
       $("#hmod").val($(this).data().modulo);
        evt.preventDefault();

        enviarForm("frmCuerpo","page.php"); //TODO -> descomentar
    })
}


/**
 * Obtener las cookie que coincida con el nombre pasado por parametros
 * @param nombre String Nombre de la cookie
 * @returns {*} Valor de la cookie
 */
function getCookie(nombre){
    var aCookies = decodeURIComponent(document.cookie).split(";");
    var  signoIgual, sNombreCook, sValorCook = null;
    for (var i = 0; i < aCookies.length; i++) {
        signoIgual = aCookies[i].indexOf("=");
        sNombreCook = aCookies[i].substr(0,signoIgual);
       // alert("array "+i+" "+sNombreCook+ " "+nombre);
        if (sNombreCook == nombre) {
            sValorCook = aCookies[i].substr(signoIgual + 1);
            //  alert("array "+sValorCook);
        }

    }
    return sValorCook;
}