var param;
$(document).ready(function () {

   // $("#frmCuerpo").on("submit",acceder);
    $("#frmCuerpo").on("submit",function(evt){
        evt.preventDefault();
        console.log(evt);
        alert((evt.target.tagName));
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
if(result[0]) {
    $("#contenido").html(result.sNombre);
    $("#hmod").val('user');

   /* $("#frmCuerpo").attr("action","index.php");
    document.frmCuerpo.submit();*/
   // $("#frmCuerpo").submit();
    enviarForm("frmCuerpo","index.php");
}else{
    $("#haccion").val("");
    $("#hmod").val("");
}


}
