CREATE TABLE IF NOT EXISTS `#__mc2016_inscripcion` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`last_name` VARCHAR(50)  NOT NULL ,
`name` VARCHAR(50)  NOT NULL ,
`gender` INT NOT NULL ,
`birthdate` DATE NOT NULL DEFAULT '0000-00-00',
`event` INT NOT NULL ,
`email` VARCHAR(256)  NOT NULL ,
`phone` VARCHAR(100)  NOT NULL ,
`tshirt` INT NOT NULL ,
`emergency_contact` VARCHAR(100)  NOT NULL ,
`emergency_phone` VARCHAR(100)  NOT NULL ,
`allergies` TEXT NOT NULL ,
`blood_type` INT NOT NULL ,
`hotel` TEXT NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__mc2016_gender` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`name` VARCHAR(100)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__mc2016_tshirt` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`name` VARCHAR(100)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__mc2016_event` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`name` VARCHAR(100)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__mc2016_blood_type` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`name` VARCHAR(100)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

INSERT INTO `#__mc2016_gender` (`id`, `name`) VALUES ('1', 'M'), ('2', 'F');

INSERT INTO `#__mc2016_blood_type` (`id`, `name`) VALUES ('1', 'A+'), ('2', 'A-'), ('3', 'B+'), ('4', 'B-'), ('5', 'AB+'), ('6', 'AB-'), ('7', 'O+'), ('8', 'O-');

INSERT INTO `#__mc2016_event` (`id`, `name`) VALUES ('1', 'Aquathlon'), ('2', 'Sprint'), ('3', 'Standard'), ('4', 'Aquathlon + Sprint'), ('5', 'Aquathlon + Standard'), ('6', 'Aquathlon + Sprint + Standard'), ('7', 'Junior'), ('8', 'U23'), ('9', 'Elite'), ('10', 'U23/Junior Relay');

INSERT INTO `#__mc2016_tshirt` (`id`, `name`) VALUES ('1', 'XCH'), ('2', 'CH'), ('3', 'MED'), ('4', 'LARGE'), ('5', 'XLARGE'), ('6', 'XXLARGE');