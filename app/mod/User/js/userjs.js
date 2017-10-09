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


    if($("#haccion").val()=="registrar"){
        $("#containerUser").removeClass('modal');
    }else{

        $("#containerUser").addClass('modal');
        $("#contentUser").show();
    }
   // callAjax("./app/mod/User/view/modules/datos.php", showTb, null, "POST", "HTML");
    $('#idRecarga').click(function(){
        tabla.ajax.reload();
    });
   Table();
  /*  $(".eliminar").click(function(){
        alert('ss');
    });*/
});
var getDataUpdate = function (tbody, table){
    alert(tbody);
    $(tbody).on('click', "button.editar", function(){
        var data = table.row( $(this).parents("tr") ).data();
        console.log(data);
        tabla.ajax.reload(null, false);
    });

}
var getDataEliminar = function (tbody, table){
    //alert(tbody);
    $(tbody).on('click', "button.eliminar", function(){
        var data = table.row( $(this).parents("tr") ).data();
        console.log(data);
        borrar(data.idUser);
        tabla.ajax.reload(null, false);
    });

}

var tabla;
function Table(){
    //Datatables
    // $("#listaUsuario").DataTable();
   tabla =  $('#listaUsuario').DataTable({
        "ajax":"app/mod/user/view/modules/datos.php",
       "columns":[
           {"data":"idUser"},
           {"data":"sNombre"},
           {"data":"sApellidos"},
           {"data":"sPassword"},
           {"data":"aRol"},
           {"defaultContent": "<button type='button' class='editar btn btn-primary'><i class='glyphicon glyphicon-pencil'></i></button>\t<button type='button'  class='eliminar btn btn-danger' data-toggle='modal' data-target='#modalEliminar' ><i class='glyphicon glyphicon-trash'></i></button>"}

        ],
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "stateSave": true, //guardar la pagina
        "deferRender": true,
        "language": {
            "loadingRecords": "cargando datos...",
            "processing": "procesando...",
            "zeroRecords": "no hay registros encontrados"
        },
        "drawCallback": function( settings ) {
            // $('#listaUsuario').hide();
        },
        "preDrawCallback": function(settings) {
            // alert( 'PREEEEE DataTables has finished its initialisation.' );
        }

//       "ajax":"/geres/app/mod/User/view/modules/Usermodule.php"
    });
   getDataUpdate("#listaUsuario tbody", tabla);
    getDataEliminar("#listaUsuario tbody", tabla);
}


function borrar(id) {
    // console.log(this);
   alert('user:'+id);

    param = {
        'idUser': id,
        'accion': 'del'
    }
    var ok = confirm("deseas borrar?");
    if (ok) {
        //callAjax("./app/mod/User/view/view.php", showTb, param, "POST", "HTML");
        callAjax("./app/mod/User/view/modules/datos.php", Table, param, "POST", "json");
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
alert(result);
    //$("#contenido").html("");
    $("#contenido").html(result);
    //$('#listaUsuarioTmp').hide();
    //$('#listaUsuarioTmp').attr("id","listaUsuario");

   // $("#haccion").val("");
}

function limpiarForm(){
    $("#txtNombre").val("");
    $("#txtApellidos").val("");
    $("#txtRol").val("");
    $("#idUser").val("");
    $("#containerUser").hide();
}
