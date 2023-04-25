CREATE TABLE IF NOT EXISTS `driver_vehicles` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `driver_id` int(11) NOT NULL,
    `vehicle_id` int(11) NOT NULL,
    `day` date NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;