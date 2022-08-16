<?php

require '../clases/cls_reg_user.php';
$obj = new reg_user();
$json = array();
$json['success'] = false;
$json['msj'] = 'no hay instruccion';

$cod = trim(filter_input(INPUT_POST, 'cod'));
if ($obj->activar_usuario($cod)) {
    $json['msj'] = 'Felicitaciones cuenta activada!!';
    $json['res'] = 'exito';
    $json['success'] = true;
} else {
    $json['msj'] = 'NO se pudo activar su cuenta!! contactenos';
}

echo json_encode($json);
?>