<?php

require_once '../clases/cls_load.php';
$obj = new load();

if (isset($_GET["caso"])) {
    $caso = $_GET["caso"];
} else {
    $caso = 0;
}
$rif_neg = trim(filter_input(INPUT_POST, 'rif'));
$nom_neg = ucwords(strtolower(trim(filter_input(INPUT_POST, 'nombre'))));
$fecha_pag = trim(filter_input(INPUT_POST, 'fecha'));
$dir_neg = strtolower(trim(filter_input(INPUT_POST, 'dir')));
$telp_neg = trim(filter_input(INPUT_POST, 'telp'));
$tels_neg = trim(filter_input(INPUT_POST, 'tels'));
$json = array();
$json['msj'] = 'sin comandos';
$json['success'] = false;

switch ($caso) {//
    case 1:
        if (empty($rif_neg) || empty($nom_neg) || empty($dir_neg) || empty($telp_neg)) {
            $json['msj'] = 'Hay campos vacios';
        } else if (!ctype_digit($telp_neg)) {
            $json['msj'] = "Formato telefono invalido";
        } else if ($_FILES['logo']['name'] == "") {
            //update sin logo
            $sqlup = "UPDATE negocio SET nom_neg='$nom_neg', direccion='$dir_neg', tel_pri_neg='$telp_neg', tel_seg_neg='$tels_neg' WHERE rif_neg='$rif_neg';";
            $resl = $obj->load_con($sqlup);
            if ($resl) {
                $json['msj'] = 'Actualizacion exitosa';
                $json['success'] = true;
            } else {
                $json['msj'] = 'no se pudo actualizar';
            }
        } else if ($_FILES['logo']['name'] != "") {
            //update con logo
            $allowedExts = array("jpg", "jpeg", "gif", "png", "JPG", "GIF", "PNG");
            $extension = end(explode(".", $_FILES["logo"]["name"]));
            if ((($_FILES["logo"]["type"] == "image/gif") || ($_FILES["logo"]["type"] == "image/jpeg") || ($_FILES["logo"]["type"] == "image/png") || ($_FILES["logo"]["type"] == "image/pjpeg")) && in_array($extension, $allowedExts)) {

                $extension = end(explode('.', $_FILES['logo']['name']));
                $foto = substr(md5(uniqid(rand())), 0, 10) . "." . $extension;
                $directorio = '../subidas/'; // directorio
                move_uploaded_file($_FILES['logo']['tmp_name'], $directorio . $foto);
                $minFoto = 'min_' . $foto;
                $fulFoto = 'ful_' . $foto;
                require_once 'rezice_img.php';
                resizeImagen($directorio . '/', $foto, 65, 65, $minFoto, $extension);
                resizeImagen($directorio . '/', $foto, 500, 500, $fulFoto, $extension);
                unlink($directorio . '/' . $foto);
                //peticion de registro a la base de datos 
                $filename = $directorio . $fulFoto;
                if (file_exists($filename)) {

                    $sqlup = "UPDATE negocio SET nom_neg='$nom_neg', tel_pri_neg='$telp_neg', tel_seg_neg='$tels_neg', direccion='$dir_neg', logo_neg='$fulFoto', min_neg='$minFoto' WHERE rif_neg='$rif_neg';";
                    $resl = $obj->load_con($sqlup);
                    if ($resl) {
                        $json['msj'] = 'Actualizacion exitosa';
                        $json['success'] = true;
                    } else {
                        $json['msj'] = 'no se pudo actualizar';
                    }
                } else {
                    unlink($directorio . $fulFoto);
                    unlink($directorio . $minFoto);
                    $json ['msj'] = "Error de srvidor no se suvio la imagen.";
                }
            } else { // El archivo no es JPG/GIF/PNG
                $json['msj'] = "esto:_' . $extension . ' _no es una imagen";
            }
        }
        break;
    case 2:
        if (empty($rif_neg) || empty($fecha_pag) || empty($telp_neg) || empty($tels_neg)) {
            $json['msj'] = 'Hay campos vacios';
        } else if ($dir_neg == '-') {
            $json['msj'] = 'Seleccione el banco';
        } else if (!ctype_digit($telp_neg)) {
            $json['msj'] = "Numero de confirmacion invalido";
        } else if (!ctype_digit($tels_neg)) {
            $json['msj'] = "Monto invalido";
        } else {//falta validar la fecha actual 
            $yapago = $obj->load_arry($obj->load_con("SELECT fecha_pag FROM pago_negocio WHERE cod_neg='$rif_neg';"));
            if (empty($yapago['fecha_pag'])) {
                $re = $obj->load_con("INSERT INTO pago_negocio (fecha_pag, cod_ban, num_pag, monto_pag, cod_neg) VALUES ('$fecha_pag','$dir_neg','$telp_neg','$tels_neg','$rif_neg');");
                if ($re) {
                    $json['msj'] = 'Actualizacion exitosa, su pago sera validado en maximo 4 horas';
                    $json['success'] = true;
                } else {
                    $json['msj'] = 'No se pudo registrar el pago';
                }
            } else {
                $json['msj'] = 'Ya hay un pago registrado de fecha: ' . $yapago['fecha_pag'];
            }
        }
        break;
    case 3:
        $resp = $obj->load_con("UPDATE negocio SET estado_neg='ACTIVO', estado_pag='solvente' WHERE cod_neg='$rif_neg';");
        if ($resp) {
            $json['msj'] = 'Pago validado exitosamente';
            $json['success'] = true;
        } else {
            $json['msj'] = 'no se validar el pago';
        }
        break;
}

echo json_encode($json);
