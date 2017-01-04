/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50713
Source Host           : 127.0.0.1:3306
Source Database       : recabarius

Target Server Type    : MYSQL
Target Server Version : 50713
File Encoding         : 65001

Date: 2017-01-02 16:02:38
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for comite_cargo
-- ----------------------------
DROP TABLE IF EXISTS `comite_cargo`;
CREATE TABLE `comite_cargo` (
  `idcargo` int(11) NOT NULL AUTO_INCREMENT,
  `cargo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idcargo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- ----------------------------
-- Table structure for comuna
-- ----------------------------
DROP TABLE IF EXISTS `comuna`;
CREATE TABLE `comuna` (
  `COMUNA_ID` int(5) NOT NULL DEFAULT '0',
  `COMUNA_NOMBRE` varchar(20) DEFAULT NULL,
  `COMUNA_PROVINCIA_ID` int(3) DEFAULT NULL,
  PRIMARY KEY (`COMUNA_ID`),
  KEY `COMUNA_PROVINCIA_ID` (`COMUNA_PROVINCIA_ID`),
  CONSTRAINT `comuna_ibfk_1` FOREIGN KEY (`COMUNA_PROVINCIA_ID`) REFERENCES `provincia` (`PROVINCIA_ID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for conservador
-- ----------------------------
DROP TABLE IF EXISTS `conservador`;
CREATE TABLE `conservador` (
  `idconservador` int(11) NOT NULL AUTO_INCREMENT,
  `conservador` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idconservador`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- ----------------------------
-- Table structure for cuenta
-- ----------------------------
DROP TABLE IF EXISTS `cuenta`;
CREATE TABLE `cuenta` (
  `ncuenta` varchar(20) NOT NULL,
  `ahorro` decimal(11,0) DEFAULT NULL,
  `subsidio` decimal(11,0) DEFAULT NULL,
  `total` decimal(11,0) DEFAULT NULL,
  `fecha_apertura` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`ncuenta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0 COMMENT='total = ahorro+subsidio';

-- ----------------------------
-- Table structure for cuenta_persona
-- ----------------------------
DROP TABLE IF EXISTS `cuenta_persona`;
CREATE TABLE `cuenta_persona` (
  `idcuenta` int(11) NOT NULL AUTO_INCREMENT,
  `ncuenta` varchar(20) DEFAULT NULL,
  `rut_titular` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`idcuenta`),
  KEY `rut_titular` (`rut_titular`),
  KEY `ncuenta` (`ncuenta`),
  CONSTRAINT `cuenta_persona_fk1` FOREIGN KEY (`ncuenta`) REFERENCES `cuenta` (`ncuenta`),
  CONSTRAINT `cuenta_persona_fk2` FOREIGN KEY (`rut_titular`) REFERENCES `persona` (`rut`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- ----------------------------
-- Table structure for deficit_habitacional
-- ----------------------------
DROP TABLE IF EXISTS `deficit_habitacional`;
CREATE TABLE `deficit_habitacional` (
  `iddeficit` int(11) NOT NULL AUTO_INCREMENT,
  `deficit` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`iddeficit`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- ----------------------------
-- Table structure for direccion
-- ----------------------------
DROP TABLE IF EXISTS `direccion`;
CREATE TABLE `direccion` (
  `iddireccion` int(11) NOT NULL AUTO_INCREMENT,
  `calle` varchar(50) DEFAULT NULL,
  `numero` int(5) DEFAULT NULL,
  `idcomuna` int(5) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT '1',
  `rutpersona` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`iddireccion`),
  KEY `rutpersona` (`rutpersona`),
  KEY `idcomuna` (`idcomuna`),
  CONSTRAINT `direccion_fk1` FOREIGN KEY (`rutpersona`) REFERENCES `persona` (`rut`),
  CONSTRAINT `direccion_fk2` FOREIGN KEY (`idcomuna`) REFERENCES `comuna` (`COMUNA_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- ----------------------------
-- Table structure for ds10
-- ----------------------------
DROP TABLE IF EXISTS `ds10`;
CREATE TABLE `ds10` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- ----------------------------
-- Table structure for egis
-- ----------------------------
DROP TABLE IF EXISTS `egis`;
CREATE TABLE `egis` (
  `idegis` int(11) NOT NULL AUTO_INCREMENT,
  `rut` varchar(12) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `fono` int(15) DEFAULT NULL,
  `correo` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idegis`),
  UNIQUE KEY `rut` (`rut`),
  KEY `tipoegis` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- ----------------------------
-- Table structure for estado_civil
-- ----------------------------
DROP TABLE IF EXISTS `estado_civil`;
CREATE TABLE `estado_civil` (
  `idestadocivil` int(11) NOT NULL,
  `estado` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idestadocivil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- ----------------------------
-- Table structure for factores_carencia
-- ----------------------------
DROP TABLE IF EXISTS `factores_carencia`;
CREATE TABLE `factores_carencia` (
  `idfactor` int(11) NOT NULL AUTO_INCREMENT,
  `factor` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idfactor`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- ----------------------------
-- Table structure for ficha_factores
-- ----------------------------
DROP TABLE IF EXISTS `ficha_factores`;
CREATE TABLE `ficha_factores` (
  `idficha_factores` int(11) NOT NULL AUTO_INCREMENT,
  `nficha` int(7) DEFAULT NULL,
  `factor` int(11) DEFAULT NULL,
  `valor` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idficha_factores`),
  KEY `nficha` (`nficha`),
  KEY `factor` (`factor`),
  CONSTRAINT `ficha_factores_fk1` FOREIGN KEY (`nficha`) REFERENCES `frh` (`nficha`),
  CONSTRAINT `ficha_factores_fk2` FOREIGN KEY (`factor`) REFERENCES `factores_carencia` (`idfactor`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- ----------------------------
-- Table structure for fono
-- ----------------------------
DROP TABLE IF EXISTS `fono`;
CREATE TABLE `fono` (
  `idfono` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(15) DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT '1',
  `rutpersona` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`idfono`),
  UNIQUE KEY `idfono` (`idfono`),
  KEY `rutpersona` (`rutpersona`),
  KEY `tipo` (`tipo`),
  CONSTRAINT `fono_fk2` FOREIGN KEY (`tipo`) REFERENCES `tipofono` (`idtipo`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- ----------------------------
-- Table structure for frh
-- ----------------------------
DROP TABLE IF EXISTS `frh`;
CREATE TABLE `frh` (
  `nficha` int(7) NOT NULL AUTO_INCREMENT,
  `tramo` int(11) DEFAULT NULL,
  `puntaje` decimal(11,0) DEFAULT NULL,
  `nucleo_familiar` decimal(11,0) DEFAULT NULL,
  `deficit` int(11) DEFAULT NULL,
  `fecha_nacimiento` bigint(20) DEFAULT NULL,
  `idestadocivil` int(11) DEFAULT NULL,
  `adultomayor` tinyint(1) DEFAULT NULL,
  `discapacidad` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`nficha`),
  KEY `idestadocivil` (`idestadocivil`),
  KEY `tramo` (`tramo`),
  KEY `deficit` (`deficit`),
  CONSTRAINT `frh_fk1` FOREIGN KEY (`idestadocivil`) REFERENCES `estado_civil` (`idestadocivil`),
  CONSTRAINT `frh_fk2` FOREIGN KEY (`tramo`) REFERENCES `tramo` (`idtramo`),
  CONSTRAINT `frh_fk3` FOREIGN KEY (`deficit`) REFERENCES `deficit_habitacional` (`iddeficit`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 PACK_KEYS=0 COMMENT='Ficha de Recepcion de Hogares.';

-- ----------------------------
-- Table structure for grupo
-- ----------------------------
DROP TABLE IF EXISTS `grupo`;
CREATE TABLE `grupo` (
  `idgrupo` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(11) DEFAULT NULL,
  `fecha` bigint(20) DEFAULT NULL,
  `personalidad` varchar(50) DEFAULT NULL,
  `nombre` varchar(120) DEFAULT NULL,
  `direccion` varchar(120) DEFAULT NULL,
  `idcomuna` int(5) DEFAULT NULL,
  `idegis` int(11) DEFAULT NULL,
  PRIMARY KEY (`idgrupo`),
  UNIQUE KEY `numero` (`numero`),
  KEY `idegis` (`idegis`),
  KEY `idcomuna` (`idcomuna`),
  CONSTRAINT `grupo_fk1` FOREIGN KEY (`idegis`) REFERENCES `egis` (`idegis`),
  CONSTRAINT `grupo_fk2` FOREIGN KEY (`idcomuna`) REFERENCES `comuna` (`COMUNA_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- ----------------------------
-- Table structure for item_postulacion
-- ----------------------------
DROP TABLE IF EXISTS `item_postulacion`;
CREATE TABLE `item_postulacion` (
  `iditem` int(11) NOT NULL AUTO_INCREMENT,
  `item` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`iditem`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- ----------------------------
-- Table structure for mts
-- ----------------------------
DROP TABLE IF EXISTS `mts`;
CREATE TABLE `mts` (
  `idmts` int(11) NOT NULL AUTO_INCREMENT,
  `rol` varchar(20) DEFAULT NULL,
  `idpiso` int(11) DEFAULT NULL,
  `metros` decimal(11,0) DEFAULT '0',
  PRIMARY KEY (`idmts`),
  KEY `idpiso` (`idpiso`),
  KEY `rol` (`rol`),
  CONSTRAINT `mts_fk1` FOREIGN KEY (`rol`) REFERENCES `vivienda` (`rol`),
  CONSTRAINT `mts_fk2` FOREIGN KEY (`idpiso`) REFERENCES `piso` (`idpiso`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- ----------------------------
-- Table structure for perfil
-- ----------------------------
DROP TABLE IF EXISTS `perfil`;
CREATE TABLE `perfil` (
  `idperfil` int(11) NOT NULL AUTO_INCREMENT,
  `perfil` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idperfil`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- ----------------------------
-- Table structure for persona
-- ----------------------------
DROP TABLE IF EXISTS `persona`;
CREATE TABLE `persona` (
  `rut` varchar(8) NOT NULL,
  `dv` varchar(1) DEFAULT NULL,
  `nombres` varchar(50) DEFAULT NULL,
  `paterno` varchar(50) DEFAULT NULL,
  `materno` varchar(50) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`rut`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- ----------------------------
-- Table structure for persona_comite
-- ----------------------------
DROP TABLE IF EXISTS `persona_comite`;
CREATE TABLE `persona_comite` (
  `idpersona_comite` int(11) NOT NULL AUTO_INCREMENT,
  `rutpersona` varchar(8) DEFAULT NULL,
  `idgrupo` int(11) DEFAULT NULL,
  `idcargo` int(11) DEFAULT NULL,
  PRIMARY KEY (`idpersona_comite`),
  KEY `rutpersona` (`rutpersona`),
  KEY `idgrupo` (`idgrupo`),
  KEY `idcargo` (`idcargo`),
  CONSTRAINT `persona_comite_fk1` FOREIGN KEY (`rutpersona`) REFERENCES `persona` (`rut`),
  CONSTRAINT `persona_comite_fk2` FOREIGN KEY (`idgrupo`) REFERENCES `grupo` (`idgrupo`),
  CONSTRAINT `persona_comite_fk3` FOREIGN KEY (`idcargo`) REFERENCES `comite_cargo` (`idcargo`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- ----------------------------
-- Table structure for persona_ficha
-- ----------------------------
DROP TABLE IF EXISTS `persona_ficha`;
CREATE TABLE `persona_ficha` (
  `idpersona_ficha` int(11) NOT NULL AUTO_INCREMENT,
  `nficha` int(7) DEFAULT NULL,
  `rutpersona` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`idpersona_ficha`),
  KEY `rutpersona` (`rutpersona`),
  KEY `nficha` (`nficha`,`rutpersona`),
  KEY `nficha_2` (`nficha`),
  CONSTRAINT `persona_ficha_fk1` FOREIGN KEY (`rutpersona`) REFERENCES `persona` (`rut`),
  CONSTRAINT `persona_ficha_fk2` FOREIGN KEY (`nficha`) REFERENCES `frh` (`nficha`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- ----------------------------
-- Table structure for persona_vivienda
-- ----------------------------
DROP TABLE IF EXISTS `persona_vivienda`;
CREATE TABLE `persona_vivienda` (
  `idpersona_vivienda` int(11) NOT NULL AUTO_INCREMENT,
  `rol` varchar(20) DEFAULT NULL,
  `rut` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`idpersona_vivienda`),
  KEY `rut` (`rut`),
  KEY `rol` (`rol`),
  CONSTRAINT `persona_vivienda_fk1` FOREIGN KEY (`rut`) REFERENCES `persona` (`rut`),
  CONSTRAINT `persona_vivienda_fk2` FOREIGN KEY (`rol`) REFERENCES `vivienda` (`rol`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- ----------------------------
-- Table structure for piso
-- ----------------------------
DROP TABLE IF EXISTS `piso`;
CREATE TABLE `piso` (
  `idpiso` int(11) NOT NULL,
  `piso` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idpiso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- ----------------------------
-- Table structure for postulaciones
-- ----------------------------
DROP TABLE IF EXISTS `postulaciones`;
CREATE TABLE `postulaciones` (
  `idpostulacion` int(11) NOT NULL AUTO_INCREMENT,
  `idgrupo` int(11) DEFAULT NULL,
  `iditem` int(11) DEFAULT NULL,
  `idds10` int(11) DEFAULT NULL,
  PRIMARY KEY (`idpostulacion`),
  KEY `idgrupo` (`idgrupo`),
  KEY `iditem` (`iditem`),
  KEY `idds10` (`idds10`),
  CONSTRAINT `postulaciones_fk1` FOREIGN KEY (`idgrupo`) REFERENCES `grupo` (`idgrupo`),
  CONSTRAINT `postulaciones_fk2` FOREIGN KEY (`iditem`) REFERENCES `item_postulacion` (`iditem`),
  CONSTRAINT `postulaciones_fk3` FOREIGN KEY (`idds10`) REFERENCES `ds10` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- ----------------------------
-- Table structure for profesionales
-- ----------------------------
DROP TABLE IF EXISTS `profesionales`;
CREATE TABLE `profesionales` (
  `rutprof` varchar(8) NOT NULL,
  `dv` varchar(1) DEFAULT NULL,
  `nombres` varchar(50) DEFAULT NULL,
  `apellidos` varchar(50) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `idcomuna` int(11) DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `cargo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`rutprof`),
  KEY `idcomuna` (`idcomuna`),
  CONSTRAINT `profesionales_fk1` FOREIGN KEY (`idcomuna`) REFERENCES `comuna` (`COMUNA_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- ----------------------------
-- Table structure for provincia
-- ----------------------------
DROP TABLE IF EXISTS `provincia`;
CREATE TABLE `provincia` (
  `PROVINCIA_ID` int(3) NOT NULL DEFAULT '0',
  `PROVINCIA_NOMBRE` varchar(23) DEFAULT NULL,
  `PROVINCIA_REGION_ID` int(2) DEFAULT NULL,
  PRIMARY KEY (`PROVINCIA_ID`),
  KEY `PROVINCIA_REGION_ID` (`PROVINCIA_REGION_ID`),
  CONSTRAINT `provincia_ibfk_1` FOREIGN KEY (`PROVINCIA_REGION_ID`) REFERENCES `region` (`REGION_ID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for region
-- ----------------------------
DROP TABLE IF EXISTS `region`;
CREATE TABLE `region` (
  `REGION_ID` int(2) NOT NULL DEFAULT '0',
  `REGION_NOMBRE` varchar(50) DEFAULT NULL,
  `ISO_3166_2_CL` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`REGION_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tipofono
-- ----------------------------
DROP TABLE IF EXISTS `tipofono`;
CREATE TABLE `tipofono` (
  `idtipo` int(11) NOT NULL,
  `tipo` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idtipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- ----------------------------
-- Table structure for tipo_vivienda
-- ----------------------------
DROP TABLE IF EXISTS `tipo_vivienda`;
CREATE TABLE `tipo_vivienda` (
  `idtipovivienda` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idtipovivienda`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- ----------------------------
-- Table structure for tramo
-- ----------------------------
DROP TABLE IF EXISTS `tramo`;
CREATE TABLE `tramo` (
  `idtramo` int(11) NOT NULL AUTO_INCREMENT,
  `tramo` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idtramo`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `idusuario` varchar(12) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellidos` varchar(20) DEFAULT NULL,
  `clave` varchar(20) DEFAULT NULL,
  `perfil` int(11) DEFAULT NULL,
  PRIMARY KEY (`idusuario`),
  KEY `perfil` (`perfil`),
  CONSTRAINT `usuarios_fk1` FOREIGN KEY (`perfil`) REFERENCES `perfil` (`idperfil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- ----------------------------
-- Table structure for vivienda
-- ----------------------------
DROP TABLE IF EXISTS `vivienda`;
CREATE TABLE `vivienda` (
  `rol` varchar(20) NOT NULL,
  `anio_recepcion` bigint(20) DEFAULT NULL,
  `fojas` varchar(20) DEFAULT NULL,
  `anio` bigint(20) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `conservador` int(11) DEFAULT NULL,
  `tipo` int(11) DEFAULT '1',
  `superficie` decimal(11,0) DEFAULT NULL,
  PRIMARY KEY (`rol`),
  KEY `tipo` (`tipo`),
  KEY `vivienda_fk2` (`conservador`),
  CONSTRAINT `vivienda_fk1` FOREIGN KEY (`tipo`) REFERENCES `tipo_vivienda` (`idtipovivienda`),
  CONSTRAINT `vivienda_fk2` FOREIGN KEY (`conservador`) REFERENCES `conservador` (`idconservador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0;
