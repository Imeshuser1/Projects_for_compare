
INSERT INTO `appconfig` (`id`, `name`, `value`) VALUES (NULL, 'payroll_prefix', 'Payroll-'), (NULL, 'payroll_series', '1'), (NULL, 'payslip_prefix', 'Payslip-'), (NULL, 'payslip_series', '1');


--
-- Table structure for table `payrolls`
--

CREATE TABLE `payrolls` (
 `payroll_id` int(11) NOT NULL AUTO_INCREMENT,
 `payroll_number` varchar(20) DEFAULT NULL,
 `payroll_token` mediumtext NOT NULL,
 `payroll_relation_id` int(11) DEFAULT NULL COMMENT 'staff_id',
 `payroll_staff_id` int(11) NOT NULL,
 `payroll_start_date` date DEFAULT NULL,
 `payroll_end_date` date DEFAULT NULL,
 `payroll_run_day` int(5) DEFAULT NULL COMMENT '1 to 29 | Day of the month',
 `payroll_base_salary` decimal(20,2) DEFAULT NULL,
 `payroll_grand_total` decimal(20,2) DEFAULT NULL,
 `payroll_total_allowance` decimal(20,2) DEFAULT NULL,
 `payroll_total_deduction` decimal(20,2) DEFAULT NULL,
 `payroll_status` int(11) DEFAULT NULL,
 `payroll_note` text,
 `payroll_expense_category` int(11) DEFAULT NULL,
 `payroll_account` int(11) DEFAULT NULL,
 `payroll_recurring` int(2) NOT NULL DEFAULT '0',
 `payroll_created` date DEFAULT NULL,
 `payroll_last_recurring` date DEFAULT NULL,
 `payroll_pdf_status` tinyint(1) NOT NULL DEFAULT '0',
 PRIMARY KEY (`payroll_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `payslips` (
 `payslip_id` int(11) NOT NULL AUTO_INCREMENT,
 `payslip_number` varchar(20) DEFAULT NULL,
 `payslip_token` varchar(32) DEFAULT NULL,
 `payslip_payroll_id` int(11) DEFAULT NULL COMMENT 'Payroll_id',
 `payslip_relation_id` int(11) DEFAULT NULL COMMENT 'staff_id',
 `payslip_staff_id` int(11) NOT NULL,
 `payslip_start_date` date DEFAULT NULL,
 `payslip_end_date` date DEFAULT NULL,
 `payslip_run_day` int(5) DEFAULT NULL COMMENT '1 to 29 | Day of the month',
 `payslip_base_salary` decimal(20,2) DEFAULT NULL,
 `payslip_grand_total` decimal(20,2) DEFAULT NULL,
 `payslip_total_allowance` decimal(20,2) DEFAULT NULL,
 `payslip_total_deduction` decimal(20,2) DEFAULT NULL,
 `payslip_status` int(11) DEFAULT NULL,
 `payslip_note` text,
 `payslip_expense_category` int(11) DEFAULT NULL,
 `payslip_account` int(11) DEFAULT NULL,
 `payslip_recurring` int(2) NOT NULL DEFAULT '0',
 `payslip_created` date DEFAULT NULL,
 `payslip_last_recurring` date DEFAULT NULL,
 `payslip_pdf_status` tinyint(1) NOT NULL DEFAULT '0',
 PRIMARY KEY (`payslip_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `payroll_item` (
 `payroll_item_id` int(11) NOT NULL AUTO_INCREMENT,
 `payroll_item_type` varchar(100) DEFAULT NULL,
 `relation_id` int(11) NOT NULL COMMENT 'payroll_id',
 `payroll_item_name` varchar(255) DEFAULT NULL,
 `payroll_item_description` text,
 `payroll_item_time` tinyint(4) NOT NULL DEFAULT '1' COMMENT '30 = Daily | 4 = Weekly | 1 = Monthly',
 `payroll_item_quantity` decimal(20,2) DEFAULT NULL,
 `payroll_item_price` decimal(20,2) NOT NULL DEFAULT '0.00',
 `payroll_item_total` decimal(20,2) DEFAULT NULL,
 PRIMARY KEY (`payroll_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `payslip_item` (
 `payslip_item_id` int(11) NOT NULL AUTO_INCREMENT,
 `payslip_item_type` varchar(100) DEFAULT NULL,
 `relation_id` int(11) NOT NULL COMMENT 'payslip_id',
 `payslip_item_name` varchar(255) DEFAULT NULL,
 `payslip_item_description` text,
 `payslip_item_time` tinyint(4) NOT NULL DEFAULT '1' COMMENT '30 = Daily | 4 = weekly | 1 = Monthly',
 `payslip_item_quantity` decimal(20,2) DEFAULT NULL,
 `payslip_item_price` decimal(20,2) NOT NULL DEFAULT '0.00',
 `payslip_item_total` decimal(20,2) DEFAULT NULL,
 PRIMARY KEY (`payslip_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insert into Permissions table--
INSERT INTO `permissions` (`id`, `permission`, `type`, `key`) VALUES (NULL, 'x_menu_payrolls', 'non-common', 'payrolls');
INSERT INTO `permissions` (`id`, `permission`, `type`, `key`) VALUES (NULL, 'x_menu_payslips', 'non-common', 'payslips');


-- Email Template--
INSERT INTO `email_templates` (`id`, `relation`, `name`, `subject`, `message`, `from_name`, `status`, `display`, `attachment`) VALUES
(NULL, 'hrm', 'payslip_generated_staff_message', 'Payslip generated', 
'<p><span><strong>PAYSLIP GENERATED</strong></span><br><br></p>
<div>Hello {staff},</div>
<div><br></div>
<div>We have prepared the following payslip for you: # <strong>{payslip_id}</strong></div>
<div><br></div>
<div>You can view the payslip on the following link: <strong>{payslip_link}</strong></div>
<div><br></div>
<div>Kind Regards,</div>
<div><br></div>
<div><strong>{name},</strong></div>
<div>{email_signature}</div>'
, 'Ciuis CRM', 1, 1, 1);


-- Email template fields--

INSERT INTO `email_template_fields` (`id`, `template_id`, `field_name`, `field_value`, `template_name`) VALUES
(NULL, 1, 'staff', 'staff', 'payslip_generated_staff_message'),
(NULL, 1, 'payslip_id', 'payslip_id', 'payslip_generated_staff_message'),
(NULL, 1, 'payslip_link', 'payslip_link', 'payslip_generated_staff_message'),
(NULL, 1, 'name', 'name', 'payslip_generated_staff_message'),
(NULL, 1, 'email_signature', 'email_signature', 'payslip_generated_staff_message');



UPDATE `modules` SET `version` = '2.0' WHERE `modules`.`name` = 'hrm';