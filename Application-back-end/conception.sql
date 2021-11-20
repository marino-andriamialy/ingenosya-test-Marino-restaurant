/*
Navicat MySQL Data Transfer

Source Server         : Local
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : ingenosia

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2021-11-21 00:10:58
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `fos_user`
-- ----------------------------
DROP TABLE IF EXISTS `fos_user`;
CREATE TABLE `fos_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_957A647992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_957A6479A0D96FBF` (`email_canonical`),
  UNIQUE KEY `UNIQ_957A6479C05FB297` (`confirmation_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of fos_user
-- ----------------------------

-- ----------------------------
-- Table structure for `ingredients`
-- ----------------------------
DROP TABLE IF EXISTS `ingredients`;
CREATE TABLE `ingredients` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `unite` varchar(10) DEFAULT NULL COMMENT 'signe quantitative  unitaire de l''ingredient exemple: kg m l',
  `stock` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ingredient_index` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ingredients
-- ----------------------------
INSERT INTO `ingredients` VALUES ('1', 'tomate', 'unite', '42.00');
INSERT INTO `ingredients` VALUES ('5', 'sucre', 'gramme', '10000.00');
INSERT INTO `ingredients` VALUES ('3', 'lait', 'litre', '40.50');
INSERT INTO `ingredients` VALUES ('4', 'huiles', 'litre', '24.00');
INSERT INTO `ingredients` VALUES ('6', 'sel', 'gramme', '100.00');
INSERT INTO `ingredients` VALUES ('7', 'oignon', 'kg', '10.00');
INSERT INTO `ingredients` VALUES ('8', 'pain', 'unite', '10.00');

-- ----------------------------
-- Table structure for `menus`
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prix_unitaire` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of menus
-- ----------------------------
INSERT INTO `menus` VALUES ('1', 'humberger', '200.50');
INSERT INTO `menus` VALUES ('2', 'sandwich', '20.00');
INSERT INTO `menus` VALUES ('3', 'pizza', '50.00');

-- ----------------------------
-- Table structure for `menus_ingredients`
-- ----------------------------
DROP TABLE IF EXISTS `menus_ingredients`;
CREATE TABLE `menus_ingredients` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `menus_id` int(10) DEFAULT NULL,
  `ingredient_id` int(10) DEFAULT NULL,
  `ingredient_quantite` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_menu_ingredient` (`menus_id`),
  KEY `fk_ingredient_menu` (`ingredient_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of menus_ingredients
-- ----------------------------
INSERT INTO `menus_ingredients` VALUES ('1', '3', '4', '50.00');
INSERT INTO `menus_ingredients` VALUES ('2', '3', '7', '10.00');
INSERT INTO `menus_ingredients` VALUES ('3', '3', '6', '3.00');
INSERT INTO `menus_ingredients` VALUES ('4', '3', '3', '3.00');
INSERT INTO `menus_ingredients` VALUES ('5', '3', '5', '1.00');
INSERT INTO `menus_ingredients` VALUES ('6', '1', '5', '6.00');
INSERT INTO `menus_ingredients` VALUES ('7', '1', '7', '3.00');
INSERT INTO `menus_ingredients` VALUES ('8', '2', '8', '3.00');
INSERT INTO `menus_ingredients` VALUES ('9', '2', '4', '20.00');

-- ----------------------------
-- Table structure for `product`
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of product
-- ----------------------------

-- ----------------------------
-- Table structure for `repas`
-- ----------------------------
DROP TABLE IF EXISTS `repas`;
CREATE TABLE `repas` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `creer_le` datetime NOT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of repas
-- ----------------------------
INSERT INTO `repas` VALUES ('1', '2121-11-19 08:42:40', '500.50', 'lumch');
INSERT INTO `repas` VALUES ('2', '2121-11-19 08:51:46', '200.00', 'dejeunee');
INSERT INTO `repas` VALUES ('3', '2121-11-19 08:53:31', '300.00', 'soir');
INSERT INTO `repas` VALUES ('4', '2121-11-20 13:31:59', '200.00', 'brunchs');

-- ----------------------------
-- Table structure for `repas_menus`
-- ----------------------------
DROP TABLE IF EXISTS `repas_menus`;
CREATE TABLE `repas_menus` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `menu_id` int(10) DEFAULT NULL,
  `repas_id` int(10) DEFAULT NULL,
  `menus_quantite` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_menu_repas` (`menu_id`),
  KEY `fk_repas_menu` (`repas_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of repas_menus
-- ----------------------------
INSERT INTO `repas_menus` VALUES ('1', '2', '3', '3');
INSERT INTO `repas_menus` VALUES ('2', '3', '3', '2');
INSERT INTO `repas_menus` VALUES ('3', '2', '2', '2');
INSERT INTO `repas_menus` VALUES ('4', '3', '2', '2');
INSERT INTO `repas_menus` VALUES ('5', '2', '1', '2');
INSERT INTO `repas_menus` VALUES ('6', '2', '4', '2');

-- ----------------------------
-- Table structure for `ventes`
-- ----------------------------
DROP TABLE IF EXISTS `ventes`;
CREATE TABLE `ventes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `repas_id` int(10) DEFAULT NULL,
  `quantite` int(10) DEFAULT NULL,
  `emballages` tinyint(4) DEFAULT NULL,
  `serviettes` tinyint(4) DEFAULT NULL,
  `couvert` tinyint(4) DEFAULT NULL,
  `creer_le` datetime NOT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ventes_repas` (`repas_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ventes
-- ----------------------------
INSERT INTO `ventes` VALUES ('1', '1', '2', '0', '2', '2', '2021-11-02 12:39:33', '2.00');
INSERT INTO `ventes` VALUES ('2', '1', '2', null, null, null, '2121-11-19 10:15:30', '20.00');
INSERT INTO `ventes` VALUES ('6', '4', '2', '1', '0', '1', '2121-11-20 20:38:13', '52.00');
INSERT INTO `ventes` VALUES ('5', '4', '2', '1', '0', '1', '2121-11-20 19:27:00', '70.00');
