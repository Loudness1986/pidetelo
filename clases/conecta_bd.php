<?php
//--------------------------------------------------------------------
//       Clase conexion-Capa de Datos
//--------------------------------------------------------------------
class cls_conexion
{
    //--------------------------------------------------------------------
    //       -abre conexion
    //       -Ejecuta sentencias SQL
    //       -cierra conexion
    //       -delvuelve el resultado
    //--------------------------------------------------------------------
    private function ejecutar($query)
    {
        //Datos de conexión a la base de datos
        $hostname = 'localhost';
        $database = 'pidetelo'; //devsoftc_pidetelo
        $username = 'root'; //devsoftc_pide
        $password = ''; //QOa@5HBr56A4
        $mysqli = new mysqli($hostname, $username, $password, $database);
        if ($mysqli->connect_errno) {
            return die("Fallo la conexión al servidor: (" . $mysqli->mysqli_connect_errno() . ") " . $mysqli->mysqli_connect_error());
        }
        $mysqli->query("SET NAMES 'utf8'");
        $resul_ejecucion = $mysqli->query($query);
        if ($resul_ejecucion) {
            $mysqli->close();
            return $resul_ejecucion;
        } else {
            $mysqli->close();
            return $resul_ejecucion;
        }
    }

    //--------------------------------------------------------------------
    //      funcion para ejecutar las consultas
    //--------------------------------------------------------------------
    public function consulta($p_query)
    {
        return cls_conexion::ejecutar($p_query);
    }

    //--------------------------------------------------------------------
    //      devuelve una consulta query en un arreglo
    //--------------------------------------------------------------------
    public function mysql_array($resultado)
    {
        return mysqli_fetch_array($resultado);
    }

    //--------------------------------------------------------------------
    //      devuelve la Cantidad de Tuplas o registros de una tabla
    //--------------------------------------------------------------------
    function N_Registro($resulta)
    {
        return mysqli_num_rows($resulta);
    }
}
//  Fin de la clase