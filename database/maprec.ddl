CREATE TABLE card
(
    card_id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    card_name VARCHAR(100) NOT NULL,
    required_count INT(11) NOT NULL
);
CREATE UNIQUE INDEX cards_card_id_uindex ON card (card_id);
CREATE TABLE card_to_map
(
    card_to_maps_id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    card_id INT(11) NOT NULL,
    map_id INT(11) NOT NULL,
    CONSTRAINT card_id_fk FOREIGN KEY (card_id) REFERENCES card (card_id),
    CONSTRAINT map_id_fk FOREIGN KEY (map_id) REFERENCES map (map_id)
);
CREATE UNIQUE INDEX cards_to_maps_card_to_maps_id_uindex ON card_to_map (card_to_maps_id);
CREATE INDEX card_id_fk ON card_to_map (card_id);
CREATE INDEX map_id_fk ON card_to_map (map_id);
CREATE TABLE map
(
    map_id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    map_name VARCHAR(100) NOT NULL,
    map_level INT(11) DEFAULT '0' NOT NULL,
    map_tier INT(11) DEFAULT '0' NOT NULL,
    map_layout VARCHAR(5) DEFAULT 'X' NOT NULL,
    map_difficulty INT(11) DEFAULT '0' NOT NULL,
    map_tileset VARCHAR(100),
    map_description VARCHAR(500) DEFAULT 'No Description Available' NOT NULL,
    map_num_bosses INT(11) DEFAULT '0'
);
CREATE UNIQUE INDEX maps_map_id_uindex ON map (map_id);