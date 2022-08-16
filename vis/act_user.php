<?php
$clr = filter_input(INPUT_GET, 'cod');
?>
<header id="header">
    <div class="container" style="margin-top: 33px ">
        <div class="row">
            <div class="col-md-10">
                <h1><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Cuenta <small> Activación</small></h1>
            </div>            
        </div>
    </div>
</header>
<section id="main">
    <div class="container">
        <div class="row">
            <?php include 'vis/modulo/panel_izquierdo.php'; ?>
            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading main-color-bg">
                        <h3 class="panel-title">En hora buena</h3>
                    </div>
                    <div class="panel-body">
                        <h1>Ahora</h1> 
                        <h3>Disfruta de los servicios que tenemos para ti</h3>

                        puedes ralizar compras y tener acesoramiento en servicio técnico profecional y confiable. 
                        <br><br>
                        <b>presiona aquí</b>
                        <input type="hidden" value="<?php echo $clr ?>" nom="cod" id="cod" />
                        <button class="btn btn-lg btn-success " id="btn-activar"><span class="glyphicon glyphicon-share-alt"></span>Activar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $("#btn-activar").off("click");
    $("#btn-activar").on("click", function (e) {
        var cod = $("#cod").val();
        $.ajax({
            url: 'control/ctrl_activar_user.php',
            type: 'POST',
            data: {'cod': cod},
            dataType: 'JSON'
        }).done(function (data) {
            if (data.success == true) {
                $("#cod").val('');
                alertify.success(data.msj);
                if (data.res == 'exito') {
                    setTimeout("location.href='index.php?pg=login'", 3000);
                }
            } else {
                alertify.error(data.msj);
            }
        });
    });
</script>