DROP TABLE IF EXISTS `payrolls`, `payslips`, `payroll_item`, `payslip_item`;

DELETE FROM `appconfig` WHERE `appconfig`.`name` = 'payroll_prefix';
DELETE FROM `appconfig` WHERE `appconfig`.`name` = 'payroll_series';
DELETE FROM `appconfig` WHERE `appconfig`.`name` = 'payslip_prefix';
DELETE FROM `appconfig` WHERE `appconfig`.`name` = 'payslip_series';


DELETE FROM `permissions` WHERE `permissions`.`key` = 'payrolls';
DELETE FROM `permissions` WHERE `permissions`.`key` = 'payslips';



DELETE FROM `email_templates` WHERE `email_templates`.`name` = 'payslip_generated_staff_message';



DELETE FROM `email_template_fields` WHERE `email_template_fields`.`template_name` = 'payslip_generated_staff_message';

DELETE FROM `recurring` WHERE `recurring`.`relation_type` = 'payroll';

UPDATE `modules` SET `version` = 'NULL' WHERE `modules`.`name` = 'hrm';