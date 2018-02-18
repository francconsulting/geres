/**
 * Created by fmbv on 24/08/2017.
 */

//definicion de variables
var inputDesactivo,
    tabla,
    ruta;

$(document).ready(function () {
    ruta = "." + dataDecryp(getCookie("PATHMOD")) //Obtener la ruta del modulo

    /**
     * Funcionalidad en el boton cerrar cuando se hace click
     */
    $("#btnCerrar, button.close").on("click", function () {
        $(".modal-title").parent("div").removeClass('alert alert-error');   //eliminar la clase alert
        $(".modal-title").parent("div").removeClass('bg-light-blue-active');  //añadir la clase de cabecera azul
        $(".modal-title").parent("div").removeClass('alert alert-success');  //añadir la clase
        $("#btnEliminar").remove();         //quitar el boton eliminar
    });


    $("#btnGuardar").hide(); //ocultar el boton guardar que esta en la ventana modal

    var param = {'existe' :0};
    //Actualizar la tabla de registro con el boton Actualizar Tabla
    $('#idRecarga').click(function () {
         tabla.ajax.reload();
    });

    //Añadir nuevo registro
    $("#addActividad").click(function () {
        callAjax('./app/mod/Sesion/controller/sesion_datos.php', function (results) {    //comprobar la sesion si esta activa
            if (!results.signIn) {
                ventanafinSesion()
            } else {
                $(".modal-title").parent("div").addClass('alert alert-success');  //añadir la clase
                ventanaModal();
                newProfile();
            }
        })
    });

    //Inicializar la tabla con los datos
    Table();

});


/**
 * Añade funcionalidad al boton ver de la tabla
 * @param tbody id de la tabla junto con el tag tbody
 * @param table Tabla a la que se aplica la funcionalidad
 */
var getDataView = function (tbody, table) {
    $(tbody).on('click', "button.ver", function () {  //funcionalidad cuando se pulsa el boton
        var datos = table.row($(this).parents("tr")).data();    //captura de datos de la fila
        $(".modal-title").html("Ver actividad");
        inputDesactivo = true;
        ver(datos);
    });

}

/**
 * Añade funcionalidad al boton modificar de la tabla
 * @param tbody id de la tabla junto con el tag tbody
 * @param table Tabla a la que se aplica la funcionalidad
 */
var getDataUpdate = function (tbody, table) {
    $(tbody).on('click', "button.editar", function () {
        var datos = table.row($(this).parents("tr")).data();
        $(".modal-title").html("Modificar actividad");
        inputDesactivo = false;
        ver(datos);
    });

}

/**
 * Añade funcionalidad al boton eliminar de la tabla
 * @param tbody id de la tabla junto con el tag tbody
 * @param table Tabla a la que se aplica la funcionalidad
 */
var getDataEliminar = function (tbody, table) {
    $(tbody).on('click', "button.eliminar", function () {
        var datos = table.row($(this).parents("tr")).data();
        //TODO poner un alert de confirmacion
        borrar(datos);
    });

}

/**
 * Creacion de la tabla que muestra los registro
 * @constructor
 */

