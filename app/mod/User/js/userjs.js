/**
 * Created by fmbv on 24/08/2017.
 */

/**
 * Borrar los datos de la base de datos
 * @param id    Integer con identificador del elemento a borrar de la base de datos
 */
$(document).ready(function () {
    $("#btnVolver").on("click", function(){
        limpiarForm();
    });
    $("#cerrar-modal").on("click", function() {
        limpiarForm();
    });



$("[data-accion]").on("click", function(){
    $("#haccion").val(($(this).data("accion")));
});
});


function borrar(id) {
    // console.log(this);
   //alert('user:'+id);

    param = {
        'idUser': id,
        'accion': 'del'
    }
    var ok = confirm("deseas borrar?");
    if (ok) {
        callAjax("./app/mod/User/view/view.php", showTb, param, "POST", "HTML");
    }


}
function ver(id) {
    // console.log(this);
    //alert('user:'+id);
    param = {
        'idUser': id,
        'accion': 'ver'
    }

        callAjax("./app/mod/User/view/view.php", showTb, param, "POST", "HTML");


}

function showTb(result){
    //alert(result);
    $("#contenido").html("");
    $("#contenido").html(result);
    $("#haccion").val("");
}

function limpiarForm(){
    $("#txtNombre").val("");
    $("#txtApellidos").val("");
    $("#txtRol").val("");
    $("#idUser").val("");
    $("#containerUser").hide();
}
