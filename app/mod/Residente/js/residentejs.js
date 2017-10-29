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
    $("#addUser").click(ver);
   Table();
  /*  $(".eliminar").click(function(){
        alert('ss');
    });*/




});
var inputDesactivo;

var getDataView = function (tbody, table){
    // alert(tbody);
    $(tbody).on('click', "button.ver", function(){
        var datos = table.row( $(this).parents("tr") ).data();
         //console.log(datos);
       // console.log(table.page.len());
        inputDesactivo = true;
        ver(datos);
    });

}
var getDataUpdate = function (tbody, table){
   // alert(tbody);
    $(tbody).on('click', "button.editar", function(){
        var datos = table.row( $(this).parents("tr") ).data();
        //console.log(datos);
        //console.log(table.page.len());
        num_index(table);
        tabla.ajax.reload(null, false);

        inputDesactivo = false;
        ver(datos);


    });

}
var getDataEliminar = function (tbody, table){
    //alert(tbody);
    $(tbody).on('click', "button.eliminar", function(){
        var datos = table.row( $(this).parents("tr") ).data();
        //console.log(data);
        borrar(datos.idUser);
      //  tabla.ajax.reload(null, false);
       // num_index(table);
    });

}

var tabla;
function Table(){
    //Datatables
    // $("#listaUsuario").DataTable();
   tabla =  $('#listaUsuario').DataTable({
       // "ajax":"app/mod/user/view/modules/datos.php",
       "ajax" : {
            "method" : "POST",
            "url" : "app/mod/residente/view/modules/datos.php"
       },
       "columns":[
           {"data":"num"},
           {"data":"sDni"},
           {"data":"sNombre"},
           {"data":"sApellidos"},
          // {"data":"sPassword"},
           {"data":"aRol"},
           {"defaultContent": "<button type='button' class='ver btn btn-primary'><i class='glyphicon glyphicon-eye-open'></i></button>\t<button type='button' class='editar btn btn-primary'><i class='glyphicon glyphicon-pencil'></i></button>\t<button type='button'  class='eliminar btn btn-danger' data-toggle='modal' data-target='#modalEliminar' ><i class='glyphicon glyphicon-trash'></i></button>"}

        ],
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "stateSave": true, //guardar la pagina
        "deferRender": true,
        /*"language": {
            "loadingRecords": "cargando datos...",
            "processing": "procesando...",
            "zeroRecords": "no hay registros encontrados"
        },*/
        "language" : idioma_espanol,
        "drawCallback": function( settings ) {
            // $('#listaUsuario').hide();
        },
        "preDrawCallback": function(settings) {
            // alert( 'PREEEEE DataTables has finished its initialisation.' );
        }

//       "ajax":"/geres/app/mod/User/view/modules/Usermodule.php"
    });
    getDataView("#listaUsuario tbody", tabla);
   getDataUpdate("#listaUsuario tbody", tabla);
    getDataEliminar("#listaUsuario tbody", tabla);

   //num_index(tabla);


}

var num_index = function(tabla){
    var x ;
    var pagActual = tabla.page()+1;
    //console.log(pagActual);
    var numViewRecod = tabla.page.len();
     x = ((numViewRecod * pagActual)-numViewRecod)+1;
   // console.log ("Valor de la X" + x);
    tabla.on( 'order.dt search.dt', function () {
        tabla.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );

    } )

        //.draw();
}

var idioma_espanol =  {
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
    },
        "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }

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
       // callAjax("./app/mod/User/view/modules/datos.php", Table, param, "POST", "json");
        callAjax("./app/mod/User/view/modules/datos.php", function(result){
            console.log(result);
            tabla.ajax.reload(null, false);
            }
            , param, "POST", "json");
    }


}
function ver(datos) {
     //console.log(data);
   /* param = {
        'idUser': id,
        'accion': 'ver'
    }
        callAjax("./app/mod/User/view/view.php", showTb, param, "POST", "HTML");
        */

    $("#dataUser").modal();
    getDatos(datos);

}

function getElementForm(formulario){
    var datos = new Object();
    $(formulario).each(function(index,element){
        //console.log(index+ "  "+ element.id+" : " +element.value);
       // nombre = eval(element.id);
         datos[element.id] = element.value;
    });
    return datos;
}