function Table() {
    //Datatables
    tabla = $('#listaActividad').DataTable({                      //creacion de la tabla
        // "ajax":"app/mod/user/view/modules/datos.php",
        "ajax": {
            "method": "POST",                                   //metodo de llamada al ajax
            "url": "app/mod/actividad/controller/actividad_datos.php"        //url donde obtener los datos
            /* "dataSrc": function(d){
                 console.log("en AJAX:" +d.data);
                 return d.data;
             }*/
        },
        //columnas a mostrar en la tabla
        "columns": [
            {
                "data": "num",
                "width": "5%"
            },

            {
                "data": "idActividad",
                "width": "10%"
            },
            {
                "data": "sNombre",
                "width": "25%"
            },
            {
                "data": "sDescripcion",
                "width": "25%"
            },
            //crear la columna con los botones
            {
                "defaultContent": "<button type='button' class='ver btn btn-xs btn-primary' title='ver'><i class='glyphicon glyphicon-eye-open'></i></button>\t<button type='button' class='editar btn btn-xs btn-primary' title='modificar'><i class='glyphicon glyphicon-pencil'></i></button>\t<button type='button'  class='eliminar btn btn-xs btn-danger' data-toggle='modal' data-target='#modalEliminar' data-backdrop='static' title='borrar'><i class='glyphicon glyphicon-trash'></i></button>",
                "width": "15%"
            }

        ],
        "paging": true,             //habilitar paginado de la tabla
        "lengthChange": false,      //mostrar elegir numeros de registros a mostrar
        "searching": true,          //habilitar busqueda en la tabla
        "ordering": true,           //habilitar ordenar registros
        "info": true,
        "processing": true,         //indicador de procesando
        "autoWidth": false,         //ancho automatico
        "stateSave": true,          //guardar la pagina
        "deferRender": true,
        "language": idioma_espanol,
        "drawCallback": function (settings) {   //funcion llamada cada vez que se pinta la tabla
            //console.log( 'Cargando datos2....' );
        },
        "preDrawCallback": function (settings) {    //funcion llamada antes de la carga
            //  console.log( 'Cargando datos....' );
            callAjax("./app/mod/Sesion/controller/sesion_datos.php", function (result) {    //comprobar sui esta activa la sesion
                //  console.log("precallback: "+!result.signIn);
                if (!result.signIn) {  //control de sesion, si no esta activa la sesion se envia al indice
                    $(location).attr('href', 'index.php');
                }
            });
        },
        "initComplete": function (setting, data) {        //funcion llamada al finalizar la carga de datos
            // console.log("datos cargados completamente..."+JSON.stringify(data));
        }
    });
    //Añadir las funcionalidades a los boton de ver, modificar y eliminar
    getDataView("#listaActividad tbody", tabla);
    getDataUpdate("#listaActividad tbody", tabla);
    getDataEliminar("#listaActividad tbody", tabla);

}

//Definir los mensajes mostrados en español
var idioma_espanol = {
    "sProcessing": "Procesando...",
    "sLengthMenu": "Mostrar _MENU_ registros",
    "sZeroRecords": "No se encontraron resultados",
    "sEmptyTable": "Ningún dato disponible en esta tabla",
    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix": "",
    "sSearch": "Buscar:",
    "sUrl": "",
    "sInfoThousands": ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"
    },
    "oAria": {
        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }

}

/**
 * Eliminar usuario de la tabla
 * @param id  identificador del usuario
 */
function borrar(datos) {
    param = {
        'idActividad': datos.idActividad,
        'accion': 'del'
    }
    callAjax("./app/mod/Sesion/controller/sesion_datos.php", function (result) {    //comprobar sui esta activa la sesion
        //  console.log("precallback: "+!result.signIn);
        if (!result.signIn) {  //control de sesion, si no esta activa la sesion se envia al indice
            ventanafinSesion()
        } else {
            ventanaModal();
            $(".modal-title").html("Borrar Actividad");                       //añadir titulo a ventana modal
            $(".modal-title").parent("div").addClass('alert alert-error');  //añadir la clase
            //añadir el contenido
            $("#contenidoModal").html("Debes confirmar la eliminacion de la actividad, <strong>" + datos.sNombre + "</strong>");
            $(".modal-footer").append("<button id='btnEliminar' type='button' class='btn btn-danger'>Eliminar</button>") //añadir el boton de eliminar

            $("#btnEliminar").on('click', function () {           //funcionalidad del boton eliminar
                callAjax(ruta + "/controller/actividad_datos.php", function (result) {       //eliminar de la tabla el id
                        console.log(result)
                        if (result.signIn && result.exito) {        //si la sesion esta activa y se ha actualizado correctamente
                            tabla.ajax.reload(null, false);         //actualizar la tabla
                            $("#ventanaModal").modal('hide');       //ocultar la ventana modal
                            $(".modal-title").parent("div").removeClass('alert alert-error');   //quitar la clase a la ventana modal
                            $("#btnEliminar").remove();             //quitar el boton de eliminar
                        } else if (result.signIn) {
                            alert('No se han podido eliminar los datos');
                            $("#ventanaModal").modal('hide');
                        } else {
                            $("#btnEliminar").remove();
                            ventanafinSesion()
                        }
                    }
                    , param, "POST", "json");

            });
        }
    });

}


