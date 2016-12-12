
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- card
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `card`;

CREATE TABLE `card`
(
    `card_id` INTEGER NOT NULL AUTO_INCREMENT,
    `card_name` VARCHAR(100) NOT NULL,
    `required_count` INTEGER NOT NULL,
    PRIMARY KEY (`card_id`),
    UNIQUE INDEX `cards_card_id_uindex` (`card_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- card_to_map
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `card_to_map`;

CREATE TABLE `card_to_map`
(
    `card_to_maps_id` INTEGER NOT NULL AUTO_INCREMENT,
    `card_id` INTEGER NOT NULL,
    `map_id` INTEGER NOT NULL,
    PRIMARY KEY (`card_to_maps_id`),
    UNIQUE INDEX `cards_to_maps_card_to_maps_id_uindex` (`card_to_maps_id`),
    INDEX `card_id_fk` (`card_id`),
    INDEX `map_id_fk` (`map_id`),
    CONSTRAINT `card_id_fk`
        FOREIGN KEY (`card_id`)
        REFERENCES `card` (`card_id`),
    CONSTRAINT `map_id_fk`
        FOREIGN KEY (`map_id`)
        REFERENCES `map` (`map_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- map
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `map`;

CREATE TABLE `map`
(
    `map_id` INTEGER NOT NULL AUTO_INCREMENT,
    `map_name` VARCHAR(100) NOT NULL,
    `map_level` INTEGER DEFAULT 0 NOT NULL,
    `map_tier` INTEGER DEFAULT 0 NOT NULL,
    `map_layout` VARCHAR(5) DEFAULT 'X' NOT NULL,
    `map_difficulty` INTEGER DEFAULT 0 NOT NULL,
    `map_tileset` VARCHAR(100),
    `map_description` VARCHAR(500) DEFAULT 'No Description Available' NOT NULL,
    `map_num_bosses` INTEGER DEFAULT 0,
    PRIMARY KEY (`map_id`),
    UNIQUE INDEX `maps_map_id_uindex` (`map_id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
