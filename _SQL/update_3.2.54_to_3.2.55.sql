-- SQL Update for GestSup !!! If you are not in lastest version, all previous scripts must be passed before !!! ;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET default_storage_engine=INNODB;

-- update GestSup version number
UPDATE `tparameters` SET `version`='3.2.55';

ALTER TABLE `trights` ADD `dashboard_col_technician` INT(1) NOT NULL COMMENT 'Affiche la colonne technicien dans la liste des tickets' AFTER `dashboard_firstname`;
UPDATE `trights` SET `dashboard_col_technician`=2;

ALTER TABLE `tstates` ADD `hide` INT(1) NOT NULL AFTER `meta`;

ALTER TABLE `tparameters` ADD `tab_name` VARCHAR(256) NOT NULL AFTER `login_background`;