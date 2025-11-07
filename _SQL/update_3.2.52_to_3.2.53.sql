-- SQL Update for GestSup !!! If you are not in lastest version, all previous scripts must be passed before !!! ;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET default_storage_engine=INNODB;

-- update GestSup version number
UPDATE `tparameters` SET `version`='3.2.53';

ALTER TABLE `tparameters` ROW_FORMAT=DYNAMIC;

ALTER TABLE `tparameters` ADD `ticket_filter_type` INT(1) NOT NULL AFTER `ticket_recurrent_create`;
ALTER TABLE `tcategory` ADD `type` INT(10) NOT NULL AFTER `technician_group`;
ALTER TABLE `tcategory` ADD INDEX(`type`);

ALTER TABLE `trights` ADD `side_group` INT(1) NOT NULL COMMENT 'Affiche le menu tickets de groupe' AFTER `side_your_observer`;