<?php
require_once 'clases/cls_load.php';
$objeto = new load();
$cod = trim(filter_input(INPUT_GET, 'codneg'));
$con_sql = "SELECT * FROM negocio JOIN det_ciudad_negocio on negocio.cod_neg=det_ciudad_negocio.cod_neg JOIN ciudad ON det_ciudad_negocio.cod_ciud=ciudad.cod_ciud JOIN estado ON ciudad.cod_est=estado.cod_est JOIN det_negocio_usuario ON negocio.cod_neg=det_negocio_usuario.cod_neg JOIN usuario ON det_negocio_usuario.cod_user=usuario.cod_user WHERE negocio.cod_neg='$cod';";
$datos = $objeto->load_arry($objeto->load_con("$con_sql"));
$datos_pago = $objeto->load_arry($objeto->load_con("SELECT * FROM pago_negocio JOIN banco ON pago_negocio.cod_ban=banco.cod_ban WHERE cod_neg=$cod"));
?>
<header id="header">
    <div class="container" style="margin-top: 33px ">
        <div class="row">
            <div class="col-md-10">
                <h1><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Detalles de negocio </h1>
            </div>            
        </div>
    </div>
</header>
<section id="main">
    <div class="container">
        <div class="row">
            <?php include 'vis/modulo/panel_izquierdo.php'; ?>
            <div class="col-md-9">
                <form id="actualidarDatos" name="actualidarDatos" class="form-horizontal" enctype="multipart/form-data">
                    <div class='col-xs-12 '>                     
                        <h3 class='text-right'> 
                            <span id="load" style="display: none"><img src="recursos/img/LoaderIcon.gif" alt="cargando"/></span>                        
                            <button type="submit" class="btn btn-lg btn-primary" id="btn-guardar" style="display: none"><i class='glyphicon glyphicon-save'></i> Guardar</button>
                            <button type="button" class="btn btn-lg btn-primary" id="btn-actualizar" onclick="activar()"><i class='glyphicon glyphicon-edit'></i> Actualizar</button>
                            <?php
                            if ($datos['estado_neg'] == 'inactivo' && $datos_pago['cod_neg']==$datos['cod_neg']) {
                                echo"   <button type='button' class='btn btn-lg btn-success' id='btn-aprobar' data-toggle='modal' data-target='#aprobar' data-id='" . $datos_pago['cod_neg'] . "' ><i class='glyphicon glyphicon-check'></i> Aprobar pago</button>";
                            }
                            ?>
                            <button type="button" class="btn btn-lg btn-warning" id="btn-cancelar" style="display: none"><i class='glyphicon glyphicon-alert'></i> Cancelar</button>
                            <a href="?pg=new_negocio" class="btn btn-lg btn-info" ><i class='glyphicon glyphicon-backward'></i> Regresar</a>
                        </h3>
                    </div>
                    <br><br><br><br>

                    <div class="panel panel-default col-lg-9">                    
                        <div class="panel-body"> 
                            <div class="form-group">
                                <label class="col-xs-2">Rif:</label>
                                <div class="col-xs-10"> 
                                    <input type="text" class="form-control" id="rif" name="rif" value="<?php echo $datos['rif_neg'] ?>" readonly>
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
                                    <select class="form-control" readonly>
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
                                <label class="col-xs-2" >Logo:</label>
                                <div class="col-xs-10"> 
                                    <input type="file" class="form-control" id="logo" name="logo" disabled>
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
                            <div class="form-group">
                                <label class="col-xs-2" >Propietario:</label>
                                <div class="col-xs-10"> 
                                    <input type="text" class="form-control" value="<?php echo $datos['nom_user'] . ' ' . $datos['ape_user'] ?>" disabled>
                                </div>
                            </div>                            
                        </div>
                    </div>  

                    <div class="col-md-3">
                        <div class="well dash-box" >                            
                            <img src="subidas/<?php echo $datos['logo_neg'] ?>" style="width: 140px; height: 120px"/>
                        </div>
                    </div> 
                    <div class="col-md-3">
                        <div class="well dash-box" >                            
                            <h4 class="text-center">Datos de pago</h4>
                            <?php
                            if (empty($datos_pago)) {
                                echo 'no hay datos';
                                echo '<hr class="featurette-divider">';
                            } else {
                                echo 'Fecha: ' . $datos_pago['fecha_pag'];
                                echo '<hr class="featurette-divider">';
                                echo 'Banco: ' . $datos_pago['nom_ban'];
                                echo '<hr class="featurette-divider">';
                                echo 'Nº confir: ' . $datos_pago['num_pag'];
                                echo '<hr class="featurette-divider">';
                                echo 'Monto: ' . $datos_pago['monto_pag'];
                            }
                            ?>
                        </div>
                    </div> 
                </form>
            </div>       
        </div>            
    </div>
