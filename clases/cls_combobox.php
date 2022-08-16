<?php

/* La clase combobox se encargar de realizar las operaciones necesarias para mostrar registros
 * ya cargados de una tabla maestra.
 * y montarlos en una variable y retornarlos
 */
require_once ("conecta_bd.php");

//creacion de la clase combobox//
class combobox extends cls_conexion {

//metodo que genera combo//
    public function generar($Sql, $pcCampo1, $pcCampo2, $Seleccionado) {
        $Valores = parent::consulta($Sql);
        while ($laRow = parent::mysql_array($Valores)) {
            if ($laRow[$pcCampo1] == $Seleccionado) {
                print("<option value='$laRow[$pcCampo1]' selected>$laRow[$pcCampo2]</option>");
            } else {
                print("<option value='$laRow[$pcCampo1]' >$laRow[$pcCampo2]</option>");
            }
        }
    }
}
