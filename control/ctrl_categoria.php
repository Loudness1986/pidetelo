<?php
require_once '../clases/cls_load.php';
$obj = new load();

/* se recibe la accion o el caso a ejecutar */
if (isset($_GET["caso"])) {
    $caso = $_GET["caso"];
} else {
    $caso = 0;
}
$cod_cate = trim(filter_input(INPUT_POST, 'id'));
$nom_cate = ucwords(strtolower(trim(filter_input(INPUT_POST, 'nombre'))));

switch ($caso) {
    case 1:
        if (empty($nom_cate)) {
            $errors[] = "Nombre vacío";
        } else if (!empty($nom_cate)) {

            $sql = "INSERT INTO categoria (nom_cate) VALUES ('" . $nom_cate . "');";
            $query_update = $obj->load_con($sql);
            if ($query_update) {
                $messages[] = "Los datos han sido guardados exitosamente.";
            } else {
                $errors [] = "Lo siento algo ha salido mal intenta nuevamente.";
            }
        } else {
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
    case 2:
        /* Inicia validacion del lado del servidor */
        if (empty($cod_cate)) {
            $errors[] = "ID vacío";
        } else if (empty($nom_cate)) {
            $errors[] = "Nombre vacío";
        } else if (!empty($cod_cate) && !empty($nom_cate)) {
            $id = intval($cod_cate);
            $sql = "UPDATE categoria SET  nom_cate='" . $nom_cate . "' WHERE cod_cate='" . $id . "'";
            $query_update = $obj->load_con($sql);
            if ($query_update) {
                $messages[] = "Los datos han sido actualizados exitosamente.";
            } else {
                $errors [] = "Lo siento algo ha salido mal intenta nuevamente.";
            }
        } else {
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
        $query = $obj->load_con("SELECT * FROM categoria");
        $numrows = $obj->contar_row($query);

        if ($numrows > 0) {
            ?>
            <table class="table table-bordered">
                <thead>
                    <tr class="info">
                        <th>Código</th>
                        <th>Nombre</th>				  
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $obj->load_arry($query)) {
                        ?>
                        <tr>
                            <td><?php echo $row['cod_cate']; ?></td>
                            <td><?php echo $row['nom_cate']; ?></td>					
                            <td>
                                <button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#dataUpdate" data-id="<?php echo $row['cod_cate'] ?>" data-nombre="<?php echo $row['nom_cate'] ?>"><i class='glyphicon glyphicon-edit'></i> Modificar</button>
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