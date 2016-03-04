CREATE TABLE `formulacion_cb`.`Especie` (
  `idEspecie` INT NOT NULL AUTO_INCREMENT,
  `Especie` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`idEspecie`))
ENGINE = InnoDB;

CREATE TABLE `formulacion_cb`.`Subespecie` (
  `idSubespecie` INT NOT NULL AUTO_INCREMENT,
  `Subespecie` VARCHAR(100) NOT NULL,
  `idEspecie` INT NOT NULL,
  PRIMARY KEY (`idSubespecie`),
  INDEX `idEspecie_idx` (`idEspecie` ASC),
  CONSTRAINT `idEspecie`
    FOREIGN KEY (`idEspecie`)
    REFERENCES `formulacion_cb`.`Especie` (`idEspecie`)
    ON DELETE RESTRICT
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE `formulacion_cb`.`Ingrediente` (
  `idIngrediente` INT NOT NULL AUTO_INCREMENT,
  `Ingrediente` VARCHAR(50) NOT NULL,
  `Clasificacion` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`idIngrediente`))
ENGINE = InnoDB;

CREATE TABLE `formulacion_cb`.`Etapa` (
  `idEtapa` INT NOT NULL AUTO_INCREMENT,
  `Etapa` VARCHAR(50) NOT NULL,
  `idSubespecie` INT NOT NULL,
  PRIMARY KEY (`idEtapa`),
  INDEX `idSubespecie_idx` (`idSubespecie` ASC),
  CONSTRAINT `idSubespecie`
    FOREIGN KEY (`idSubespecie`)
    REFERENCES `formulacion_cb`.`Subespecie` (`idSubespecie`)
    ON DELETE RESTRICT
    ON UPDATE NO ACTION);

CREATE TABLE `formulacion_cb`.`Detalle_Etapa` (
  `idDetalle_Etapa` INT NOT NULL AUTO_INCREMENT,
  `Descripcion` VARCHAR(100) NOT NULL,
  `idEtapa` INT NOT NULL,
  PRIMARY KEY (`idDetalle_Etapa`),
  INDEX `idEtapa_idx` (`idEtapa` ASC),
  CONSTRAINT `idEtapa`
    FOREIGN KEY (`idEtapa`)
    REFERENCES `formulacion_cb`.`Etapa` (`idEtapa`)
    ON DELETE RESTRICT
    ON UPDATE NO ACTION);
ALTER TABLE `formulacion_cb`.`Ingrediente` 
ADD COLUMN `Status` INT NOT NULL AFTER `idEspecie`;
ALTER TABLE `formulacion_cb`.`Ingrediente` 
CHANGE COLUMN `Status` `Status` INT(11) NOT NULL DEFAULT 1 ;

CREATE TABLE `formulacion_cb`.`Producto` (
  `idProducto` INT NOT NULL AUTO_INCREMENT,
  `Producto` VARCHAR(60) NOT NULL,
  `Descripcion` VARCHAR(100) NOT NULL,
  `idEtapa` INT NOT NULL,
  `Status` INT NOT NULL DEFAULT 1,
  PRIMARY KEY (`idProducto`),
  INDEX `idEtapa_idx` (`idEtapa` ASC),
  CONSTRAINT `idEtapa`
    FOREIGN KEY (`idEtapa`)
    REFERENCES `formulacion_cb`.`Etapa` (`idEtapa`)
    ON DELETE RESTRICT
    ON UPDATE NO ACTION);
CREATE TABLE `formulacion_cb`.`Especificacion` (
  `idEspecificacion` INT NOT NULL AUTO_INCREMENT,
  `Especificacion` FLOAT NOT NULL,
  `idIngrediente` INT NOT NULL,
  PRIMARY KEY (`idEspecificacion`),
  INDEX `idIngrediente_idx` (`idIngrediente` ASC),
  CONSTRAINT `idIngrediente`
    FOREIGN KEY (`idIngrediente`)
    REFERENCES `formulacion_cb`.`Ingrediente` (`idIngrediente`)
    ON DELETE RESTRICT
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;
CREATE TABLE `formulacion_cb`.`Tipo_Ganado` (
  `idTipo_Ganado` INT NOT NULL AUTO_INCREMENT,
  `TipoGanado` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`idTipo_Ganado`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;
CREATE TABLE `formulacion_cb`.`Tipo_Mezclado` (
  `idTipo_Mezclado` INT NOT NULL AUTO_INCREMENT,
  `TipoMezclado` VARCHAR(50) NOT NULL,
  `Status` BIT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idTipo_Mezclado`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;
ALTER TABLE `formulacion_cb`.`Tipo_Ganado` 
DROP COLUMN `idSubespecie`,
CHANGE COLUMN `idTipo_Ganado` `idTipo_Ganado` INT(11) NOT NULL ,
ADD COLUMN `idEtapa` INT NOT NULL AFTER `TipoGanado`,
ADD INDEX `idEtapa_idx` (`idEtapa` ASC),
DROP INDEX `idSubespecie_idx` ;
ALTER TABLE `formulacion_cb`.`Tipo_Ganado` 
ADD CONSTRAINT `idEtapa`
  FOREIGN KEY (`idEtapa`)
  REFERENCES `formulacion_cb`.`Etapa` (`idEtapa`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
CREATE TABLE `formulacion_cb`.`Fase` (
  `idFase` INT NOT NULL AUTO_INCREMENT,
  `Fase` VARCHAR(50) NOT NULL,
  `idSubespecie` INT NOT NULL,
  PRIMARY KEY (`idFase`),
  INDEX `idSubespecie_idx` (`idSubespecie` ASC),
  CONSTRAINT `idSubespecie`
    FOREIGN KEY (`idSubespecie`)
    REFERENCES `formulacion_cb`.`Subespecie` (`idSubespecie`)
    ON DELETE RESTRICT
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;
CREATE TABLE `formulacion_cb`.`Solicitud` (
  `idSolicitud` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `Fecha` DATE NOT NULL COMMENT '',
  `Solicitante` VARCHAR(100) NOT NULL COMMENT '',
  `Tipo_Cliente` VARCHAR(15) NOT NULL COMMENT '',
  `Nombre_Cliente` VARCHAR(100) NOT NULL COMMENT '',
  `Telefono` VARCHAR(15) NULL COMMENT '',
  `NoCabezas` INT NOT NULL COMMENT '',
  `Tipo_Ganado` VARCHAR(20) NULL COMMENT '',
  `Alimentacion` VARCHAR(20) NULL COMMENT '',
  `Produccion` VARCHAR(20) NULL COMMENT '',
  `Secas` VARCHAR(20) NULL COMMENT '',
  `Reemplazos` VARCHAR(20) NULL COMMENT '',
  `Implante` VARCHAR(45) NULL COMMENT '',
  `Desparasitante` VARCHAR(45) NULL COMMENT '',
  `Vacuna` VARCHAR(45) NULL COMMENT '',
  `ProduccionLeche` FLOAT NULL COMMENT '',
  `PorcentajeGrasa` FLOAT NULL COMMENT '',
  `TipoMezclado` VARCHAR(30) NOT NULL COMMENT '',
  `Comentario` VARCHAR(500) NULL COMMENT '',
  `idFormulador` INT NOT NULL COMMENT '',
  `Status` BIT(1) NOT NULL DEFAULT 1 COMMENT '',
  PRIMARY KEY (`idSolicitud`)  COMMENT '')
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;