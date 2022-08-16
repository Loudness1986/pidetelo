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
$cod_con = trim(filter_input(INPUT_POST, 'id'));
$nom_con = ucwords(strtolower(trim(filter_input(INPUT_POST, 'nombre'))));
$descrip_con = strtolower(trim(filter_input(INPUT_POST, 'descrip')));

$cod_user = $_SESSION['id'];
$cod= $obj->load_arry($obj->load_con("SELECT cod_neg FROM det_negocio_usuario WHERE cod_user=$cod_user"));
$cod_neg = $cod['cod_neg'];

switch ($caso) {
    case 1:
        if (empty($nom_con)) {
            $errors[] = "Nombre vacío";
        } else if (empty($descrip_con)) {
            $errors[] = "Ingrese una breve descripción";
        } else if (!empty($nom_con) && !empty($descrip_con)) {

            $sql = "INSERT INTO contorno (nom_con, descrip_con, cod_neg) VALUES ('" . $nom_con . "', '" . $descrip_con . "', '" . $cod_neg . "');";
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
        if (empty($cod_con)) {
            $errors[] = "ID vacío";
        } else if (empty($nom_con)) {
            $errors[] = "Nombre vacío";
        } else if (empty($descrip_con)) {
            $errors[] = "Ingrese una breve descripción";
        } else if (!empty($cod_con) && !empty($nom_con) && !empty($descrip_con)) {
            $id = intval($cod_con);
            $sql = "UPDATE contorno SET  nom_con='" . $nom_con . "', descrip_con='" . $descrip_con . "' WHERE cod_con='" . $id . "'";
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

        $query = $obj->load_con("SELECT * FROM contorno WHERE cod_neg=$cod_neg");
        $numrows = $obj->contar_row($query);

        if ($numrows > 0) {
            ?>
            <table class="table table-bordered">
                <thead>
                    <tr class="info">                        
                        <th>Nombre</th>	
                        <th>Descripción</th>                       
                        <th>Acción</th>                            
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $obj->load_arry($query)) {
                        ?>
                        <tr>
                            <td><?php echo $row['nom_con']; ?></td>
                            <td><?php echo $row['descrip_con']; ?></td>                            
                            <td>                               
                                <button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#dataUpdate" data-id="<?php echo $row['cod_con'] ?>" data-nombre="<?php echo $row['nom_con'] ?>" data-descrip="<?php echo $row['descrip_con'] ?>"><i class='glyphicon glyphicon-edit'></i> Modificar</button> 
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

