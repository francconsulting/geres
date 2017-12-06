<<<<<<< HEAD
var param;
$(document).ready(function () {

   // $("#frmCuerpo").on("submit",acceder);
    $("#frmCuerpo").on("submit",function(evt){

        evt.preventDefault();
        console.log(evt);
       // alert((evt.target.tagName));
        $("#btnEnviar").attr("disabled", "disabled");
    });
    $("#btnEnviar").on("click", function(){

        acceder('acceder')
    });
    $("#btnRegistrar").on("click", function(){
        acceder('registrar')
    });
    $("#procesando").css({'background-image': 'url("./app/img/loaded_lineball.gif")' , 'background-repeat': 'no-repeat'});
});

function acceder(accion) {

    //evt.preventDefault();
    // console.log(this);
    param = {
        'usuario': $('#usuario').val(),
        'pass' : $('#pass').val(),
        'accion': accion
    }

   // if (accion == 'acceder') {
       // callAjax("./app/mod/Login/view/view.php", mostrar, param);
        callAjax("index.php", mostrar, param);
    //}
   /* if (accion == 'registrar') {
        callAjax("./app/mod/Login/view/view.php", mostrar, param, "POST","HTML");
    }*/
   // callAjax("./app/mod/Login/controller/login_controller2.php", mostrar, param);
    $("#haccion").val(accion);
}


function mostrar(result){
    console.log(result);

if(result['logado']) {
    $("#contenido").html(result.sNombre);
    $("#hmod").val('user');

   /* $("#frmCuerpo").attr("action","index.php");
    document.frmCuerpo.submit();*/
   // $("#frmCuerpo").submit();
    enviarForm("frmCuerpo","page.php"); //TODO -> descomentar
}else{
    $("#procesando").fadeOut(3000, function() {
        $("#mensaje").addClass("alert alert-danger alert-dismissible")
                    .text(result['msg'])
                    .clearQueue()
                    .fadeIn("fast")
                    .fadeOut(4000, function(){
                        $("#btnEnviar").removeAttr("disabled");
                    }); //mostrar mensaje de ok

    });
        $("#haccion").val("");
    $("#hmod").val("");
}



}
=======
var param;
$(document).ready(function () {

   // $("#frmCuerpo").on("submit",acceder);
    $("#frmCuerpo").on("submit",function(evt){

        evt.preventDefault();
        console.log(evt);
       // alert((evt.target.tagName));
        $("#btnEnviar").attr("disabled", "disabled");
    });
    $("#btnEnviar").on("click", function(){

        acceder('acceder')
    });
    $("#btnRegistrar").on("click", function(){
        acceder('registrar')
    });
    $("#procesando").css({'background-image': 'url("./app/img/loaded_lineball.gif")' , 'background-repeat': 'no-repeat'});
});

function acceder(accion) {

    //evt.preventDefault();
    // console.log(this);
    param = {
        'usuario': $('#usuario').val(),
        'pass' : $('#pass').val(),
        'accion': accion
    }

   // if (accion == 'acceder') {
       // callAjax("./app/mod/Login/view/view.php", mostrar, param);
        callAjax("index.php", mostrar, param);
    //}
   /* if (accion == 'registrar') {
        callAjax("./app/mod/Login/view/view.php", mostrar, param, "POST","HTML");
    }*/
   // callAjax("./app/mod/Login/controller/login_controller2.php", mostrar, param);
    $("#haccion").val(accion);
}


function mostrar(result){
    console.log(result);

if(result['logado']) {
    $("#contenido").html(result.sNombre);
    $("#hmod").val('user');

   /* $("#frmCuerpo").attr("action","index.php");
    document.frmCuerpo.submit();*/
   // $("#frmCuerpo").submit();
    enviarForm("frmCuerpo","page.php"); //TODO -> descomentar
}else{
    $("#procesando").fadeOut(3000, function() {
        $("#mensaje").addClass("alert alert-danger alert-dismissible")
                    .text(result['msg'])
                    .clearQueue()
                    .fadeIn("fast")
                    .fadeOut(4000, function(){
                        $("#btnEnviar").removeAttr("disabled");
                    }); //mostrar mensaje de ok

    });
        $("#haccion").val("");
    $("#hmod").val("");
}



}
>>>>>>> retomar
