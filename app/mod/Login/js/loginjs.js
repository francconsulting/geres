var param;
$(document).ready(function () {

   // $("#frmCuerpo").on("submit",acceder);
    $("#frmCuerpo").on("submit",function(evt){
        evt.preventDefault();
        console.log(evt);
        alert((evt.target.tagName));
        $("#btnEnviar").attr("disabled", "disabled");
    });
    $("#btnEnviar").on("click", function(){
        acceder('acceder')
    });
    $("#btnRegistrar").on("click", function(){
        acceder('registrar')
    });

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
        callAjax("./app/mod/Login/view/view.php", mostrar, param);
    //}
   /* if (accion == 'registrar') {
        callAjax("./app/mod/Login/view/view.php", mostrar, param, "POST","HTML");
    }*/
   // callAjax("./app/mod/Login/controller/login_controller2.php", mostrar, param);
    $("#haccion").val(accion);
}


function mostrar(result){

    //console.log(result);
if(result['logado']) {
    $("#contenido").html(result.sNombre);
    $("#hmod").val('user');

   /* $("#frmCuerpo").attr("action","index.php");
    document.frmCuerpo.submit();*/
   // $("#frmCuerpo").submit();

 //   enviarForm("frmCuerpo","index.php");
}else{
    $("#procesando").fadeOut(1000, function() {
        $("#mensaje").addClass("ok")
                    .text(result['msg'])
                    .clearQueue()
                    .fadeIn("fast")
                    .fadeOut(3000, function(){
                        $("#btnEnviar").removeAttr("disabled");
                    }); //mostrar mensaje de ok

    });
        $("#haccion").val("");
    $("#hmod").val("");
}



}
