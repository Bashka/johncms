ALTER TABLE `downfiles` CHANGE `size` `size` INT( 11 ) NOT NULL DEFAULT '0';
ALTER TABLE `downpath` CHANGE `dost` `dost` INT( 11 ) NOT NULL DEFAULT '0';
ALTER TABLE `downpath` CHANGE `types` `types` VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';
ALTER TABLE `downpath` ADD INDEX `ref` ( `refid` );
ALTER TABLE `downpath` ADD FULLTEXT `way` (`way`);
ALTER TABLE `downpath` ADD INDEX `position` ( `position` );
ALTER TABLE `downfiles` ADD INDEX `pathid` ( `pathid` );
ALTER TABLE `downfiles` ADD INDEX `time` ( `time` );
ALTER TABLE `downfiles` ADD FULLTEXT `way` (`way`);
ALTER TABLE `downfiles` ADD INDEX `type_status` ( `type` , `status` );