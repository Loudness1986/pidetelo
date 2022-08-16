<?php

require 'conecta_bd.php';

class reg_user extends cls_conexion {

    //añadimos la funcion que se encargara de generar un numero aleatorio 
    private function genera_random($longitud) {
        $exp_reg = "[^A-Z0-9]";
        return substr(eregi_replace($exp_reg, "", md5(rand())) . eregi_replace($exp_reg, "", md5(rand())) . eregi_replace($exp_reg, "", md5(rand())), 0, $longitud);
    }

    public function check_email($check) {
        $resstr = parent::mysql_array(parent::consulta("SELECT email_user FROM usuario WHERE email_user='$check'"));
        $str = $resstr['email_user'];
        $si = true;
        if (strcmp($str, $check) !== 0) {
            $si = false;
        }
        return $si;
    }

    public function registrar_user($p1, $p2, $p3, $p4, $p5, $p6) {
        date_default_timezone_set('America/Caracas');
        $fecha = date("Y-m-d");
        $confir = reg_user::genera_random(20);
        $nom = ucwords($p2);
        $ape = ucwords($p3);
        $pas = sha1(md5($p6)); //cambiar para encriptar la clave        
        $result_reg = parent::consulta("INSERT INTO usuario (cedula, nom_user, ape_user, tel_user, email_user, pas_user, cod_val, fecha_reg) VALUES ('$p1', '$nom', '$ape','$p4', '$p5', '$pas', '$confir', '$fecha');");
        $mensaje = "Ahora pidetelo ya\n\n";
        $mensaje .= "ingresa con tu correo y clave:\n\n";
        //$mensaje .= "A\n";
        //$mensaje .= "Contraseña: .\n\n";
        $mensaje .= 'Activa tu cuenta pulsando el siguiente enlace:';
        $mensaje .="www.devsoft.com.ve/?pg=act_user&cod=$confir ";
        $asunto = "Activación De Cuenta";
        if ($result_reg) {
            if (mail($p5, $asunto, $mensaje)) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function buscaAcceso($p1, $p2) {
        $pass = sha1(md5($p2));
        $resultado = parent::consulta("SELECT * FROM usuario WHERE email_user ='$p1' AND pas_user='$pass' LIMIT 1;");
        $acceso = parent::mysql_array($resultado);
        $p22 = $acceso['clav_user'];
        if (strcmp($pass, $p22 !== 0)) {
            return $acceso;
        }
    }

    public function activar_usuario($p1) {
        $p_if = false;
        $rre = parent::mysql_array(parent::consulta("SELECT * FROM usuario WHERE cod_val ='$p1' LIMIT 1;"));
        parent::consulta("UPDATE `usuario` SET `estado_user` = 'activo', `descrip_user` = 'usuario activo' WHERE `usuario`.`cod_user` = '" . $rre['cod_user'] . "';");
        $sql_2 = parent::mysql_array(parent::consulta("SELECT estado_user FROM usuario WHERE cod_user ='" . $rre['cod_user'] . "' LIMIT 1;"));

        if ($sql_2['estado_user'] == 'activo') {
            $p_if = true;
        }
        return $p_if;
    }

}
