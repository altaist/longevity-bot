
CREATE TABLE `form_med_1` ( `userId` INT NOT NULL , `temperature` DECIMAL(3,1)  , `pressure1` MEDIUMINT  , `pressure2` MEDIUMINT  , `glucose` SMALLINT , `saturation` TINYINT  , `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ) ENGINE = InnoDB;
