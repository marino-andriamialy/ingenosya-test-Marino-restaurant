CREATE TABLE `ingredients` (
`id` int(10) NOT NULL,
`nom` varchar(255) NOT NULL,
`unite` varchar(10) NULL COMMENT 'signe quantitative  unitaire de l\'ingredient exemple: kg m l',
`stock` decimal(10,2) NULL,
PRIMARY KEY (`id`) ,
UNIQUE INDEX `ingredient_index` (`id`)
);

CREATE TABLE `menus` (
`id` int(10) NOT NULL,
`nom` varchar(255) NOT NULL,
`prix_unitaire` decimal(10,2) NULL,
PRIMARY KEY (`id`) 
);

CREATE TABLE `repas` (
`id` int(10) NOT NULL,
`creer_le` datetime NOT NULL,
`prix` decimal(10,2) NULL,
PRIMARY KEY (`id`) 
);

CREATE TABLE `menus_ingredients` (
`menus_id` int(10) NULL,
`ingredient_id` int(10) NULL,
`id` int(10) NOT NULL,
`ingredient_quantite` decimal(10,2) NULL,
PRIMARY KEY (`id`) 
);

CREATE TABLE `repas_menus` (
`id` int(10) NOT NULL,
`menu_id` int(10) NULL,
`repas_id` int(10) NULL,
`menus_quantite` int(10) NULL,
PRIMARY KEY (`id`) 
);

CREATE TABLE `ventes` (
`id` int(10) NOT NULL,
`repas_id` int(10) NULL,
`quantite` int(10) NULL,
`emballages` tinyint(4) NULL,
`serviettes` tinyint(4) NULL,
`couvert` tinyint(4) NULL,
PRIMARY KEY (`id`) 
);


ALTER TABLE `menus_ingredients` ADD CONSTRAINT `fk_menu_ingredient` FOREIGN KEY (`menus_id`) REFERENCES `menus` (`id`);
ALTER TABLE `menus_ingredients` ADD CONSTRAINT `fk_ingredient_menu` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`);
ALTER TABLE `repas_menus` ADD CONSTRAINT `fk_menu_repas` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`);
ALTER TABLE `repas_menus` ADD CONSTRAINT `fk_repas_menu` FOREIGN KEY (`repas_id`) REFERENCES `repas` (`id`);
ALTER TABLE `ventes` ADD CONSTRAINT `fk_ventes_repas` FOREIGN KEY (`repas_id`) REFERENCES `repas` (`id`);

