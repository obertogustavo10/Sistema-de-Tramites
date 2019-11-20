/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MariaDB
 Source Server Version : 100406
 Source Host           : localhost:3306
 Source Schema         : sistemas

 Target Server Type    : MariaDB
 Target Server Version : 100406
 File Encoding         : 65001

 Date: 19/11/2019 21:04:50
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for sistema_areas
-- ----------------------------
DROP TABLE IF EXISTS `sistema_areas`;
CREATE TABLE `sistema_areas`  (
  `idarea` smallint(6) NOT NULL AUTO_INCREMENT,
  `ncarea` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descarea` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `activo` smallint(6) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idarea`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sistema_areas
-- ----------------------------
INSERT INTO `sistema_areas` VALUES (1, 'SISTEMAS', 'Sistemas', 1);

-- ----------------------------
-- Table structure for sistema_familias
-- ----------------------------
DROP TABLE IF EXISTS `sistema_familias`;
CREATE TABLE `sistema_familias`  (
  `idfamilias` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `descripcion` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`idfamilias`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sistema_familias
-- ----------------------------
INSERT INTO `sistema_familias` VALUES (1, 'administrador total', 'administrador total');

-- ----------------------------
-- Table structure for sistema_menu_area
-- ----------------------------
DROP TABLE IF EXISTS `sistema_menu_area`;
CREATE TABLE `sistema_menu_area`  (
  `fk_idmenu` int(11) NOT NULL,
  `fk_idarea` int(11) NOT NULL,
  INDEX `fk_idmenu`(`fk_idmenu`) USING BTREE,
  INDEX `fk_idarea`(`fk_idarea`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sistema_menu_area
-- ----------------------------
INSERT INTO `sistema_menu_area` VALUES (20, 1);
INSERT INTO `sistema_menu_area` VALUES (21, 1);
INSERT INTO `sistema_menu_area` VALUES (10, 1);
INSERT INTO `sistema_menu_area` VALUES (3, 1);
INSERT INTO `sistema_menu_area` VALUES (6, 1);
INSERT INTO `sistema_menu_area` VALUES (9, 1);
INSERT INTO `sistema_menu_area` VALUES (12, 1);
INSERT INTO `sistema_menu_area` VALUES (1, 1);
INSERT INTO `sistema_menu_area` VALUES (8, 1);
INSERT INTO `sistema_menu_area` VALUES (11, 1);
INSERT INTO `sistema_menu_area` VALUES (27, 1);
INSERT INTO `sistema_menu_area` VALUES (7, 1);
INSERT INTO `sistema_menu_area` VALUES (24, 1);
INSERT INTO `sistema_menu_area` VALUES (19, 1);
INSERT INTO `sistema_menu_area` VALUES (23, 1);
INSERT INTO `sistema_menu_area` VALUES (5, 1);
INSERT INTO `sistema_menu_area` VALUES (22, 1);
INSERT INTO `sistema_menu_area` VALUES (17, 1);
INSERT INTO `sistema_menu_area` VALUES (16, 1);
INSERT INTO `sistema_menu_area` VALUES (29, 1);
INSERT INTO `sistema_menu_area` VALUES (30, 1);

-- ----------------------------
-- Table structure for sistema_menues
-- ----------------------------
DROP TABLE IF EXISTS `sistema_menues`;
CREATE TABLE `sistema_menues`  (
  `idmenu` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT '',
  `orden` int(11) NULL DEFAULT 0,
  `nombre` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `id_padre` int(11) NULL DEFAULT 0,
  `fk_idpatente` int(11) NULL DEFAULT NULL,
  `css` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT '0',
  `activo` tinyint(1) NULL DEFAULT 0,
  PRIMARY KEY (`idmenu`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 31 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sistema_menues
-- ----------------------------
INSERT INTO `sistema_menues` VALUES (1, '/legajo/alumnos', 2, 'Alumnos', 12, NULL, '', 1);
INSERT INTO `sistema_menues` VALUES (2, '', 0, 'Previo a Inscripción', 0, NULL, 'fa fa-folder fa-fw', 1);
INSERT INTO `sistema_menues` VALUES (3, '/home', -10000, 'Inicio', 0, NULL, 'fa fa-fw fa-home', 1);
INSERT INTO `sistema_menues` VALUES (4, '', 99, 'Configuración', 0, NULL, 'fa fa-cogs fa-fw', 1);
INSERT INTO `sistema_menues` VALUES (5, '/', 1, 'Cronograma', 2, NULL, '', 1);
INSERT INTO `sistema_menues` VALUES (6, '/previoinscripcion/ofertadecursada', 0, 'Oferta de Cursada', 2, NULL, '', 1);
INSERT INTO `sistema_menues` VALUES (7, '', 100, 'Sistema', 0, NULL, 'fa fa-lock fa-fw', 1);
INSERT INTO `sistema_menues` VALUES (8, '/grupos', 3, 'Áreas de trabajo', 7, NULL, '', 1);
INSERT INTO `sistema_menues` VALUES (9, '/usuarios', 1, 'Usuarios', 7, NULL, '', 1);
INSERT INTO `sistema_menues` VALUES (10, '/permisos', 2, 'Permisos', 7, NULL, '', 1);
INSERT INTO `sistema_menues` VALUES (11, '/sistema/menu', 4, 'Menú', 7, NULL, '', 1);
INSERT INTO `sistema_menues` VALUES (12, '', 3, 'Legajo electrónico', 0, NULL, 'fa fa-folder fa-fw', 1);
INSERT INTO `sistema_menues` VALUES (13, '/legajo/personal', 2, 'Personal Fmed', 12, NULL, '', 1);
INSERT INTO `sistema_menues` VALUES (14, '', 0, 'Seguimiento Inscripción', 0, NULL, 'fa fa-folder fa-fw', 1);
INSERT INTO `sistema_menues` VALUES (15, '', 0, 'Creación de Actividades', 0, NULL, 'fa fa-university', 1);
INSERT INTO `sistema_menues` VALUES (20, '/publico/situacionimpositiva', 4, 'Situación impositiva', 4, NULL, '', 1);
INSERT INTO `sistema_menues` VALUES (21, '/publico/paises', 0, 'Países', 4, NULL, NULL, 1);
INSERT INTO `sistema_menues` VALUES (22, '/actividad/modulos', 3, 'Módulos', 15, NULL, '', 1);
INSERT INTO `sistema_menues` VALUES (23, '/actividad/materias', 2, 'Materias', 15, NULL, '', 1);
INSERT INTO `sistema_menues` VALUES (24, '/publico/sedes', 5, 'Sedes', 4, NULL, '', 1);
INSERT INTO `sistema_menues` VALUES (27, '/seguimiento/inscripciones', 0, 'Inscripciones', 14, NULL, NULL, 1);
INSERT INTO `sistema_menues` VALUES (28, '/publico/tipodocumento', 0, 'Tipos de documento', 4, NULL, NULL, 1);
INSERT INTO `sistema_menues` VALUES (29, '', 0, 'Certificados', 0, NULL, 'fa fa-certificate', 1);
INSERT INTO `sistema_menues` VALUES (30, '/certificados', 0, 'Listado de certificados', 29, NULL, '', 1);

-- ----------------------------
-- Table structure for sistema_paquetes
-- ----------------------------
DROP TABLE IF EXISTS `sistema_paquetes`;
CREATE TABLE `sistema_paquetes`  (
  `paqueteid` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`paqueteid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sistema_patente_familia
-- ----------------------------
DROP TABLE IF EXISTS `sistema_patente_familia`;
CREATE TABLE `sistema_patente_familia`  (
  `fk_idpatente` int(11) NOT NULL,
  `fk_idfamilia` int(11) NOT NULL,
  INDEX `fk_idpatente`(`fk_idpatente`) USING BTREE,
  INDEX `fk_idfamilia`(`fk_idfamilia`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sistema_patente_familia
-- ----------------------------
INSERT INTO `sistema_patente_familia` VALUES (48, 3);
INSERT INTO `sistema_patente_familia` VALUES (70, 4);
INSERT INTO `sistema_patente_familia` VALUES (71, 4);
INSERT INTO `sistema_patente_familia` VALUES (72, 4);
INSERT INTO `sistema_patente_familia` VALUES (73, 4);
INSERT INTO `sistema_patente_familia` VALUES (1, 2);
INSERT INTO `sistema_patente_familia` VALUES (2, 2);
INSERT INTO `sistema_patente_familia` VALUES (5, 2);
INSERT INTO `sistema_patente_familia` VALUES (1, 1);
INSERT INTO `sistema_patente_familia` VALUES (2, 1);
INSERT INTO `sistema_patente_familia` VALUES (3, 1);
INSERT INTO `sistema_patente_familia` VALUES (4, 1);
INSERT INTO `sistema_patente_familia` VALUES (5, 1);
INSERT INTO `sistema_patente_familia` VALUES (6, 1);
INSERT INTO `sistema_patente_familia` VALUES (7, 1);
INSERT INTO `sistema_patente_familia` VALUES (8, 1);
INSERT INTO `sistema_patente_familia` VALUES (9, 1);
INSERT INTO `sistema_patente_familia` VALUES (10, 1);
INSERT INTO `sistema_patente_familia` VALUES (11, 1);
INSERT INTO `sistema_patente_familia` VALUES (12, 1);
INSERT INTO `sistema_patente_familia` VALUES (13, 1);
INSERT INTO `sistema_patente_familia` VALUES (14, 1);
INSERT INTO `sistema_patente_familia` VALUES (15, 1);
INSERT INTO `sistema_patente_familia` VALUES (16, 1);
INSERT INTO `sistema_patente_familia` VALUES (17, 1);
INSERT INTO `sistema_patente_familia` VALUES (18, 1);
INSERT INTO `sistema_patente_familia` VALUES (19, 1);
INSERT INTO `sistema_patente_familia` VALUES (20, 1);
INSERT INTO `sistema_patente_familia` VALUES (28, 1);
INSERT INTO `sistema_patente_familia` VALUES (29, 1);
INSERT INTO `sistema_patente_familia` VALUES (30, 1);
INSERT INTO `sistema_patente_familia` VALUES (31, 1);
INSERT INTO `sistema_patente_familia` VALUES (32, 1);
INSERT INTO `sistema_patente_familia` VALUES (36, 1);
INSERT INTO `sistema_patente_familia` VALUES (37, 1);
INSERT INTO `sistema_patente_familia` VALUES (39, 1);
INSERT INTO `sistema_patente_familia` VALUES (40, 1);
INSERT INTO `sistema_patente_familia` VALUES (43, 1);
INSERT INTO `sistema_patente_familia` VALUES (44, 1);
INSERT INTO `sistema_patente_familia` VALUES (45, 1);
INSERT INTO `sistema_patente_familia` VALUES (70, 1);
INSERT INTO `sistema_patente_familia` VALUES (71, 1);
INSERT INTO `sistema_patente_familia` VALUES (72, 1);
INSERT INTO `sistema_patente_familia` VALUES (73, 1);
INSERT INTO `sistema_patente_familia` VALUES (74, 1);

-- ----------------------------
-- Table structure for sistema_patentes
-- ----------------------------
DROP TABLE IF EXISTS `sistema_patentes`;
CREATE TABLE `sistema_patentes`  (
  `idpatente` int(11) NOT NULL,
  `tipo` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `submodulo` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT '',
  `modulo` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT '',
  `log_operacion` smallint(6) NOT NULL DEFAULT 0,
  `descripcion` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`idpatente`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sistema_patentes
-- ----------------------------
INSERT INTO `sistema_patentes` VALUES (1, 'CONSULTA', 'Permisos', 'PERMISOSCONSULTA', 'Sistema', 1, 'Consulta de permisos');
INSERT INTO `sistema_patentes` VALUES (2, 'ALTA', 'Permisos', 'PERMISOSALTA', 'Sistema', 1, 'Alta de familia');
INSERT INTO `sistema_patentes` VALUES (3, 'EDITAR', 'Permisos', 'PERMISOSMODIFICACION', 'Sistema', 1, 'Modificación de familia de permisos');
INSERT INTO `sistema_patentes` VALUES (4, 'BAJA', 'Permisos', 'PERMISOSBAJA', 'Sistema', 1, 'Baja de familia de permisos');
INSERT INTO `sistema_patentes` VALUES (5, 'BAJA', 'Grupo de usuarios', 'GRUPOBAJA', 'Sistema', 1, 'Baja de grupo de usuarios');
INSERT INTO `sistema_patentes` VALUES (6, 'CONSULTA', 'Grupo de usuarios', 'GRUPOCONSULTA', 'Sistema', 1, 'Consulta de grupo de usuarios');
INSERT INTO `sistema_patentes` VALUES (7, 'EDITAR', 'Grupo de usuarios', 'GRUPOMODIFICACION', 'Sistema', 1, 'Modificación de grupos de usuarios');
INSERT INTO `sistema_patentes` VALUES (8, 'ALTA', 'Grupo de usuarios', 'GRUPOALTA', 'Sistema', 1, 'Alta de grupos de usuarios');
INSERT INTO `sistema_patentes` VALUES (9, 'EDITAR', 'Usuario', 'USUARIOASIGNARGRUPO', 'Sistema', 1, 'Agrega grupos a un usuario');
INSERT INTO `sistema_patentes` VALUES (10, 'ALTA', 'Usuario', 'USUARIOALTA', 'Sistema', 1, 'Nuevo usuario');
INSERT INTO `sistema_patentes` VALUES (11, 'BAJA', 'Usuario', 'USUARIOELIMINAR', 'Sistema', 1, 'Eliminar usuario');
INSERT INTO `sistema_patentes` VALUES (12, 'EDITAR', 'Usuario', 'USUARIOMODIFICAR', 'Sistema', 1, 'Modificar usuario');
INSERT INTO `sistema_patentes` VALUES (13, 'EDITAR', 'Usuario', 'USUARIOAGREGARPERMISO', 'Sistema', 1, 'Agrega permisos dentro de la pantalla del usuario');
INSERT INTO `sistema_patentes` VALUES (14, 'BAJA', 'Usuario', 'USUARIOELIMINARPERMISO', 'Sistema', 1, 'Eliminar un permiso del usuario');
INSERT INTO `sistema_patentes` VALUES (15, 'CONSULTA', 'Usuario', 'USUARIOGRUPOGRILLA', 'Sistema', 1, 'Muestra la grilla de grupos de un usuario');
INSERT INTO `sistema_patentes` VALUES (16, 'EDITAR', 'Usuario', 'USUARIOGRUPOAGREGAR', 'Sistema', 1, 'Agrega un grupo para el usuario');
INSERT INTO `sistema_patentes` VALUES (17, 'BAJA', 'Usuario', 'USUARIOGRUPOELIMINAR', 'Sistema', 1, 'Elimina un grupo del usuario');
INSERT INTO `sistema_patentes` VALUES (18, 'EDITAR', 'Permisos', 'PERMISOSAGREGARPATENTE', 'Sistema', 1, 'Agrega patente a un permiso');
INSERT INTO `sistema_patentes` VALUES (19, 'BAJA', 'Permisos', 'PERMISOSELIMINARPATENTE', 'Sistema', 1, 'Elimina patente a un permiso');
INSERT INTO `sistema_patentes` VALUES (20, 'CONSULTA', 'Usuaurio', 'USUARIOCONSULTA', 'Sistema', 1, 'Consulta la lista de usuarios');
INSERT INTO `sistema_patentes` VALUES (28, 'ALTA', 'Incidente', 'INCIDENTEALTA', 'Incidente', 1, 'Nuevo incidente');
INSERT INTO `sistema_patentes` VALUES (29, 'CONSULTA', 'Incidente', 'INCIDENTECONSULTA', 'Incidente', 1, 'Listado de incidentes');
INSERT INTO `sistema_patentes` VALUES (30, 'EDITAR', 'Persona', 'PERSONAMODIFICACION', 'Panel de control ', 1, 'Modificar  una persona');
INSERT INTO `sistema_patentes` VALUES (31, 'ALTA', 'Persona', 'PERSONAALTA', 'Panel de control', 1, 'Agrega una nueva persona');
INSERT INTO `sistema_patentes` VALUES (32, 'CONSULTA', 'Persona', 'PERSONACONSULTA', 'Panel de control', 1, 'Listado de Personas');
INSERT INTO `sistema_patentes` VALUES (36, 'ALTA', 'Categoria', 'INCIDENTECATEGORIAALTA', 'Incidente', 1, 'Agrega una nueva categoria al incidente');
INSERT INTO `sistema_patentes` VALUES (37, 'CONSULTA', 'Categoria', 'INCIDENTECATEGORIACONSULTA', 'Incidente', 1, 'Listado de categorias para un incidente');
INSERT INTO `sistema_patentes` VALUES (39, 'CONSULTA', 'Cargo', 'CARGOCONSULTA', 'Panel de control', 1, 'Listado de cargos');
INSERT INTO `sistema_patentes` VALUES (40, 'EDITAR', 'Incidente', 'INCIDENTEMODIFICACION', 'Incidente', 1, 'Modifica un incidente');
INSERT INTO `sistema_patentes` VALUES (43, 'ALTA', 'Cargo', 'CARGOALTA', 'Panel de control', 1, 'Agrega un cargo');
INSERT INTO `sistema_patentes` VALUES (44, 'EDITAR', 'Cargo', 'CARGOMODIFICACION', 'Panel de control', 1, 'Modifica un cargo');
INSERT INTO `sistema_patentes` VALUES (45, 'BAJA', 'Cargo', 'CARGOELIMINAR', 'Panel de control', 1, 'Elimina un cargo');
INSERT INTO `sistema_patentes` VALUES (47, 'EDITAR', 'Incidente', 'INCIDENTESEGUIMIENTO', 'Incidente', 1, 'Modifica un seguimiento');
INSERT INTO `sistema_patentes` VALUES (48, 'EDITAR', 'Incidente', 'INCIDENTE_ADMINISTRADOR', 'Incidente', 1, 'Administrador de incidentes');
INSERT INTO `sistema_patentes` VALUES (70, 'CONSULTA', 'Menu', 'MENUCONSULTA', 'Sistema', 1, 'Listado del menu del sistema');
INSERT INTO `sistema_patentes` VALUES (71, 'ALTA', 'Menu', 'MENUALTA', 'Sistema', 1, 'Agrega un nuevo elemento de menu');
INSERT INTO `sistema_patentes` VALUES (72, 'EDITAR', 'Menu', 'MENUMODIFICACION', 'Sistema', 1, 'Modifica un elemento de menu');
INSERT INTO `sistema_patentes` VALUES (73, 'BAJA', 'Menu', 'MENUELIMINAR', 'SIstema', 1, 'Elimina un elemento de menu');
INSERT INTO `sistema_patentes` VALUES (74, 'CONSULTA', 'Sistema', 'SIMULARALUMNO', 'Sistema', 1, 'Permite al administrador simular el login como alu');

-- ----------------------------
-- Table structure for sistema_usuario_familia
-- ----------------------------
DROP TABLE IF EXISTS `sistema_usuario_familia`;
CREATE TABLE `sistema_usuario_familia`  (
  `fk_idusuario` int(11) NOT NULL,
  `fk_idfamilia` int(11) NOT NULL,
  `fk_idarea` int(11) NOT NULL,
  INDEX `fk_idusuario`(`fk_idusuario`) USING BTREE,
  INDEX `fk_idfamilia`(`fk_idfamilia`) USING BTREE,
  INDEX `fk_idarea`(`fk_idarea`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sistema_usuario_familia
-- ----------------------------
INSERT INTO `sistema_usuario_familia` VALUES (1, 1, 1);

-- ----------------------------
-- Table structure for sistema_usuarios
-- ----------------------------
DROP TABLE IF EXISTS `sistema_usuarios`;
CREATE TABLE `sistema_usuarios`  (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `clave` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `ultimo_ingreso` timestamp(0) NOT NULL DEFAULT current_timestamp() ON UPDATE CURRENT_TIMESTAMP,
  `token` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT 'current_timestamp()',
  `root` smallint(6) NOT NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `cantidad_bloqueo` int(11) NULL DEFAULT NULL,
  `areapredeterminada` smallint(6) NULL DEFAULT NULL,
  `activo` smallint(6) NULL DEFAULT NULL,
  PRIMARY KEY (`idusuario`) USING BTREE,
  UNIQUE INDEX `usuario`(`usuario`) USING BTREE,
  UNIQUE INDEX `email`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sistema_usuarios
-- ----------------------------
INSERT INTO `sistema_usuarios` VALUES (1, 'admin', 'Laura', 'Hernandez', 'lalalejandrahc@gmail.com', '1234', '2019-09-17 17:27:10', 'current_timestamp()', 1, '2019-09-17 16:05:57', 0, 1, 1);

SET FOREIGN_KEY_CHECKS = 1;
