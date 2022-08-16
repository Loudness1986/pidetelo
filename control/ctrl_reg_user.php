<?php

require '../clases/cls_reg_user.php';
$obj = new reg_user();
$json = array();
$json['success'] = false;
$json['msj'] = 'no hay instruccion';
$ced = trim(filter_input(INPUT_POST, 'ced'));
$nom = ucwords(strtolower(trim(filter_input(INPUT_POST, 'nom'))));
$ape = ucwords(strtolower(trim(filter_input(INPUT_POST, 'ape'))));
$tel = trim(filter_input(INPUT_POST, 'tel'));
$ema = trim(filter_input(INPUT_POST, 'email'));
$pass = trim(filter_input(INPUT_POST, 'pas'));
$pass2 = trim(filter_input(INPUT_POST, 'pass'));

if (empty($ced)) {
    $json['msj'] = 'debes colocar tu cedula';
} else if (!ctype_digit($ced)) {
    $json['msj'] = 'tu cedula debe tener solo numeros';
} else if ((strlen($ced) < 7) || (strlen($ced) > 8)) {
    $json['msj'] = 'cedula incorrecta';
} else if (empty($nom)) {
    $json['msj'] = 'debes colocar tu nombre';
} else if (!ctype_alpha($nom)) {
    $json['msj'] = 'tu nombre debe tener solo letras';
} else if (empty($ape)) {
    $json['msj'] = 'debes colocar tu apellido';
} else if (!ctype_alpha($ape)) {
    $json['msj'] = 'tu apellido debe tener solo letras';
} else if (empty($tel)) {
    $json['msj'] = 'debes tener un telefono de contacto';
} else if (!ctype_digit($tel)) {
    $json['msj'] = 'tu telefono debe tener solo numeros';
} else if ((strlen($tel) < 8) || (strlen($tel) > 11)) {
    $json['msj'] = 'tu telefono no es valido';
} else if (empty($ema)) {
    $json['msj'] = 'debes colocar un correo valido';
} else if (!preg_match("/^[_.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+.)+[a-zA-Z]{2,6}$/i", $ema)) {
    $json['msj'] = 'debes colocar un correo valido';
} else if (empty($pass)) {
    $json['msj'] = 'debes elegir una clave';
} else if (strlen($pass) < 8) {
    $json['msj'] = 'minimos 8 characters para tu clave !';
} else if (empty($pass2)) {
    $json['msj'] = 'debes confirmar tu clave !';
} else if (strcmp($pass, $pass2) !== 0) {
    $json['msj'] = 'las claves no son iguales !';
} else {
    if ($obj->check_email($ema)) {
        $json['msj'] = 'Ya este correo existe';
    } else {
        $res = $obj->registrar_user($ced, $nom, $ape, $tel, $ema, $pass2);
        if ($res == true) {
            $json['msj'] = 'Registro completado confirma tu correo!!';
            $json['res'] = 'exito';
            $json['success'] = true;
        }
        if ($res == false) {
            $json['msj'] = 'registro no completado verifique sus datos!';
        }
    }
}
echo json_encode($json);
?>
