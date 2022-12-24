/* Alter table */

ALTER TABLE `app_person` ADD `energy` DECIMAL(6,2) NOT NULL DEFAULT '0' AFTER `jsonData`;
ALTER TABLE `app_person` CHANGE `energy` `energy` DECIMAL(4,1) NOT NULL DEFAULT '0.00';