/**
 * Capturar los datos para mostrarlos en
 * el formulario en una ventana modal
 * @param datos  Objeto con las propiedades a mostrar
 */
function ver(datos) {
    getDatos(datos);    //pasar los datos al formulario
}


/**
 * Actualiza los datos del objeto que se envia por parametros
 * @param datos Objeto con las propiedades a actualizar
 */
function actualizar(datos) {
console.log(datos)
    var bUpdate = false,
        nuevosDatos = getElementForm('#profile input'), //captura de todos los elementos del formulario
        param = new Object();
    //  console.log(nuevosDatos);     console.log(datos);

    for (var item  in nuevosDatos) {    //recorrer todos los elemento del formulario
        //  alert(item+ "  "+nuevosDatos[item]+"   -> "+data[item]);
        if (datos[item] == undefined) { //establecer a vacio los elementos que viajan indefinido
            datos[item] = ''
        }
        if (nuevosDatos[item] != datos[item]) { //si hay cambios con los datos anteriores se actualizara el registro
            bUpdate = true;
        }
        param[item] = nuevosDatos[item];        //guardar los valores en un Objeto

    }
    console.log(param);
    if (bUpdate) {      //si hay cambios
        param['accion'] = 'update';
        callAjax("./app/mod/User/controller/actividad_datos.php", function (result) {
            //console.log(result);
            if (result.signIn && result.exito) {        //si la sesion esta activa y se ha actualizado correctamente
                $("#ventanaModal").modal('hide');
                tabla.ajax.reload(null, false);
            } else {
                if (result.signIn) {    //si no se actualizaron los datos y continua la sesion activa
                    alert('No se han podido actualizar los datos');
                    $("#ventanaModal").modal('hide');
                } else {                 //si no continua la sesion activa
                    ventanafinSesion()
                }
            }
        }, param, "POST", "json");
    }
}

/**
 * Cargar el formulario de nuevo registro en la
 * ventana modal.
 * @returns {String} Contenido HTML a mostrar en la ventana
 */
function newProfile() {
    $(".modal-title").parent("div").addClass('bg-light-green-active');  //añadir la clase de cabecera azul
    $(".modal-title").html("Añadir nueva actividad");
    //Cargar pagina en ventana con Ajax
    return callAjax(ruta + "/view/profile.php", function (result) {
        noSubmit('profile');                //evita el envio de formulario

        $("#contenidoModal").html(result);  //carga el html en el ventan modal
        avatarDefault();
        bvValidarForm();        //validar formulario con boostrapValidation

    }, null, 'POST', 'HTML');
}

/**
 * Añadir la imagen por defecto del avatar
 * al formulario del perfil
 */
function avatarDefault() {
    var avatar = 'avatar_m1.svg';
    //$("#avatar").attr("src", "./app/images/avatar/" + avatar);
    $("#avatar").width(100);
    $("#avatar").height(100);
    $("#avatar").css({"background-color" : "green", "font-size" : "36px", "font-weight" : "bold", "line-height" : $("#avatar").width()+"px", "text-align" : "center"});
    $("#avatar").append("<span>");
    $("#avatar span").css({"display" : "inline-block", "vertical-align" : "middle", "line-height" : "normal"})


    console.log($("#avatar").height());
    $("#avatar span").text("AC#");
}

/**
 * Cumplimenta los datos en el formulario de perfil,
 * con los que existen en función el registro elegido en
 * la tabla
 * @param datos Valores de la fila elegida
 * @returns {String} Contenido HTML a mostrar en la ventana modal
 */
