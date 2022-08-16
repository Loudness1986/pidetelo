<?php
session_start();
require_once '../clases/cls_load.php';
$obj = new load();

/* se recibe la accion o el caso a ejecutar */
if (isset($_GET["caso"])) {
    $caso = $_GET["caso"];
} else {
    $caso = 0;
}
$cod_neg = $obj->load_arry($obj->load_con("SELECT cod_neg FROM det_negocio_usuario WHERE cod_user='" . $_SESSION['id'] . "'"));
$cod_sp = trim(filter_input(INPUT_POST, 'id'));
$nom_sp = ucwords(strtolower(trim(filter_input(INPUT_POST, 'nombre'))));
$pres_sp = trim(filter_input(INPUT_POST, 'presentacion'));
$prec_sp = trim(filter_input(INPUT_POST, 'precio'));
$id_pro = $_POST['product'];
$stad_sp = $_POST['estado'];


$json = array();
$json['msj'] = 'sin comandos';
$json['success'] = false;
switch ($caso) {
    case 1:
        if (empty($nom_sp)) {
            $json['msj'] = "Nombre vacío";
        } else if ($pres_sp == '-') {
            $json['msj'] = "Seleccione la presentacion de su producto";
        } else if (empty($prec_sp)) {
            $json['msj'] = "Indique el precio del producto";
        } else if ($_FILES['logo']['name'] == "") {
            $json['msj'] = "su producto debe tener un logo";
        } else if (!empty($nom_sp)) {
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
                    $obj->load_con("BEGIN");

                    $sql = "INSERT INTO sub_producto (nom_subp, presen_subp, precio_subp, estado_subp, logo_ful_subp, logo_min_subp) VALUES ('$nom_sp', '$pres_sp', '$prec_sp', 'agotado', '$fulFoto', '$minFoto');";
                    $query_update = $obj->load_con($sql);
                    if ($query_update) {
                        $dat_ult = $obj->load_arry($obj->load_con("SELECT cod_subp FROM sub_producto WHERE nom_subp='$nom_sp'"));
                        $respuesta = $obj->load_con("INSERT INTO det_subp_negocio (cod_subp, cod_neg) VALUES ('" . $dat_ult['cod_subp'] . "', '" . $cod_neg['cod_neg'] . "')");
                        if ($respuesta) {
                            $obj->load_con("COMMIT");
                            $json['msj'] = "Los datos han sido guardados exitosamente.";
                            $json['success'] = true;
                        } else {
                            $obj->load_con("ROLLBACK");
                            $json['msj'] = "No se regitro los detalles.";
                        }
                    } else {
                        $obj->load_con("ROLLBACK");
                        $json['msj'] = "Lo siento algo ha salido mal intenta nuevamente.";
                    }
                } else {
                    unlink($directorio . $fulFoto);
                    unlink($directorio . $minFoto);
                    $json['msj'] = "Error de srvidor no se suvio la imagen.";
                }
            } else { // El archivo no es JPG/GIF/PNG
                $json['msj'] = "esto:_' . $extension . ' _no es una imagen";
            }
        } else {
            $json['msj'] = "Error desconocido.";
        }

        echo json_encode($json);
        break;
    case 2:
//aca los datos de actualizar el producto como tal
        break;
    case 3:
//aca actualizar el estado del producto solamente
        for ($i = 0; $i < count($id_pro); $i++) {
            if ($stad_sp[$i] == 'disponible') {
                $obj->load_con('UPDATE sub_producto SET estado_subp="disponible" WHERE cod_subp="' . $id_pro[$i] . '"');
                $json['success'] = true;
                $json['msj'] = "Actualización exitosa";
            } else {
                $obj->load_con('UPDATE sub_producto SET estado_subp="agotado" WHERE cod_subp="' . $id_pro[$i] . '"');
                $json['success'] = true;
                $json['msj'] = "Actualización exitosa";
            }
        }
        echo json_encode($json);
        break;
    default :
        $query = $obj->load_con('SELECT * FROM sub_producto JOIN det_subp_negocio ON det_subp_negocio.cod_subp=sub_producto.cod_subp WHERE det_subp_negocio.cod_neg="' . $cod_neg['cod_neg'] . '"');
        $numrows = $obj->contar_row($query);

        if ($numrows > 0) {
            ?>
            <table class="table table-bordered">
                <thead>
                    <tr class="info">                        
                        <th>Nombre</th>	
                        <th>Presentacion</th>
                        <th>Precio</th>
                        <th>Estatus</th>                        
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $obj->load_arry($query)) {
                        $check = '';
                        $check2 = '';
                        if ($row['estado_subp'] == 'disponible') {
                            $clss = 'success';
                            $check = 'selected';
                        }
                        if ($row['estado_subp'] == 'agotado') {
                            $clss = '';
                            $check2 = 'selected';
                        }
                        ?>
                        <tr>
                            <td><?php echo $row['nom_subp']; ?></td>
                            <td><?php echo $row['presen_subp']; ?></td>	
                            <td><?php echo $row['precio_subp']; ?></td>
                            <td class="<?php echo $clss; ?>">
                                <input type="hidden" value="<?php echo $row['cod_subp'] ?>" name="product[]">                                   
                                <select name="estado[]" >
                                    <option value="disponible"  <?php echo $check; ?>>Disponible</option>
                                    <option value="agotado"  <?php echo $check2; ?>>Agotado</option>
                                </select>
                            </td>                            	
                            <td>
                                <a href="?pg=deta_pro&codneg=<?php echo $row['cod_subp'] ?>" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-edit"></span> edtar</a>
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

