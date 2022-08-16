<?php

require_once 'clases/cls_load.php';

function detalle_prod($param) {
    $obj = new load();
    $sql = "SELECT * FROM det_prod_negocio JOIN producto ON producto.cod_pro=det_prod_negocio.cod_pro JOIN negocio on negocio.cod_neg=det_prod_negocio.cod_neg JOIN det_ciudad_negocio ON det_ciudad_negocio.cod_neg=negocio.cod_neg JOIN ciudad ON ciudad.cod_ciud=det_ciudad_negocio.cod_ciud JOIN estado ON estado.cod_est=ciudad.cod_est JOIN categoria ON categoria.cod_cate=producto.cod_cate WHERE det_prod_negocio.id_tama=$param";
    $consulta = $obj->load_con($sql);
    $row = $obj->load_arry($consulta);
    //---------saca los detalles de contorno-----------------------------------
    $consulta2 = $obj->load_con('SELECT * FROM contorno JOIN det_prod_cont ON det_prod_cont.cod_con=contorno.cod_con WHERE det_prod_cont.cod_pro="'.$row['cod_pro'].'"');
    //---------actualizar el contador de visitas-------------------------------
    
    $obj->load_con(' UPDATE producto SET visi_pro = visi_pro + 1 WHERE cod_pro = "'.$row['cod_pro'].'"');
    //--------------------------------------------
    $disponible = '<h3 class="text-center alert alert-warning">Agotado</h3>';
    $attb = 'disabled';
    if ($row['estado_pro'] != 'agotado') {
        $disponible = '<h3 class="text-center alert alert-success">Disponible</h3>';
        $attb = '';
    }
    echo '
        <div class="col-xs-12 col-sm-6">';
    echo $disponible;
    echo'   <h4><strong>Nombre: </strong>' . $row['nom_pro'] . '</h4>
            <h4><strong>Precio: </strong>' . $row['precio_pro'] . ',00 Bfs</h4>
            <h4><strong>Preparación: </strong><small>' . $row['tiempo_pro'] . ' min</small></h4>  
            <h4><strong>Clasificación: </strong><small>' . $row['nom_cate'] . '</small></h4>
            <h4><strong>Descripción: </strong><small>' . $row['descrip_pro'] . '</small></h4>
            <h4><strong>Cantidad: </strong><input type="number" name="cant" value="1" style="width: 40px" /></h4><br>    
            <h4><strong>Ubicaion: </strong>' . $row['nom_ciud'] . '</h4>
            <address>
                <strong>' . $row['nom_neg'] . '</strong><br>
                       <abbr title="Dirección"> ' . $row['direccion'] . '</abbr> <br>
                 <abbr title="Telefono">Tel:</abbr> ' . $row['tel_pri_neg'] . ' ' . $row['tel_seg_neg'] . '
            </address>
                
            
            
        </div>
        <div class="col-xs-12 col-sm-6">
            <br><br><br>
            <img class="img-responsive" src="subidas/' . $row['logo_ful_pro'] . '">
        </div> 
        <div class="col-xs-12"  >
        <div class="row">
        <div class="col-md-3">
        <h4><strong>Contornos: </strong> </h4>';
    while ($row1 = $obj->load_arry($consulta2)) {

        echo '<select class="form-control"   name="conto[]" style="margin-top: 5px" readonly>
             <option value="-" >   No agregar</option>';
        $Valores = $obj->load_con("SELECT * FROM contorno");
        $seleccionado = $row1['cod_con'];
        while ($laRow = $obj->load_arry($Valores)) {
            if ($laRow['cod_con'] == $seleccionado) {
                print('<option value="' . $laRow["cod_con"] . '" selected>' . $laRow["nom_con"] . '</option>');
            } else {
                print('<option value="' . $laRow["cod_con"] . '" >' . $laRow["nom_con"] . '</option>');
            }
        }
        echo '</select>';
    }
    echo' </div>'; //col-md-3  style="border: 1px #000 dotted"
    echo '<div class="col-md-9" >';
    echo '     Elige la como quieres tu pedido: envio a domicilio, retiro personal ó disfrutar comiendolo en el sitio
                
          </div>'; //col-md-9
    echo' </div>'; //row
    echo' </div>';
    echo'   <div class="col-xs-12" style="margin-top: 10px;">
            <a href="?pg=catalogo_prod" class="btn btn-lg btn-primary"><i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;Regresar</a> &nbsp;&nbsp;&nbsp; 
            <button ' . $attb . ' class="btn btn-lg btn-success" data-toggle="modal" data-target="#dataRegister" ><i class="glyphicon glyphicon-hand-right"></i>&nbsp;&nbsp; Pedir</button>
        
        </div>
     ';
}


'<select class="form-control"   name="retiro" style="margin-top: 5px">
                     <option value="-" > Seleccione </option>
                     <option value="-" > envio a domicilio </option>
                     <option value="-" > retiro personal </option>
                     <option value="-" > comer en el mismo lugar </option>
                </select>';