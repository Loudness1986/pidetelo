<?php
session_start();
require_once 'clases/cls_load.php';
$objeto = new load();
$cod = $_SESSION['id'];
$con_sql = "SELECT * FROM negocio JOIN det_ciudad_negocio on negocio.cod_neg=det_ciudad_negocio.cod_neg JOIN ciudad ON det_ciudad_negocio.cod_ciud=ciudad.cod_ciud JOIN estado ON ciudad.cod_est=estado.cod_est JOIN det_negocio_usuario ON negocio.cod_neg=det_negocio_usuario.cod_neg JOIN usuario ON det_negocio_usuario.cod_user=usuario.cod_user WHERE det_negocio_usuario.cod_user='$cod';";
$datos = $objeto->load_arry($objeto->load_con("$con_sql"));
$datos_pago = $objeto->load_arry($objeto->load_con("SELECT cod_neg FROM pago_negocio WHERE cod_neg='".$datos['cod_neg']."';"));

?>
<header id="header">
    <div class="container" style="margin-top: 33px ">
        <div class="row">
            <div class="col-md-10">
                <h1><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Mi Negocio </h1>
            </div>            
        </div>
    </div>
</header>
<section id="main">
    <div class="container">
        <div class="row">
            <?php include 'vis/modulo/panel_izquierdo.php'; ?>
            <div class="col-md-9">
                <form class="form-horizontal" enctype="multipart/form-data">
                    <div class='col-xs-12 '>                     
                        <h3 class='text-right'>

<!-- <button type="submit" class="btn btn-lg btn-primary" id="btn-guardar" style="display: none"><i class='glyphicon glyphicon-save'></i> Guardar</button>
<button type="button" class="btn btn-lg btn-primary" id="btn-actualizar" onclick="activar()"><i class='glyphicon glyphicon-edit'></i> Actualizar</button>-->
                            <?php
                            if ($datos_pago['cod_neg'] != $datos['cod_neg']) {
                                echo"   <button type='button' class='btn btn-lg btn-warning' data-toggle='modal' data-target='#reportarPago'><i class='glyphicon glyphicon-alert'></i> Reportar pago</button>";
                            
                                
                            }
                            ?>
                            <button type="button" class="btn btn-lg btn-warning" id="btn-cancelar" style="display: none"><i class='glyphicon glyphicon-alert'></i> Cancelar</button>
                            <a href="<?= $_SERVER["HTTP_REFERER"] ?>" class="btn btn-lg btn-info" ><i class='glyphicon glyphicon-backward'></i> Regresar</a>
                        </h3>
                    </div>
                    <br><br><br><br>

                    <div class="panel panel-default col-lg-9">                    
                        <div class="panel-body"> 
                            <div class="form-group">
                                <label class="col-xs-2">Rif:</label>
                                <div class="col-xs-10"> 
                                    <input type="text" class="form-control" id="rif" name="rif" value="<?php echo $datos['rif_neg'] ?>" disabled>
                                </div>                                
                            </div>
                            <div class="form-group">
                                <label class="col-xs-2">Nombre:</label>
                                <div class="col-xs-10"> 
                                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $datos['nom_neg'] ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-2">Correo:</label>
                                <div class="col-xs-10"> 
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $datos['email_neg'] ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="rif" class="col-xs-2">Ciudad:</label>
                                <div class="col-xs-10">
                                    <select class="form-control" disabled>
                                        <option value='-' >      Seleccione</option>
                                        <?php
                                        require_once 'clases/cls_combobox.php';
                                        $obj = new combobox();
                                        $select = $datos['cod_ciud'];
                                        $Sql_1 = "SELECT ciudad.cod_ciud, ciudad.nom_ciud, estado.nom_est FROM ciudad JOIN estado on ciudad.cod_est=estado.cod_est";
                                        $obj->generar($Sql_1, "cod_ciud", "nom_ciud", $select); //combinar el nombre desde db ciudad mas estado
                                        ?>
                                    </select>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-xs-2">Dirección:</label>
                                <div class="col-xs-10"> 
                                    <input type="text" class="form-control" id="dir" name="dir" value="<?php echo $datos['direccion'] ?>" disabled>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-xs-2" >Tlf 1:</label>
                                <div class="col-xs-10"> 
                                    <input type="text" class="form-control" id="telp" name="telp" value="<?php echo $datos['tel_pri_neg'] ?>" disabled> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-2" >Tlf 2:</label>
                                <div class="col-xs-10"> 
                                    <input type="text" class="form-control" id="tels" name="tels" value="<?php echo $datos['tel_seg_neg'] ?>" disabled>
                                </div>
                            </div>                            
                            <div class="form-group">
                                <label class="col-xs-2" >Estado:</label>
                                <div class="col-xs-10"> 
                                    <input type="text" class="form-control" value="<?php echo $datos['estado_neg'] ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-2" >Pago:</label>
                                <div class="col-xs-10"> 
                                    <input type="text" class="form-control" value="<?php echo $datos['estado_pag'] ?>" disabled>
                                </div>
                            </div>                           
                        </div>
                    </div>  

                    <div class="col-md-3">
                        <div class="well dash-box" >                            
                            <img src="subidas/<?php echo $datos['logo_neg'] ?>" style="width: 140px; height: 120px"/>
                        </div>
                    </div>                    
                </form>
            </div>       
        </div>            
    </div>
</section>
<form id="pago" class="form-horizontal">
    <div class="modal fade" id="reportarPago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Reportar pago</h4>
                </div>
                <div class="modal-body">
                    <span id="load" style="display: none"><img src="recursos/img/LoaderIcon.gif" alt="cargando"/></span>                  
                    <div class="form-group">
                        <label for="nombre" class="col-xs-2">Fecha:</label>
                        <div class="col-xs-10">
                            <input type="hidden" class="form-control" id="rif" name="rif" value="<?php echo $datos['cod_neg'] ?>">
                            <input type="date" class="form-control" id="fecha" name="fecha">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="rif" class="col-xs-2">Banco:</label>
                        <div class="col-xs-10">
                            <select class="form-control" id="dir" name="dir">
                                <option value='-' >      Seleccione</option>
                                <?php
                                require_once 'clases/cls_combobox.php';
                                $obj_b = new combobox();
                                $Sql = "SELECT * FROM banco";
                                $obj_b->generar($Sql, "cod_ban", "nom_ban", '');
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nombre" class="col-xs-2">Nº confir:</label>
                        <div class="col-xs-10">                            
                            <input type="text" class="form-control" id="telp" name="telp">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nombre" class="col-xs-2">Monto:</label>
                        <div class="col-xs-10">                            
                            <input type="text" class="form-control" id="tels" name="tels">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btn-enviar">Enviar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>                            
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(function () {

        $("#pago").submit(function (event) {
            var form = document.forms.namedItem("pago");
            var parametros = new FormData(form);
            $.ajax({
                type: "POST",
                url: "control/ctrl_update_negocio.php?caso=2",
                data: parametros,
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    $('#btn-enviar').attr("disabled", true);
                    $("#load").show();
                },
                success: function (data) {
                    if (data.success == true) {
                        $("#load").hide();
                        $('#btn-enviar').attr("disabled", false);
                        alertify.success(data.msj);
                        setTimeout("location.reload(true)", 2000);
                    } else {
                        alertify.error(data.msj);
                        $("#load").hide();
                        $('#btn-enviar').attr("disabled", false);
                    }
                },
                error: function (jqXHR, textStatus, error) {
                    alertify.error(jqXHR);
                    $("#load").hide();
                }


            });
            return false;
        });

    });
</script>
