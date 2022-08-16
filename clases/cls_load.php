<?php

require_once 'conecta_bd.php';

class load extends cls_conexion {

    public function load_con($pSql) {
        return parent::consulta($pSql);
    }

    public function load_arry($param) {
        return parent::mysql_array($param);
    }

    public function contar_row($param) {
        return parent::N_Registro($param);
    }

}