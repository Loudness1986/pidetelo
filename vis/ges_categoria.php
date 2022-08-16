<header id="header">
    <div class="container" style="margin-top: 33px ">
        <div class="row">
            <div class="col-md-10">
                <h1><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Categorias</h1>
            </div>            
        </div>
    </div>
</header>
<section id="main">
    <div class="container">
        <div class="row">
            <?php include 'vis/modulo/panel_izquierdo.php'; ?>
            <div class="col-md-10">
                <div class='col-xs-12'>
                    <h3 class='text-right'>		
                        <button type="button" class="btn btn-lg btn-primary" data-toggle="modal" data-target="#dataRegister"><i class='glyphicon glyphicon-plus'></i> Agregar</button>
                    </h3>
                </div>	

                <div class="row">		
                    <div class="col-xs-12">
                        <div id="loader" class="text-center"> <img src="loader.gif"></div>
                        <div class="datos_ajax_delete"></div>
                        <div class="outer_div"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<form id="guardarDatos">
            <div class="modal fade" id="dataRegister" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Registrar Nueva Categoria</h4>
                        </div>
                        <div class="modal-body">
                            <div id="datos_ajax_register"></div>                            
                            <div class="form-group">
                                <label for="nombre" class="control-label">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre">
                            </div>                         
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Guardar datos</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>                            
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <form id="actualidarDatos">
            <div class="modal fade" id="dataUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel"></h4>
                        </div>
                        <div class="modal-body">
                            <div id="datos_ajax"></div>                    
                            <div class="form-group">
                                <label for="nombre" class="control-label">Nombre:</label>
                                <input type="hidden" class="form-control" id="id" name="id">
                                <input type="text" class="form-control" id="nombre" name="nombre">
                            </div>                    
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Actualizar datos</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>                            
                        </div>
                    </div>
                </div>
            </div>
        </form>
<script>
            $(document).ready(function () {
                load();
            });

            function load() {
                $("#loader").fadeIn('slow');
                $.ajax({
                    url: 'control/ctrl_categoria.php',
                    beforeSend: function () {
                        $("#loader").html("<img src='recursos/img/loader.gif'>");
                    },
                    success: function (data) {
                        $(".outer_div").html(data).fadeIn('slow');
                        $("#loader").html("");
                    }
                });
            }

            $("#guardarDatos").submit(function (event) {
                var parametros = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "control/ctrl_categoria.php?caso=1",
                    data: parametros,
                    beforeSend: function () {
                        $("#datos_ajax_register").html("Mensaje: Cargando...");
                    },
                    success: function (datos) {
                        $("#datos_ajax_register").html(datos);
                        load();
                    }
                });
                event.preventDefault();
            });
            $('#dataUpdate').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var codigo = button.data('id');
                var nombre = button.data('nombre');

                var modal = $(this)
                modal.find('.modal-title').text('Modificar Categoria: ' + nombre);
                modal.find('.modal-body #id').val(codigo);
                modal.find('.modal-body #nombre').val(nombre);
                $('.alert').hide();//Oculto alert
            });

            $("#actualidarDatos").submit(function (event) {
                var parametros = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "control/ctrl_categoria.php?caso=2",
                    data: parametros,
                    beforeSend: function () {
                        $("#datos_ajax").html("Mensaje: Cargando...");
                    },
                    success: function (datos) {
                        $("#datos_ajax").html(datos);

                        load();
                    }
                });
                event.preventDefault();
            });
        </script>