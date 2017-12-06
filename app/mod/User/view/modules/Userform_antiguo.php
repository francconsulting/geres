<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 13/08/2017
 * Time: 19:55
 */
//Estructura de ventana modal para el contenido del modulo
?>
<div id="dataUser" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Ficha personal</h4>
            </div>
            <div class="modal-body">
                <div id="contenidoModal"></div>
            </div>
            <div class="modal-footer">
                <button id="btnCerrar" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button id="btnGuardar" type="button" class="btn btn-primary">Guardar cambios</button>
            </div>


        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



