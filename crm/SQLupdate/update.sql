---Version--3--Saniya--Gazala--------------
ALTER TABLE `discussions` ADD `is_read` TINYINT(1) NOT NULL DEFAULT '0' AFTER `contact_id`;

ALTER TABLE `notifications` ADD `relation_type` VARCHAR(100) NULL AFTER `perres`, ADD `relation` INT(5) NULL AFTER `relation_type`;