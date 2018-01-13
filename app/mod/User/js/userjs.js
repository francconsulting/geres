/**
 * Created by fmbv on 24/08/2017.
 */

$(document).ready(function () {
alert(document.cookie);

    function getCookie(nombre){
        let aCookies = decodeURIComponent(document.cookie).split(";");
        let  signoIgual, sNombreCook, sValorCook = null;
        for (var i = 0; i < aCookies.length; i++) {
            signoIgual = aCookies[i].indexOf("=");
            sNombreCook = aCookies[i].substr(0,signoIgual);
            alert("array "+i+" "+sNombreCook+ " "+nombre);
            if (sNombreCook == nombre) {
                sValorCook = aCookies[i].substr(signoIgual + 1);
                //  alert("array "+sValorCook);
            }

        }
        return sValorCook;
    }
    console.log(getCookie("PATHMOD"))
    //console.log(dataDecryp(getCookie("PATHMOD")))
    /**
     * Funcionalidad en el boton cerrar cuando se hace click
     */
    $("#btnCerrar, button.close").on("click", function () {
        $(".modal-title").parent("div").removeClass('alert alert-error');   //eliminar la clase alert
        $("#btnEliminar").remove();         //quitar el boton eliminar
    });


    $("#btnGuardar").hide(); //ocultar el boton guardar que esta en la ventana modal

    //Actualizar la tabla de registro con el boton Actualizar Tabla
    $('#idRecarga').click(function () {
        tabla.ajax.reload();
    });

    //Añadir nuevo usuario
    // $("#addUser").click(ver);
    $("#addUser").click(function () {
        ventanaModal();
        newProfile();

    });

    //Inicializar la tabla con los datos
    Table();
});

//definicion de variables
var inputDesactivo,
    tabla;

/**
 * Añade funcionalidad al boton ver de la tabla
 * @param tbody id de la tabla junto con el tag tbody
 * @param table Tabla a la que se aplica la funcionalidad
 */