function actualizar(datos) {
    var bUpdate = false;
    var nuevosDatos = getElementForm('#profile input');
  //  console.log(nuevosDatos);
    console.log(datos);
    var param = new Object();
    for (var item  in nuevosDatos){
      //  alert(item+ "  "+nuevosDatos[item]+"   -> "+data[item]);
        if (datos[item]==undefined){datos[item]=''}
        if(nuevosDatos[item] != datos[item]){
            bUpdate = true;
        }
        param[item] = nuevosDatos[item];

    }
  //  console.log(param);
    if (bUpdate){
        param['accion'] = 'update';
        callAjax("./app/mod/User/view/modules/datos.php", function(){
            if($("#fAvatar")[0].files[0] != undefined) {
                cargarArchivo();
            }else {
                $("#dataUser").modal('hide');
                tabla.ajax.reload(null, false);
            }
        }, param, "POST", "json");
    }

    /* param = {
         'idUser': data.idUser,
         'datos' : data,
         'sNombre' : $("#txtNombre").val(),
         'accion': 'update'
     }*/
    //callAjax("./app/mod/User/view/modules/datos.php", Table, param, "POST", "json");


}

function getDatos(datos){
   return callAjax("./app/mod/User/view/modules/profile.php",function(result){
       console.log(datos);
            $("#contenidoModal").html(result);
            if (datos.idUser!= undefined) {
                $("#NombrePerfil").html(datos.sNombre);
                $("#ApellidosPerfil").html(datos.sApellidos);
                console.log("avatar: "+datos.sAvatar);
                var avatar = '',
                    genero = '';
                console.log("genero: "+datos.cGenero);
                (datos.cGenero == '') ? genero = 'M' : genero = datos.cGenero;

                if(datos.sAvatar == null){
                    (genero == 'H') ? avatar = 'avatar_h1.svg' : avatar = 'avatar_m1.svg';
                }else{
                    avatar = datos.sAvatar;
                }
                console.log(avatar + ' '+ genero);

                $("#avatar").attr("src", "./app/images/avatar/" + avatar);
                $("#avatar").width(100);
                $("#avatar").height(100);
                $("#sAvatar").val(avatar);
                $("#cGenero").val(genero);
                $("#idUser").val(datos.idUser);
                $("#sNombre").val(datos.sNombre);
                $("#sApellidos").val(datos.sApellidos);

                var rol = datos.aRol.replace(" ","").split(",");
                var arrayRol = [];
                rol.forEach(function(element){
                       console.log($( "[name=aRolAux]" ));
                    $( "[name=aRolAux]" ).each(function(index){
                       // if ($( "[name=aRolAux]:checkbox" ).val()==element){
                        console.log($( "[name=aRolAux]" )[index].value + "  "+ element);

                        if( $( "[name=aRolAux]" )[index].value == element){
                            arrayRol.push($( "[name=aRolAux]" )[index].value);
                            console.log($(this).attr('checked', true));
                        }

                      //  }
                    });

                });


                if(genero == 'H'){
                    $("#cGeneroH").prop('checked', true);
                }else{
                    $("#cGeneroM").prop('checked', true);
                }

                //$("#sPassword").val(datos.sPassword.substr(0,10));
                $("#sEmail").val(datos.sEmail);
                $("#aRol").val(datos.aRol);
                $("#sTelefono1").val(datos.sTelefono1);
                $("#sTelefono2").val(datos.sTelefono2);
                $("#sDireccion").val(datos.sDireccion);
                $("#sCodigoPostal").val(datos.sCodigoPostal);

                $("#auditoria").html("Actualizado: " + datos.dtU);


                $("#btnGuardar").hide();

                if(inputDesactivo) {
                    $("#btnActualizar, #auditoria").hide();
                }
                $("form input").attr("disabled", inputDesactivo);


                $( "[name=aRolAux]:checkbox" ).on('change', function (){
                    if($(this).is(':checked')){
                        arrayRol.push($(this).val());
                    }else{
                       var indice = arrayRol.indexOf($(this).val());
                       arrayRol.splice(indice,1); //eliminar elemento
                    }
                    arrayRol.sort()
                    $("#aRol").val(arrayRol);
                });
                console.log(avatar);
                $( "[name=cGeneroAux]:radio" ).on('click', function (){
                    console.log($(this).val());
                    if($(this).is(':checked')){
                     $("#cGenero").val($(this).val());
                    if(avatar == 'avatar_m1.svg'  || avatar == 'avatar_h1.svg') {
                        if ($(this).val() != 'H') {
                            avatar = 'avatar_m1.svg'
                        } else {
                            avatar = 'avatar_h1.svg'
                        }
                        $("#avatar").attr("src", "./app/images/avatar/" + avatar);
                        $("#avatar").width(100);
                        $("#avatar").height(100);
                        $("#sAvatar").val(avatar);
                    }
                    }


                });

            }

            $("#profile").bootstrapValidator({
               message : 'Valor errorneo',
               feedbackIcons: {
                   valid: 'glyphicon glyphicon-ok',
                   invalid: 'glyphicon glyphicon-remove',
                   validating: 'glyphicon glyphicon-refresh'
               },
               fields : {
                   sNombre : {
                       validators : {
                           notEmpty :  bvNoVacio,
                           stringLength : {
                                min : 2,
                                max : 45,
                                message : "El nombre debe tener entre 2 y 45 caracteres "
                           },
                           regexp : bvSoloTexto

                       }
                   },
                   sApellidos : {
                       validators : {
                           notEmpty: bvNoVacio,
                           stringLength: {
                               min: 2,
                               max: 90,
                               message : "Los apellidos debe tener entre 2 y 90 caracteres "
                           },
                           regexp : bvSoloTexto
                       }
                   },
                   sPassword : {
                       validators: {
                           notEmpty : {
                                enabled : false
                           },
                           stringLength : {
                               min : 8,
                               max : 15,
                               message : "Mínimo 8 caracteres y máximo 15"
                           },
                           regexp : bvPassword
                       }
                   },
                   sEmail : {
                       validators : {
                           notEmpty : bvNoVacio,
                           emailAddress: 'No es una direccion de email valida.'
                       }
                   },
                   sTelefono1 : {
                       validators : {
                           notEmpty : bvNoVacio,
                           phone: bvTelefono
                       }
                   },
                   sTelefono2 : {
                       validators : {
                           notEmpty : bvNoVacio,
                           phone: bvTelefono
                       }
                   },
                   sCodigoPostal : {
                       validators : {
                           regexp: bvZipCode
                          // regexp : bvZipCode5
                       }
                   },
                   cGeneroAux : {
                     validators : {
                         notEmpty : bvElige
                     }
                   }

               }
           })
                .on('error.form.bv',function(e){
                    //alert('errorr');
                    console.log(e);

                })
                .on('success.form.bv', function(e){
                    $("#cGenero").val($("input[name='cGeneroAux']:checked").val());

                    $("#fAvatar").hide();
                    $("#fAvatar").closest('.fileinput-button').attr('disabled',true);
                    actualizar(datos);
                })
                .on('error.field.bv', function(e, data){
                    // $(e.target)  --> The field element
                    // data.bv      --> The BootstrapValidator instance
                    // data.field   --> The field name
                    // data.element --> The field element
                    console.log(data);
                })
                .on('success.field.bv', function(e, data) {
                    //console.log( data.field);
                    if ($("#sCodigoPostal").val()=='' && data.field=="sCodigoPostal"){
                       data.element
                           .closest('.form-group') //obtener el campo padre
                          .removeClass('has-success')
                           .find('[data-bv-icon-for="sCodigoPostal"]').hide()

                        //data.element.parents('.form-group').find('.form-control-feedback[data-bv-icon-for=sCP]').hide();

                    }
                    if(data.field == 'cGeneroAux'){
                        var padre = data.element.closest('.form-group');
                        var padreAncho = padre.width();
                        var ico = padre.find('[data-bv-icon-for="cGeneroAux"]');
                        ico.offset({left: padre.offset().left+padreAncho-50});
                    }
                })
                .on('error.field.bv', function(e,data){
                    if(data.field == 'cGeneroAux'){
                        var padre = data.element.closest('.form-group');
                        var padreAncho = padre.width();
                       var ico = padre.find('[data-bv-icon-for="cGeneroAux"]');
                        ico.offset({left: padre.offset().left+padreAncho-50});
                    }
                })
                .on('error.validator.bv', function(e, data) { //SOLO UN MENSAJE POR ERROR
                    // $(e.target)    --> The field element
                    // data.bv        --> The BootstrapValidator instance
                    // data.field     --> The field name
                    // data.element   --> The field element
                    // data.validator --> The current validator name
                    data.element
                        .data('bv.messages')
                        // Hide all the messages
                        .find('.help-block[data-bv-for="' + data.field + '"]').hide()
                    // Show only message associated with current validator
                        .filter('[data-bv-validator="' + data.validator + '"]').show();
                })
            ;


         //  $("#btnCargarArchivo").on("click",cargarArchivo);

           $("#profile").submit(function(evt){

               evt.preventDefault();

           })

          // $("#btnActualizar").click(function(){actualizar(datos)});


    /*       $(".form-control").blur(function(){
               $(this).parents("div:first").append("<span class=\"glyphicon glyphicon-ok form-control-feedback\" aria-hidden=\"true\"></span>");
               $(this).parents("div.form-group").addClass("has-success has-feedback");
               //$(this).;
           });*/

        },null,
        "POST",
        "HTML");
}
function previewFile(){

    var file =  $("#fAvatar")[0].files[0];
        fileName = file.name,
        fileExt = fileName.substring(fileName.lastIndexOf('.')+1),
        fileSize = file.size,
        fileType = file.type;
    //visualixar archivo
    if(isImage(fileExt) && pesoImagen(fileSize)) {
        var reader = new FileReader();
        reader.onload = function () {
            $('#avatar').attr("src", reader.result);
            $("#avatar").width(100);
            $("#avatar").height(100);
            $("#sAvatar").val(file.name);

        };
        reader.onerror = function () {
            console.log("error");
        }

        reader.readAsDataURL(file);
    }else{
        $("#sAvatar")
            .closest('.form-group') //obtener el campo padre
            .addClass('has-feedback has-error')
            .find('[data-bv-icon-for="fAvatar"]').show();

        $("#msgfile")
            .addClass('has-error')
            .append('<small style="" class="help-block"  data-bv-for="sAvatar" data-bv-result="INVALID">Por favor, revisa el tamaño y el tipo de archivo (jpg, gif, png, jpeg) </small>')
            .append('<i style="" class="form-control-feedback glyphicon glyphicon-remove" data-bv-icon-for="sAvatar"></i>')
        //$('#avatar').attr("src","");
        //$("#fAvatar").val('');
    }
}