</section>
<form id="aprobarPago">
    <div class="modal fade" id="aprobar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <input type="hidden" id="rif" name="rif">
                <h2 class="text-center text-muted">Estas seguro?</h2>
                <p class="lead text-muted text-center" style="display: block;margin:10px">De aprobar este pago. Deseas continuar?</p>
                <div class="modal-footer">
                    <span id="load" style="display: none"><img src="recursos/img/LoaderIcon.gif" alt="cargando"/></span>
                    <button type="submit" class="btn btn-lg btn-primary" id="btn-aceptar">Aceptar</button>
                    <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancelar</button>                    
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(function () {

        $("#btn-actualizar").off("click");
        $("#btn-actualizar").on("click", function (e) {
            $('#btn-actualizar').hide();
            $('#btn-guardar').show();
            $('#btn-cancelar').show();
            $('#nombre').removeAttr('disabled');
            $('#dir').removeAttr('disabled');
            $('#telp').removeAttr('disabled');
            $('#tels').removeAttr('disabled');
            $('#logo').removeAttr('disabled');
        });
        $("#btn-cancelar").off("click");
        $("#btn-cancelar").on("click", function (e) {
            $('#btn-actualizar').show();
            $('#btn-guardar').hide();
            $('#btn-cancelar').hide();
            $("#load").hide();
            $('#nombre').attr('disabled', 'disabled');
            $('#dir').attr('disabled', 'disabled');
            $('#telp').attr('disabled', 'disabled');
            $('#tels').attr('disabled', 'disabled');
            $('#logo').attr('disabled', 'disabled');
        });
        $('#aprobar').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('#rif').val(id);
        });

        $("#actualidarDatos").submit(function (event) {
            var form = document.forms.namedItem("actualidarDatos");
            var parametros = new FormData(form);
            $.ajax({
                type: "POST",
                url: "control/ctrl_update_negocio.php?caso=1",
                data: parametros,
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    $('#btn-guardar').attr("disabled", true);
                    $("#load").show();
                },
                success: function (data) {
                    if (data.success == true) {
                        $("#load").hide();
                        $('#btn-guardar').attr("disabled", false);
                        alertify.success(data.msj);
                        setTimeout("location.reload(true)", 3000);
                    } else {
                        alertify.error(data.msj);
                        $("#load").hide();
                        $('#btn-guardar').attr("disabled", false);
                    }
                },
                error: function (jqXHR, textStatus, error) {
                    alertify.error(jqXHR);
                    $("#load").hide();
                }


            });
            return false;
        });
        $("#aprobarPago").submit(function (event) {
            var parametros = $(this).serialize();
            $.ajax({
                type: "POST",
                url: 'control/ctrl_update_negocio.php?caso=3',
                data: parametros,
                dataType: 'JSON',
                beforeSend: function (objeto) {
                    $('#btn-aceptar').attr("disabled", true);
                    $("#load").show();
                },
                success: function (data) {
                    if (data.success == true) {
                        $("#load").hide();
                        alertify.success(data.msj);
                        setTimeout("location.reload(true)", 1000);
                    } else {
                        $("#load").hide();
                        $('#btn-aceptar').attr("disabled", false);
                        alertify.error(data.msj);
                    }
                    $('#aprobar').modal('hide');
                }
            });
            event.preventDefault();
        });
    });
</script>
