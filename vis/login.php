<header id="header">
    <div class="container" style="margin-top: 33px ">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center"><i class="glyphicon glyphicon-option-vertical"></i>Ingresar <small> para disfrutar de nuestros servicios</small></h1>
            </div>
        </div>
    </div>
</header>
<section id="main" style="margin-top: 90px; margin-bottom: 130px">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">                
                <div class="form-group">
                    <label>Tu Correo</label> 
                    <input type="text" name="usr" id="usr" class="form-control" placeholder="ejemplo@latinmail.com">
                </div>
                <div class="form-group">
                    <label>Tu Clave</label> 
                    <input type="password" name="clv" id="clv" class="form-control" placeholder="Password">
                </div>
                <button class="btn btn-success btn-block">Entrar</button>
                <div class="text-center" style="margin-top: 10px">
                    <small>Olvido su clave</small>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();

        $(".btn-block").off("click");
        $(".btn-block").on("click", function (e) {
            var usuario = $("#usr").val();
            var clave = $("#clv").val();

            $.ajax({
                url: 'control/ctrl_acceso.php',
                type: 'POST',
                data: {'user': usuario, 'pass': clave},
                dataType: 'JSON',
                success: function (data) {
                    if (data.success == true) {
                        $("#usr").val('');
                        $("#clv").val('');
                        alertify.success(data.msj);
                        if (data.res == 'exito') {
                            setTimeout("location.href='index.php'", 1500);
                        }
                    } else {
                        alertify.error(data.msj);
                    }
                },
                error: function (jqXHR, textStatus, error) {
                    alertify.error(error);
                }
            });
        });

    });
</script>
