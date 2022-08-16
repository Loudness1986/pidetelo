
<?php
require_once 'clases/cls_combobox.php';
$obj = new combobox();
?>

<header id="header">
    <div class="container" style="margin-top: 33px ">
        <div class="row">
            <div class="col-md-10">
                <h1><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Plataforma <small>Administrar usuarios</small></h1>
            </div>            
        </div>
    </div>
</header>
<section id="main">
    <div class="container">
        <div class="row">
            <?php include 'vis/modulo/panel_izquierdo.php'; ?>
            <div class="col-md-10">
                <div class="form-horizontal ">
                    <h4 ><strong>Lista de usuarios</strong></h4>
                    <table class='table table-bordered'>
                        <thead class='alert-info'>
                            <tr>
                                <th><b>Nº</b></th>
                                <th><b>Usuario</b></th>
                                <th><b>Correo/Email</b></th>
                                <th><b>Estado</b></th>
                                <th><b>Fecha_reg</b></th>
                                <th><b>Observacion</b></th>
                                <th><b>Acción</b></th>
                            </tr>
                        </thead>
                        <tbody id="detalle-user">
                            <!-- Aqui el vasiado de datos-->
                         <?php include_once 'control/ctrl_load_detalle_user.php';?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</section>