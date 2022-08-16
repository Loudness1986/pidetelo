<?php
require_once 'clases/cls_load.php';
$obj = new load();
$sql = "SELECT * FROM categoria ORDER BY nom_cate ASC";
$consulta = $obj->load_con($sql);
$si_hy = $obj->contar_row($consulta);
if($si_hy > 0){
while ($row = $obj->load_arry($consulta)) { 
    echo "<h5>" . $row['nom_cate'] . "</h5>";    
}
}  else {
    echo '<h5>No hay datos</h5>';
}