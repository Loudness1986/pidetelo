<?php

require_once 'conecta_bd.php';

class auto_com extends cls_conexion {

    //Auto Completar 
    public function auto_com_mod($termino) {
        $datos = array();
        $sql = "SELECT cod_mod,nom_mod,nom_mar FROM modelo JOIN marca on modelo.cod_mar=marca.cod_mar WHERE nom_mod LIKE '%$termino%';";
        $resultado = parent::consulta($sql);
        while ($row = parent::mysql_array($resultado)) {
            $datos[] = array("value" => $row['nom_mar'].' '.$row['nom_mod'] ,
                "cod" => $row['cod_mod']);
        }
        return $datos;
    }

}
