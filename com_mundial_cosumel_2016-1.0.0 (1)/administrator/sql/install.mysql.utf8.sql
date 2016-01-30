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