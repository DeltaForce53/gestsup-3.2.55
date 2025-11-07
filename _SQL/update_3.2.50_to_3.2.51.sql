-- SQL Update for GestSup !!! If you are not in lastest version, all previous scripts must be passed before !!! ;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET default_storage_engine=INNODB;

-- update GestSup version number
UPDATE `tparameters` SET `version`='3.2.51';

ALTER TABLE `trights` ADD `asset_list_col_tenant` INT(1) NOT NULL COMMENT 'Affiche une colonne avec le nom des locataires sur la liste des équipements' AFTER `asset_list_col_sn_manufacturer`;
ALTER TABLE `trights` ADD `asset_list_tenant_only` INT(1) NOT NULL COMMENT 'Affiche uniquement les équipements associé au locataire de l\'utilisateur connecté' AFTER `asset_list_company_only`;

ALTER TABLE `tparameters` ADD `cron_weekly` INT(2) NOT NULL AFTER `cron_daily`;
ALTER TABLE tparameters ROW_FORMAT=DYNAMIC;