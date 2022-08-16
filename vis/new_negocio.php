
<header id="header">
    <div class="container" style="margin-top: 33px ">
        <div class="row">
            <div class="col-md-10">
                <h1><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Gestionar nuevo negocio </h1>
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
                        <div id="loader" class="text-center"> <img src="recursos/img/loader.gif"></div>
                        <div class="datos_ajax_delete"></div>
                        <div class="outer_div"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<form id="guardarDatos" name="guardarDatos" class="form-horizontal" enctype="multipart/form-data">
    <div class="modal fade" id="dataRegister" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Registrar Nuevo Negocio</h4>
                </div>
                <div class="modal-body">
                    <div id="datos_ajax_register"></div>                            
                    <div class="form-group">
                        <label class="col-xs-2">Rif:</label>
                        <div class="col-xs-10"> 
                            <input type="text" class="form-control" id="rif" name="rif" placeholder="ejem: J23882882">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2">Nombre:</label>
                        <div class="col-xs-10"> 
                            <input type="text" class="form-control" id="nombre" name="nombre">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2">Correo:</label>
                        <div class="col-xs-10"> 
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="rif" class="col-xs-2">Ciudad:</label>
                        <div class="col-xs-8">
                            <select name="ciud" id="ciud" class="form-control" >
                                <option value='-' >      Seleccione</option>
                                <?php                                
                                require_once 'clases/cls_combobox.php';
                                $obj = new combobox();                                
                                $Sql_1 = "SELECT ciudad.cod_ciud, CONCAT(ciudad.nom_ciud, ' ', estado.nom_est) As nombre FROM ciudad JOIN estado on ciudad.cod_est=estado.cod_est";                
                                $obj->generar($Sql_1, "cod_ciud", "nombre", $select);//combinar el nombre desde db ciudad mas estado
                                ?>
                            </select>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="col-xs-2">Dirección:</label>
                        <div class="col-xs-10"> 
                            <input type="text" class="form-control" id="dir" name="dir">
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="col-xs-2" style="width: 105px">telefono 1:</label>
                        <div class="col-xs-9"> 
                            <input type="text" class="form-control" id="telp" name="telp">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3" style="width: 105px">Telefono 2:</label>
                        <div class="col-xs-9"> 
                            <input type="text" class="form-control" id="tels" name="tels">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3" style="width: 105px">Logo:</label>
                        <div class="col-xs-9"> 
                            <input type="file" class="form-control" id="logo" name="logo">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="rif" class="col-xs-2">Propietario:</label>
                        <div class="col-xs-8">
                            <select name="propi" id="propi" class="form-control" >
                                <option value='-' >      Seleccione</option>
                                <?php                               
                                $Sql = "SELECT cod_user, CONCAT(nom_user,' ', ape_user) AS nombre FROM usuario"; //concatenar cedula nombre y apellido               
                                $obj->generar($Sql, "cod_user", "nombre", $select);
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btn-guardar" class="btn btn-primary">Guardar datos</button>
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
            url: 'control/ctrl_new_negocio.php',
            beforeSend: function () {
                $("#loader").html("<img src='recursos/img/loader.gif'>");
            },
            success: function (data) {
                $(".outer_div").html(data).fadeIn('slow');
                $("#loader").html("");
            }
        });
    }

    $("#guardarDatos").submit(function () {
        var form = document.forms.namedItem("guardarDatos");
        var parametros = new FormData(form);
        $.ajax({
            type: "POST",
            url: "control/ctrl_new_negocio.php?caso=1",
            data: parametros,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#btn-guardar').attr("disabled", true);
                $("#datos_ajax_register").html("Mensaje: Cargando...");
            },
            success: function (datos) {
                $("#datos_ajax_register").html(datos);
                load();
                $('#btn-guardar').attr("disabled", false);
            }
        });
        //event.preventDefault();
        return false;
    });
</script>