
<header id="header">
    <div class="container" style="margin-top: 33px ">
        <div class="row">
            <div class="col-md-10">
                <h1><span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span> Detalle <small> de producto</small></h1>				
            </div>            
        </div>
    </div>
</header>
<section id="main">
    <div class="container">
        <div class="row">
            <?php include 'vis/modulo/panel_izquierdo.php'; ?>
            <div class="col-md-10">
                <?php
                if (isset($_SESSION['id'])) {
                    include_once 'control/ctrl_detalle_catalogo_prod.php';
                    $id = $_GET['CodProd'];
                    detalle_prod($id);
                    ?>
                    <input type="hidden" name="cod_pro" id="cod_pro" value="<?php echo $id ?>" />
                    <input type="hidden" name="cod_user" id="cod_user" value="<?php echo $_SESSION['id'] ?>" />
                </div>
            </div>


        <?php } else { ?>
            <div class="panel panel-default">
                <div class="panel-heading main-color-bg">
                    <h3 class="panel-title"><i class="glyphicon glyphicon-lock"></i> Mensaje de esta web</h3>
                </div>            
                <div class="panel-body">
                    <p>Debes estar registrado para ver los detalles, precios y hacer consultas sobre nuestros productos</p>
                </div>
                <div class="panel-footer">
                    <a href="?pg=login" class="btn btn-block btn-lg btn-info"><span class="glyphicon glyphicon-user"></span> Iniciar session</a>
                </div>
            </div>
        <?php } ?>
    </div>
</section>
<form id="guardarDatos" name="guardarDatos" class="form-horizontal" enctype="multipart/form-data">
    <div class="modal fade" id="dataRegister" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Detalles de mi Pedído</h4>
                </div>
                <div class="modal-body">                                                
                    
                    <hr class="divider">
                    <div class="row text-right">
                        <div class="col-xs-3 col-xs-offset-7" >
                            <strong>
                                Sub Total:<br><br><br>
                                Impuestos (IVA 7%):<br><br><br>
                                Total:
                            </strong>
                        </div>
                        <div class="col-xs-2">
                            <strong>
                                <input type="text" name="subt" value="1200.00 Bsf" class="form-control"/><br>
                                <input type="text" name="iva" value="1200.00 Bsf" class="form-control"/><br>
                                <input type="text" name="total" value="1,452.00 Bsf" class="form-control"/>
                            </strong>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btn-guardar" class="btn btn-primary">Enviar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>                            
                </div>
            </div>
        </div>
    </div>
</form>

<script type = "text/javascript" >

    $(document).ready(function () {
        $("#msm").val('');
        $("#btn-enviar").off("click");
        $("#btn-enviar").on("click", function (e) {
            //var ee = $("#msm").val();
            //alertify.error(ee);
            if ($('#msm').val().trim() === '') {
                alertify.error('bebe escribir su prgunta');
            } else {
                var url = 'control/ctrl_preguntas.php';
                $('#btn-enviar').attr("disabled", true);
                var ee = $("#msm").val();
                var ii = $("#cod_pro").val();
                var oo = $("#cod_user").val();
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {'mensaje': ee, 'producto': ii, 'usuario': oo},
                    dataType: 'JSON',
                    success: function (data) {
                        if (data.success == true) {
                            $("#msm").val('');
                            alertify.success(data.msj);
                            $('#btn-enviar').attr("disabled", false);
                            //$("#detalle-user").load('control/ctrl_detalle_catalogo_prod.php');
                            if (data.res == 'exito') {
                                alertify.success('las consultas de precio se enviaran a tu correo');
                            }
                            setTimeout('location.reload()', 3000);//mientras tanto 
                        } else {
                            alertify.error(data.msj);
                            $('#btn-enviar').attr("disabled", false);
                        }
                    },
                    error: function (jqXHR, textStatus, error) {
                        alertify.error(jqXHR);
                    }
                });
            }
        });
    });
</script>

