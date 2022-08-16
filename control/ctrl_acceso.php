<?php

/*
 * control de acceso de usuarios
 */

require ("../clases/cls_reg_user.php");
$objeto = new reg_user();
$user = trim(filter_input(INPUT_POST, 'user'));
$clave = trim(filter_input(INPUT_POST, 'pass'));

$json = array();
$obj = new reg_user();
if (empty($user)) {
    $json['msj'] = 'Ingresa tu usuario';
    $json['success'] = false;
} else if (!preg_match("/^[_.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+.)+[a-zA-Z]{2,6}$/i", $user)) {
    $json['msj'] = 'debes colocar un correo valido';
    $json['success'] = false;
} else if (empty($clave)) {
    $json['msj'] = 'Ingresa tu clave';
    $json['success'] = false;
} else {
    $acce = $obj->buscaAcceso($user, $clave);
    if ($acce != NULL) {
        $estado = $acce['estado_user'];
        if ($estado == 'activo') {
            session_start();
            $_SESSION["id"] = $acce['cod_user'];
            $_SESSION["ced"] = $acce['cedula'];
            $_SESSION["nom"] = $acce['nom_user'];
            $_SESSION["ape"] = $acce['ape_user'];
            $_SESSION['nivel'] = $acce['nivel'];
            $_SESSION['nego'] = $acce['t_t_n_n'];
            $json['res'] = 'exito';
            $json['msj'] = 'Usuario Verificado con exito';
            $json['success'] = true;
        } else {
            $json['msj'] = 'Usuario Inactivo o Bloqueado';
            $json['success'] = false;
        }
    } else {
        $json['msj'] = 'No se pudo verificar el Acceso [cuenta no existe]';
        $json['success'] = false;
    }
}
echo json_encode($json);
