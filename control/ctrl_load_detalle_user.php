<?php

require_once 'clases/cls_load.php';
$obj = new load();
$sql = "SELECT * FROM usuario";
$consulta = $obj->load_con($sql);

while ($row = $obj->load_arry($consulta)) {
    echo "<tr>";
    echo "<td>" . $row['cod_user'] . "</td>";
    echo "<td>" . $row['nom_user'] . ' ' . $row['ape_user'] . "</td>";
    echo "<td>" . $row['email_user'] . "</td>";
    echo "<td>" . $row['estado_user'] . "</td>";
    echo "<td>" . $row['fecha_reg'] . "</td>";
    echo "<td>" . $row['descrip_user'] . "</td>";
    echo "<td>accion</td>";
    echo "</tr>";
}
    




