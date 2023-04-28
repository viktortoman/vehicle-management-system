CREATE TABLE IF NOT EXISTS `cargos` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `type` varchar(255) NOT NULL,
    `customer` varchar(255) NOT NULL,
    `number_of_passengers` int(11) NULL,
    `cargo_date` datetime NOT NULL,
    `place` varchar(255) NULL,
    `weight_of_load` int(11) NULL,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` datetime NULL,
    `deleted_at` datetime NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;