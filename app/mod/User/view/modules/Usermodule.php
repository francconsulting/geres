<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 13/08/2017
 * Time: 19:55
 *
 * Proposito: pagina que muestra la tabla con lista de usuarios
 */

//Cargar archivos js y css especificos para el funcionamiento de la pagina
//DATATABLES
echo Helper::getCssExtra(array('plugins/datatables/dataTables.bootstrap'));
echo Helper::getJsExtra(array(
    '/plugins/datatables/jquery.dataTables.min',
    '/plugins/datatables/dataTables.bootstrap.min'
));

?>
<!-- DataTables -->
<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="text-left">
            <button type='button' id="addUser" class='ver btn bg-olive right'><i
                        class='glyphicon glyphicon-user'></i> Nuevo usuario
            </button>
        </div>
    </div>
</div>

<div class="box">
    <div class="box-header">
        <h3 class="box-title">Lista de Usuarios</h3>
    </div>
    <div class="box-body">
        <table id="listaUsuario" class="table table-bordered table-striped dataTable" cellpadding="3" cellspacing="2">
            <thead>
            <tr>
                <th>nº</th>
                <th></th>
                <th>id</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Rol</th>
                <th></th>
            </tr>
            </thead>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="text-right">
            <button type='button' id="idRecarga" class='ver btn btn-primary'><i class='glyphicon glyphicon-repeat'></i>
                Actualizar tabla
            </button>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: #66afe9;
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(102, 175, 233, 0.6);
    }

    #profile .has-error .form-control {
        color: #cb2b20;
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(255, 57, 45, 0.6);
    }
</style>

