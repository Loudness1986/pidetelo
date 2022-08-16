<header id="header">
    <div class="container" style="margin-top: 33px ">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center"><i class="glyphicon glyphicon-option-vertical"></i> Area de Registro <small>Nuevo Usuario</small></h1>
            </div>
        </div>
    </div>
</header>
<br>
<section id="main" style="margin-bottom: 80px">
    <div class="container">
        <div class="col-md-6 col-md-offset-3" >
            <form enctype="multipart/form-data" id="Form_register" name="Form_register" autocomplete="off">
                <div class="row">
                    <div class="col-md-3 field-label-responsive">
                        <label for="ced">Cedula</label>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                <div class="input-group-addon" ><i class="glyphicon glyphicon-option-vertical"></i></div>
                                <input type="text" class="form-control" id="ced" name="ced" placeholder="numero de cedula"  autofocus>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">        
                        <a href="#" data-toggle="tooltip" data-placement="right" title="Tu Cedula"><i class="glyphicon glyphicon-info-sign"> </i></a>                                                      
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 field-label-responsive">
                        <label for="nom">Nombre</label>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                <div class="input-group-addon" ><i class="glyphicon glyphicon-menu-right"></i></div>
                                <input type="text" class="form-control" id="nom" name="nom" placeholder="ejem: jorge">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">        
                        <a href="#" data-toggle="tooltip" data-placement="right" title="Tu Nombre!"><i class="glyphicon glyphicon-info-sign"> </i></a>                                                      
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 field-label-responsive">
                        <label for="ape">Apellido</label>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                <div class="input-group-addon" ><i class="glyphicon glyphicon-menu-right"></i></div>
                                <input type="text" name="ape" class="form-control" id="ape" placeholder="Ejem: perez">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">        
                        <a href="#" data-toggle="tooltip" data-placement="right" title="Tu Apellido!"><i class="glyphicon glyphicon-info-sign"> </i></a>                                                      
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 field-label-responsive">
                        <label for="tel">Teléfono</label>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                <div class="input-group-addon" ><i class="glyphicon glyphicon-phone"></i></div>
                                <input type="text" class="form-control" id="tel" name="tel" placeholder="ejem: 04240001177">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">        
                        <a href="#" data-toggle="tooltip" data-placement="right" title="Tu numero de contacto"><i class="glyphicon glyphicon-info-sign"> </i></a>                                                      
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 field-label-responsive">
                        <label for="email">E-Mail/Correo</label>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                <div class="input-group-addon" ><i class="glyphicon glyphicon-envelope"></i></div>
                                <input type="email" name="email" class="form-control" id="email" placeholder="jorge1988@example.com"  autofocus>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">        
                        <a href="#" data-toggle="tooltip" data-placement="right" title="Ingresa un correo Valido!"><i class="glyphicon glyphicon-info-sign"> </i></a>                                                      
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 field-label-responsive">
                        <label for="password">Clave</label>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group has-danger">
                            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                <div class="input-group-addon" ><i class="glyphicon glyphicon-lock"></i></div>
                                <input type="password" name="pas" class="form-control" id="pas" placeholder="********" >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">        
                        <a href="#" data-toggle="tooltip" data-placement="right" title="elige tu clave personal!"><i class="glyphicon glyphicon-info-sign"> </i></a>                                                      
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 field-label-responsive">
                        <label for="password">Confirmar Clave</label>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                <div class="input-group-addon" ><i class="glyphicon glyphicon-repeat"></i>
                                </div>
                                <input type="password" name="pass" class="form-control" id="pass" placeholder="********" >
                            </div>
                        </div>                        
                    </div>
                    <div class="col-md-1">        
                        <a href="#" data-toggle="tooltip" data-placement="right" title="Confirma tu clave!"><i class="glyphicon glyphicon-info-sign"> </i></a>                                                      
                    </div>
                </div>
                <div class="row text-right">                    
                    <div class="col-md-6">

                        <button type="button" class="btn btn-success " id="btn-reg-user"><i class="glyphicon glyphicon-log-in"></i> Registrar</button>
                    </div>
                    <div class="col-md-2">
                        <button type="reset" class="btn btn-xs"><i class="glyphicon glyphicon-refresh"></i> reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
        $("#btn-reg-user").off("click");
        $("#btn-reg-user").on("click", function (e) {
            var url = 'control/ctrl_reg_user.php';
            var form = document.forms.namedItem("Form_register");
            var formData = new FormData(form);
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if (data.success == true) {
                        $("#ced").val('');
                        $("#nom").val('');
                        $("#ape").val('');
                        $("#tel").val('');
                        $("#email").val('');
                        $("#pas").val('');
                        $("#pass").val('');
                        alertify.success(data.msj);
                        if (data.res == 'exito') {
                            //$(".container").load('detalle.php');
                            setTimeout("location.href='index.php'", 3000);
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