var getDataView = function (tbody, table) {
    $(tbody).on('click', "button.ver", function () {  //funcionalidad cuando se pulsa el boton
        var datos = table.row($(this).parents("tr")).data();    //captura de datos de la fila
        $(".modal-title").html("Visualizar datos del usuario");
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
        //num_index(table);                 //TODO ELiminiar
        // tabla.ajax.reload(null, false);   //TODO Eliminar
        $(".modal-title").html("Modificar datos del usuario");
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
    tabla = $('#listaUsuario').DataTable({                      //creacion de la tabla
        // "ajax":"app/mod/user/view/modules/datos.php",
        "ajax": {
            "method": "POST",                                   //metodo de llamada al ajax
            "url": "app/mod/user/controller/user_datos.php"        //url donde obtener los datos
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
                "data": "sAvatar",
                "width": "5%",
                "render": function (data, type, row) {          //mostrar una imagen en la tabla
                    //console.log("imagen " +data + " tipo: "+type + " fila: "+JSON.stringify(row));
                    return '<img src="/geres/app/images/avatar/' + data + '" width="25" height="25" class="img-circle" title="' + row.sNombre + " " + row.sApellidos + '" alt="Avatar usuario">';
                }
            },
            {
                "data": "idUser",
                "width": "10%"
            },
            {
                "data": "sNombre",
                "width": "25%"
            },
            {
                "data": "sApellidos",
                "width": "25%"
            },
            {
                "data": "aRol",
                "width": "12%"
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
    getDataView("#listaUsuario tbody", tabla);
    getDataUpdate("#listaUsuario tbody", tabla);
    getDataEliminar("#listaUsuario tbody", tabla);

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
        'idUser': datos.idUser,
        'accion': 'del'
    }
    ventanaModal();
    $(".modal-title").html("Borrar usuario");                       //añadir titulo a ventana modal
    $(".modal-title").parent("div").addClass('alert alert-error');  //añadir la clase
    //añadir el contenido
    $("#contenidoModal").html("Debes confirmar la eliminacion del usuario, <strong>" + datos.sNombre + " " + datos.sApellidos + "</strong>");
    $(".modal-footer").append("<button id='btnEliminar' type='button' class='btn btn-danger'>Eliminar</button>") //añadir el boton de eliminar

    $("#btnEliminar").on('click', function () {           //funcionalidad del boton eliminar
        callAjax("./app/mod/User/controller/user_datos.php", function (result) {       //eliminar de la tabla el id
                tabla.ajax.reload(null, false);         //actualizar la tabla
                $("#ventanaModal").modal('hide');       //ocultar la ventana modal
                $(".modal-title").parent("div").removeClass('alert alert-error');   //quitar la clase a la ventana modal
                $("#btnEliminar").remove();             //quitar el boton de eliminar
            }
            , param, "POST", "json");

    });
}


/**
 *  Abrir la ventana modal
 */
function ventanaModal() {
    $("#ventanaModal").modal({backdrop: "static"});
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
 * Capturar los datos para mostrarlos en
 * el formulario en una ventana modal
 * @param datos  Objeto con las propiedades a mostrar
 */
function ver(datos) {
    getDatos(datos);    //pasar los datos al formulario
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

/**
 * Actualiza los datos del objeto que se envia por parametros
 * @param datos Objeto con las propiedades a actualizar
 */
function actualizar(datos) {
    var bUpdate = false,
        nuevosDatos = getElementForm('#profile input'),
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
        callAjax("./app/mod/User/controller/user_datos.php", function (result) {
            //console.log(result);
            if (result.signIn && result.exito) {        //si la sesion esta activa y se ha actualizado correctamente
                if ($("#fAvatar")[0].files[0] != undefined) {   //uploader para el avatar si se ha definido
                    cargarArchivo();
                } else {
                    $("#ventanaModal").modal('hide');
                    tabla.ajax.reload(null, false);
                }
            } else {
                if (result.signIn) {    //si no se actualizaron los datos y continua la sesion activa
                    alert('No se han podido actualizar los datos');
                    $("#ventanaModal").modal('hide');
                } else {                 //si no continua la sesion activa
                    alert('La sesion ha caducado');
                    $(location).attr('href', 'index.php');
                }
            }
        }, param, "POST", "json");
    }
}

/**
 * Cargar el formulario de nuevo usuario en la
 * ventana modal.
 * @returns {String} Contenido HTML a mostrar en la ventana
 */
function newProfile() {
    //Cargar pagina en ventana con Ajax
    return callAjax("./app/mod/User/view/modules/profile.php", function (result) {
        noSubmit('profile');                //evita el envio de formulario
        $("#contenidoModal").html(result);  //carga el html en el ventan modal
        $("#sNombre").keyup(function () {
            $("#NombrePerfil").html($("#sNombre").val());
        });
        $("#sApellidos").keyup(function () {
            $("#ApellidosPerfil").html($("#sApellidos").val());
        });

        avatarDefault();        //poner el avatar por defecto
        toggleAvatar();         //cambiar el avatar por defecto segun sexo marcado
        bvValidarForm();        //validar formulario con boostrapValidation

    }, null, 'POST', 'HTML');
}

/**
 * Añadir la imagen por defecto del avatar
 * al formulario del perfil
 */
function avatarDefault() {
    var avatar = 'avatar_m1.svg';
    $("#cGeneroM").prop('checked', true);
    $("#avatar").attr("src", "./app/images/avatar/" + avatar);
    $("#avatar").width(100);
    $("#avatar").height(100);
}

/**
 * Alternar las imagens por defecto del avatar cuando
 * se cambia el sexo en el formulario.
 */
function toggleAvatar() {
    //accion que se realiza cuando se selecciona la opcion del radiobutton
    $("[name=cGeneroAux]:radio").on('click', function () {
        var avatar = $("#avatar").attr("src");      //captura del avatan disponible
        if ($(this).is(':checked')) {
            $("#cGenero").val($(this).val());   //guardar el valor en el formulario para usar en el POST

            //Si el avatar actual es alguno de los por defecto
            if (avatar.search('avatar_m1.svg') >= 0 || avatar.search('avatar_h1.svg') >= 0) {
                if ($(this).val() != 'H') {
                    avatar = 'avatar_m1.svg'
                } else {
                    avatar = 'avatar_h1.svg'
                }
                $("#avatar").attr("src", "./app/images/avatar/" + avatar);  //establecer la imagen del avatar
            }
            $("#avatar").width(100);
            $("#avatar").height(100);
            $("#sAvatar").val(avatar);
        }
    });
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
       if (!result.signIn){
           alert('La sesion ha caducado');
           $(location).attr('href', 'index.php');
       }else{
           ventanaModal();     //abrir ventana modal
           //Cargar con Ajax el contenido HTML en la ventana modal
           return callAjax("./app/mod/User/view/modules/profile.php", function (result) {
                   //console.log(datos);
                   $("#contenidoModal").html(result);              //cargar el HTML en el div
                   noSubmit('profile');   //evitar el envio del formulario

                   //Cargar los datos en el formualrio
                   $("#NombrePerfil").html(datos.sNombre);
                   $("#ApellidosPerfil").html(datos.sApellidos);

                   var avatar = '',
                       genero = '';

                   (datos.cGenero == '') ? genero = 'M' : genero = datos.cGenero;

                   if (datos.sAvatar == null) {
                       (genero == 'H') ? avatar = 'avatar_h1.svg' : avatar = 'avatar_m1.svg';
                   } else {
                       avatar = datos.sAvatar;
                   }
                   $("#avatar").attr("src", "./app/images/avatar/" + avatar);
                   $("#avatar").width(100);
                   $("#avatar").height(100);
                   $("#sAvatar").val(avatar);
                   $("#cGenero").val(genero);
                   $("#idUser").val(datos.idUser);
                   $("#sNombre").val(datos.sNombre);
                   $("#sApellidos").val(datos.sApellidos);

                   var rol = datos.aRol.replace(" ", "").split(",");   //guardar los valores de la Cadena aRol en el array rol
                   var arrayRol = [];
                   rol.forEach(function (element) {
                       $("[name=aRolAux]").each(function (index) {
                           if ($("[name=aRolAux]")[index].value == element) {  //Comparar si el elemento marcado ya estaba marcado o no para tenerlo disponeble para el POST
                               arrayRol.push($("[name=aRolAux]")[index].value);
                           }
                       });
                   });

                   //Establecer el check del genero a marcar en la carga del formulario según los datos de la tabla
                   if (genero == 'H') {
                       $("#cGeneroH").prop('checked', true);
                   } else {
                       $("#cGeneroM").prop('checked', true);
                   }

                   $("#sEmail").val(datos.sEmail);
                   $("#aRol").val(datos.aRol);
                   $("#sTelefono1").val(datos.sTelefono1);
                   $("#sTelefono2").val(datos.sTelefono2);
                   $("#sDireccion").val(datos.sDireccion);
                   $("#sCodigoPostal").val(datos.sCodigoPostal);
                   $("#auditoria").html("Actualizado: " + datos.dtU);


                   $("#btnGuardar").hide();   //TODO quitar el boton de guardar cambios?????

                   //Cuando es solo visualizar los datos en el formulario
                   if (inputDesactivo) {
                       $("#btnActualizar").hide();                     //ocultar el boton de actualizar
                       $("#fAvatar").closest('.form-group').hide();    //ocultar el boton de carga del avatar
                   }

                   $("form input").attr("disabled", inputDesactivo);  //habilitar o desabilitar los campos del formulario

                   //almacenar-actualizar los valores del rol en un array segun se marquen o desmarquen
                   $("[name=aRolAux]:checkbox").on('change', function () {
                       if ($(this).is(':checked')) {
                           arrayRol.push($(this).val());                   //si se marca arradir al array
                       } else {
                           var indice = arrayRol.indexOf($(this).val());    //buscar el indice en el array del elemento desmarcado
                           arrayRol.splice(indice, 1);                       //eliminar elemento
                       }
                       arrayRol.sort()                                     //ordenar el array
                       $("#aRol").val(arrayRol);                           //almacenar los valores en un elemento del formulario
                   });


                   toggleAvatar();  //canbiar la imagen del avatar
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
            sApellidos: {
                validators: {
                    notEmpty: bvNoVacio,
                    stringLength: {
                        min: 2,
                        max: 90,
                        message: "Los apellidos debe tener entre 2 y 90 caracteres "
                    },
                    regexp: bvSoloTexto
                }
            },
            sPassword: {
                validators: {
                    notEmpty: {
                        enabled: false
                    },
                    stringLength: {
                        min: 8,
                        max: 15,
                        message: "Mínimo 8 caracteres y máximo 15"
                    },
                    regexp: bvPassword
                }
            },
            sEmail: {
                validators: {
                    notEmpty: bvNoVacio,
                    emailAddress: 'No es una direccion de email valida.'
                }
            },
            sTelefono1: {
                validators: {
                    notEmpty: bvNoVacio,
                    phone: bvTelefono
                }
            },
            sTelefono2: {
                validators: {
                    notEmpty: bvNoVacio,
                    phone: bvTelefono
                }
            },
            sCodigoPostal: {
                validators: {
                    regexp: bvZipCode
                    // regexp : bvZipCode5
                }
            },
            cGeneroAux: {
                validators: {
                    notEmpty: bvElige
                }
            }

        }
    })
        .on('error.form.bv', function (e) {
            console.log(e);
        })
        .on('success.form.bv', function (e) {  //actualizacion de datos y estados de campos del formularios con el envio correcto
            $("#cGenero").val($("input[name='cGeneroAux']:checked").val());
            $("#fAvatar").hide();
            $("#fAvatar").closest('.fileinput-button').attr('disabled', true);
            actualizar(datos);
        })
        .on('success.field.bv', function (e, data) {     //acciones cuando success, por campo
            //console.log( data.field);
            if ($("#sCodigoPostal").val() == '' && data.field == "sCodigoPostal") {  //acciones para el codigo postal
                data.element
                    .closest('.form-group') //obtener el campo padre
                    .removeClass('has-success')  //quitar la clase
                    .find('[data-bv-icon-for="sCodigoPostal"]').hide()  //buscar el campo con icono para el campo indicado

                //data.element.parents('.form-group').find('.form-control-feedback[data-bv-icon-for=sCP]').hide();

            }
            if (data.field == 'cGeneroAux') {     //acciones para el campo Sexo
                moverIconoBv('cGeneroAux');
            }
        })
        .on('error.field.bv', function (e, data) {     //acciones cuando existe error, por campo
            if (data.field == 'cGeneroAux') {     //acciones para el campo Sexo
                moverIconoBv('cGeneroAux');
            }
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
 * Previsualizacion de imagenes en navegador
 * antes de realizar la carga (upload) del fichero
 */

function previewFile(inputFile) {
    var file = $("#fAvatar")[0].files[0];
        fileName = file.name,                                           //nombre
        fileExt = fileName.substring(fileName.lastIndexOf('.') + 1),      //extension
        fileSize = file.size,                                           //tamaño
        fileType = file.type;                                           //tipo
    //visualixar archivo


    if (isImage(fileExt) && pesoImagen(fileSize)) {
        var reader = new FileReader();
        reader.readAsDataURL(file);                                 //leer el contenido file//leer fichero almacenado en buffer cliente
        reader.onload = function () {                                   //cuando la lectura se completa
            $('#avatar')
                .attr("src", reader.result)                   //asignar la imagen al elemento donde mostrarla
                .width(100)
                .height(100)

            $('#sAvatar').val(file.name)                      //almacenar el nombre de la imagen en un campo del formulario
            $('#sAvatar').closest('.form-group')
                .removeClass('has-error')
                .addClass('has-feedback has-success')     //añadir la clase error y feedbak
                .find('[data-bv-icon-for="fAvatar"]').show();
            $("#msgfile")                                   //establecer formato y contenido del mensaje
                .text('')
                .removeClass('has-error')
                .addClass('has-success')
                .append('<i style="" class="form-control-feedback glyphicon glyphicon-ok" data-bv-icon-for="sAvatar"></i>')//limpiar el mensaje de error
        };
        reader.onerror = function () {                                  //si se produce un error en la carga del archivo
            alert('se ha producido un error en la carga del archivo');
            console.log("error");
        }
    } else {              //cuando no es correcto el tipo y/o el peso de la imagen
        $("#sAvatar")
            .closest('.form-group') //obtener el campo padre
            .addClass('has-feedback has-error')     //añadir la clase error y feedbak
            .find('[data-bv-icon-for="fAvatar"]').show();
        $("#msgfile")                               //establecer formato y contenido del mensaje
            .text('')
            .addClass('has-error')
            .append('<small style="" class="help-block"  data-bv-for="sAvatar" data-bv-result="INVALID">Por favor, revisa el tamaño y el tipo de archivo (jpg, gif, png, jpeg) </small>')
            .append('<i style="" class="form-control-feedback glyphicon glyphicon-remove" data-bv-icon-for="sAvatar"></i>')
    }
}


/**
 *
 * @returns {boolean}
 */
function cargarArchivo() {
    var file = $("#fAvatar")[0].files[0];
    if (file != undefined) {
        var fileName = file.name,
            fileExt = fileName.substring(fileName.lastIndexOf('.') + 1),
            fileSize = file.size,
            fileType = file.type;

        if (isImage(fileExt) && pesoImagen(fileSize)) {


            var formData = new FormData(document.getElementById('profile'));
            formData.append('accion', 'upload');


            console.log(formData);
            uploadAjax('./app/mod/User/controller/user_datos.php', function (result) {
                // alert('fin');
                console.log(result.exito);
                /* var dataImg = result;
                 $("#avatar").attr("src",dataImg.avatar);
                 $("#avatar").width(100);
                 $("#avatar").height(100);*/
                if (result.exito) {
                    $("#ventanaModal").modal('hide');
                    tabla.ajax.reload(null, false);
                }

            }, formData);

        } else {
            alert('Comprueba el tipo y tamaño de imagen');
            $("#fAvatar").val('');
            return false;

        }
    }
    //console.log(file);
}

/**
 * Comprobar si es una imagen el fichero a subir
 * @param extension Extension del archivo a cargar
 * @returns {boolean}
 */
function isImage(extension) {
    switch (extension.toLowerCase()) {
        case 'jpg':
        case 'gif':
        case 'png':
        case 'jpeg':
            return true;
            break;
        default:
            return false;
            break;
    }
}

/**
 * Comprueba si el peso del archivo es el permitido
 * @param peso Peso del archivo
 * @returns {boolean}
 */
function pesoImagen(peso) {
    //console.log(peso);
    if (peso < 2200000) { //2Mg
        return true;
    } else {
        return false;
    }
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
var bvPassword = {
    //regexp : /(?=^.{8,15}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/  , //letra May, letra min, 1 num ó 1 carct esp,
    regexp: /(?=^.{8,15}$)((?=.*\d)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/, //letra May, letra min, 1 num, 1 carct esp,
    message: "Al menos una letra Mayúscula.<br/>Al menos una letra minúscula.<br/>Al menos un dígito.<br/>Al menos un caracter especial.<br/>No se permiten espacios en blanco"
}
var bvTelefono = {
    country: 'ES',
    message: 'El número de teléfono en %s no es un número válido.'
}
var bvZipCode = {
    regexp: /^\d{5}$/,
    message: 'Por favor, el Código Postal debe contener 5 dígitos.'
}


function showTb(result) {
    alert(result);
    //$("#contenido").html("");
    $("#contenido").html(result);
    //$('#listaUsuarioTmp').hide();
    //$('#listaUsuarioTmp').attr("id","listaUsuario");

    // $("#haccion").val("");
}

function limpiarForm() {
    $("#txtNombre").val("");
    $("#txtApellidos").val("");
    $("#txtRol").val("");
    $("#idUser").val("");
    $("#containerUser").hide();
}
