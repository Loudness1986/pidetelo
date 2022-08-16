<?php

require_once 'clases/cls_load.php';
$obj = new load();

$consulta = $obj->load_con("SELECT * FROM producto JOIN det_prod_negocio ON det_prod_negocio.cod_pro=producto.cod_pro ORDER BY producto.cod_pro DESC LIMIT 5");
$si_hay_reg = $obj->contar_row($consulta);
if ($si_hay_reg > 0) {
    while ($row = $obj->load_arry($consulta)) {
        $cod = $row['id_tama'];
        $logo = $row['logo_min_pro'];
        echo '  <tr>
              <td><a href="?pg=detalle_catalogo_prod&CodProd=' . $cod . '" >  ' . $row['nom_pro'] . '</a></td>
              <td>' . $row['descrip_pro'] . '</td>
              <td><img src="subidas/' . $logo . '" /> &nbsp;&nbsp;Bsf. ' . $row['precio_pro'] . ' </td>
            </tr>';
    }
} else {
    echo '<tr>
            <td colspan="3">no hay publicaciones!!</td>            
         </tr>';
}