function cargarArchivo(){
    var file =  $("#fAvatar")[0].files[0];
    if (file != undefined) {
        var fileName = file.name,
            fileExt = fileName.substring(fileName.lastIndexOf('.') + 1),
            fileSize = file.size,
            fileType = file.type;

        if (isImage(fileExt) && pesoImagen(fileSize)) {


            var formData = new FormData(document.getElementById('profile'));
            formData.append('accion', 'upload');


            console.log(formData);
            uploadAjax('./app/mod/User/view/modules/datos.php', function (result) {
                // alert('fin');
                console.log(result.exito);
                /* var dataImg = result;
                 $("#avatar").attr("src",dataImg.avatar);
                 $("#avatar").width(100);
                 $("#avatar").height(100);*/
                if (result.exito){
                    $("#dataUser").modal('hide');
                    tabla.ajax.reload(null, false);
                }

            }, formData);

        } else {
            alert('Comprueba el tipo y tamaño de imagen');
            $("#fAvatar").val('');
            return false;

        }
    }
console.log(file);
}

function isImage(extension){
    switch(extension.toLowerCase())
    {
        case 'jpg': case 'gif': case 'png': case 'jpeg':
        return true;
        break;
        default:
            return false;
            break;
    }
}

function pesoImagen(peso){
    console.log(peso);
    if(peso<2000000){ //2Mg
        return true;
    }else{
        return false;
    }
}

var bvNoVacio =  {
    message : 'El campo es requerido. Por favor introduce un valor.'
}
var bvElige = {
    message : 'Por favor, debes elegir un valor.'
}
var bvSoloTexto = {
    regexp : /^[a-zA-Z\s]+$/i,
    message : "Por favor no estan permitido números ni caracteres especiales"
}
var bvSoloNumero = {
    regexp : /^[0-9]+$/i,
    message : "Por favor solo se permiten números"
}
var bvPassword = {
    //regexp : /(?=^.{8,15}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/  , //letra May, letra min, 1 num ó 1 carct esp,
    regexp : /(?=^.{8,15}$)((?=.*\d)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/  , //letra May, letra min, 1 num, 1 carct esp,
    message : "Al menos una letra Mayúscula.<br/>Al menos una letra minúscula.<br/>Al menos un dígito.<br/>Al menos un caracter especial.<br/>No se permiten espacios en blanco"
}
var bvTelefono = {
    country : 'ES',
    message: 'El número de teléfono en %s no es un número válido.'
}
var bvZipCode = {
    regexp: /^\d{5}$/,
    message: 'Por favor, el Código Postal debe contener 5 dígitos.'
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
