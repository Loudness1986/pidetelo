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
$cod_p = trim(filter_input(INPUT_POST, 'id'));
$nom_p = ucwords(strtolower(trim(filter_input(INPUT_POST, 'nombre'))));
$des_p = strtolower(trim(filter_input(INPUT_POST, 'descrip')));
$tmp_p = trim(filter_input(INPUT_POST, 'tmp'));
$pre_p = trim(filter_input(INPUT_POST, 'precio'));
$cat_p = trim(filter_input(INPUT_POST, 'cate'));
$con_p = $_POST['conto']; //contornos
//$tamaño = $_POST['tama']; //tamaño
//$array_pre = $_POST['pre']; //tamaño
$id_pro = $_POST['product'];
$dispo = $_POST['dispo'];


$json = array();
$json['msj'] = 'sin comandos';
$json['success'] = false;
switch ($caso) {
    case 1:
        if (empty($nom_p)) {
            $json['msj'] = "Nombre vacío";
        } else if (empty($des_p)) {
            $json['msj'] = "Ingrese breve descripcion de su producto";
        } else if (empty($pre_p)) {
            $json['msj'] = "Indique el precio del producto";
        } else if ($tmp_p == '-') {
            $json['msj'] = "Seleccione tiempo de espera";
        } else if ($cat_p == '-') {
            $json['msj'] = "Seleccione una categoria";
        } else if ($_FILES['logo']['name'] == "") {
            $json['msj'] = "Debe tener una imagen para mostrar";
        } else if (!empty($nom_p)) {
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
                    //validacion de la rejilla contornos
                    for ($index = 0; $index < count($con_p); $index++) {
                        if ($con_p[$index] == '-') {
                            $json['msj'] = "Seleccione los contornos";
                        }
                    }
                    $sql = "INSERT INTO producto (nom_pro, descrip_pro, tiempo_pro, cod_cate, logo_ful_pro, logo_min_pro) VALUES ('$nom_p', '$des_p', '$tmp_p', '$cat_p', '$fulFoto', '$minFoto');";
                    $query_update = $obj->load_con($sql);
                    if ($query_update) {
                        $dat_ult = $obj->load_arry($obj->load_con("SELECT cod_pro FROM producto WHERE nom_pro='$nom_p'"));
                        $obj->load_con("INSERT INTO det_prod_negocio (tama_pro, precio_pro, estado_pro, cod_neg, cod_pro) VALUES ('normal', '" . $pre_p . "', 'agotado', '" . $cod_neg['cod_neg'] . "', '" . $dat_ult['cod_pro'] . "')");

                        for ($index = 0; $index < count($con_p); $index++) {
                            $obj->load_con("INSERT INTO det_prod_cont (cod_pro, cod_con) VALUES ('" . $dat_ult['cod_pro'] . "', '$con_p[$index]')");
                        }
                        if ($index == count($con_p)) {
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
        //aca ira la actualizacion del producto
        break;
    case 3:
        for ($i = 0; $i < count($id_pro); $i++) {
            if ($dispo[$i] == 'disponible') {
                $obj->load_con('UPDATE det_prod_negocio SET estado_pro="disponible" WHERE id_tama="' . $id_pro[$i] . '"');
                $json['success'] = true;
                $json['msj'] = "Actualización exitosa";
            } else {
                $obj->load_con('UPDATE det_prod_negocio SET estado_pro="agotado" WHERE id_tama="' . $id_pro[$i] . '"');
                $json['success'] = true;
                $json['msj'] = "Actualización exitosa";
            }
        }
        echo json_encode($json);
        break;
    default :
        //consulta principal para recuperar los datos
        $query = $obj->load_con('SELECT * FROM producto JOIN det_prod_negocio ON det_prod_negocio.cod_pro=producto.cod_pro WHERE det_prod_negocio.cod_neg="' . $cod_neg['cod_neg'] . '"');
        $numrows = $obj->contar_row($query);

        if ($numrows > 0) {
            ?>
            <table class="table table-bordered">
                <thead>
                    <tr class="info">                        
                        <th>Nombre</th>	
                        <th>Descripcion</th>
                        <th>Precio</th>
                        <th>Estatus</th>
                        <th>Tamaño</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $obj->load_arry($query)) {
                        $check = '';
                        $check2 = '';
                        if ($row['estado_pro'] == 'disponible') {
                            $clss = 'success';
                            $check = 'selected';
                        }
                        if ($row['estado_pro'] == 'agotado') {
                            $clss = '';
                            $check2 = 'selected';
                        }
                        ?>
                        <tr>
                            <td><?php echo $row['nom_pro']; ?></td>
                            <td><?php echo $row['descrip_pro']; ?></td>	
                            <td><?php echo $row['precio_pro']; ?></td>
                            <td class="<?php echo $clss; ?>">
                                <input type="hidden" value="<?php echo $row['id_tama'] ?>" name="product[]">                                   
                                <select name="dispo[]" >
                                    <option value="disponible"  <?php echo $check; ?>>Disponible</option>
                                    <option value="agotado"  <?php echo $check2; ?>>Agotado</option>
                                </select>
                            </td>	
                            <td><?php echo $row['tama_pro']; ?></td>	
                            <td>
                                <a href="?pg=deta_pro&codneg=<?php echo $row['cod_neg'] ?>" class="btn btn-xs btn-success"><i class='glyphicon glyphicon-plus'></i> detalles</a>
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