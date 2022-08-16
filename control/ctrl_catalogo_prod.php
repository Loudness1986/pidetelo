<?php
require_once 'clases/cls_load.php';
$obj = new load();
$sql = "SELECT * FROM producto JOIN det_prod_negocio ON det_prod_negocio.cod_pro=producto.cod_pro JOIN negocio on negocio.cod_neg=det_prod_negocio.cod_neg JOIN det_ciudad_negocio ON det_ciudad_negocio.cod_neg=negocio.cod_neg JOIN ciudad ON ciudad.cod_ciud=det_ciudad_negocio.cod_ciud JOIN estado ON estado.cod_est=ciudad.cod_est";
$consulta = $obj->load_con($sql);
$si_hay_reg = $obj->contar_row($consulta);
if ($si_hay_reg > 0) {
    while ($row = $obj->load_arry($consulta)) {
        echo '
        <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="thumbnail">
                <img src="subidas/' . $row['logo_ful_pro'] . '">
                <div class="caption">
                    <h3>' . $row['nom_pro'] . '</h3>
                    <p>' . $row['nom_ciud'] . ' - ' . $row['nom_neg'] . '</p>
                    
                    <p class="text-center">
                    <a href="?pg=detalle_catalogo_prod&CodProd=' . $row['id_tama'] . '" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-plus"></i>&nbsp; Detalles</a>&nbsp;&nbsp;
                    </p>
                </div>
            </div>
        </div>';
        //echo '<br>';
    }
//<p>$' . $row['precio_pro'] . '</p>
} else {
    ?>
    <div class="alert alert-warning alert-dismissable">
        
        <h4>Aviso!!!</h4> No hay datos para mostrar
    </div>
    <?php
}