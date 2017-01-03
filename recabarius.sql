/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50713
Source Host           : 127.0.0.1:3306
Source Database       : recabarius

Target Server Type    : MYSQL
Target Server Version : 50713
File Encoding         : 65001

Date: 2016-12-08 14:42:25
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
-- Records of comite_cargo
-- ----------------------------
INSERT INTO `comite_cargo` VALUES ('1', 'miembro');
INSERT INTO `comite_cargo` VALUES ('2', 'presidente');
INSERT INTO `comite_cargo` VALUES ('3', 'secretario');

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
-- Records of comuna
-- ----------------------------
INSERT INTO `comuna` VALUES ('1101', 'Iquique', '11');
INSERT INTO `comuna` VALUES ('1107', 'Alto Hospicio', '11');
INSERT INTO `comuna` VALUES ('1401', 'Pozo Almonte', '14');
INSERT INTO `comuna` VALUES ('1402', 'Camiña', '14');
INSERT INTO `comuna` VALUES ('1403', 'Colchane', '14');
INSERT INTO `comuna` VALUES ('1404', 'Huara', '14');
INSERT INTO `comuna` VALUES ('1405', 'Pica', '14');
INSERT INTO `comuna` VALUES ('2101', 'Antofagasta', '21');
INSERT INTO `comuna` VALUES ('2102', 'Mejillones', '21');
INSERT INTO `comuna` VALUES ('2103', 'Sierra Gorda', '21');
INSERT INTO `comuna` VALUES ('2104', 'Taltal', '21');
INSERT INTO `comuna` VALUES ('2201', 'Calama', '22');
INSERT INTO `comuna` VALUES ('2202', 'Ollagüe', '22');
INSERT INTO `comuna` VALUES ('2203', 'San Pedro de Atacama', '22');
INSERT INTO `comuna` VALUES ('2301', 'Tocopilla', '23');
INSERT INTO `comuna` VALUES ('2302', 'María Elena', '23');
INSERT INTO `comuna` VALUES ('3101', 'Copiapó', '31');
INSERT INTO `comuna` VALUES ('3102', 'Caldera', '31');
INSERT INTO `comuna` VALUES ('3103', 'Tierra Amarilla', '31');
INSERT INTO `comuna` VALUES ('3201', 'Chañaral', '32');
INSERT INTO `comuna` VALUES ('3202', 'Diego de Almagro', '32');
INSERT INTO `comuna` VALUES ('3301', 'Vallenar', '33');
INSERT INTO `comuna` VALUES ('3302', 'Alto del Carmen', '33');
INSERT INTO `comuna` VALUES ('3303', 'Freirina', '33');
INSERT INTO `comuna` VALUES ('3304', 'Huasco', '33');
INSERT INTO `comuna` VALUES ('4101', 'La Serena', '41');
INSERT INTO `comuna` VALUES ('4102', 'Coquimbo', '41');
INSERT INTO `comuna` VALUES ('4103', 'Andacollo', '41');
INSERT INTO `comuna` VALUES ('4104', 'La Higuera', '41');
INSERT INTO `comuna` VALUES ('4105', 'Paihuano', '41');
INSERT INTO `comuna` VALUES ('4106', 'Vicuña', '41');
INSERT INTO `comuna` VALUES ('4201', 'Illapel', '42');
INSERT INTO `comuna` VALUES ('4202', 'Canela', '42');
INSERT INTO `comuna` VALUES ('4203', 'Los Vilos', '42');
INSERT INTO `comuna` VALUES ('4204', 'Salamanca', '42');
INSERT INTO `comuna` VALUES ('4301', 'Ovalle', '43');
INSERT INTO `comuna` VALUES ('4302', 'Combarbalá', '43');
INSERT INTO `comuna` VALUES ('4303', 'Monte Patria', '43');
INSERT INTO `comuna` VALUES ('4304', 'Punitaqui', '43');
INSERT INTO `comuna` VALUES ('4305', 'Río Hurtado', '43');
INSERT INTO `comuna` VALUES ('5101', 'Valparaíso', '51');
INSERT INTO `comuna` VALUES ('5102', 'Casablanca', '51');
INSERT INTO `comuna` VALUES ('5103', 'Concón', '51');
INSERT INTO `comuna` VALUES ('5104', 'Juan Fernández', '51');
INSERT INTO `comuna` VALUES ('5105', 'Puchuncaví', '51');
INSERT INTO `comuna` VALUES ('5107', 'Quintero', '51');
INSERT INTO `comuna` VALUES ('5109', 'Viña del Mar', '51');
INSERT INTO `comuna` VALUES ('5201', 'Isla de Pascua', '52');
INSERT INTO `comuna` VALUES ('5301', 'Los Andes', '53');
INSERT INTO `comuna` VALUES ('5302', 'Calle Larga', '53');
INSERT INTO `comuna` VALUES ('5303', 'Rinconada', '53');
INSERT INTO `comuna` VALUES ('5304', 'San Esteban', '53');
INSERT INTO `comuna` VALUES ('5401', 'La Ligua', '54');
INSERT INTO `comuna` VALUES ('5402', 'Cabildo', '54');
INSERT INTO `comuna` VALUES ('5403', 'Papudo', '54');
INSERT INTO `comuna` VALUES ('5404', 'Petorca', '54');
INSERT INTO `comuna` VALUES ('5405', 'Zapallar', '54');
INSERT INTO `comuna` VALUES ('5501', 'Quillota', '55');
INSERT INTO `comuna` VALUES ('5502', 'La Calera', '55');
INSERT INTO `comuna` VALUES ('5503', 'Hijuelas', '55');
INSERT INTO `comuna` VALUES ('5504', 'La Cruz', '55');
INSERT INTO `comuna` VALUES ('5506', 'Nogales', '55');
INSERT INTO `comuna` VALUES ('5601', 'San Antonio', '56');
INSERT INTO `comuna` VALUES ('5602', 'Algarrobo', '56');
INSERT INTO `comuna` VALUES ('5603', 'Cartagena', '56');
INSERT INTO `comuna` VALUES ('5604', 'El Quisco', '56');
INSERT INTO `comuna` VALUES ('5605', 'El Tabo', '56');
INSERT INTO `comuna` VALUES ('5606', 'Santo Domingo', '56');
INSERT INTO `comuna` VALUES ('5701', 'San Felipe', '57');
INSERT INTO `comuna` VALUES ('5702', 'Catemu', '57');
INSERT INTO `comuna` VALUES ('5703', 'Llay Llay', '57');
INSERT INTO `comuna` VALUES ('5704', 'Panquehue', '57');
INSERT INTO `comuna` VALUES ('5705', 'Putaendo', '57');
INSERT INTO `comuna` VALUES ('5706', 'Santa María', '57');
INSERT INTO `comuna` VALUES ('5801', 'Quilpué', '58');
INSERT INTO `comuna` VALUES ('5802', 'Limache', '58');
INSERT INTO `comuna` VALUES ('5803', 'Olmué', '58');
INSERT INTO `comuna` VALUES ('5804', 'Villa Alemana', '58');
INSERT INTO `comuna` VALUES ('6101', 'Rancagua', '61');
INSERT INTO `comuna` VALUES ('6102', 'Codegua', '61');
INSERT INTO `comuna` VALUES ('6103', 'Coinco', '61');
INSERT INTO `comuna` VALUES ('6104', 'Coltauco', '61');
INSERT INTO `comuna` VALUES ('6105', 'Doñihue', '61');
INSERT INTO `comuna` VALUES ('6106', 'Graneros', '61');
INSERT INTO `comuna` VALUES ('6107', 'Las Cabras', '61');
INSERT INTO `comuna` VALUES ('6108', 'Machalí', '61');
INSERT INTO `comuna` VALUES ('6109', 'Malloa', '61');
INSERT INTO `comuna` VALUES ('6110', 'Mostazal', '61');
INSERT INTO `comuna` VALUES ('6111', 'Olivar', '61');
INSERT INTO `comuna` VALUES ('6112', 'Peumo', '61');
INSERT INTO `comuna` VALUES ('6113', 'Pichidegua', '61');
INSERT INTO `comuna` VALUES ('6114', 'Quinta de Tilcoco', '61');
INSERT INTO `comuna` VALUES ('6115', 'Rengo', '61');
INSERT INTO `comuna` VALUES ('6116', 'Requínoa', '61');
INSERT INTO `comuna` VALUES ('6117', 'San Vicente', '61');
INSERT INTO `comuna` VALUES ('6201', 'Pichilemu', '62');
INSERT INTO `comuna` VALUES ('6202', 'La Estrella', '62');
INSERT INTO `comuna` VALUES ('6203', 'Litueche', '62');
INSERT INTO `comuna` VALUES ('6204', 'Marchihue', '62');
INSERT INTO `comuna` VALUES ('6205', 'Navidad', '62');
INSERT INTO `comuna` VALUES ('6206', 'Paredones', '62');
INSERT INTO `comuna` VALUES ('6301', 'San Fernando', '63');
INSERT INTO `comuna` VALUES ('6302', 'Chépica', '63');
INSERT INTO `comuna` VALUES ('6303', 'Chimbarongo', '63');
INSERT INTO `comuna` VALUES ('6304', 'Lolol', '63');
INSERT INTO `comuna` VALUES ('6305', 'Nancagua', '63');
INSERT INTO `comuna` VALUES ('6306', 'Palmilla', '63');
INSERT INTO `comuna` VALUES ('6307', 'Peralillo', '63');
INSERT INTO `comuna` VALUES ('6308', 'Placilla', '63');
INSERT INTO `comuna` VALUES ('6309', 'Pumanque', '63');
INSERT INTO `comuna` VALUES ('6310', 'Santa Cruz', '63');
INSERT INTO `comuna` VALUES ('7101', 'Talca', '71');
INSERT INTO `comuna` VALUES ('7102', 'Constitución', '71');
INSERT INTO `comuna` VALUES ('7103', 'Curepto', '71');
INSERT INTO `comuna` VALUES ('7104', 'Empedrado', '71');
INSERT INTO `comuna` VALUES ('7105', 'Maule', '71');
INSERT INTO `comuna` VALUES ('7106', 'Pelarco', '71');
INSERT INTO `comuna` VALUES ('7107', 'Pencahue', '71');
INSERT INTO `comuna` VALUES ('7108', 'Río Claro', '71');
INSERT INTO `comuna` VALUES ('7109', 'San Clemente', '71');
INSERT INTO `comuna` VALUES ('7110', 'San Rafael', '71');
INSERT INTO `comuna` VALUES ('7201', 'Cauquenes', '72');
INSERT INTO `comuna` VALUES ('7202', 'Chanco', '72');
INSERT INTO `comuna` VALUES ('7203', 'Pelluhue', '72');
INSERT INTO `comuna` VALUES ('7301', 'Curicó', '73');
INSERT INTO `comuna` VALUES ('7302', 'Hualañé', '73');
INSERT INTO `comuna` VALUES ('7303', 'Licantén', '73');
INSERT INTO `comuna` VALUES ('7304', 'Molina', '73');
INSERT INTO `comuna` VALUES ('7305', 'Rauco', '73');
INSERT INTO `comuna` VALUES ('7306', 'Romeral', '73');
INSERT INTO `comuna` VALUES ('7307', 'Sagrada Familia', '73');
INSERT INTO `comuna` VALUES ('7308', 'Teno', '73');
INSERT INTO `comuna` VALUES ('7309', 'Vichuquén', '73');
INSERT INTO `comuna` VALUES ('7401', 'Linares', '74');
INSERT INTO `comuna` VALUES ('7402', 'Colbún', '74');
INSERT INTO `comuna` VALUES ('7403', 'Longaví', '74');
INSERT INTO `comuna` VALUES ('7404', 'Parral', '74');
INSERT INTO `comuna` VALUES ('7405', 'Retiro', '74');
INSERT INTO `comuna` VALUES ('7406', 'San Javier', '74');
INSERT INTO `comuna` VALUES ('7407', 'Villa Alegre', '74');
INSERT INTO `comuna` VALUES ('7408', 'Yerbas Buenas', '74');
INSERT INTO `comuna` VALUES ('8101', 'Concepción', '81');
INSERT INTO `comuna` VALUES ('8102', 'Coronel', '81');
INSERT INTO `comuna` VALUES ('8103', 'Chiguayante', '81');
INSERT INTO `comuna` VALUES ('8104', 'Florida', '81');
INSERT INTO `comuna` VALUES ('8105', 'Hualqui', '81');
INSERT INTO `comuna` VALUES ('8106', 'Lota', '81');
INSERT INTO `comuna` VALUES ('8107', 'Penco', '81');
INSERT INTO `comuna` VALUES ('8108', 'San Pedro de la Paz', '81');
INSERT INTO `comuna` VALUES ('8109', 'Santa Juana', '81');
INSERT INTO `comuna` VALUES ('8110', 'Talcahuano', '81');
INSERT INTO `comuna` VALUES ('8111', 'Tomé', '81');
INSERT INTO `comuna` VALUES ('8112', 'Hualpén', '81');
INSERT INTO `comuna` VALUES ('8201', 'Lebu', '82');
INSERT INTO `comuna` VALUES ('8202', 'Arauco', '82');
INSERT INTO `comuna` VALUES ('8203', 'Cañete', '82');
INSERT INTO `comuna` VALUES ('8204', 'Contulmo', '82');
INSERT INTO `comuna` VALUES ('8205', 'Curanilahue', '82');
INSERT INTO `comuna` VALUES ('8206', 'Los Álamos', '82');
INSERT INTO `comuna` VALUES ('8207', 'Tirúa', '82');
INSERT INTO `comuna` VALUES ('8301', 'Los Ángeles', '83');
INSERT INTO `comuna` VALUES ('8302', 'Antuco', '83');
INSERT INTO `comuna` VALUES ('8303', 'Cabrero', '83');
INSERT INTO `comuna` VALUES ('8304', 'Laja', '83');
INSERT INTO `comuna` VALUES ('8305', 'Mulchén', '83');
INSERT INTO `comuna` VALUES ('8306', 'Nacimiento', '83');
INSERT INTO `comuna` VALUES ('8307', 'Negrete', '83');
INSERT INTO `comuna` VALUES ('8308', 'Quilaco', '83');
INSERT INTO `comuna` VALUES ('8309', 'Quilleco', '83');
INSERT INTO `comuna` VALUES ('8310', 'San Rosendo', '83');
INSERT INTO `comuna` VALUES ('8311', 'Santa Bárbara', '83');
INSERT INTO `comuna` VALUES ('8312', 'Tucapel', '83');
INSERT INTO `comuna` VALUES ('8313', 'Yumbel', '83');
INSERT INTO `comuna` VALUES ('8314', 'Alto Biobío', '83');
INSERT INTO `comuna` VALUES ('8401', 'Chillán', '84');
INSERT INTO `comuna` VALUES ('8402', 'Bulnes', '84');
INSERT INTO `comuna` VALUES ('8403', 'Cobquecura', '84');
INSERT INTO `comuna` VALUES ('8404', 'Coelemu', '84');
INSERT INTO `comuna` VALUES ('8405', 'Coihueco', '84');
INSERT INTO `comuna` VALUES ('8406', 'Chillán Viejo', '84');
INSERT INTO `comuna` VALUES ('8407', 'El Carmen', '84');
INSERT INTO `comuna` VALUES ('8408', 'Ninhue', '84');
INSERT INTO `comuna` VALUES ('8409', 'Ñiquén', '84');
INSERT INTO `comuna` VALUES ('8410', 'Pemuco', '84');
INSERT INTO `comuna` VALUES ('8411', 'Pinto', '84');
INSERT INTO `comuna` VALUES ('8412', 'Portezuelo', '84');
INSERT INTO `comuna` VALUES ('8413', 'Quillón', '84');
INSERT INTO `comuna` VALUES ('8414', 'Quirihue', '84');
INSERT INTO `comuna` VALUES ('8415', 'Ránquil', '84');
INSERT INTO `comuna` VALUES ('8416', 'San Carlos', '84');
INSERT INTO `comuna` VALUES ('8417', 'San Fabián', '84');
INSERT INTO `comuna` VALUES ('8418', 'San Ignacio', '84');
INSERT INTO `comuna` VALUES ('8419', 'San Nicolás', '84');
INSERT INTO `comuna` VALUES ('8420', 'Treguaco', '84');
INSERT INTO `comuna` VALUES ('8421', 'Yungay', '84');
INSERT INTO `comuna` VALUES ('9101', 'Temuco', '91');
INSERT INTO `comuna` VALUES ('9102', 'Carahue', '91');
INSERT INTO `comuna` VALUES ('9103', 'Cunco', '91');
INSERT INTO `comuna` VALUES ('9104', 'Curarrehue', '91');
INSERT INTO `comuna` VALUES ('9105', 'Freire', '91');
INSERT INTO `comuna` VALUES ('9106', 'Galvarino', '91');
INSERT INTO `comuna` VALUES ('9107', 'Gorbea', '91');
INSERT INTO `comuna` VALUES ('9108', 'Lautaro', '91');
INSERT INTO `comuna` VALUES ('9109', 'Loncoche', '91');
INSERT INTO `comuna` VALUES ('9110', 'Melipeuco', '91');
INSERT INTO `comuna` VALUES ('9111', 'Nueva Imperial', '91');
INSERT INTO `comuna` VALUES ('9112', 'Padre las Casas', '91');
INSERT INTO `comuna` VALUES ('9113', 'Perquenco', '91');
INSERT INTO `comuna` VALUES ('9114', 'Pitrufquén', '91');
INSERT INTO `comuna` VALUES ('9115', 'Pucón', '91');
INSERT INTO `comuna` VALUES ('9116', 'Saavedra', '91');
INSERT INTO `comuna` VALUES ('9117', 'Teodoro Schmidt', '91');
INSERT INTO `comuna` VALUES ('9118', 'Toltén', '91');
INSERT INTO `comuna` VALUES ('9119', 'Vilcún', '91');
INSERT INTO `comuna` VALUES ('9120', 'Villarrica', '91');
INSERT INTO `comuna` VALUES ('9121', 'Cholchol', '91');
INSERT INTO `comuna` VALUES ('9201', 'Angol', '92');
INSERT INTO `comuna` VALUES ('9202', 'Collipulli', '92');
INSERT INTO `comuna` VALUES ('9203', 'Curacautín', '92');
INSERT INTO `comuna` VALUES ('9204', 'Ercilla', '92');
INSERT INTO `comuna` VALUES ('9205', 'Lonquimay', '92');
INSERT INTO `comuna` VALUES ('9206', 'Los Sauces', '92');
INSERT INTO `comuna` VALUES ('9207', 'Lumaco', '92');
INSERT INTO `comuna` VALUES ('9208', 'Purén', '92');
INSERT INTO `comuna` VALUES ('9209', 'Renaico', '92');
INSERT INTO `comuna` VALUES ('9210', 'Traiguén', '92');
INSERT INTO `comuna` VALUES ('9211', 'Victoria', '92');
INSERT INTO `comuna` VALUES ('10101', 'Puerto Montt', '101');
INSERT INTO `comuna` VALUES ('10102', 'Calbuco', '101');
INSERT INTO `comuna` VALUES ('10103', 'Cochamó', '101');
INSERT INTO `comuna` VALUES ('10104', 'Fresia', '101');
INSERT INTO `comuna` VALUES ('10105', 'Frutillar', '101');
INSERT INTO `comuna` VALUES ('10106', 'Los Muermos', '101');
INSERT INTO `comuna` VALUES ('10107', 'Llanquihue', '101');
INSERT INTO `comuna` VALUES ('10108', 'Maullín', '101');
INSERT INTO `comuna` VALUES ('10109', 'Puerto Varas', '101');
INSERT INTO `comuna` VALUES ('10201', 'Castro', '102');
INSERT INTO `comuna` VALUES ('10202', 'Ancud', '102');
INSERT INTO `comuna` VALUES ('10203', 'Chonchi', '102');
INSERT INTO `comuna` VALUES ('10204', 'Curaco de Vélez', '102');
INSERT INTO `comuna` VALUES ('10205', 'Dalcahue', '102');
INSERT INTO `comuna` VALUES ('10206', 'Puqueldón', '102');
INSERT INTO `comuna` VALUES ('10207', 'Queilén', '102');
INSERT INTO `comuna` VALUES ('10208', 'Quellón', '102');
INSERT INTO `comuna` VALUES ('10209', 'Quemchi', '102');
INSERT INTO `comuna` VALUES ('10210', 'Quinchao', '102');
INSERT INTO `comuna` VALUES ('10301', 'Osorno', '103');
INSERT INTO `comuna` VALUES ('10302', 'Puerto Octay', '103');
INSERT INTO `comuna` VALUES ('10303', 'Purranque', '103');
INSERT INTO `comuna` VALUES ('10304', 'Puyehue', '103');
INSERT INTO `comuna` VALUES ('10305', 'Río Negro', '103');
INSERT INTO `comuna` VALUES ('10306', 'San Juan de la Costa', '103');
INSERT INTO `comuna` VALUES ('10307', 'San Pablo', '103');
INSERT INTO `comuna` VALUES ('10401', 'Chaitén', '104');
INSERT INTO `comuna` VALUES ('10402', 'Futaleufú', '104');
INSERT INTO `comuna` VALUES ('10403', 'Hualaihué', '104');
INSERT INTO `comuna` VALUES ('10404', 'Palena', '104');
INSERT INTO `comuna` VALUES ('11101', 'Coyhaique', '111');
INSERT INTO `comuna` VALUES ('11102', 'Lago Verde', '111');
INSERT INTO `comuna` VALUES ('11201', 'Aysén', '112');
INSERT INTO `comuna` VALUES ('11202', 'Cisnes', '112');
INSERT INTO `comuna` VALUES ('11203', 'Guaitecas', '112');
INSERT INTO `comuna` VALUES ('11301', 'Cochrane', '113');
INSERT INTO `comuna` VALUES ('11302', 'O\'Higgins', '113');
INSERT INTO `comuna` VALUES ('11303', 'Tortel', '113');
INSERT INTO `comuna` VALUES ('11401', 'Chile Chico', '114');
INSERT INTO `comuna` VALUES ('11402', 'Río Ibáñez', '114');
INSERT INTO `comuna` VALUES ('12101', 'Punta Arenas', '121');
INSERT INTO `comuna` VALUES ('12102', 'Laguna Blanca', '121');
INSERT INTO `comuna` VALUES ('12103', 'Río Verde', '121');
INSERT INTO `comuna` VALUES ('12104', 'San Gregorio', '121');
INSERT INTO `comuna` VALUES ('12201', 'Cabo de Hornos', '122');
INSERT INTO `comuna` VALUES ('12202', 'Antártica', '122');
INSERT INTO `comuna` VALUES ('12301', 'Porvenir', '123');
INSERT INTO `comuna` VALUES ('12302', 'Primavera', '123');
INSERT INTO `comuna` VALUES ('12303', 'Timaukel', '123');
INSERT INTO `comuna` VALUES ('12401', 'Natales', '124');
INSERT INTO `comuna` VALUES ('12402', 'Torres del Paine', '124');
INSERT INTO `comuna` VALUES ('13101', 'Santiago', '131');
INSERT INTO `comuna` VALUES ('13102', 'Cerrillos', '131');
INSERT INTO `comuna` VALUES ('13103', 'Cerro Navia', '131');
INSERT INTO `comuna` VALUES ('13104', 'Conchalí', '131');
INSERT INTO `comuna` VALUES ('13105', 'El Bosque', '131');
INSERT INTO `comuna` VALUES ('13106', 'Estación Central', '131');
INSERT INTO `comuna` VALUES ('13107', 'Huechuraba', '131');
INSERT INTO `comuna` VALUES ('13108', 'Independencia', '131');
INSERT INTO `comuna` VALUES ('13109', 'La Cisterna', '131');
INSERT INTO `comuna` VALUES ('13110', 'La Florida', '131');
INSERT INTO `comuna` VALUES ('13111', 'La Granja', '131');
INSERT INTO `comuna` VALUES ('13112', 'La Pintana', '131');
INSERT INTO `comuna` VALUES ('13113', 'La Reina', '131');
INSERT INTO `comuna` VALUES ('13114', 'Las Condes', '131');
INSERT INTO `comuna` VALUES ('13115', 'Lo Barnechea', '131');
INSERT INTO `comuna` VALUES ('13116', 'Lo Espejo', '131');
INSERT INTO `comuna` VALUES ('13117', 'Lo Prado', '131');
INSERT INTO `comuna` VALUES ('13118', 'Macul', '131');
INSERT INTO `comuna` VALUES ('13119', 'Maipú', '131');
INSERT INTO `comuna` VALUES ('13120', 'Ñuñoa', '131');
INSERT INTO `comuna` VALUES ('13121', 'Pedro Aguirre Cerda', '131');
INSERT INTO `comuna` VALUES ('13122', 'Peñalolén', '131');
INSERT INTO `comuna` VALUES ('13123', 'Providencia', '131');
INSERT INTO `comuna` VALUES ('13124', 'Pudahuel', '131');
INSERT INTO `comuna` VALUES ('13125', 'Quilicura', '131');
INSERT INTO `comuna` VALUES ('13126', 'Quinta Normal', '131');
INSERT INTO `comuna` VALUES ('13127', 'Recoleta', '131');
INSERT INTO `comuna` VALUES ('13128', 'Renca', '131');
INSERT INTO `comuna` VALUES ('13129', 'San Joaquín', '131');
INSERT INTO `comuna` VALUES ('13130', 'San Miguel', '131');
INSERT INTO `comuna` VALUES ('13131', 'San Ramón', '131');
INSERT INTO `comuna` VALUES ('13132', 'Vitacura', '131');
INSERT INTO `comuna` VALUES ('13201', 'Puente Alto', '132');
INSERT INTO `comuna` VALUES ('13202', 'Pirque', '132');
INSERT INTO `comuna` VALUES ('13203', 'San José de Maipo', '132');
INSERT INTO `comuna` VALUES ('13301', 'Colina', '133');
INSERT INTO `comuna` VALUES ('13302', 'Lampa', '133');
INSERT INTO `comuna` VALUES ('13303', 'Tiltil', '133');
INSERT INTO `comuna` VALUES ('13401', 'San Bernardo', '134');
INSERT INTO `comuna` VALUES ('13402', 'Buin', '134');
INSERT INTO `comuna` VALUES ('13403', 'Calera de Tango', '134');
INSERT INTO `comuna` VALUES ('13404', 'Paine', '134');
INSERT INTO `comuna` VALUES ('13501', 'Melipilla', '135');
INSERT INTO `comuna` VALUES ('13502', 'Alhué', '135');
INSERT INTO `comuna` VALUES ('13503', 'Curacaví', '135');
INSERT INTO `comuna` VALUES ('13504', 'María Pinto', '135');
INSERT INTO `comuna` VALUES ('13505', 'San Pedro', '135');
INSERT INTO `comuna` VALUES ('13601', 'Talagante', '136');
INSERT INTO `comuna` VALUES ('13602', 'El Monte', '136');
INSERT INTO `comuna` VALUES ('13603', 'Isla de Maipo', '136');
INSERT INTO `comuna` VALUES ('13604', 'Padre Hurtado', '136');
INSERT INTO `comuna` VALUES ('13605', 'Peñaflor', '136');
INSERT INTO `comuna` VALUES ('14101', 'Valdivia', '141');
INSERT INTO `comuna` VALUES ('14102', 'Corral', '141');
INSERT INTO `comuna` VALUES ('14103', 'Lanco', '141');
INSERT INTO `comuna` VALUES ('14104', 'Los Lagos', '141');
INSERT INTO `comuna` VALUES ('14105', 'Máfil', '141');
INSERT INTO `comuna` VALUES ('14106', 'Mariquina', '141');
INSERT INTO `comuna` VALUES ('14107', 'Paillaco', '141');
INSERT INTO `comuna` VALUES ('14108', 'Panguipulli', '141');
INSERT INTO `comuna` VALUES ('14201', 'La Unión', '142');
INSERT INTO `comuna` VALUES ('14202', 'Futrono', '142');
INSERT INTO `comuna` VALUES ('14203', 'Lago Ranco', '142');
INSERT INTO `comuna` VALUES ('14204', 'Río Bueno', '142');
INSERT INTO `comuna` VALUES ('15101', 'Arica', '151');
INSERT INTO `comuna` VALUES ('15102', 'Camarones', '151');
INSERT INTO `comuna` VALUES ('15201', 'Putre', '152');
INSERT INTO `comuna` VALUES ('15202', 'General Lagos', '152');

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
-- Records of conservador
-- ----------------------------
INSERT INTO `conservador` VALUES ('1', 'conservador 1');
INSERT INTO `conservador` VALUES ('2', 'conservador 2');
INSERT INTO `conservador` VALUES ('3', 'conservador 3');

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
-- Records of cuenta
-- ----------------------------
INSERT INTO `cuenta` VALUES ('000001', '2000000', '1000000', '3000000', '1413774000');

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
-- Records of cuenta_persona
-- ----------------------------
INSERT INTO `cuenta_persona` VALUES ('1', '000001', '14165260');

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
-- Records of deficit_habitacional
-- ----------------------------
INSERT INTO `deficit_habitacional` VALUES ('1', 'Bajo');
INSERT INTO `deficit_habitacional` VALUES ('2', 'Medio');
INSERT INTO `deficit_habitacional` VALUES ('3', 'Alto');

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
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- ----------------------------
-- Records of direccion
-- ----------------------------
INSERT INTO `direccion` VALUES ('1', 'Serafín Gutiérrez', '233', '7407', '1', '14165260');
INSERT INTO `direccion` VALUES ('2', 'Abate Molina', '324', '7407', '1', '18973861');
INSERT INTO `direccion` VALUES ('3', 'Abate Molina', '327', '7407', '1', '16923722');
INSERT INTO `direccion` VALUES ('4', 'Abate Molina', '330', '7407', '1', '18679317');
INSERT INTO `direccion` VALUES ('5', 'Abate Molina', '333', '7407', '1', '18967368');
INSERT INTO `direccion` VALUES ('6', 'Abate Molina', '336', '7407', '1', '19105058');
INSERT INTO `direccion` VALUES ('7', 'Abate Molina', '339', '7407', '1', '19105657');
INSERT INTO `direccion` VALUES ('8', 'Abate Molina', '342', '7407', '1', '18225402');
INSERT INTO `direccion` VALUES ('9', 'Abate Molina', '345', '7407', '1', '16729223');
INSERT INTO `direccion` VALUES ('10', 'Abate Molina', '348', '7407', '1', '18892856');
INSERT INTO `direccion` VALUES ('11', 'Abate Molina', '351', '7407', '1', '18894184');
INSERT INTO `direccion` VALUES ('12', 'Abate Molina', '354', '7407', '1', '19094587');
INSERT INTO `direccion` VALUES ('13', 'Abate Molina', '357', '7407', '1', '19267734');
INSERT INTO `direccion` VALUES ('14', 'Abate Molina', '360', '7407', '1', '18892563');
INSERT INTO `direccion` VALUES ('15', 'Abate Molina', '363', '7407', '1', '17496901');
INSERT INTO `direccion` VALUES ('16', 'Abate Molina', '366', '7407', '1', '18573644');
INSERT INTO `direccion` VALUES ('17', 'Abate Molina', '369', '7407', '1', '19386472');
INSERT INTO `direccion` VALUES ('18', 'Abate Molina', '372', '7407', '1', '18542359');
INSERT INTO `direccion` VALUES ('19', 'Abate Molina', '375', '7407', '1', '19044341');
INSERT INTO `direccion` VALUES ('20', 'Abate Molina', '378', '7407', '1', '17823534');
INSERT INTO `direccion` VALUES ('21', 'Abate Molina', '381', '7407', '1', '18655356');
INSERT INTO `direccion` VALUES ('22', 'Abate Molina', '384', '7407', '1', '18780937');
INSERT INTO `direccion` VALUES ('23', 'Abate Molina', '387', '7407', '1', '19105844');
INSERT INTO `direccion` VALUES ('24', 'Abate Molina', '390', '7407', '1', '15855950');
INSERT INTO `direccion` VALUES ('25', 'Abate Molina', '393', '7407', '1', '6847788');
INSERT INTO `direccion` VALUES ('26', 'Abate Molina', '396', '7407', '1', '18474540');
INSERT INTO `direccion` VALUES ('27', 'Abate Molina', '399', '7407', '1', '17495776');
INSERT INTO `direccion` VALUES ('28', 'Abate Molina', '402', '7407', '1', '18226451');
INSERT INTO `direccion` VALUES ('29', 'Abate Molina', '405', '7407', '1', '17211850');
INSERT INTO `direccion` VALUES ('30', 'Abate Molina', '408', '7407', '1', '19389347');
INSERT INTO `direccion` VALUES ('31', 'Abate Molina', '411', '7407', '1', '15875443');
INSERT INTO `direccion` VALUES ('32', 'Abate Molina', '414', '7407', '1', '13797051');
INSERT INTO `direccion` VALUES ('33', 'Abate Molina', '417', '7407', '1', '18656513');
INSERT INTO `direccion` VALUES ('34', 'Abate Molina', '420', '7407', '1', '18576030');
INSERT INTO `direccion` VALUES ('35', 'Abate Molina', '423', '7407', '1', '19106560');
INSERT INTO `direccion` VALUES ('36', 'Abate Molina', '426', '7407', '1', '15848457');
INSERT INTO `direccion` VALUES ('37', 'Abate Molina', '429', '7407', '1', '18476259');
INSERT INTO `direccion` VALUES ('38', 'Abate Molina', '432', '7407', '1', '15136003');
INSERT INTO `direccion` VALUES ('39', 'Abate Molina', '435', '7407', '1', '18573479');
INSERT INTO `direccion` VALUES ('40', 'Abate Molina', '438', '7407', '1', '17823971');
INSERT INTO `direccion` VALUES ('41', 'Abate Molina', '441', '7407', '1', '18893212');
INSERT INTO `direccion` VALUES ('42', 'Abate Molina', '444', '7407', '1', '17040598');
INSERT INTO `direccion` VALUES ('43', 'Abate Molina', '447', '7407', '1', '12748698');
INSERT INTO `direccion` VALUES ('44', 'Abate Molina', '450', '7407', '1', '17493888');
INSERT INTO `direccion` VALUES ('45', 'Abate Molina', '453', '7407', '1', '19042996');
INSERT INTO `direccion` VALUES ('46', 'Abate Molina', '456', '7407', '1', '18893902');
INSERT INTO `direccion` VALUES ('47', 'Abate Molina', '459', '7407', '1', '14015927');
INSERT INTO `direccion` VALUES ('48', 'Abate Molina', '462', '7407', '1', '18656637');
INSERT INTO `direccion` VALUES ('49', 'Abate Molina', '465', '7407', '1', '19390757');
INSERT INTO `direccion` VALUES ('50', 'Abate Molina', '468', '7407', '1', '19106010');
INSERT INTO `direccion` VALUES ('51', 'Abate Molina', '471', '7407', '1', '19043828');
INSERT INTO `direccion` VALUES ('52', 'Abate Molina', '474', '7407', '1', '18893062');
INSERT INTO `direccion` VALUES ('53', 'Abate Molina', '477', '7407', '1', '19044574');
INSERT INTO `direccion` VALUES ('54', 'Abate Molina', '480', '7407', '1', '15135633');
INSERT INTO `direccion` VALUES ('55', 'Abate Molina', '483', '7407', '1', '19472320');
INSERT INTO `direccion` VALUES ('56', 'Abate Molina', '486', '7407', '1', '19471888');
INSERT INTO `direccion` VALUES ('57', 'Abate Molina', '489', '7407', '1', '19601739');
INSERT INTO `direccion` VALUES ('58', 'Abate Molina', '492', '7407', '1', '18780695');
INSERT INTO `direccion` VALUES ('59', 'Abate Molina', '495', '7407', '1', '19574405');
INSERT INTO `direccion` VALUES ('60', 'Abate Molina', '498', '7407', '1', '19144476');
INSERT INTO `direccion` VALUES ('61', 'Abate Molina', '501', '7407', '1', '19105091');
INSERT INTO `direccion` VALUES ('62', 'Abate Molina', '504', '7407', '1', '17186073');
INSERT INTO `direccion` VALUES ('63', 'Abate Molina', '507', '7407', '1', '18982398');
INSERT INTO `direccion` VALUES ('64', 'Abate Molina', '510', '7407', '1', '17932092');
INSERT INTO `direccion` VALUES ('65', 'Abate Molina', '513', '7407', '1', '17822610');
INSERT INTO `direccion` VALUES ('66', 'Abate Molina', '516', '7407', '1', '18319418');
INSERT INTO `direccion` VALUES ('67', 'Abate Molina', '519', '7407', '1', '17187237');
INSERT INTO `direccion` VALUES ('68', 'Abate Molina', '522', '7407', '1', '17825948');
INSERT INTO `direccion` VALUES ('69', 'Abate Molina', '525', '7407', '1', '19473751');
INSERT INTO `direccion` VALUES ('70', 'Abate Molina', '528', '7407', '1', '16456251');
INSERT INTO `direccion` VALUES ('71', 'Abate Molina', '531', '7407', '1', '19473187');
INSERT INTO `direccion` VALUES ('72', 'Abate Molina', '534', '7407', '1', '15138556');
INSERT INTO `direccion` VALUES ('73', 'Abate Molina', '537', '7407', '1', '19044624');
INSERT INTO `direccion` VALUES ('74', 'Abate Molina', '540', '7407', '1', '14399821');
INSERT INTO `direccion` VALUES ('75', 'Abate Molina', '543', '7407', '1', '12520452');
INSERT INTO `direccion` VALUES ('76', 'Abate Molina', '546', '7407', '1', '18892211');
INSERT INTO `direccion` VALUES ('77', 'Abate Molina', '549', '7407', '1', '19392836');
INSERT INTO `direccion` VALUES ('78', 'Abate Molina', '552', '7407', '1', '16730541');
INSERT INTO `direccion` VALUES ('79', 'Abate Molina', '555', '7407', '1', '18226871');
INSERT INTO `direccion` VALUES ('80', 'Abate Molina', '558', '7407', '1', '18226599');
INSERT INTO `direccion` VALUES ('81', 'Abate Molina', '561', '7407', '1', '11674809');
INSERT INTO `direccion` VALUES ('82', 'Abate Molina', '564', '7407', '1', '12156819');
INSERT INTO `direccion` VALUES ('83', 'Abate Molina', '567', '7407', '1', '19695907');
INSERT INTO `direccion` VALUES ('84', 'Abate Molina', '570', '7407', '1', '15134015');
INSERT INTO `direccion` VALUES ('85', 'Abate Molina', '573', '7407', '1', '18279477');
INSERT INTO `direccion` VALUES ('86', 'Abate Molina', '576', '7407', '1', '17185413');
INSERT INTO `direccion` VALUES ('87', 'Abate Molina', '579', '7407', '1', '18227873');
INSERT INTO `direccion` VALUES ('88', 'Abate Molina', '582', '7407', '1', '16730778');
INSERT INTO `direccion` VALUES ('89', 'Abate Molina', '585', '7407', '1', '17495922');
INSERT INTO `direccion` VALUES ('90', 'Abate Molina', '588', '7407', '1', '18225632');
INSERT INTO `direccion` VALUES ('91', 'Abate Molina', '591', '7407', '1', '17684923');
INSERT INTO `direccion` VALUES ('92', 'Abate Molina', '594', '7407', '1', '18225335');
INSERT INTO `direccion` VALUES ('93', 'Abate Molina', '597', '7407', '1', '18225566');
INSERT INTO `direccion` VALUES ('94', 'Abate Molina', '600', '7407', '1', '18228511');
INSERT INTO `direccion` VALUES ('95', 'Abate Molina', '603', '7407', '1', '18572304');
INSERT INTO `direccion` VALUES ('96', 'Abate Molina', '606', '7407', '1', '18576184');
INSERT INTO `direccion` VALUES ('97', 'Abate Molina', '609', '7407', '1', '18891260');
INSERT INTO `direccion` VALUES ('98', 'Abate Molina', '612', '7407', '1', '19697589');

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
-- Records of ds10
-- ----------------------------
INSERT INTO `ds10` VALUES ('1', 'Regular');
INSERT INTO `ds10` VALUES ('2', 'Rural');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- ----------------------------
-- Records of egis
-- ----------------------------

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
-- Records of estado_civil
-- ----------------------------
INSERT INTO `estado_civil` VALUES ('1', 'Soltero');
INSERT INTO `estado_civil` VALUES ('2', 'Casado');
INSERT INTO `estado_civil` VALUES ('3', 'Divorciado');

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
-- Records of factores_carencia
-- ----------------------------
INSERT INTO `factores_carencia` VALUES ('1', 'Allegamiento');
INSERT INTO `factores_carencia` VALUES ('2', 'Hacinamiento');
INSERT INTO `factores_carencia` VALUES ('3', 'Falta de agua');
INSERT INTO `factores_carencia` VALUES ('4', 'Tipo de vivienda');
INSERT INTO `factores_carencia` VALUES ('5', 'Alcantarillado');

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
  CONSTRAINT `ficha_factores_fk2` FOREIGN KEY (`factor`) REFERENCES `factores_carencia` (`idfactor`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- ----------------------------
-- Records of ficha_factores
-- ----------------------------
INSERT INTO `ficha_factores` VALUES ('1', '1', '1', '1');
INSERT INTO `ficha_factores` VALUES ('2', '1', '2', '1');
INSERT INTO `ficha_factores` VALUES ('3', '1', '3', '0');
INSERT INTO `ficha_factores` VALUES ('4', '1', '4', '0');
INSERT INTO `ficha_factores` VALUES ('5', '1', '5', '1');

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
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- ----------------------------
-- Records of fono
-- ----------------------------
INSERT INTO `fono` VALUES ('1', '75583209', '2', '1', '14165260');
INSERT INTO `fono` VALUES ('2', '131', '1', '1', '18973861');
INSERT INTO `fono` VALUES ('3', '136', '1', '1', '16923722');
INSERT INTO `fono` VALUES ('4', '141', '1', '1', '18679317');
INSERT INTO `fono` VALUES ('5', '146', '1', '1', '18967368');
INSERT INTO `fono` VALUES ('6', '151', '1', '1', '19105058');
INSERT INTO `fono` VALUES ('7', '156', '1', '1', '19105657');
INSERT INTO `fono` VALUES ('8', '161', '1', '1', '18225402');
INSERT INTO `fono` VALUES ('9', '166', '1', '1', '16729223');
INSERT INTO `fono` VALUES ('10', '171', '1', '1', '18892856');
INSERT INTO `fono` VALUES ('11', '176', '1', '1', '18894184');
INSERT INTO `fono` VALUES ('12', '181', '1', '1', '19094587');
INSERT INTO `fono` VALUES ('13', '186', '1', '1', '19267734');
INSERT INTO `fono` VALUES ('14', '191', '1', '1', '18892563');
INSERT INTO `fono` VALUES ('15', '196', '1', '1', '17496901');
INSERT INTO `fono` VALUES ('16', '201', '1', '1', '18573644');
INSERT INTO `fono` VALUES ('17', '206', '1', '1', '19386472');
INSERT INTO `fono` VALUES ('18', '211', '1', '1', '18542359');
INSERT INTO `fono` VALUES ('19', '216', '1', '1', '19044341');
INSERT INTO `fono` VALUES ('20', '221', '1', '1', '17823534');
INSERT INTO `fono` VALUES ('21', '226', '1', '1', '18655356');
INSERT INTO `fono` VALUES ('22', '231', '1', '1', '18780937');
INSERT INTO `fono` VALUES ('23', '236', '1', '1', '19105844');
INSERT INTO `fono` VALUES ('24', '241', '1', '1', '15855950');
INSERT INTO `fono` VALUES ('25', '246', '1', '1', '6847788');
INSERT INTO `fono` VALUES ('26', '251', '1', '1', '18474540');
INSERT INTO `fono` VALUES ('27', '256', '1', '1', '17495776');
INSERT INTO `fono` VALUES ('28', '261', '1', '1', '18226451');
INSERT INTO `fono` VALUES ('29', '266', '1', '1', '17211850');
INSERT INTO `fono` VALUES ('30', '271', '1', '1', '19389347');
INSERT INTO `fono` VALUES ('31', '276', '1', '1', '15875443');
INSERT INTO `fono` VALUES ('32', '281', '1', '1', '13797051');
INSERT INTO `fono` VALUES ('33', '286', '1', '1', '18656513');
INSERT INTO `fono` VALUES ('34', '291', '1', '1', '18576030');
INSERT INTO `fono` VALUES ('35', '296', '1', '1', '19106560');
INSERT INTO `fono` VALUES ('36', '301', '1', '1', '15848457');
INSERT INTO `fono` VALUES ('37', '306', '1', '1', '18476259');
INSERT INTO `fono` VALUES ('38', '311', '1', '1', '15136003');
INSERT INTO `fono` VALUES ('39', '316', '1', '1', '18573479');
INSERT INTO `fono` VALUES ('40', '321', '1', '1', '17823971');
INSERT INTO `fono` VALUES ('41', '326', '1', '1', '18893212');
INSERT INTO `fono` VALUES ('42', '331', '1', '1', '17040598');
INSERT INTO `fono` VALUES ('43', '336', '1', '1', '12748698');
INSERT INTO `fono` VALUES ('44', '341', '1', '1', '17493888');
INSERT INTO `fono` VALUES ('45', '346', '1', '1', '19042996');
INSERT INTO `fono` VALUES ('46', '351', '1', '1', '18893902');
INSERT INTO `fono` VALUES ('47', '356', '1', '1', '14015927');
INSERT INTO `fono` VALUES ('48', '361', '1', '1', '18656637');
INSERT INTO `fono` VALUES ('49', '366', '1', '1', '19390757');
INSERT INTO `fono` VALUES ('50', '371', '1', '1', '19106010');
INSERT INTO `fono` VALUES ('51', '376', '1', '1', '19043828');
INSERT INTO `fono` VALUES ('52', '381', '1', '1', '18893062');
INSERT INTO `fono` VALUES ('53', '386', '1', '1', '19044574');
INSERT INTO `fono` VALUES ('54', '391', '1', '1', '15135633');
INSERT INTO `fono` VALUES ('55', '396', '1', '1', '19472320');
INSERT INTO `fono` VALUES ('56', '401', '1', '1', '19471888');
INSERT INTO `fono` VALUES ('57', '406', '1', '1', '19601739');
INSERT INTO `fono` VALUES ('58', '411', '1', '1', '18780695');
INSERT INTO `fono` VALUES ('59', '416', '1', '1', '19574405');
INSERT INTO `fono` VALUES ('60', '421', '1', '1', '19144476');
INSERT INTO `fono` VALUES ('61', '426', '1', '1', '19105091');
INSERT INTO `fono` VALUES ('62', '431', '1', '1', '17186073');
INSERT INTO `fono` VALUES ('63', '436', '1', '1', '18982398');
INSERT INTO `fono` VALUES ('64', '441', '1', '1', '17932092');
INSERT INTO `fono` VALUES ('65', '446', '1', '1', '17822610');
INSERT INTO `fono` VALUES ('66', '451', '1', '1', '18319418');
INSERT INTO `fono` VALUES ('67', '456', '1', '1', '17187237');
INSERT INTO `fono` VALUES ('68', '461', '1', '1', '17825948');
INSERT INTO `fono` VALUES ('69', '466', '1', '1', '19473751');
INSERT INTO `fono` VALUES ('70', '471', '1', '1', '16456251');
INSERT INTO `fono` VALUES ('71', '476', '1', '1', '19473187');
INSERT INTO `fono` VALUES ('72', '481', '1', '1', '15138556');
INSERT INTO `fono` VALUES ('73', '486', '1', '1', '19044624');
INSERT INTO `fono` VALUES ('74', '491', '1', '1', '14399821');
INSERT INTO `fono` VALUES ('75', '496', '1', '1', '12520452');
INSERT INTO `fono` VALUES ('76', '501', '1', '1', '18892211');
INSERT INTO `fono` VALUES ('77', '506', '1', '1', '19392836');
INSERT INTO `fono` VALUES ('78', '511', '1', '1', '16730541');
INSERT INTO `fono` VALUES ('79', '516', '1', '1', '18226871');
INSERT INTO `fono` VALUES ('80', '521', '1', '1', '18226599');
INSERT INTO `fono` VALUES ('81', '526', '1', '1', '11674809');
INSERT INTO `fono` VALUES ('82', '531', '1', '1', '12156819');
INSERT INTO `fono` VALUES ('83', '536', '1', '1', '19695907');
INSERT INTO `fono` VALUES ('84', '541', '1', '1', '15134015');
INSERT INTO `fono` VALUES ('85', '546', '1', '1', '18279477');
INSERT INTO `fono` VALUES ('86', '551', '1', '1', '17185413');
INSERT INTO `fono` VALUES ('87', '556', '1', '1', '18227873');
INSERT INTO `fono` VALUES ('88', '561', '1', '1', '16730778');
INSERT INTO `fono` VALUES ('89', '566', '1', '1', '17495922');
INSERT INTO `fono` VALUES ('90', '571', '1', '1', '18225632');
INSERT INTO `fono` VALUES ('91', '576', '1', '1', '17684923');
INSERT INTO `fono` VALUES ('92', '581', '1', '1', '18225335');
INSERT INTO `fono` VALUES ('93', '586', '1', '1', '18225566');
INSERT INTO `fono` VALUES ('94', '591', '1', '1', '18228511');
INSERT INTO `fono` VALUES ('95', '596', '1', '1', '18572304');
INSERT INTO `fono` VALUES ('96', '601', '1', '1', '18576184');
INSERT INTO `fono` VALUES ('97', '606', '1', '1', '18891260');
INSERT INTO `fono` VALUES ('98', '611', '1', '1', '19697589');

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
-- Records of frh
-- ----------------------------
INSERT INTO `frh` VALUES ('1', '2', '14000', '7', '1', '376196400', '2', '1', '0');

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
  `ds10` int(11) DEFAULT NULL,
  `idegis` int(11) DEFAULT NULL,
  PRIMARY KEY (`idgrupo`),
  UNIQUE KEY `numero` (`numero`),
  KEY `idegis` (`idegis`),
  KEY `idcomuna` (`idcomuna`),
  KEY `ds10` (`ds10`),
  CONSTRAINT `grupo_fk1` FOREIGN KEY (`idegis`) REFERENCES `egis` (`idegis`),
  CONSTRAINT `grupo_fk2` FOREIGN KEY (`idcomuna`) REFERENCES `comuna` (`COMUNA_ID`),
  CONSTRAINT `grupo_fk3` FOREIGN KEY (`ds10`) REFERENCES `ds10` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- ----------------------------
-- Records of grupo
-- ----------------------------
INSERT INTO `grupo` VALUES ('1', '1', '946684800', '1,1', 'particular', 'manuel rodriguez sin numero', '7407', null, null);

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
-- Records of item_postulacion
-- ----------------------------
INSERT INTO `item_postulacion` VALUES ('1', 'ampliacion');
INSERT INTO `item_postulacion` VALUES ('2', 'mejoramiento');
INSERT INTO `item_postulacion` VALUES ('3', 'csolar');
INSERT INTO `item_postulacion` VALUES ('4', 'ctermico');

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
-- Records of mts
-- ----------------------------
INSERT INTO `mts` VALUES ('1', '78889', '1', '40');
INSERT INTO `mts` VALUES ('2', '78889', '2', '40');

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
-- Records of perfil
-- ----------------------------
INSERT INTO `perfil` VALUES ('1', 'admin');
INSERT INTO `perfil` VALUES ('2', 'digitador');

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
-- Records of persona
-- ----------------------------
INSERT INTO `persona` VALUES ('11674809', '6', 'RICARDO ALFONSO', 'POZO', 'ROMERO', '11674809@example.com', '0');
INSERT INTO `persona` VALUES ('12156819', '5', 'RAFAEL  GABRIEL', 'CASTRO', 'GONZÁLEZ', '12156819@example.com', '1');
INSERT INTO `persona` VALUES ('12520452', 'K', 'ALEX MAURICIO', 'VALDES', 'DIAZ', '12520452@example.com', '1');
INSERT INTO `persona` VALUES ('12748698', '0', 'CHRISTIAN LEONARDI', 'LÓPEZ', 'ROSAS', '12748698@example.com', '1');
INSERT INTO `persona` VALUES ('13797051', '1', 'MARCELO ALEJANDRO', 'SANDOVAL', 'BUSTOS', '13797051@example.com', '1');
INSERT INTO `persona` VALUES ('14015927', '1', 'ÁLVARO CHRISTIAN', 'SEPÚLVEDA', 'ADASME', '14015927@example.com', '1');
INSERT INTO `persona` VALUES ('14165260', '5', 'Hermann Ignacio', 'Pollack', 'Vega', 'hermann.pollack@gmail.com', '1');
INSERT INTO `persona` VALUES ('14399821', '5', 'HÉCTOR EDUARDO', 'NÚÑEZ', 'BRAVO', '14399821@example.com', '1');
INSERT INTO `persona` VALUES ('15134015', '6', 'MARIO RODRIGO', 'SEPÚLVEDA', 'AMÉSTICA', '15134015@example.com', '1');
INSERT INTO `persona` VALUES ('15135633', '8', 'JOEL ESTEBAN', 'CHODIN', 'GONZALEZ', '15135633@example.com', '1');
INSERT INTO `persona` VALUES ('15136003', '3', 'HERNÁN SEBASTIAN', 'RODRÍGUEZ', 'PINCHEIRA', '15136003@example.com', '1');
INSERT INTO `persona` VALUES ('15138556', '7', 'CRISTIAN IVÁN', 'ROJAS', 'MUÑOZ', '15138556@example.com', '1');
INSERT INTO `persona` VALUES ('15848457', '9', 'HÉCTOR CRISTOFER', 'MANCILLA', 'SÁNCHEZ', '15848457@example.com', '1');
INSERT INTO `persona` VALUES ('15855950', '1', 'LUIS GUSTAVO', 'ESPINOZA', 'BRAVO', '15855950@example.com', '1');
INSERT INTO `persona` VALUES ('15875443', '6', 'LUIS ALBERTO', 'SOTO', 'CAMPOS', '15875443@example.com', '1');
INSERT INTO `persona` VALUES ('16456251', '4', 'ELISEO ANTONIO', 'GONZALEZ', 'GOMEZ', '16456251@example.com', '1');
INSERT INTO `persona` VALUES ('16729223', '2', 'SEBASTIÁN ANTONIO', 'ALBORNOZ', 'ARELLANO', '16729223@example.com', '1');
INSERT INTO `persona` VALUES ('16730541', '5', 'MARIO ENRIQUE', 'GONZÁLEZ', 'GUTIÉRREZ', '16730541@example.com', '1');
INSERT INTO `persona` VALUES ('16730778', '7', 'MARCELO HUMBERTO', 'ÓRDENES', 'ROJAS', '16730778@example.com', '1');
INSERT INTO `persona` VALUES ('16923722', '0', 'PABLO ANDRÉS', 'PATRI', 'MELLADO', '16923722@example.com', '1');
INSERT INTO `persona` VALUES ('17040598', '6', 'CRSITOBAL LEONARDO', 'ROJAS', 'FUENTES', '17040598@example.com', '1');
INSERT INTO `persona` VALUES ('17185413', 'K', 'ENRIQUE JAVIER', 'ZENTENO', 'SOTO', '17185413@example.com', '1');
INSERT INTO `persona` VALUES ('17186073', '3', 'BRAULIO ANDRÉS', 'OLIVARES', 'ROJAS', '17186073@example.com', '1');
INSERT INTO `persona` VALUES ('17187237', '5', 'ALEJANDRO ANDRES', 'GUTIERREZ', 'LOYOLA', '17187237@example.com', '1');
INSERT INTO `persona` VALUES ('17211850', 'K', 'RONALD MAXIMILIANO', 'RUZ', 'CÁCERES', '17211850@example.com', '1');
INSERT INTO `persona` VALUES ('17493888', '1', 'MAYKER ANGELO', 'CÉSPEDES', 'URRIOLA', '17493888@example.com', '1');
INSERT INTO `persona` VALUES ('17495776', '2', 'CARLOS JAVIER', 'GONZÁLEZ', 'SALAZAR', '17495776@example.com', '1');
INSERT INTO `persona` VALUES ('17495922', '6', 'JUAN LUIS', 'SEPÚLVEDA', 'MUÑOZ', '17495922@example.com', '1');
INSERT INTO `persona` VALUES ('17496901', '9', 'EITEL ESTEBAN', 'CORTÉS', 'SANTANDER', '17496901@example.com', '1');
INSERT INTO `persona` VALUES ('17684923', '1', 'JOSÉ EDUARDO', 'RODRÍGUEZ', 'ARROYO', '17684923@example.com', '1');
INSERT INTO `persona` VALUES ('17822610', 'K', 'JORGE ANDRÉS', 'MARTÍNEZ', 'VALENZUELA', '17822610@example.com', '1');
INSERT INTO `persona` VALUES ('17823534', '6', 'CAMILO ALBERTO', 'TOBAR', 'DÍAZ', '17823534@example.com', '1');
INSERT INTO `persona` VALUES ('17823971', '6', 'EDUAR BAUTISTA', 'BARROS', 'MUÑOZ', '17823971@example.com', '1');
INSERT INTO `persona` VALUES ('17825948', '2', 'WALTER RAMIRO', 'SOLÍS', 'CORNEJO', '17825948@example.com', '1');
INSERT INTO `persona` VALUES ('17932092', '4', 'MARCELO IGNACIO', 'BRAVO', 'JORQUERA', '17932092@example.com', '1');
INSERT INTO `persona` VALUES ('18225335', '9', 'CARLOS ANDRES', 'MORA', 'COFRÉ', '18225335@example.com', '1');
INSERT INTO `persona` VALUES ('18225402', '9', 'MATÍAS ALEJANDRO', 'RODRÍGUEZ', 'CONTRERAS', '18225402@example.com', '1');
INSERT INTO `persona` VALUES ('18225566', '1', 'GUILLERMO ANDRÉS', 'CEBALLOS', 'LOYOLA', '18225566@example.com', '1');
INSERT INTO `persona` VALUES ('18225632', '3', 'GEORGE MICHAEL', 'CONCHA', 'CÁCERES', '18225632@example.com', '1');
INSERT INTO `persona` VALUES ('18226451', '2', 'DIEGO ANTONIO', 'FUENTES', 'POBLETE', '18226451@example.com', '1');
INSERT INTO `persona` VALUES ('18226599', '3', 'CAMILO FABIÁN', 'CORVALÁN', 'AGUILERA', '18226599@example.com', '1');
INSERT INTO `persona` VALUES ('18226871', '2', 'SEBASTIÁN RICARDO', 'ALCAÍNO', 'ROCO', '18226871@example.com', '1');
INSERT INTO `persona` VALUES ('18227873', '4', 'GERMÁN EDUARDO', 'ESPINOZA', 'ROJAS', '18227873@example.com', '1');
INSERT INTO `persona` VALUES ('18228511', '0', 'FELIPE ANDRÉS', 'PIÑA', 'RIQUELME', '18228511@example.com', '1');
INSERT INTO `persona` VALUES ('18279477', '5', 'FRANCISCO DIEGO', 'ENCINA', 'BRAVO', '18279477@example.com', '1');
INSERT INTO `persona` VALUES ('18319418', '6', 'ENY LESLIE NAYADETH', 'LEIVA', 'CIFUENTES', '18319418@example.com', '1');
INSERT INTO `persona` VALUES ('18474540', '2', 'JAIME ALONSO', 'ORÓSTICA', 'AHUMADA', '18474540@example.com', '1');
INSERT INTO `persona` VALUES ('18476259', '5', 'GONZALO ENRIQUE', 'JAQUE', 'CASTILLO', '18476259@example.com', '1');
INSERT INTO `persona` VALUES ('18542359', 'K', 'HÉCTOR SAMUEL', 'PACHECO', 'LERI', '18542359@example.com', '1');
INSERT INTO `persona` VALUES ('18572304', '6', 'PAOLO VALENTÍN', 'FERNÁNDEZ', 'FAÚNDEZ', '18572304@example.com', '1');
INSERT INTO `persona` VALUES ('18573479', 'K', 'PEDRO EDUARDO', 'CAMPOS', 'DÍAZ', '18573479@example.com', '1');
INSERT INTO `persona` VALUES ('18573644', 'K', 'JULIÁN JEREMY', 'CÁRCAMO', 'SALAS', '18573644@example.com', '1');
INSERT INTO `persona` VALUES ('18576030', '8', 'JAVIER IGNACIO', 'FUENTES', 'CID', '18576030@example.com', '1');
INSERT INTO `persona` VALUES ('18576184', '3', 'FRANCISCO IGNACIO', 'AYALA', 'ANDRADES', '18576184@example.com', '1');
INSERT INTO `persona` VALUES ('18655356', 'K', 'LUIS FELIPE', 'GAJARDO', 'COLOMA', '18655356@example.com', '1');
INSERT INTO `persona` VALUES ('18656513', '4', 'RODOLFO ALEJANDRO', 'HORMAZABAL', 'RETAMAL', '18656513@example.com', '1');
INSERT INTO `persona` VALUES ('18656637', '8', 'VICTOR ALEJANDRO', 'MOYA', 'FAUNDEZ', '18656637@example.com', '1');
INSERT INTO `persona` VALUES ('18679317', 'K', 'ALEJANDRO OCTAVIO', 'GÓMEZ', 'SEPÚLVEDA', '18679317@example.com', '1');
INSERT INTO `persona` VALUES ('18780695', 'K', 'JUAN ANTONIO', 'MUÑOZ', 'MUÑOZ', '18780695@example.com', '1');
INSERT INTO `persona` VALUES ('18780937', '1', 'ESTEBAN ALEJANDRO', 'FIGUEROA', 'SANTANDER', '18780937@example.com', '1');
INSERT INTO `persona` VALUES ('18891260', '5', 'CARLOS ANDRÉS', 'RIVERA', 'CÁCERES', '18891260@example.com', '1');
INSERT INTO `persona` VALUES ('18892211', '2', 'LUIS MANUEL', 'RAMOS', 'MUÑOZ', '18892211@example.com', '1');
INSERT INTO `persona` VALUES ('18892563', '4', 'LUIS ALEJANDRO', 'HERRERA', 'HERRERA', '18892563@example.com', '1');
INSERT INTO `persona` VALUES ('18892856', '0', 'DAVID EDUARDO', 'ESCALONA', 'CARRASCO', '18892856@example.com', '1');
INSERT INTO `persona` VALUES ('18893062', 'K', 'BRANDO FELIPE', 'FERNÁNDEZ', 'BRAVO', '18893062@example.com', '1');
INSERT INTO `persona` VALUES ('18893212', '6', 'FRANCISCO ANDRÉS', 'ORELLANA', 'ROJAS', '18893212@example.com', '1');
INSERT INTO `persona` VALUES ('18893902', '3', 'RICARDO IGANCIO', 'DE LA JARA', 'MOYA', '18893902@example.com', '1');
INSERT INTO `persona` VALUES ('18894184', '2', 'SERGIO MATÍAS', 'VÁSQUEZ', 'ITURRA', '18894184@example.com', '1');
INSERT INTO `persona` VALUES ('18967368', 'K', 'RONALD FIDEL', 'CÁCERES', 'LÓPEZ', '18967368@example.com', '1');
INSERT INTO `persona` VALUES ('18973861', '7', 'GONZALO EDUARDO', 'TORO', 'FERNANDEZ', '18973861@example.com', '1');
INSERT INTO `persona` VALUES ('18982398', '3', 'MAICOL ANDRÉS', 'LARENAS', 'QUIERO', '18982398@example.com', '1');
INSERT INTO `persona` VALUES ('19042996', '2', 'MATÍAS JAVIER', 'ARIAS', 'BERRÍOS', '19042996@example.com', '1');
INSERT INTO `persona` VALUES ('19043828', '7', 'GONZALO ANDRÉS', 'BRAVO', 'MUÑOZ', '19043828@example.com', '1');
INSERT INTO `persona` VALUES ('19044341', '8', 'MAICOL ANDRÉS', 'PARDO', 'GAJARDO', '19044341@example.com', '1');
INSERT INTO `persona` VALUES ('19044574', '7', 'SEBASTIÁN ALEJANDRO', 'ALISTE', 'MUÑOZ', '19044574@example.com', '1');
INSERT INTO `persona` VALUES ('19044624', '7', 'RODRIGO ENRIQUE', 'LÓPEZ', 'VALENZUELA', '19044624@example.com', '1');
INSERT INTO `persona` VALUES ('19094587', '1', 'ERICK SEBASTIÁN', 'GUTIÉRREZ', 'MATELUNA', '19094587@example.com', '1');
INSERT INTO `persona` VALUES ('19105058', '4', 'PABLO BERNABÉ', 'ÁLVAREZ', 'CHANDÍA', '19105058@example.com', '1');
INSERT INTO `persona` VALUES ('19105091', '6', 'MARIO ESTEBAN', 'ROJAS', 'CASTRO', '19105091@example.com', '1');
INSERT INTO `persona` VALUES ('19105657', '4', 'NICOLÁS ANTONIO', 'HERRERA', 'CANTILLANA', '19105657@example.com', '1');
INSERT INTO `persona` VALUES ('19105844', '5', 'RAMÓN IGNACIO', 'ÁVILA', 'ORÓSTICA', '19105844@example.com', '1');
INSERT INTO `persona` VALUES ('19106010', '5', 'FELIPE MANUEL', 'ANCACURA', 'PÉREZ', '19106010@example.com', '1');
INSERT INTO `persona` VALUES ('19106560', '3', 'EMANUEL EDUARDO', 'FUENTEALBA', 'PACHECO', '19106560@example.com', '1');
INSERT INTO `persona` VALUES ('19144476', '0', 'ÁLVARO IGNACIO', 'GARCÉS', 'REYES', '19144476@example.com', '1');
INSERT INTO `persona` VALUES ('19267734', '3', 'CRISTIAN ALBERTO', 'CAMPOS', 'ALARCÓN', '19267734@example.com', '1');
INSERT INTO `persona` VALUES ('19386472', '4', 'VICTOR MANUEL', 'SILVA', 'HORMAZÁBAL', '19386472@example.com', '1');
INSERT INTO `persona` VALUES ('19389347', '3', 'MATÍAS ALEJANDRO', 'TOLOZA', 'BOBADILLA', '19389347@example.com', '1');
INSERT INTO `persona` VALUES ('19390757', '1', 'LUIS MATÍAS', 'DÍAZ', 'VÁSQUEZ', '19390757@example.com', '1');
INSERT INTO `persona` VALUES ('19392836', '6', 'ARIEL IGNACIO', 'HERRERA', 'CASANOVA', '19392836@example.com', '1');
INSERT INTO `persona` VALUES ('19471888', '8', 'SERGIO ANDRÉS', 'MÁRQUEZ', 'FUENTES', '19471888@example.com', '1');
INSERT INTO `persona` VALUES ('19472320', '2', 'LUIS ALEXIS', 'GONZALEZ', 'GUTIERREZ', '19472320@example.com', '1');
INSERT INTO `persona` VALUES ('19473187', '6', 'FELIPE ANDRES', 'SEPULVEDA', 'SAZO', '19473187@example.com', '1');
INSERT INTO `persona` VALUES ('19473751', '3', 'EDUARDO RODRIGO', 'ALBORNOZ', 'RIVERA', '19473751@example.com', '1');
INSERT INTO `persona` VALUES ('19574405', 'K', 'CARLOS ANDRÉS', 'VÁSQUEZ', 'NORAMBUENA', '19574405@example.com', '1');
INSERT INTO `persona` VALUES ('19601739', '9', 'ALAN GONZALO', 'RAMÍREZ', 'SALAS', '19601739@example.com', '1');
INSERT INTO `persona` VALUES ('19695907', '6', 'LUIS ALBERTO', 'BUSTAMANTE', 'BUSTAMANTE', '19695907@example.com', '1');
INSERT INTO `persona` VALUES ('19697589', '6', 'JORGE NICOLÁS', 'PIZARRO', 'BRIONES', '19697589@example.com', '1');
INSERT INTO `persona` VALUES ('6847788', '3', 'CARLOS EDUARDO', 'ESPINOZA', 'MANRÍQUEZ', '6847788@example.com', '1');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- ----------------------------
-- Records of persona_comite
-- ----------------------------

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
-- Records of persona_ficha
-- ----------------------------
INSERT INTO `persona_ficha` VALUES ('1', '1', '14165260');

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
-- Records of persona_vivienda
-- ----------------------------
INSERT INTO `persona_vivienda` VALUES ('1', '78889', '14165260');

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
-- Records of piso
-- ----------------------------
INSERT INTO `piso` VALUES ('1', '1er Piso');
INSERT INTO `piso` VALUES ('2', '2do Piso');

-- ----------------------------
-- Table structure for postulaciones
-- ----------------------------
DROP TABLE IF EXISTS `postulaciones`;
CREATE TABLE `postulaciones` (
  `idpostulacion` int(11) NOT NULL AUTO_INCREMENT,
  `idgrupo` int(11) DEFAULT NULL,
  `iditem` int(11) DEFAULT NULL,
  PRIMARY KEY (`idpostulacion`),
  KEY `idgrupo` (`idgrupo`),
  KEY `iditem` (`iditem`),
  CONSTRAINT `postulaciones_fk1` FOREIGN KEY (`idgrupo`) REFERENCES `grupo` (`idgrupo`),
  CONSTRAINT `postulaciones_fk2` FOREIGN KEY (`iditem`) REFERENCES `item_postulacion` (`iditem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- ----------------------------
-- Records of postulaciones
-- ----------------------------

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
-- Records of provincia
-- ----------------------------
INSERT INTO `provincia` VALUES ('11', 'Iquique', '1');
INSERT INTO `provincia` VALUES ('14', 'Tamarugal', '1');
INSERT INTO `provincia` VALUES ('21', 'Antofagasta', '2');
INSERT INTO `provincia` VALUES ('22', 'El Loa', '2');
INSERT INTO `provincia` VALUES ('23', 'Tocopilla', '2');
INSERT INTO `provincia` VALUES ('31', 'Copiapó', '3');
INSERT INTO `provincia` VALUES ('32', 'Chañaral', '3');
INSERT INTO `provincia` VALUES ('33', 'Huasco', '3');
INSERT INTO `provincia` VALUES ('41', 'Elqui', '4');
INSERT INTO `provincia` VALUES ('42', 'Choapa', '4');
INSERT INTO `provincia` VALUES ('43', 'Limarí', '4');
INSERT INTO `provincia` VALUES ('51', 'Valparaíso', '5');
INSERT INTO `provincia` VALUES ('52', 'Isla de Pascua', '5');
INSERT INTO `provincia` VALUES ('53', 'Los Andes', '5');
INSERT INTO `provincia` VALUES ('54', 'Petorca', '5');
INSERT INTO `provincia` VALUES ('55', 'Quillota', '5');
INSERT INTO `provincia` VALUES ('56', 'San Antonio', '5');
INSERT INTO `provincia` VALUES ('57', 'San Felipe de Aconcagua', '5');
INSERT INTO `provincia` VALUES ('58', 'Marga Marga', '5');
INSERT INTO `provincia` VALUES ('61', 'Cachapoal', '6');
INSERT INTO `provincia` VALUES ('62', 'Cardenal Caro', '6');
INSERT INTO `provincia` VALUES ('63', 'Colchagua', '6');
INSERT INTO `provincia` VALUES ('71', 'Talca', '7');
INSERT INTO `provincia` VALUES ('72', 'Cauquenes', '7');
INSERT INTO `provincia` VALUES ('73', 'Curicó', '7');
INSERT INTO `provincia` VALUES ('74', 'Linares', '7');
INSERT INTO `provincia` VALUES ('81', 'Concepción', '8');
INSERT INTO `provincia` VALUES ('82', 'Arauco', '8');
INSERT INTO `provincia` VALUES ('83', 'Biobío', '8');
INSERT INTO `provincia` VALUES ('84', 'Ñuble', '8');
INSERT INTO `provincia` VALUES ('91', 'Cautín', '9');
INSERT INTO `provincia` VALUES ('92', 'Malleco', '9');
INSERT INTO `provincia` VALUES ('101', 'Llanquihue', '10');
INSERT INTO `provincia` VALUES ('102', 'Chiloé', '10');
INSERT INTO `provincia` VALUES ('103', 'Osorno', '10');
INSERT INTO `provincia` VALUES ('104', 'Palena', '10');
INSERT INTO `provincia` VALUES ('111', 'Coihaique', '11');
INSERT INTO `provincia` VALUES ('112', 'Aisén', '11');
INSERT INTO `provincia` VALUES ('113', 'Capitán Prat', '11');
INSERT INTO `provincia` VALUES ('114', 'General Carrera', '11');
INSERT INTO `provincia` VALUES ('121', 'Magallanes', '12');
INSERT INTO `provincia` VALUES ('122', 'Antártica Chilena', '12');
INSERT INTO `provincia` VALUES ('123', 'Tierra del Fuego', '12');
INSERT INTO `provincia` VALUES ('124', 'Última Esperanza', '12');
INSERT INTO `provincia` VALUES ('131', 'Santiago', '13');
INSERT INTO `provincia` VALUES ('132', 'Cordillera', '13');
INSERT INTO `provincia` VALUES ('133', 'Chacabuco', '13');
INSERT INTO `provincia` VALUES ('134', 'Maipo', '13');
INSERT INTO `provincia` VALUES ('135', 'Melipilla', '13');
INSERT INTO `provincia` VALUES ('136', 'Talagante', '13');
INSERT INTO `provincia` VALUES ('141', 'Valdivia', '14');
INSERT INTO `provincia` VALUES ('142', 'Ranco', '14');
INSERT INTO `provincia` VALUES ('151', 'Arica', '15');
INSERT INTO `provincia` VALUES ('152', 'Parinacota', '15');

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
-- Records of region
-- ----------------------------
INSERT INTO `region` VALUES ('1', 'Tarapacá', 'CL-TA');
INSERT INTO `region` VALUES ('2', 'Antofagasta', 'CL-AN');
INSERT INTO `region` VALUES ('3', 'Atacama', 'CL-AT');
INSERT INTO `region` VALUES ('4', 'Coquimbo', 'CL-CO');
INSERT INTO `region` VALUES ('5', 'Valparaíso', 'CL-VS');
INSERT INTO `region` VALUES ('6', 'Región del Libertador Gral. Bernardo O’Higgins', 'CL-LI');
INSERT INTO `region` VALUES ('7', 'Región del Maule', 'CL-ML');
INSERT INTO `region` VALUES ('8', 'Región del Biobío', 'CL-BI');
INSERT INTO `region` VALUES ('9', 'Región de la Araucanía', 'CL-AR');
INSERT INTO `region` VALUES ('10', 'Región de Los Lagos', 'CL-LL');
INSERT INTO `region` VALUES ('11', 'Región Aisén del Gral. Carlos Ibáñez del Campo', 'CL-AI');
INSERT INTO `region` VALUES ('12', 'Región de Magallanes y de la Antártica Chilena', 'CL-MA');
INSERT INTO `region` VALUES ('13', 'Región Metropolitana de Santiago', 'CL-RM');
INSERT INTO `region` VALUES ('14', 'Región de Los Ríos', 'CL-LR');
INSERT INTO `region` VALUES ('15', 'Arica y Parinacota', 'CL-AP');

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
-- Records of tipofono
-- ----------------------------
INSERT INTO `tipofono` VALUES ('1', 'Fijo');
INSERT INTO `tipofono` VALUES ('2', 'Movil');

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
-- Records of tipo_vivienda
-- ----------------------------
INSERT INTO `tipo_vivienda` VALUES ('1', 'urbano');
INSERT INTO `tipo_vivienda` VALUES ('2', 'rural');

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
-- Records of tramo
-- ----------------------------
INSERT INTO `tramo` VALUES ('1', 'Tramo 1');
INSERT INTO `tramo` VALUES ('2', 'Tramo 2');
INSERT INTO `tramo` VALUES ('3', 'Tramo 3');
INSERT INTO `tramo` VALUES ('4', 'Tramo 4');
INSERT INTO `tramo` VALUES ('5', 'Tramo 5');

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
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES ('1-9', 'Manuel', 'Recabal', 'holamundo', '1');

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

-- ----------------------------
-- Records of vivienda
-- ----------------------------
INSERT INTO `vivienda` VALUES ('78889', '2000', '89', '2016', '9', '1', '1', '90');
