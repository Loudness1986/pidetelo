SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `pidetelo` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci ;
USE `pidetelo` ;

-- -----------------------------------------------------
-- Table `pidetelo`.`banco`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pidetelo`.`banco` (
  `cod_ban` INT(3) NOT NULL AUTO_INCREMENT ,
  `nom_ban` VARCHAR(40) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL ,
  PRIMARY KEY (`cod_ban`) )
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;


-- -----------------------------------------------------
-- Table `pidetelo`.`bitacora`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pidetelo`.`bitacora` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `operacion` VARCHAR(10) NULL DEFAULT NULL ,
  `usuario` VARCHAR(40) NULL DEFAULT NULL ,
  `host` VARCHAR(30) NOT NULL ,
  `modificado` DATETIME NULL DEFAULT NULL ,
  `tabla` VARCHAR(40) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `pidetelo`.`categoria`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pidetelo`.`categoria` (
  `cod_cate` INT(11) NOT NULL AUTO_INCREMENT ,
  `nom_cate` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL ,
  PRIMARY KEY (`cod_cate`) )
ENGINE = InnoDB
AUTO_INCREMENT = 25
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;


-- -----------------------------------------------------
-- Table `pidetelo`.`estado`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pidetelo`.`estado` (
  `cod_est` INT(3) NOT NULL AUTO_INCREMENT ,
  `nom_est` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL ,
  PRIMARY KEY (`cod_est`) )
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;


-- -----------------------------------------------------
-- Table `pidetelo`.`ciudad`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pidetelo`.`ciudad` (
  `cod_ciud` INT(3) NOT NULL AUTO_INCREMENT ,
  `nom_ciud` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL ,
  `cod_est` INT(3) NOT NULL ,
  PRIMARY KEY (`cod_ciud`) ,
  INDEX `fk_ciudad_estado1` (`cod_est` ASC) ,
  CONSTRAINT `fk_ciudad_estado1`
    FOREIGN KEY (`cod_est` )
    REFERENCES `pidetelo`.`estado` (`cod_est` )
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;


-- -----------------------------------------------------
-- Table `pidetelo`.`negocio`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pidetelo`.`negocio` (
  `cod_neg` INT(11) NOT NULL AUTO_INCREMENT ,
  `rif_neg` VARCHAR(20) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL ,
  `nom_neg` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL ,
  `email_neg` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL ,
  `tel_pri_neg` VARCHAR(18) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL ,
  `tel_seg_neg` VARCHAR(18) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NULL DEFAULT 'No' ,
  `direccion` TEXT CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL ,
  `logo_neg` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NULL DEFAULT 'no hay logo' ,
  `min_neg` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL ,
  `estado_neg` VARCHAR(20) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL DEFAULT 'inactivo' ,
  `estado_pag` VARCHAR(20) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL DEFAULT 'pendiente' ,
  PRIMARY KEY (`cod_neg`) )
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;


