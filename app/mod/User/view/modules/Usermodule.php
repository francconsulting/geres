<<<<<<< HEAD
<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 13/08/2017
 * Time: 19:55
 */

echo Helper::getCssExtra(array('plugins/datatables/dataTables.bootstrap'));
//DATATABLES
echo Helper::getJsExtra(array(
    '/plugins/datatables/jquery.dataTables.min',
    'plugins/datatables/dataTables.bootstrap.min'
));

$totalRegistros = User_model::getRowCount();

//if (!empty($rows)){
if ($totalRegistros>0){
    echo "Total Registros: ". User_model::getRowCount()."<br />";
    //header('Content-type: application/json');

    ?>
    <!-- DataTables -->

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Usuarios</h3>
        </div>
        <div class="box-body">
            <table id="listaUsuario" class="table table-bordered table-striped dataTable"  cellpadding="3" cellspacing="2">
                <thead>
                <tr>
                    <th>nº</th>
                    <th>id</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Rol</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (count($rows) > 1) {
                    $i=1;
                    foreach ($rows as $row) { ?>
                        <tr>
                            <td><?php echo $i;?></td>
                            <td>+<?php echo $row->getIdUser(); ?></td>
                            <td><?php echo $row->getSNombre(); ?></td>
                            <td><?php echo $row->getApellidos(); ?></td>
                            <td><?php echo $row->getARol(); ?></td>
                            <td ><span data-accion="del" onclick="borrar('<?php echo $row->getIdUser();?>');">Borrar</span>
                                <span  id="md" data-accion="ver" onclick="ver('<?php echo $row->getIdUser();?>');">Ver</span>
                            </td>
                        </tr>

                    <?php
                        $i++;}
                } else { ?>
                    <tr>
                        <td>-<?php echo $rows->getIdUser(); ?></td>
                        <td><?php echo $rows->getSNombre(); ?></td>
                        <td><?php echo $rows->getApellidos(); ?></td>
                        <td><?php echo $rows->getARol(); ?></td>
                        <td ><span data-accion="del" onclick="borrar('<?php echo $rows->getIdUser();?>');">Borrar</span>
                            <span id="md" data-accion="ver" onclick="ver('<?php echo $rows->getIdUser();?>');">Ver</span>
                        </td>
                    </tr>

                <?php } ?>
                </tbody>
            </table>

        </div>
    </div>

<?php
    echo "Total Registros: ". User_model::getRowCount()."<br />";
}else{
    echo "no hay registros";
}

?>

=======
<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 13/08/2017
 * Time: 19:55
 */

echo Helper::getCssExtra(array('plugins/datatables/dataTables.bootstrap'));
//DATATABLES
echo Helper::getJsExtra(array(
    '/plugins/datatables/jquery.dataTables.min',
    'plugins/datatables/dataTables.bootstrap.min'
));

$totalRegistros = User_model::getRowCount();

//if (!empty($rows)){
if ($totalRegistros>0){
    echo "Total Registros: ". User_model::getRowCount()."<br />";
    //header('Content-type: application/json');

    ?>
    <!-- DataTables -->

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Usuarios</h3>
        </div>
        <div class="box-body">
            <table id="listaUsuario" class="table table-bordered table-striped dataTable"  cellpadding="3" cellspacing="2">
                <thead>
                <tr>
                    <th>nº</th>
                    <th>id</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Rol</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (count($rows) > 1) {
                    $i=1;
                    foreach ($rows as $row) { ?>
                        <tr>
                            <td><?php echo $i;?></td>
                            <td>+<?php echo $row->getIdUser(); ?></td>
                            <td><?php echo $row->getSNombre(); ?></td>
                            <td><?php echo $row->getApellidos(); ?></td>
                            <td><?php echo $row->getARol(); ?></td>
                            <td ><span data-accion="del" onclick="borrar('<?php echo $row->getIdUser();?>');">Borrar</span>
                                <span  id="md" data-accion="ver" onclick="ver('<?php echo $row->getIdUser();?>');">Ver</span>
                            </td>
                        </tr>

                    <?php
                        $i++;}
                } else { ?>
                    <tr>
                        <td>-<?php echo $rows->getIdUser(); ?></td>
                        <td><?php echo $rows->getSNombre(); ?></td>
                        <td><?php echo $rows->getApellidos(); ?></td>
                        <td><?php echo $rows->getARol(); ?></td>
                        <td ><span data-accion="del" onclick="borrar('<?php echo $rows->getIdUser();?>');">Borrar</span>
                            <span id="md" data-accion="ver" onclick="ver('<?php echo $rows->getIdUser();?>');">Ver</span>
                        </td>
                    </tr>

                <?php } ?>
                </tbody>
            </table>

        </div>
    </div>

<?php
    echo "Total Registros: ". User_model::getRowCount()."<br />";
}else{
    echo "no hay registros";
}


?>

>>>>>>> retomar
<input type="submit" name="idRecarga" value="recargar">