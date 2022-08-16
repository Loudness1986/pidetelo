<header id="header">
    <div class="container" style="margin-top: 33px ">
        <div class="row">
            <div class="col-md-10">
                <h1><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Registrar Otros Productos <small> servicios adicional, refrescos, jugos, golosinas</small></h1>
            </div>            
        </div>
    </div>
</header>
<section id="main">
    <div class="container">
        <div class="row">
            <?php include 'vis/modulo/panel_izquierdo.php'; ?>
            <div class="col-md-10">
                <form id="actualidarDatos" name="actualidarDatos" class="form-horizontal" enctype="multipart/form-data">
                    <div class='col-xs-12'>
                        <h3 class='text-right'>
                            <span id="load" style="display: none"><img src="recursos/img/LoaderIcon.gif" alt="cargando"/></span>
                            <button type="submit" class="btn btn-lg btn-primary" id="btn-actualizar"><span class="glyphicon glyphicon-refresh"></span> Actualizar</button>
                            <button type="button" class="btn btn-lg btn-success" data-toggle="modal" data-target="#dataRegister"><i class='glyphicon glyphicon-plus'></i> Agregar</button>
                        </h3>
                    </div>
                    <div class="row">		
                        <div class="col-xs-12">
                            <div id="loader" class="text-center"> <img src="loader.gif"></div>
                            <div class="datos_ajax_delete"></div>
                            <div class="outer_div"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<form id="guardarDatos" class="form-horizontal">
    <div class="modal fade" id="dataRegister" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Registrar nuevo producto</h4>
                </div>
                <div class="modal-body">
                    <div id="datos_ajax_register"></div>                            
                    <div class="form-group">
                        <label class="col-xs-2">Nombre:</label>
                        <div class="col-xs-10"> 
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de tu producto">
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="col-xs-2">Presentación:</label>
                        <div class="col-xs-10"> 
                            <select class="form-control" id="presentacion" name="presentacion">
                                <option value='-' >      Seleccione</option>
                                <option value='ración' >Ración</option>
                                <option value='1 litro' >1 litros</option>
                                <option value='1 litro 1/2'>1 litro 1/2</option>                                
                                <option value='2 litros' >2 litros</option>                                
                                <option value='1355 cm3 lata' >355 cm<sup>3</sup> lata</option>
                                <option value='extra' >Extra</option>
                                
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2">Precio:</label>
                        <div class="col-xs-10"> 
                            <input type="number" class="form-control" id="precio" name="precio" placeholder="precio de tu producto">

                        </div>
                    </div>  
                    <div class="form-group">
                        <label class="col-xs-2" >Logo:</label>
                        <div class="col-xs-10"> 
                            <input type="file" class="form-control" id="logo" name="logo" >
                        </div>
                    </div> 
                </div>
                <div class="modal-footer">
                    <span id="loadd" style="display: none"><img src="recursos/img/LoaderIcon.gif" alt="cargando"/></span>
                    <button type="submit" class="btn btn-primary" id="btn-guardar">Guardar</button>
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
            url: 'control/ctrl_new_sub_producto.php',
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
        var form = document.forms.namedItem("guardarDatos");
        var parametros = new FormData(form);
        $.ajax({
            type: "POST",
            url: "control/ctrl_new_sub_producto.php?caso=1",
            data: parametros,
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#btn-guardar').attr("disabled", true);
                $("#loadd").show();
            },
            success: function (data) {
                if (data.success == true) {
                    $("#loadd").hide();
                    $('#btn-guardar').attr("disabled", false);
                    alertify.success(data.msj);
                    load();
                    $("#nombre").val('');
                    $("#presentacion").val('-');
                    $("#precio").val('');
                    $("#logo").val('');
                } else {
                    alertify.error(data.msj);
                    $("#loadd").hide();
                    $('#btn-guardar').attr("disabled", false);
                }
            },
            error: function (jqXHR, textStatus, error) {
                alertify.error(jqXHR);
                $("#loadd").hide();
                $('#btn-guardar').attr("disabled", false);
            }
        });
        return false;
    });
    
    $("#actualidarDatos").submit(function (event) {
            var form = document.forms.namedItem("actualidarDatos");
            var parametros = new FormData(form);
            $.ajax({
                type: "POST",
                url: "control/ctrl_new_sub_producto.php?caso=3",
                data: parametros,
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    $('#btn-actualizar').attr("disabled", true);
                    $("#load").show();
                },
                success: function (data) {
                    if (data.success == true) {
                        $("#load").hide();
                        $('#btn-actualizar').attr("disabled", false);
                        alertify.success(data.msj);
                        load();
                    } else {
                        alertify.error(data.msj);
                        $("#load").hide();
                        $('#btn-actualizar').attr("disabled", false);
                        load();
                    }
                },
                error: function (jqXHR, textStatus, error) {
                    alertify.error(jqXHR);
                    $("#load").hide();
                    $('#btn-actualizar').attr("disabled", false);
                }


            });
            return false;
        });
</script>