-- -----------------------------------------------------
-- Table `pidetelo`.`contorno`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pidetelo`.`contorno` (
  `cod_con` INT(11) NOT NULL AUTO_INCREMENT ,
  `nom_con` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL ,
  `descrip_con` VARCHAR(90) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL ,
  `cod_neg` INT(11) NOT NULL ,
  PRIMARY KEY (`cod_con`) ,
  INDEX `fk_contorno_negocio1` (`cod_neg` ASC) ,
  CONSTRAINT `fk_contorno_negocio1`
    FOREIGN KEY (`cod_neg` )
    REFERENCES `pidetelo`.`negocio` (`cod_neg` )
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;


-- -----------------------------------------------------
-- Table `pidetelo`.`det_banco_negocio`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pidetelo`.`det_banco_negocio` (
  `tipo_cuenta_neg` VARCHAR(10) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL ,
  `num_centa_neg` VARCHAR(20) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL ,
  `banco_cod` INT(3) NOT NULL ,
  `negocio_cod` INT(11) NOT NULL ,
  INDEX `fk_det_banco_negocio_banco1` (`banco_cod` ASC) ,
  INDEX `fk_det_banco_negocio_negocio1` (`negocio_cod` ASC) ,
  CONSTRAINT `fk_det_banco_negocio_banco1`
    FOREIGN KEY (`banco_cod` )
    REFERENCES `pidetelo`.`banco` (`cod_ban` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_det_banco_negocio_negocio1`
    FOREIGN KEY (`negocio_cod` )
    REFERENCES `pidetelo`.`negocio` (`cod_neg` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;


-- -----------------------------------------------------
-- Table `pidetelo`.`det_ciudad_negocio`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pidetelo`.`det_ciudad_negocio` (
  `cod_ciud` INT(3) NOT NULL ,
  `cod_neg` INT(11) NOT NULL ,
  INDEX `fk_det_ciudad_negicio_ciudad1` (`cod_ciud` ASC) ,
  INDEX `fk_det_ciudad_negicio_negocio1` (`cod_neg` ASC) ,
  CONSTRAINT `fk_det_ciudad_negicio_ciudad1`
    FOREIGN KEY (`cod_ciud` )
    REFERENCES `pidetelo`.`ciudad` (`cod_ciud` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_det_ciudad_negicio_negocio1`
    FOREIGN KEY (`cod_neg` )
    REFERENCES `pidetelo`.`negocio` (`cod_neg` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;


-- -----------------------------------------------------
-- Table `pidetelo`.`usuario`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pidetelo`.`usuario` (
  `cod_user` INT(11) NOT NULL AUTO_INCREMENT ,
  `cedula` VARCHAR(12) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_spanish_ci' NOT NULL ,
  `nom_user` VARCHAR(25) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_spanish_ci' NOT NULL ,
  `ape_user` VARCHAR(25) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_spanish_ci' NOT NULL ,
  `tel_user` VARCHAR(11) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_spanish_ci' NOT NULL ,
  `email_user` VARCHAR(45) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_spanish_ci' NOT NULL ,
  `pas_user` VARCHAR(100) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_spanish_ci' NOT NULL ,
  `nivel` INT(2) NOT NULL DEFAULT '2' ,
  `estado_user` VARCHAR(14) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_spanish_ci' NOT NULL DEFAULT 'no_activo' ,
  `cod_val` VARCHAR(45) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_spanish_ci' NOT NULL ,
  `fecha_reg` DATE NOT NULL ,
  `direccion` VARCHAR(100) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_spanish_ci' NOT NULL DEFAULT 'sin dirección de domicilio' ,
  `descrip_user` VARCHAR(45) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_spanish_ci' NOT NULL DEFAULT 'usuario no activo' ,
  `t_t_n_n` CHAR(2) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_spanish_ci' NOT NULL DEFAULT 'N' ,
  PRIMARY KEY (`cod_user`) )
ENGINE = InnoDB
AUTO_INCREMENT = 1;


-- -----------------------------------------------------
-- Table `pidetelo`.`det_ciudad_usuario`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pidetelo`.`det_ciudad_usuario` (
  `cod_ciud` INT(3) NOT NULL ,
  `cod_neg` INT(11) NOT NULL ,
  INDEX `fk_det_ciudad_ciudad1` (`cod_ciud` ASC) ,
  INDEX `fk_det_ciudad_usuario1` (`cod_neg` ASC) ,
  CONSTRAINT `fk_det_ciudad_ciudad1`
    FOREIGN KEY (`cod_ciud` )
    REFERENCES `pidetelo`.`ciudad` (`cod_ciud` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_det_ciudad_usuario1`
    FOREIGN KEY (`cod_neg` )
    REFERENCES `pidetelo`.`usuario` (`cod_user` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;


-- -----------------------------------------------------
-- Table `pidetelo`.`det_negocio_usuario`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pidetelo`.`det_negocio_usuario` (
  `cod_user` INT(11) NOT NULL ,
  `cod_neg` INT(11) NOT NULL ,
  INDEX `fk_det_negocio_usuario_usuario1` (`cod_user` ASC) ,
  INDEX `fk_det_negocio_usuario_negocio1` (`cod_neg` ASC) ,
  CONSTRAINT `fk_det_negocio_usuario_negocio1`
    FOREIGN KEY (`cod_neg` )
    REFERENCES `pidetelo`.`negocio` (`cod_neg` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_det_negocio_usuario_usuario1`
    FOREIGN KEY (`cod_user` )
    REFERENCES `pidetelo`.`usuario` (`cod_user` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;


-- -----------------------------------------------------
-- Table `pidetelo`.`repartidor`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pidetelo`.`repartidor` (
  `cod_repar` INT(11) NOT NULL AUTO_INCREMENT ,
  `nom_repar` VARCHAR(45) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_spanish_ci' NOT NULL ,
  `ape_repar` VARCHAR(45) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_spanish_ci' NOT NULL ,
  `tel_repar` VARCHAR(20) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_spanish_ci' NOT NULL ,
  `tipo_veiculo` VARCHAR(200) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_spanish_ci' NOT NULL ,
  PRIMARY KEY (`cod_repar`) )
ENGINE = InnoDB
AUTO_INCREMENT = 1;


-- -----------------------------------------------------
-- Table `pidetelo`.`pedido`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pidetelo`.`pedido` (
  `cod_ped` INT(11) NOT NULL AUTO_INCREMENT ,
  `tipo_entrega` VARCHAR(20) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL ,
  `estado_ped` VARCHAR(20) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL DEFAULT 'pendiente' ,
  `fecha_ped` DATETIME NOT NULL ,
  `fecha_confir` DATE NULL DEFAULT NULL ,
  `num_confir` VARCHAR(20) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NULL DEFAULT NULL COMMENT 'numero de confirmacion de pago' ,
  `cod_ban` INT(3) NULL DEFAULT NULL ,
  `cod_user` INT(11) NOT NULL ,
  `cod_repar` INT(11) NULL DEFAULT NULL ,
  PRIMARY KEY (`cod_ped`) ,
  INDEX `fk_pedidos_usuario1` (`cod_user` ASC) ,
  INDEX `fk_pedido_banco1` (`cod_ban` ASC) ,
  INDEX `cod_repar` (`cod_repar` ASC) ,
  CONSTRAINT `fk_pedido_banco1`
    FOREIGN KEY (`cod_ban` )
    REFERENCES `pidetelo`.`banco` (`cod_ban` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_pedidos_usuario1`
    FOREIGN KEY (`cod_user` )
    REFERENCES `pidetelo`.`usuario` (`cod_user` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_repart`
    FOREIGN KEY (`cod_repar` )
    REFERENCES `pidetelo`.`repartidor` (`cod_repar` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;


-- -----------------------------------------------------
-- Table `pidetelo`.`producto`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pidetelo`.`producto` (
  `cod_pro` INT(11) NOT NULL AUTO_INCREMENT ,
  `nom_pro` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL ,
  `descrip_pro` TEXT CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL ,
  `tiempo_pro` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL ,
  `visi_pro` INT(9) NULL DEFAULT '0' COMMENT 'cantidad de visitas para calcular un rankin' ,
  `cod_cate` INT(11) NOT NULL ,
  `logo_ful_pro` VARCHAR(40) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL ,
  `logo_min_pro` VARCHAR(40) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL ,
  PRIMARY KEY (`cod_pro`) ,
  INDEX `fk_producto_categoria1` (`cod_cate` ASC) ,
  CONSTRAINT `fk_producto_categoria1`
    FOREIGN KEY (`cod_cate` )
    REFERENCES `pidetelo`.`categoria` (`cod_cate` )
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci
COMMENT = 'aca se alojara todos los productos que ofrecen nuestros soci' ;


-- -----------------------------------------------------
-- Table `pidetelo`.`det_prod_negocio`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pidetelo`.`det_prod_negocio` (
  `id_tama` INT(7) NOT NULL AUTO_INCREMENT ,
  `tama_pro` VARCHAR(45) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_spanish_ci' NOT NULL ,
  `precio_pro` DOUBLE NOT NULL ,
  `estado_pro` VARCHAR(20) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_spanish_ci' NOT NULL ,
  `cod_neg` INT(11) NOT NULL ,
  `cod_pro` INT(11) NOT NULL ,
  PRIMARY KEY (`id_tama`) ,
  INDEX `fk_det_prod_negocio_negocio1` (`cod_neg` ASC) ,
  INDEX `fk_det_prod_negocio_producto1` (`cod_pro` ASC) ,
  CONSTRAINT `fk_det_prod_negocio_negocio1`
    FOREIGN KEY (`cod_neg` )
    REFERENCES `pidetelo`.`negocio` (`cod_neg` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_det_prod_negocio_producto1`
    FOREIGN KEY (`cod_pro` )
    REFERENCES `pidetelo`.`producto` (`cod_pro` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1;


-- -----------------------------------------------------
-- Table `pidetelo`.`det_pedido_prod`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pidetelo`.`det_pedido_prod` (
  `id_dt_p` INT(7) NOT NULL AUTO_INCREMENT ,
  `cantidad` INT(7) NOT NULL ,
  `cod_ped` INT(11) NOT NULL ,
  `cod_pro` INT(7) NOT NULL COMMENT 'esta relacionado con det_prod_negocio' ,
  `cod_neg` INT(11) NOT NULL ,
  PRIMARY KEY (`id_dt_p`) ,
  INDEX `fk_det_pedido_prod_pedido1` (`cod_ped` ASC) ,
  INDEX `fk_det_pedido_prod_producto1` (`cod_pro` ASC) ,
  INDEX `fk_det_pedido_prod_negocio1` (`cod_neg` ASC) ,
  CONSTRAINT `fk_det_pedido_prod_negocio1`
    FOREIGN KEY (`cod_neg` )
    REFERENCES `pidetelo`.`negocio` (`cod_neg` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_det_pedido_prod_pedido1`
    FOREIGN KEY (`cod_ped` )
    REFERENCES `pidetelo`.`pedido` (`cod_ped` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_det_pedido_prod_producto1`
    FOREIGN KEY (`cod_pro` )
    REFERENCES `pidetelo`.`det_prod_negocio` (`id_tama` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 1;


-- -----------------------------------------------------
-- Table `pidetelo`.`det_prod_cont`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pidetelo`.`det_prod_cont` (
  `cod_pro` INT(11) NOT NULL ,
  `cod_con` INT(11) NOT NULL ,
  INDEX `fk_det_prod_cont_producto1` (`cod_pro` ASC) ,
  INDEX `fk_det_prod_cont_contorno1` (`cod_con` ASC) ,
  CONSTRAINT `fk_det_prod_cont_contorno1`
    FOREIGN KEY (`cod_con` )
    REFERENCES `pidetelo`.`contorno` (`cod_con` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto`
    FOREIGN KEY (`cod_pro` )
    REFERENCES `pidetelo`.`producto` (`cod_pro` ))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_spanish_ci;


-- -----------------------------------------------------
-- Table `pidetelo`.`sub_producto`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pidetelo`.`sub_producto` (
  `cod_subp` INT(11) NOT NULL AUTO_INCREMENT ,
  `nom_subp` VARCHAR(45) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_spanish_ci' NOT NULL ,
  `presen_subp` VARCHAR(20) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_spanish_ci' NOT NULL ,
  `precio_subp` VARCHAR(20) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_spanish_ci' NOT NULL ,
  `estado_subp` VARCHAR(20) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_spanish_ci' NOT NULL DEFAULT 'agotado' ,
  `logo_ful_subp` VARCHAR(40) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_spanish_ci' NOT NULL ,
  `logo_min_subp` VARCHAR(40) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_spanish_ci' NOT NULL ,
  PRIMARY KEY (`cod_subp`) )
ENGINE = InnoDB
AUTO_INCREMENT = 1;


-- -----------------------------------------------------
-- Table `pidetelo`.`det_subp_negocio`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pidetelo`.`det_subp_negocio` (
  `cod_subp` INT(11) NOT NULL ,
  `cod_neg` INT(11) NOT NULL ,
  INDEX `fk_det_subp_negocio_sub_producto1` (`cod_subp` ASC) ,
  INDEX `fk_det_subp_negocio_negocio1` (`cod_neg` ASC) ,
  CONSTRAINT `fk_det_subp_negocio_negocio1`
    FOREIGN KEY (`cod_neg` )
    REFERENCES `pidetelo`.`negocio` (`cod_neg` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_det_subp_negocio_sub_producto1`
    FOREIGN KEY (`cod_subp` )
    REFERENCES `pidetelo`.`sub_producto` (`cod_subp` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_spanish_ci;


-- -----------------------------------------------------
-- Table `pidetelo`.`det_subp_pedido`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pidetelo`.`det_subp_pedido` (
  `cant_sub` INT(7) NOT NULL ,
  `cod_subp` INT(11) NOT NULL ,
  `cod_ped` INT(11) NOT NULL ,
  `cod_neg` INT(11) NOT NULL ,
  INDEX `fk_det_subp_pedido_sub_producto1` (`cod_subp` ASC) ,
  INDEX `fk_det_subp_pedido_pedido1` (`cod_ped` ASC) ,
  INDEX `fk_det_subp_pedido_negocio1` (`cod_neg` ASC) ,
  CONSTRAINT `fk_det_subp_pedido_negocio1`
    FOREIGN KEY (`cod_neg` )
    REFERENCES `pidetelo`.`negocio` (`cod_neg` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_det_subp_pedido_pedido1`
    FOREIGN KEY (`cod_ped` )
    REFERENCES `pidetelo`.`pedido` (`cod_ped` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_det_subp_pedido_sub_producto1`
    FOREIGN KEY (`cod_subp` )
    REFERENCES `pidetelo`.`sub_producto` (`cod_subp` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_spanish_ci;


-- -----------------------------------------------------
-- Table `pidetelo`.`pago_negocio`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pidetelo`.`pago_negocio` (
  `cod_pag` INT(11) NOT NULL AUTO_INCREMENT ,
  `fecha_pag` DATE NOT NULL ,
  `cod_ban` INT(3) NOT NULL ,
  `num_pag` VARCHAR(45) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_spanish_ci' NOT NULL COMMENT 'numero de confirmacion' ,
  `monto_pag` DOUBLE NOT NULL ,
  `cod_neg` INT(11) NOT NULL ,
  PRIMARY KEY (`cod_pag`) ,
  INDEX `cod_ban` (`cod_ban` ASC) ,
  INDEX `cod_neg` (`cod_neg` ASC) ,
  CONSTRAINT `pago_negocio_ibfk_1`
    FOREIGN KEY (`cod_ban` )
    REFERENCES `pidetelo`.`banco` (`cod_ban` )
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `pago_negocio_ibfk_2`
    FOREIGN KEY (`cod_neg` )
    REFERENCES `pidetelo`.`negocio` (`cod_neg` )
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB
AUTO_INCREMENT = 1;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
