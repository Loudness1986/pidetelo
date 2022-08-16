<?php
require_once '../clases/cls_load.php';
$obj = new load();

/* se recibe la accion o el caso a ejecutar */
if (isset($_GET["caso"])) {
    $caso = $_GET["caso"];
} else {
    $caso = 0;
}
$id_neg = trim(filter_input(INPUT_POST, 'id'));
$rif_neg = ucwords(trim(filter_input(INPUT_POST, 'rif')));
$nom_neg = ucwords(strtolower(trim(filter_input(INPUT_POST, 'nombre'))));
$email_neg = strtolower(trim(filter_input(INPUT_POST, 'email')));
$ciud_neg = trim(filter_input(INPUT_POST, 'ciud'));
$dir_neg = strtolower(trim(filter_input(INPUT_POST, 'dir')));
$telp_neg = trim(filter_input(INPUT_POST, 'telp'));
$tels_neg = trim(filter_input(INPUT_POST, 'tels'));
$propi_neg = trim(filter_input(INPUT_POST, 'propi'));

switch ($caso) {//
    case 1:
        if (empty($rif_neg)) {
            $errors[] = "Rif vacío";
        } else if ((strlen($rif_neg) < 10) || (strlen($rif_neg) > 10)) {
            $errors[] = "Formato Rif incorrecto";
        } else if (empty($nom_neg)) {
            $errors[] = "Nombre vacío";
        } else if (empty($email_neg)) {
            $errors[] = "Correo vacío";
        } else if (!preg_match("/^[_.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+.)+[a-zA-Z]{2,6}$/i", $email_neg)) {
            $errors[] = "Correo no valido";
        } else if ($ciud_neg == "-") {
            $errors[] = "Seleccione ciudad";
        } else if (empty($dir_neg)) {
            $errors[] = "Dirección vacía";
        } else if (empty($telp_neg)) {
            $errors[] = "Telefono 1 obligatorio";
        } else if (!ctype_digit($telp_neg)) {
            $errors[] = "Formato telefono invalido";
        } else if ($_FILES['logo']['name'] == "") {
            $errors[] = "Seleccione el logo";
        } else if ($propi_neg == "-") {
            $errors[] = "Indique quien sera propietario de este negocio";
        } else if (!empty($rif_neg) && !empty($nom_neg) && !empty($email_neg) && !empty($dir_neg) && !empty($telp_neg)) {

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
                    $existe = $obj->load_arry($obj->load_con("SELECT rif_neg FROM negocio WHERE rif_neg='$rif_neg'"));
                    if (!$existe) {
                        $sql = "INSERT INTO negocio (rif_neg, nom_neg, email_neg, tel_pri_neg, tel_seg_neg, direccion, logo_neg, min_neg) VALUES ('" . $rif_neg . "', '" . $nom_neg . "', '" . $email_neg . "', '" . $telp_neg . "', '" . $tels_neg . "', '" . $dir_neg . "', '" . $fulFoto . "', '" . $minFoto . "');";
                        $query_update = $obj->load_con($sql);
                        if ($query_update) {

                            $cod_neg = $obj->load_arry($obj->load_con("SELECT cod_neg FROM negocio WHERE rif_neg='$rif_neg'"));
                            $result = $obj->load_con("INSERT INTO det_ciudad_negocio (cod_ciud,cod_neg) VALUES ('" . $ciud_neg . "','" . $cod_neg['cod_neg'] . "');");
                            if ($result) {
                                $resultpropi = $obj->load_con("INSERT INTO det_negocio_usuario (cod_user,cod_neg) VALUES ('" . $propi_neg . "','" . $cod_neg['cod_neg'] . "');");
                                if ($resultpropi) {
                                    $obj->load_con("UPDATE `usuario` SET `t_t_n_n` = 'S' WHERE `usuario`.`cod_user` = '" . $propi_neg . "';");
                                    $messages[] = "Los datos han sido guardados exitosamente.";
                                } else {
                                    unlink($directorio . $fulFoto);
                                    unlink($directorio . $minFoto);
                                    $errors [] = "Lo siento algo ha salido mal intenta nuevamente.";
                                }
                            } else {
                                unlink($directorio . $fulFoto);
                                unlink($directorio . $minFoto);
                                $errors [] = "Lo siento algo ha salido mal intenta nuevamente.";
                            }
                        } else {
                            unlink($directorio . $fulFoto);
                            unlink($directorio . $minFoto);
                            $errors [] = "Lo siento algo ha salido mal intenta nuevamente.";
                        }
                    } else {
                        unlink($directorio . $fulFoto);
                        unlink($directorio . $minFoto);
                        $errors [] = "Ya existen los datos que intenta registrar.";
                    }
                } else {
                    unlink($directorio . $fulFoto);
                    unlink($directorio . $minFoto);
                    $errors [] = "Error de srvidor no se suvio la imagen.";
                }
            } else { // El archivo no es JPG/GIF/PNG
                $errors[] = "esto:_' . $extension . ' _no es una imagen";
            }
        } else {
            unlink($directorio . $fulFoto);
            unlink($directorio . $minFoto);
            $errors [] = "Error desconocido.";
        }

        if (isset($errors)) {
            ?>
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Error!</strong> 
                <?php
                foreach ($errors as $error) {
                    echo $error;
                }
                ?>
            </div>
            <?php
        }
        if (isset($messages)) {
            ?>
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>¡Bien hecho!</strong>
                <?php
                foreach ($messages as $message) {
                    echo $message;
                }
                ?>
            </div>
            <?php
        }
        break;
    
    default :
        //consulta principal para recuperar los datos
        $query = $obj->load_con("SELECT * FROM negocio");
        $numrows = $obj->contar_row($query);

        if ($numrows > 0) {
            ?>
            <table class="table table-bordered">
                <thead>
                    <tr class="info">
                        <th>Rif</th>	
                        <th>Nombre</th>
                        <th>Telf 1</th>
                        <th>Estatus</th>
                        <th>Pago</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $obj->load_arry($query)) {
                        if ($row['estado_pag'] == 'pendiente') {
                            $clss = 'danger';
                        }
                        ?>
                        <tr>
                            <td><?php echo $row['rif_neg']; ?></td>
                            <td><?php echo $row['nom_neg']; ?></td>                            
                            <td><?php echo $row['tel_pri_neg']; ?></td>
                            <td><?php echo $row['estado_neg']; ?></td>
                            <td class="<?php echo $clss; ?>"><?php echo $row['estado_pag']; ?></td>
                            <td>
                                <a href="?pg=deta_neg&codneg=<?php echo $row['cod_neg'] ?>" class="btn btn-xs btn-success"><i class='glyphicon glyphicon-plus'></i> detalles</a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>       

            <?php
        } else {
            ?>
            <div class="alert alert-warning alert-dismissable">
                <h4>Aviso!!!</h4> No se encontro registros para mostrar
            </div>
            <?php
        }
        break;
}	