function getDatos(datos) {
    callAjax('./app/mod/Sesion/controller/sesion_datos.php', function (result) {
        if (!result.signIn) {
            ventanafinSesion()
        } else {
            $(".modal-title").parent("div").addClass('bg-light-blue-active');  //añadir la clase de cabecera azul
            ventanaModal();     //abrir ventana modal
            //Cargar con Ajax el contenido HTML en la ventana modal
            return callAjax(ruta + "/view/profile.php", function (result) {

                    $("#contenidoModal").html(result);              //cargar el HTML en el div
                    noSubmit('profile');   //evitar el envio del formulario

                    //Cargar los datos en el formualrio
                    $("#sNombre").html(datos.sNombre);
                    $("#tDescripcion").html(datos.tDescripcion);
                    $("#idActividad").val(datos.idActividad);


                    $("#auditoria").html("Actualizado: " + datos.dtU);


                    $("#btnGuardar").hide();   //TODO quitar el boton de guardar cambios?????

                    //Cuando es solo visualizar los datos en el formulario
                    if (inputDesactivo) {
                        $("#btnActualizar").hide();                     //ocultar el boton de actualizar
                    }

                    $("form input").attr("disabled", inputDesactivo);  //habilitar o desabilitar los campos del formulario

                    bvValidarForm(datos);  //comprobaciones de validacion del formulario

                }, null,
                "POST",
                "HTML");
        }
    })

}


/**
 * Validacion de los datos del formulario con
 * boostrapValidator
 * @param datos
 */
function bvValidarForm(datos) {
    $("#profile").bootstrapValidator({
        message: 'Valor errorneo',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            sNombre: {
                validators: {
                    notEmpty: bvNoVacio,
                    stringLength: {
                        min: 2,
                        max: 45,
                        message: "El nombre debe tener entre 2 y 45 caracteres "
                    },
                    regexp: bvSoloTexto

                }
            },
            tDescripcion: {
                validators: {
                    notEmpty: bvNoVacio,
                    stringLength: {
                        min: 2,
                        max: 255,
                        message: "Introduce la descripcion de la actividad "
                    },
                    regexp: bvSoloTexto
                }
            }
        }
    })
        .on('error.form.bv', function (e) {
            console.log(e);
        })
        .on('success.form.bv', function (e) {  //actualizacion de datos y estados de campos del formularios con el envio correcto
            actualizar(datos);
        })
        .on('success.field.bv', function (e, data) {     //acciones cuando success, por campo

        })
        .on('error.field.bv', function (e, data) {     //acciones cuando existe error, por campo

        })
        .on('error.validator.bv', function (e, data) { //SOLO UN MENSAJE POR ERROR
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
        });
}

/**
 * Posicion del icono de BV cuando no se muestra alineado con
 * el resto de iconos de validacion de los otros campos
 * @param nameField   Nombre del campo donde se aplica el posicionamiento
 */
function moverIconoBv(nameField) {
    // var padre = data.element.closest('.form-group');
    var padre = $("[name='" + nameField + "']").closest('.form-group');
    var padreAncho = padre.width();
    var ico = padre.find('[data-bv-icon-for="' + nameField + '"]');
    ico.offset({left: padre.offset().left + padreAncho - 50});
}



/**
 * Variables para los mensajes de validacion del formulario
 *
 */
var bvNoVacio = {
    message: 'El campo es requerido. Por favor introduce un valor.'
}
var bvElige = {
    message: 'Por favor, debes elegir un valor.'
}
var bvSoloTexto = {
    regexp: /^[a-zA-Z\s]+$/i,
    message: "Por favor no estan permitido números ni caracteres especiales"
}
var bvSoloNumero = {
    regexp: /^[0-9]+$/i,
    message: "Por favor solo se permiten números"
}


function limpiarForm() {
    $("#txtNombre").val("");
    $("#txtApellidos").val("");
    $("#txtRol").val("");
    $("#idUser").val("");
    $("#containerUser").hide();
}
