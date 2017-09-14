<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 13/08/2017
 * Time: 19:55
 */

$totalRegistros = User_model::getRowCount();
//if (!empty($rows)){
if ($totalRegistros>0){
    echo "Total Registros: ". User_model::getRowCount()."<br />";
    //header('Content-type: application/json');

    ?>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Usuarios</h3>
        </div>
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped" cellpadding="3" cellspacing="2">
                <tr>
                    <th>id</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Rol</th>
                    <th></th>
                </tr>

                <?php
                if (count($rows) > 1) {
                    foreach ($rows as $row) { ?>
                        <tr>
                            <td>+<?php echo $row->getIdUser(); ?></td>
                            <td><?php echo $row->getSNombre(); ?></td>
                            <td><?php echo $row->getApellidos(); ?></td>
                            <td><?php echo $row->getARol(); ?></td>
                            <td ><span data-accion="del" onclick="borrar('<?php echo $row->getIdUser();?>');">Borrar</span>
                                <span  id="md" data-accion="ver" onclick="ver('<?php echo $row->getIdUser();?>');">Ver</span>
                            </td>
                        </tr>

                    <?php }
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
            </table>
        </div>
    </div>

<?php
    echo "Total Registros: ". User_model::getRowCount()."<br />";
}else{
    echo "no hay registros";
}


?>

