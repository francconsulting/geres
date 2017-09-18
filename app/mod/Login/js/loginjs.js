var param;
$(document).ready(function () {
    $("#frmCuerpo").on("submit",acceder);
});

function acceder(evt) {

    evt.preventDefault();
    // console.log(this);
    param = {
        'usuario': $('#usuario').val(),
        'accion': 'acceder'
    }

    callAjax("./app/mod/Login/view/view.php", mostrar, param);
   // callAjax("./app/mod/Login/controller/login_controller2.php", mostrar, param);
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
}


}
