-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 15, 2022 at 10:49 AM
-- Server version: 5.7.24
-- PHP Version: 8.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demo_ciuis_crm`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` int(5) NOT NULL,
  `bankname` varchar(100) DEFAULT NULL,
  `branchbank` varchar(100) DEFAULT NULL,
  `account` varchar(5) DEFAULT NULL,
  `iban` varchar(100) DEFAULT NULL,
  `status_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `name`, `type`, `bankname`, `branchbank`, `account`, `iban`, `status_id`) VALUES
(1, 'Cash', 0, '', '', '21474', '', 0),
(3, 'Zurich Cantonal Bank', 1, 'Zurich Cantonal Bank', 'New York', '21474', 'GB23 1123 1213 4343 3444 43', 0),
(4, 'Alternative Bank', 1, 'Alternative Bank', 'Denver', '21474', 'GB23 1123 1213 4343 3444 43', 0);

-- --------------------------------------------------------

--
-- Table structure for table `appconfig`
--

CREATE TABLE `appconfig` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `appconfig`
--

INSERT INTO `appconfig` (`id`, `name`, `value`) VALUES
(1, 'inv_prefix', 'INV-'),
(2, 'inv_suffix', ''),
(3, 'project_prefix', 'PROJ-'),
(4, 'project_suffix', ''),
(5, 'expense_prefix', 'EXP-'),
(6, 'expense_suffix', ''),
(7, 'proposal_prefix', 'PRO-'),
(8, 'proposal_suffix', ''),
(9, 'order_prefix', 'ODR-'),
(10, 'order_suffix', ''),
(11, 'tax_label', 'VAT'),
(12, 'product_prefix', 'PRD-'),
(13, 'vendor_prefix', 'VEN-'),
(14, 'customer_prefix', 'CUST-'),
(15, 'lead_prefix', 'LEAD-'),
(16, 'ticket_prefix', 'TKT-'),
(17, 'staff_prefix', 'STAFF-'),
(18, 'purchase_prefix', 'PO-'),
(19, 'task_prefix', 'TASK-'),
(20, 'invoice_series', '1'),
(21, 'project_series', '1'),
(22, 'product_series', '1'),
(23, 'order_series', '1'),
(24, 'proposal_series', '1'),
(25, 'vendor_series', '1'),
(26, 'customer_series', '1'),
(27, 'expense_series', '1'),
(28, 'lead_series', '1'),
(29, 'ticket_series', '1'),
(30, 'staff_series', '1'),
(31, 'purchase_series', '1'),
(32, 'task_series', '1'),
(33, 'deposit_prefix', 'DEP-'),
(34, 'deposit_series', '1'),
(35, 'decimal_separator', '.'),
(36, 'thousand_separator', ','),
(37, 'appointment_color', '#23ce54'),
(38, 'project_color', '#81c5f4'),
(39, 'task_color', '#f4de81'),
(40, 'inventory_prefix', 'INVT-'),
(41, 'inventory_series', '1'),
(42, 'warehouse_prefix', 'WAHS-'),
(43, 'warehouse_series', '1');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(5) NOT NULL,
  `contact_id` int(5) NOT NULL,
  `staff_id` int(5) NOT NULL,
  `booking_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `contact_id`, `staff_id`, `booking_date`, `start_time`, `end_time`, `status`) VALUES
(1, 23, 1, '2018-04-02', '09:00:00', '09:30:00', 1),
(2, 23, 1, '2018-04-02', '09:30:00', '10:00:00', 3);

-- --------------------------------------------------------

--
-- Table structure for table `branding`
--

CREATE TABLE `branding` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `value` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `branding`
--

INSERT INTO `branding` (`id`, `name`, `value`) VALUES
(1, 'meta_keywords', 'Ciuis™ CRM software for customer relationship management is available for sale, so you can get more information to take advantage of your exclusive concierge.'),
(2, 'meta_description', 'Ciuis, CRM, Project Management tool, client management, crm, customer, expenses, invoice system, invoices, lead, project management, recurring invoices, sales, self hosted, support tickets, task manager, ticket system'),
(3, 'admin_login_image', 'login.jpg'),
(4, 'client_login_image', 'login.jpg'),
(7, 'admin_login_text', 'Welcome! With Ciuis CRM you can easily manage your customer relationships and save time on your business.'),
(8, 'client_login_text', 'Ciuis™ CRM software for customer relationship management is available for sale, so you can get more information to take advantage of your exclusive concierge.'),
(9, 'enable_support_button_on_client', '1'),
(10, 'favicon_icon', 'logo-fav.png'),
(11, 'support_button_title', 'Ciuis Support'),
(12, 'support_button_link', 'https://support.suisesoft.tech/'),
(13, 'title', 'Ciuis CRM'),
(14, 'nav_logo', ''),
(15, 'title', 'Ciuis CRM'),
(16, 'app_logo', ''),
(17, 'preloader', 'preloader.gif'),
(18, 'disable_preloader', '0'),
(19, 'enable_client_area_button', '1'),
(20, 'client_area_button_title', 'Client Area'),
(21, 'email_banner', 'shipper.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `content` mediumtext,
  `relation_type` varchar(255) NOT NULL,
  `relation` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `content`, `relation_type`, `relation`, `staff_id`, `created`) VALUES
(1, 'Lorem ipsum dolor sit amet!', 'proposal', 1, 1, '2017-09-05 06:22:36'),
(2, 'Lorem ipsum dolor sit amet!', 'proposal', 2, 1, '2017-09-05 06:22:36'),
(4, 'Lorem ipsum comment.', 'proposal', 3, 1, '2017-09-10 01:23:55'),
(5, 'test', 'proposal', 3, NULL, '2017-09-10 01:29:20'),
(6, 'Test Comment', 'proposal', 3, NULL, '2017-09-10 01:30:38'),
(7, 'Sample comment', 'proposal', 5, 1, '2017-11-25 04:55:21'),
(8, 'Sample comment', 'proposal', 2, 1, '2018-01-10 00:19:23'),
(9, 'Sample', 'proposal', 2, 1, '2018-01-10 00:22:48'),
(10, 'Make a little discount.', 'proposal', 5, 1, '2018-01-22 20:47:51');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `surname` varchar(100) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `extension` varchar(100) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `language` varchar(100) NOT NULL,
  `address` text,
  `skype` varchar(100) DEFAULT NULL,
  `linkedin` varchar(100) DEFAULT NULL,
  `customer_id` int(5) NOT NULL,
  `position` varchar(100) DEFAULT NULL,
  `primary` int(5) DEFAULT '0',
  `admin` int(5) DEFAULT '0',
  `inactive` tinyint(1) DEFAULT '0',
  `tour_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT ' 0=Not Shown, 1=Shown'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `surname`, `phone`, `extension`, `mobile`, `email`, `username`, `password`, `language`, `address`, `skype`, `linkedin`, `customer_id`, `position`, `primary`, `admin`, `inactive`, `tour_status`) VALUES
(8, 'Sandra', 'Bailey', '(981) 450 5274', '102', '(948) 153 4877', 'sandra-86@example.com', '', '', '', '2514 W Tanner Ranch Rd, Queen Creek, AZ, 85142', 'Bailey', 'Bailey', 1, 'Sales Agent', 0, 0, 0, 1),
(11, 'Kyle', 'Romero', '(946) 610 7796', '21', '(946) 610 7796', 'kyle.romero@example.com', '', '$2y$10$PIoAOeFgAkAHb1JZkD.kVeyXcANIz3y43uCSdYpjtmXq9vDXbbeM6', '', 'USA', 'kyle', 'kyle', 5, 'Sales Agent', 1, 0, 0, 1),
(12, 'Charles', 'Simmons', '(271) 967 5863', '', '(271) 967 5863', 'charles-91@example.com', '', '$2y$10$FrXB.1neoDBrR25q0EGa9OCuBb6rh45VsD/v/YUO5oZhwO9tyaLam', '', 'RUSSIA', 'charles2323', 'charles2323', 5, 'Sales Agent', 1, 0, 0, 1),
(13, 'Phillip', 'Estrada', '(666) 295 5922', '', '(666) 295 5922', 'phillip85@example.com', '', '$2y$10$pqF77bPYxazC7VcyXrfJL.D/C8l4.04xVeCEKW2lY0SCYpsXaHwYO', '', 'USA', 'phillip85', 'phillip85', 1, 'Product Manager', 1, 0, 0, 1),
(14, 'Michel', 'Kworks', '1 993 23223', '', '', 'michel@example.com', '', '$2y$10$hZCawFLfCSIjDWST/k9RjubsJCc0j3WGrVZkgZ4uiK5vTrlNkuDQK', '', 'Test', 'michel', '', 16, 'General Manager', 1, 0, NULL, 1),
(15, 'Gerald', 'DeGroot', '626-931-8754', '23', '626-931-8754', 'chaim@example.com', '', '$2y$10$uVDLwo5P.MX89gbyAHuNSuToHYLV8B5gtTOiTdPjShxGXAKIo6iu2', '', '4521 Providence Lane', 'chaim', 'chaim', 17, 'General Manager', 1, 0, NULL, 1),
(16, 'Terry', 'McCoy', '(467) 826 4441', '11', '(467) 826 4441', 'terry_mccoy@example.com', '', '$2y$10$54kEiZGHESg.RMspMR9ro.fvKw56ux09ArXbmYlYvfQ.ybCVocixW', '', 'United States', 'terry', 'teryy', 9, 'Sales Agent', 1, 0, NULL, 1),
(17, 'Robert Lopez', 'Lopez', '(344) 888 6449', '', '(344) 888 6449', 'robert.lopez@example.com', '', '$2y$10$cQqH.HpkZ5YAvO3AITYbLesxS/w5Xd2o.kGCP9LOo6DoR/PN9Jzce', '', '', '', '', 9, 'General Manager', NULL, 0, NULL, 1),
(18, 'Mary', 'Murphy', '(694) 752 3564', '', '(694) 752 3564', 'mary.murphy@example.com', '', '$2y$10$QtEg17joyKhYOMo0GDYb/OhMtnJyD900CBIqiLsplglK1xzfky4/W', '', '', '', '', 9, '', NULL, 0, NULL, 1),
(19, 'Theresa', 'Sullivan', '(781) 560 5175', '', '(781) 560 5175', 'theresa_82@example.com', '', '$2y$10$VvekKYEU.RqtGaNRqXALLu/a6wimQF.iRlCQz07EFic9QUjK49LYy', '', '', '', '', 9, '', NULL, 0, NULL, 1),
(20, 'Anna', 'Holland', '(221) 862 7179', '11', '(221) 862 7179', 'anna-holland@example.com', '', '$2y$10$uE/XaLobpbnPIv9tpiKex.6q7UHcbauuGTgpWElggKNZVHYT0iGd.', '', 'Address lorem ipsum.', 'anna', 'anna', 9, 'Henel', 1, 0, NULL, 1),
(21, 'Ann', 'Arbor', '(221) 862 7179', '', '(467) 826 4441', 'quice@example.com', '', '$2y$10$lMewMEh8/3wUcT48CRUBF.bFbypReQhIvap5Je59mRz/nkulLvPbG', '', '', '', '', 17, 'Sales Agent', 1, 0, NULL, 1),
(22, 'Indigo', 'Violet', '(221) 862 7179', '222', '(467) 826 4441', 'indigo@example.com', '', '$2y$10$fw20vep0VddOgQVPhNrW0u7OrP6zgXWmXnSdhYQzUX2q.9X9OTDwO', '', 'United states of america', 'indigo', 'indigo', 17, 'Sales Agent', 1, 0, NULL, 1),
(23, 'Sue', 'Shei', '(221) 862 7179', '222', '(781) 560 5175', 'sue@example.com', '', '$2y$10$fw20vep0VddOgQVPhNrW0u7OrP6zgXWmXnSdhYQzUX2q.9X9OTDwO', '', '22222', '222', '22', 17, 'Sales Agent', 1, 1, NULL, 1),
(26, 'Andiano', 'Molly', '(221) 862 7179', '', '(467) 826 4441', 'molly@example.com', '', '$2y$10$7yT2BcUNFbc1G0cSx/xhseVPZJySTNosOtMv5azjyosNnMTnA0gGa', '', '', '', '', 17, '', 1, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `customergroups`
--

CREATE TABLE `customergroups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `customer_number` varchar(100) DEFAULT NULL,
  `type` int(5) DEFAULT NULL,
  `created` date NOT NULL,
  `staff_id` int(5) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `namesurname` varchar(200) DEFAULT NULL,
  `groupid` int(5) NOT NULL,
  `taxoffice` varchar(100) DEFAULT NULL,
  `taxnumber` varchar(50) DEFAULT NULL,
  `ssn` varchar(100) DEFAULT NULL,
  `executive` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `zipcode` varchar(50) DEFAULT NULL,
  `country_id` int(5) DEFAULT NULL,
  `state` varchar(200) DEFAULT NULL,
  `state_id` int(5) DEFAULT NULL,
  `city` varchar(200) DEFAULT NULL,
  `town` varchar(200) DEFAULT NULL,
  `billing_street` varchar(200) NOT NULL,
  `billing_city` varchar(100) NOT NULL,
  `billing_state` varchar(200) NOT NULL,
  `billing_state_id` int(5) DEFAULT NULL,
  `billing_zip` varchar(50) NOT NULL,
  `billing_country` int(5) NOT NULL,
  `shipping_street` varchar(200) NOT NULL,
  `shipping_city` varchar(200) NOT NULL,
  `shipping_state` varchar(255) NOT NULL,
  `shipping_state_id` int(5) DEFAULT NULL,
  `shipping_zip` varchar(255) NOT NULL,
  `shipping_country` int(11) NOT NULL,
  `latitude` varchar(100) NOT NULL,
  `longitude` varchar(100) NOT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `fax` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `web` varchar(100) DEFAULT NULL,
  `risk` int(5) DEFAULT '0',
  `customer_status_id` int(5) DEFAULT '1' COMMENT '0 = Inactive | 1 = Active',
  `subsidiary_parent_id` int(5) NOT NULL,
  `default_payment_method` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_number`, `type`, `created`, `staff_id`, `company`, `namesurname`, `groupid`, `taxoffice`, `taxnumber`, `ssn`, `executive`, `address`, `zipcode`, `country_id`, `state`, `state_id`, `city`, `town`, `billing_street`, `billing_city`, `billing_state`, `billing_state_id`, `billing_zip`, `billing_country`, `shipping_street`, `shipping_city`, `shipping_state`, `shipping_state_id`, `shipping_zip`, `shipping_country`, `latitude`, `longitude`, `phone`, `fax`, `email`, `web`, `risk`, `customer_status_id`, `subsidiary_parent_id`, `default_payment_method`) VALUES
(1, NULL, 0, '2017-04-16', 1, 'H&M Law Office', NULL, 0, 'Washington DC Tax & Revenue', '456364265', NULL, 'Roger Wade', '799 E DRAGRAM SUITE 5A TUCSON AZ 85705 USA', '97311-8487', 23, 'Uk', NULL, 'Deve', 'Ata', '', '', '', NULL, '', 0, '', '', '', NULL, '', 0, '', '', '+1 (808) 136 4131', '+1 (808) 136 4131', 'info@orgon.com', 'www.example.com', 17, 1, 0, NULL),
(6, NULL, 0, '2017-08-22', 1, 'Northern Star', '', 0, '', '0', '', '', '7110 Gum Branch Rd, Richlands, NC, 28574', '54617', 1, 'NC', NULL, 'New York', '', '', '', '', NULL, '', 0, '', '', '', NULL, '', 0, '', '', '(140) 211 2494', '', 'judyyoung@example.com', 'www.example.com', 0, 1, 0, 'bank'),
(8, NULL, 0, '2017-08-22', 1, 'Transhex LLC.', '', 0, '', '0', '', '', '95 Meadow St, Winsted, CT, 06098', '54617', 6, 'CT', NULL, 'New York', '', '', '', '', NULL, '', 0, '', '', '', NULL, '', 0, '', '', '(954) 630 6210', '', 'nicholas-90@example.com', 'www.example.com', 0, 1, 0, 'bank'),
(9, NULL, 1, '2017-08-23', 1, '', 'Neuer Manuel', 0, 'New York', '0', '234354241', 'Himself', 'Celeste Slater\n606-3727 Ullamcorper. Street\nRoseville NH 11523', '012345', 83, 'Berlin', NULL, 'Stadt', 'Dorf', 'Celeste Slater\n606-3727 Ullamcorper. Street\nRoseville NH 11523', 'Stadt', 'Berlin', NULL, '012345', 83, 'Celeste Slater\n606-3727 Ullamcorper. Street\nRoseville NH 11523', 'Stadt', 'Berlin', NULL, '012345', 83, '', '', '00493661123456', '00493661123456', 'manuel@neuer.de', 'www.neuer.de', 42, 1, 0, 'stripe'),
(12, NULL, 0, '2017-08-24', 1, 'Unadoncare INC.', '', 0, '', '0', '', '', '95 Meadow St, Winsted, CT, 06098', '54617', 3, 'CT', NULL, 'New York', '', '', '', '', NULL, '', 0, '', '', '', NULL, '', 0, '', '', '(432) 156 5172', '', 'jane-85@example.com', 'www.example.com', 0, 1, 0, 'bank'),
(15, NULL, 0, '2017-08-24', 1, 'Perscriptorem Pictures', '', 0, '', '0', '', '', '70 Bowman St. South Windsor, CT 06074', '54617', 2, 'GA', NULL, 'New York', '', '', '', '', NULL, '', 0, '', '', '', NULL, '', 0, '', '', '(296) 452 9522', '', 'joycemccoy@example.com', 'www.example.com', 0, 1, 0, 'stripe'),
(16, NULL, 0, '2017-11-12', 1, 'Donway INC.', '', 0, 'London', '22112211', '', '', '5094 Vidrine Rd, Ville Platte, LA, 22356', '54617', 5, 'MI', NULL, 'New York', '', '', '', '', NULL, '', 0, '', '', '', NULL, '', 0, '', '', '+1-202-555-0160', '', 'lance@example.com', 'www.example.com', 0, 1, 17, 'stripe'),
(17, NULL, 0, '2017-11-13', 1, 'DHARMA Initiative', '', 0, 'London', '221122113', '', 'Gerald DeGroot', '4521 Providence Lane La Puente CA', '33344', 236, 'California', NULL, 'Los Angeles', 'Neiler', '4521 Providence Lane La Puente CA', 'Los Angeles', 'California', NULL, '33344', 236, '4521 Providence Lane La Puente CA', 'Los Angeles', 'California', NULL, '33344', 236, '', '', '+44 232 2322', '+44 232 2322', 'dharna@example.com', 'www.dharna.com', 48, 1, 0, 'bank'),
(18, NULL, 0, '2018-03-21', 1, 'Parallax Corporation', '', 0, 'New York', '2147483647', '', 'Melinda Gibson', 'Example Address', '2233', 236, 'California', NULL, 'Los Angeles', 'Bla', 'Example Address', 'Los Angeles', 'California', NULL, '2233', 236, 'Example Address', 'Los Angeles', 'California', NULL, '2233', 236, '', '', '1 944 444 4444', '1 944 444 4444', 'parallax@example.com', 'www.parallax.com', 0, 1, 17, 'bank');

-- --------------------------------------------------------

--
-- Table structure for table `custom_fields`
--

CREATE TABLE `custom_fields` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `order` int(11) NOT NULL,
  `data` longtext NOT NULL,
  `relation` varchar(100) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `permission` varchar(100) NOT NULL,
  `active` varchar(100) NOT NULL DEFAULT 'true',
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `custom_fields_data`
--

CREATE TABLE `custom_fields_data` (
  `id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `relation_type` varchar(255) NOT NULL,
  `relation` int(11) NOT NULL,
  `data` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `db_backup`
--

CREATE TABLE `db_backup` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `version` varchar(10) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`) VALUES
(1, 'Administrator'),
(2, 'Sales Agent'),
(3, 'IT Services'),
(4, 'Tax Dept');

-- --------------------------------------------------------

--
-- Table structure for table `depositcat`
--

CREATE TABLE `depositcat` (
  `id` int(11) NOT NULL,
  `name` varchar(300) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` int(11) NOT NULL,
  `deposit_number` varchar(100) DEFAULT NULL,
  `token` varchar(200) NOT NULL,
  `relation_type` varchar(100) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `description` text,
  `category_id` int(5) NOT NULL,
  `account_id` int(5) NOT NULL,
  `staff_id` int(5) NOT NULL,
  `customer_id` int(5) NOT NULL,
  `invoice_id` int(5) DEFAULT NULL,
  `created` datetime NOT NULL,
  `date` date NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `sub_total` decimal(20,2) DEFAULT NULL,
  `total_tax` decimal(20,2) DEFAULT NULL,
  `status` int(5) DEFAULT NULL COMMENT 'Unpaid-0, Paid-1, Internal-2',
  `recurring` int(5) DEFAULT NULL,
  `last_recurring` date DEFAULT NULL,
  `pdf_status` tinyint(1) NOT NULL DEFAULT '0',
  `deposits_created_by` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `discussions`
--

CREATE TABLE `discussions` (
  `id` int(11) NOT NULL,
  `relation_type` varchar(100) NOT NULL,
  `relation` int(5) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `show_to_customer` tinyint(1) NOT NULL DEFAULT '0',
  `datecreated` datetime NOT NULL,
  `staff_id` int(5) NOT NULL DEFAULT '0',
  `contact_id` int(5) NOT NULL DEFAULT '0',
  `is_read` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `discussions`
--

INSERT INTO `discussions` (`id`, `relation_type`, `relation`, `subject`, `description`, `show_to_customer`, `datecreated`, `staff_id`, `contact_id`, `is_read`) VALUES
(1, 'invoice', 7, 'Hi There?', 'Lorem ipsum dolor sit amet', 1, '2018-03-05 00:00:00', 1, 23, 0),
(2, 'invoice', 7, 'Sample', 'Test', 1, '2018-03-07 21:37:02', 1, 23, 0),
(3, 'invoice', 7, 'Test Two', 'Test detail', 1, '2018-03-07 21:40:37', 1, 26, 0),
(4, 'invoice', 7, 'Test 3', 'Test 3', 1, '2018-03-07 21:43:00', 1, 22, 0),
(5, 'invoice', 7, 'Example Discuss', 'test', 0, '2018-03-07 21:43:41', 1, 21, 0),
(6, 'invoice', 7, 'Example Discuss 2', 'test', 1, '2018-03-07 21:43:59', 1, 23, 0),
(7, 'invoice', 12, 'Test', 'Test discussion', 1, '2018-08-30 22:40:50', 1, 23, 0);

-- --------------------------------------------------------

--
-- Table structure for table `discussion_comments`
--

CREATE TABLE `discussion_comments` (
  `id` int(11) NOT NULL,
  `discussion_id` int(5) NOT NULL,
  `created` datetime NOT NULL,
  `content` text NOT NULL,
  `staff_id` int(5) NOT NULL,
  `contact_id` int(5) DEFAULT '0',
  `full_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `discussion_comments`
--

INSERT INTO `discussion_comments` (`id`, `discussion_id`, `created`, `content`, `staff_id`, `contact_id`, `full_name`) VALUES
(1, 1, '2018-03-06 00:46:08', 'Sample', 1, 23, 'Lance Bogrol'),
(2, 1, '2018-03-06 00:46:55', 'Sample for tony', 1, 23, 'Lance Bogrol'),
(3, 1, '2018-03-06 18:19:11', 'Example for tony', 1, 23, 'Lance Bogrol'),
(4, 1, '2018-03-07 19:44:11', 'Contact message', 1, 23, 'Sue Shei'),
(5, 1, '2018-03-07 19:44:24', 'Contact message', 1, 23, 'Sue Shei'),
(6, 1, '2018-03-07 19:45:31', 'Toney contact', 1, 23, 'Sue Shei'),
(7, 1, '2018-03-07 19:57:38', 'Bla bla 8', 1, 23, 'Sue Shei'),
(8, 1, '2018-03-07 20:06:17', 'Thanks sue!', 1, 23, 'Lance Bogrol'),
(9, 1, '2018-03-07 20:07:19', 'thanks again', 1, 23, 'Lance Bogrol'),
(10, 1, '2018-03-07 20:08:26', 'ada', 1, 23, 'Lance Bogrol'),
(11, 1, '2018-03-09 16:08:39', 'adsfsa', 1, 23, 'Lance Bogrol'),
(12, 7, '2018-08-30 22:41:11', 'hi, its so expensive', 1, 23, 'Sue Shei');

-- --------------------------------------------------------

--
-- Table structure for table `email_queue`
--

CREATE TABLE `email_queue` (
  `id` int(11) NOT NULL,
  `from_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `cc` varchar(255) DEFAULT NULL,
  `bcc` varchar(255) DEFAULT NULL,
  `subject` mediumtext,
  `message` mediumtext,
  `attachments` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `display` tinyint(1) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `send_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `email_queue`
--

INSERT INTO `email_queue` (`id`, `from_name`, `email`, `cc`, `bcc`, `subject`, `message`, `attachments`, `status`, `display`, `created`, `send_date`) VALUES
(1, 'Ciuis CRM', 'emma@example.com', NULL, NULL, 'New Task Assigned to You - Design Frontend', '<p><span>Dear Emma Durst,</span><br><br><span>You have been assigned to a new task:</span><br><br><span><strong>Name:</strong> Design Frontend</span></p><p><strong>Start Date:</strong> 2019-04-15</p><p><span><strong>Due date:</strong> 2019-06-15</span></p><p><span><strong>Priority:</strong> MEDIUM</span></p><p><strong>Status:</strong> IN PROGRESS<span><br><br></span><span>You can view the task on the following link: <a href=\"http://localhost/ciuiscrm/tasks/task/2\" data-mce-href=\"http://localhost/ciuiscrm/tasks/task/2\" style=\"\">view</a></span><br><br><span>Kind Regards,</span></p><p><strong>Lance Bogrol</strong>,<br><span>lance@example.com</span><br></p>', NULL, 1, 1, '2019-04-15 19:20:21', NULL),
(2, 'Ciuis CRM', 'emma@example.com', NULL, NULL, 'New Comment on Task - Design Frontend', '<p>Dear Emma Durst,<br><br>A comment has been made on the following task:<br><br><strong>Task:</strong> Design Frontend<br><strong>Comment:</strong> Pending Server Conffig<br><br>You can view the task on the following link: <a href=\"http://localhost/ciuiscrm/tasks/task/2\" data-mce-href=\"http://localhost/ciuiscrm/tasks/task/2\">view</a><br><br>Kind Regards,</p><p><strong>Lance Bogrol</strong>,<br>lance@example.com<br></p>', NULL, 1, 1, '2019-04-15 19:21:00', NULL),
(3, 'Ciuis CRM', 'ruby@example.com', NULL, NULL, 'New Task Assigned to You - Coding PHP backend', '<p><span>Dear Ruby Von Rails,</span><br><br><span>You have been assigned to a new task:</span><br><br><span><strong>Name:</strong> Coding PHP backend</span></p><p><strong>Start Date:</strong> 2019-04-15</p><p><span><strong>Due date:</strong> 2019-04-30</span></p><p><span><strong>Priority:</strong> MEDIUM</span></p><p><strong>Status:</strong> Waiting<span><br><br></span><span>You can view the task on the following link: <a href=\"http://localhost/ciuiscrm/tasks/task/3\" data-mce-href=\"http://localhost/ciuiscrm/tasks/task/3\" style=\"\">view</a></span><br><br><span>Kind Regards,</span></p><p><strong>Lance Bogrol</strong>,<br><span>lance@example.com</span><br></p>', NULL, 1, 1, '2019-04-15 20:13:26', NULL),
(4, 'Ciuis CRM', 'ruby@example.com', NULL, NULL, 'New Comment on Task - Coding PHP backend', '<p>Dear Ruby Von Rails,<br><br>A comment has been made on the following task:<br><br><strong>Task:</strong> Coding PHP backend<br><strong>Comment:</strong> We can solve this problem by solving the HTML issue<br><br>You can view the task on the following link: <a href=\"http://localhost/ciuiscrm/tasks/task/3\" data-mce-href=\"http://localhost/ciuiscrm/tasks/task/3\">view</a><br><br>Kind Regards,</p><p><strong>Lance Bogrol</strong>,<br>lance@example.com<br></p>', NULL, 1, 1, '2019-04-15 20:14:10', NULL),
(5, 'Ciuis CRM', 'lance@example.com', NULL, NULL, 'New Ticket Created', '<p><span>A new ticket has been created.</span><br><br><span><strong>Subject</strong>: Zclus Site Similar On siteGround</span><br><span><strong>Department</strong>: </span><br><span><strong>Priority</strong>: MEDIUM</span><br><br><span><strong>Ticket message:</strong></span><br><span>Need help with the website ? </span><br><br><span>Kind Regards,</span></p><p><strong>Sue</strong>,<br><span>sue@example.com</span><br></p>', NULL, 1, 1, '2019-04-15 16:49:41', NULL),
(6, 'Ciuis CRM', 'sue@example.com', NULL, NULL, 'New Ticket Opened', '<p><span>Hi Sue,</span><br><br><span>Thank you for contacting our team. A ticket has now been created for your request. </span></p><p><span>You will be notified when a response is made by email.</span><br><br><span><strong>Subject:</strong> Zclus Site Similar On siteGround</span><br><span><strong>Department</strong>: </span><br><span><strong>Priority:</strong> MEDIUM</span><br><br><span><strong>Ticket message:</strong></span><br><span>Need help with the website ? </span><br><br><br><span>Kind Regards,</span></p><p><strong>Sue</strong>,<br><span>sue@example.com</span><br></p>', NULL, 1, 1, '2019-04-15 16:49:41', NULL),
(7, 'Ciuis CRM', 'root@ciuis.com', NULL, NULL, 'New Staff Added (Welcome Email)', '<p>Hi Root Admin,<br><br>You are added as member on our CRM.<br><br>Please use the following logic credentials:<br><br><strong>Email:</strong> root@ciuis.com<br><strong>Password:</strong> root<br><br>Click <span><span><a href=\"{http://localhost/ciuiscrm/login}\" data-mce-href=\"{http://localhost/ciuiscrm/login}\">here </a> </span></span>to login in the dashboard.<br><br>Best Regards,<br><strong>Lance Bogrol</strong>,<br>lance@example.com<br></p>', NULL, 1, 1, '2019-04-16 05:15:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id` int(11) NOT NULL,
  `relation` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` mediumtext,
  `from_name` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `display` tinyint(1) DEFAULT '1',
  `attachment` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `relation`, `name`, `subject`, `message`, `from_name`, `status`, `display`, `attachment`) VALUES
(1, 'invoice', 'invoice_message', 'Invoice with number {invoice_number} created', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\" /></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" />\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {customer}</h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            Invoice {invoice_number}\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            We have prepared following invoice for you.: #{invoice_number}                              \n                                        </p> \n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                          You can view the invoice on the following link: <a href=\"{invoice_link}\">Invoice Link</a>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">Invoice Status: {invoice_status} \n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">please contact us for following information.</p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p> \n                                    </div>  \n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 1),
(2, 'invoice', 'invoice_reminder', 'Send Invoice', '<h1><span xss=removed>DOCTYPE</span></h1>\n<p xss=removed>DOCTYPE</p>', 'CiusiCRM', 1, 0, 0),
(3, 'invoice', 'invoice_payment', 'Invoice Payment Recorded', '<!doctype html>\n<html lang=\"en\">\n  <head>\n    <!-- Required meta tags -->\n    <meta charset=\"utf-8\">\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n    <title>:: Email ::</title>\n    <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n  </head>\n <body>\n    <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n        <thead>\n            <tr>\n                <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                        <tbody>\n                            <tr>                                <td align=\"left\" valign=\"top\">\n                                    <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                </td>    \n                                <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                    <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </th>\n            </tr>\n        </thead>\n        <tr>\n            <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n            </td>\n        </tr>\n        <tr>\n            <td align=\"center\" valign=\"top\">\n                <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                    <tbody>\n                        <tr>\n                            <td>\n                                <div style=\"padding:8px 60px 0px 60px;\">\n                                    <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {customer}</h6>\n                                </div>\n                            </td>\n                        </tr>    \n\n                    </tbody>            \n                </table>\n            </td>\n        </tr>\n        <tr>\n            <td align=\"center\" valign=\"top\">\n                <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                    <tbody>\n                        <tr>\n                            <td align=\"left\" valign=\"top\">\n                                <div style=\"padding:8px 60px 60px 60px;\">\n                                    <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                      Thank you for the payment. Find the payment details below:\n                                   </p>\n                                    <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n\nAmount: {payment_total} <br/>\nDate: {payment_date} <br/>\nInvoice Number: #{invoice_number}                                                                  \n                                     </p> \n                                   <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                          You can always view the invoice for this payment at the following link: <a href=\"{invoice_link}\">Invoice  Link</a>\n                                   </p>                                  \n                                   <p>We are looking forward working with you.</p>\n                           \n                                   <p><strong>Kind Regards,</strong></p>\n\n                                    <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">The {company_name} team</p> \n                                </div>  \n                            </td>\n                            \n                        </tr>\n                    </tbody>\n                \n                </table>\n                \n            \n            </td>\n            \n        </tr>\n        \n     \n      \n        <tr>\n            <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                    <tbody>\n                        <tr>\n                            <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                            <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                            </td>\n                            <td align=\"right\" valign=\"middle\">\n                                <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                            </td>\n                        </tr>\n                        <tr>\n                            <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                &copy;2019 {company_name} All rights reserved.\n                            </td>\n                        </tr>\n                    </tbody>\n                </table>\n            </td>\n        </tr>\n    </table>\n</body>\n</html>', 'CiusiCRM', 1, 1, 0),
(4, 'invoice', 'invoice_overdue', 'Invoice Overdue Notice - {invoice_number}', '<p><span>Hi {customer},</span><br><br><span>This is an overdue notice for invoice <strong># {invoice_number}</strong></span><br><br><span>This invoice was due: {invoice_duedate}</span><br><br><span>You can view the invoice on the following link: <a>{invoice_number}</a></span><br><br><span><strong>Kind Regards,</strong>,</span></p><p><strong>{name}</strong><br><span>{email_signature}</span></p>', 'CiusiCRM', 1, 0, 0),
(5, 'customer', 'new_contact_added', 'Welcome aboard', '<!doctype html>\n<html lang=\"en\">\n<head>\n    <!-- Required meta tags -->\n    <meta charset=\"utf-8\">\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n    <title>:: Email ::</title>\n    <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n</head>\n<body>\n    <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n        <thead>\n            <tr>\n                <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                        <tbody>\n                            <tr>                                <td align=\"left\" valign=\"top\">\n                                <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                            </td>    \n                            <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                            </td>\n                        </tr>    \n\n                    </tbody>            \n                </table>\n            </th>\n        </tr>\n    </thead>\n    <tr>\n        <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n            <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n        </td>\n    </tr>\n    <tr>\n        <td align=\"center\" valign=\"top\">\n            <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                <tbody>\n                    <tr>\n                        <td>\n                            <div style=\"padding:8px 60px 0px 60px;\">\n                                <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {customer}</h6>\n                            </div>\n                        </td>\n                    </tr>    \n\n                </tbody>            \n            </table>\n        </td>\n    </tr>\n    <tr>\n        <td align=\"center\" valign=\"top\">\n            <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                <tbody>\n                    <tr>\n                        <td align=\"left\" valign=\"top\">\n                            <div style=\"padding:8px 60px 60px 60px;\">\n                                <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                  Thank you for registering.\n                              </p>\n                              <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                 We just wanted to say welcome.Please contact us if you need any help.                           \n                             </p> \n                             <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                Click here to view your profile: <a href=\"{app_url}\" href=\"{app_url}\">{app_url}</a>\n                            </p>\n                            <p>Your login details:</p>\n                            <p>Email: {login_email}<br/>Password: {login_password}</p>\n\n                            <p>(This is an automated email, so please don\'t reply to this email address)</p>\n                            <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p>\n                        </div>  \n                    </td>\n\n                </tr>\n            </tbody>\n\n        </table>\n\n\n    </td>\n\n</tr>\n\n\n\n<tr>\n    <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n            <tbody>\n                <tr>\n                    <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                    <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                        <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                        <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                    </td>\n                    <td align=\"right\" valign=\"middle\">\n                        <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                        <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                        <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                    </td>\n                </tr>\n                <tr>\n                    <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                        &copy;2019 {company_name} All rights reserved.\n                    </td>\n                </tr>\n            </tbody>\n        </table>\n    </td>\n</tr>\n</table>\n</body>\n</html>', 'CiusiCRM', 1, 1, 0),
(6, 'customer', 'new_customer', 'New Customer Registration', '<!doctype html>\n<html lang=\"en\">\n<head>\n    <!-- Required meta tags -->\n    <meta charset=\"utf-8\">\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n    <title>:: Email ::</title>\n    <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n</head>\n<body>\n    <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n        <thead>\n            <tr>\n                <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                        <tbody>\n                            <tr>                                <td align=\"left\" valign=\"top\">\n                                <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                            </td>    \n                            <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                            </td>\n                        </tr>    \n\n                    </tbody>            \n                </table>\n            </th>\n        </tr>\n    </thead>\n    <tr>\n        <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n            <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n        </td>\n    </tr>\n    <tr>\n        <td align=\"center\" valign=\"top\">\n            <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                <tbody>\n                    <tr>\n                        <td>\n                            <div style=\"padding:8px 60px 0px 60px;\">\n                                <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear Admin</h6>\n                            </div>\n                        </td>\n                    </tr>    \n\n                </tbody>            \n            </table>\n        </td>\n    </tr>\n    <tr>\n        <td align=\"center\" valign=\"top\">\n            <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                <tbody>\n                    <tr>\n                        <td align=\"left\" valign=\"top\">\n                            <div style=\"padding:8px 60px 60px 60px;\">\n                                <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                  New customer registration on your customer portal:\n                              </p>\n                              <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                <strong>Type</strong>: {customer_type}<br/><strong>Name: </strong>{name}<br><strong>Email:</strong> {customer_email}                    \n                             </p> \n                           \n                            <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p>\n                        </div>  \n                    </td>\n\n                </tr>\n            </tbody>\n\n        </table>\n\n\n    </td>\n\n</tr>\n\n\n\n<tr>\n    <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n            <tbody>\n                <tr>\n                    <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                    <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                        <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                        <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                    </td>\n                    <td align=\"right\" valign=\"middle\">\n                        <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                        <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                        <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                    </td>\n                </tr>\n                <tr>\n                    <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                        &copy;2019 {company_name} All rights reserved.\n                    </td>\n                </tr>\n            </tbody>\n        </table>\n    </td>\n</tr>\n</table>\n</body>\n</html>', 'CiusiCRM', 1, 1, 0),
(7, 'staff', 'new_staff', 'New Staff Added (Welcome Email)', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {staff}</h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            You are added as member on our CRM.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            Please use the following logic credentials:\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                           <strong>Email:</strong> {staff_email}<br><strong>Password:</strong> {password}\n                                        </p> \n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            Click <a href=\"{login_url}\">here </a> to login in the dashboard.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">Best Regards<br/>The {company_name} team</p> \n                                    </div>  \n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 0),
(8, 'staff', 'forgot_password', 'Reset password', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {staffname}</h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            Forgot your password?<br>To create a new password, just follow this link:\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            <a href=\"{password_url}\">Reset Password</a>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                           You received this email, because it was requested by a user. This is part of the procedure to create a new password on the system. If you DID NOT request a new password then please ignore this email and your password will remain the same.\n                                        </p> \n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p> \n                                    </div>  \n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 0),
(9, 'staff', 'password_reset', 'Your password has been changed', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear, </h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            <strong>You have changed your password.</strong>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                           Please, keep it in your records so you don\'t forget it.<br>Your email address for login is: \n                                           <span style=\"color: rgb(0, 0, 255)\">{staff_email}</span>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            If this was not you, please contact us.\n                                        </p> \n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p> \n                                    </div>  \n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 0),
(10, 'staff', 'reminder_email', 'Send Invoice', 'Im sending Invoice', 'CiusiCRM', 1, 0, 0);
INSERT INTO `email_templates` (`id`, `relation`, `name`, `subject`, `message`, `from_name`, `status`, `display`, `attachment`) VALUES
(11, 'task', 'new_task_assigned', 'New Task Assigned to You - {task_name}', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {staffname}, </h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                           You have been assigned to a new task:\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            <strong>Name:</strong> {task_name}<br><strong>Start Date:</strong> {task_startdate}<br><strong>Due Date:</strong> {task_duedate}<br><strong>Priority:</strong> {task_priority}<br><strong>Status:</strong> {task_status}\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                           You can view the task on the following link: <a href=\"{task_url}\">View</a>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p>\n                                    </div>  \n                                </td>\n\n                            </tr>\n                        </tbody>\n\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 0),
(12, 'task', 'task_comments', 'New Comment on Task - {task_name}', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {staffname}</h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                           A comment has been made on the following task:\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            <strong>Task:</strong> {task_name}<br><strong>Comment:</strong> {task_comment}                             \n                                        </p> \n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            You can view the task on the following link: <a href=\"{task_url}\">view</a>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p> \n                                    </div>  \n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 0),
(13, 'task', 'task_attachment', 'New Attachment on Task - {task_name}', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {staffname}</h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                          <strong>{logged_in_user}</strong> added an attachment on the following task:\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                           <strong>Name:</strong> {task_name}                          \n                                        </p> \n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            You can view the task on the following link: <a href=\"{task_url}\">view</a>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p> \n                                    </div>  \n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 0),
(14, 'task', 'task_updated', 'Task Status Changed', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {staffname}</h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                          <strong>{logged_in_user}</strong>  marked task as <strong>{task_status}</strong>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                           <strong>Name:</strong> {task_name}<br><strong>Due date:</strong> {task_duedate}\n                                        </p> \n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            You can view the task on the following link: <a href=\"{task_url}\">{task_name}</a>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p> \n                                    </div>  \n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 0),
(15, 'ticket', 'new_ticket', 'New Ticket Opened', '<!doctype html>\n<html lang=\"en\">\n<head>\n    <!-- Required meta tags -->\n    <meta charset=\"utf-8\">\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n    <title>:: Email ::</title>\n    <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n</head>\n<body>\n    <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n        <thead>\n            <tr>\n                <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                        <tbody>\n                            <tr>                                <td align=\"left\" valign=\"top\">\n                                <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                            </td>    \n                            <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                            </td>\n                        </tr>    \n\n                    </tbody>            \n                </table>\n            </th>\n        </tr>\n    </thead>\n    <tr>\n        <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n            <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n        </td>\n    </tr>\n    <tr>\n        <td align=\"center\" valign=\"top\">\n            <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                <tbody>\n                    <tr>\n                        <td>\n                            <div style=\"padding:8px 60px 0px 60px;\">\n                                <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {customer}</h6>\n                            </div>\n                        </td>\n                    </tr>    \n\n                </tbody>            \n            </table>\n        </td>\n    </tr>\n    <tr>\n        <td align=\"center\" valign=\"top\">\n            <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                <tbody>\n                    <tr>\n                        <td align=\"left\" valign=\"top\">\n                            <div style=\"padding:8px 60px 60px 60px;\">\n                                <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                  New ticket has been opened.\n                              </p>\n                              <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                <strong>Subject:</strong> {ticket_subject}<br><strong>Department:</strong> {ticket_department}<br><strong>Priority:</strong> {ticket_priority}                   \n                             </p> \n\n                             <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                <strong>Ticket message:</strong><br/><span>{ticket_message}</span>\n                             </p>\n                           \n                            <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p>\n                        </div>  \n                    </td>\n\n                </tr>\n            </tbody>\n\n        </table>\n\n\n    </td>\n\n</tr>\n\n\n\n<tr>\n    <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n            <tbody>\n                <tr>\n                    <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                    <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                        <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                        <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                    </td>\n                    <td align=\"right\" valign=\"middle\">\n                        <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                        <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                        <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                    </td>\n                </tr>\n                <tr>\n                    <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                        &copy;2019 {company_name} All rights reserved.\n                    </td>\n                </tr>\n            </tbody>\n        </table>\n    </td>\n</tr>\n</table>\n</body>\n</html>', 'CiusiCRM', 1, 1, 0),
(16, 'ticket', 'new_customer_ticket', 'New Ticket Created', '<!doctype html>\n<html lang=\"en\">\n<head>\n    <!-- Required meta tags -->\n    <meta charset=\"utf-8\">\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n    <title>:: Email ::</title>\n    <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n</head>\n<body>\n    <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n        <thead>\n            <tr>\n                <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                        <tbody>\n                            <tr>                                <td align=\"left\" valign=\"top\">\n                                <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                            </td>    \n                            <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                            </td>\n                        </tr>    \n\n                    </tbody>            \n                </table>\n            </th>\n        </tr>\n    </thead>\n    <tr>\n        <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n            <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n        </td>\n    </tr>\n    <tr>\n        <td align=\"center\" valign=\"top\">\n            <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                <tbody>\n                    <tr>\n                        <td>\n                            <div style=\"padding:8px 60px 0px 60px;\">\n                                <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear Admin</h6>\n                            </div>\n                        </td>\n                    </tr>    \n\n                </tbody>            \n            </table>\n        </td>\n    </tr>\n    <tr>\n        <td align=\"center\" valign=\"top\">\n            <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                <tbody>\n                    <tr>\n                        <td align=\"left\" valign=\"top\">\n                            <div style=\"padding:8px 60px 60px 60px;\">\n                                <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                  New ticket has been created.\n                              </p>\n                              <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                <strong>Subject:</strong> {ticket_subject}<br><strong>Department:</strong> {ticket_department}<br><strong>Priority:</strong> {ticket_priority}                   \n                             </p> \n\n                             <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                <strong>Ticket message:</strong><span>{ticket_message}</span>\n                             </p>\n                           \n                            <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p>\n                        </div>  \n                    </td>\n\n                </tr>\n            </tbody>\n\n        </table>\n\n\n    </td>\n\n</tr>\n\n\n\n<tr>\n    <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n            <tbody>\n                <tr>\n                    <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                    <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                        <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                        <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                    </td>\n                    <td align=\"right\" valign=\"middle\">\n                        <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                        <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                        <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                    </td>\n                </tr>\n                <tr>\n                    <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                        &copy;2019 {company_name} All rights reserved.\n                    </td>\n                </tr>\n            </tbody>\n        </table>\n    </td>\n</tr>\n</table>\n</body>\n</html>', 'CiusiCRM', 1, 1, 0),
(17, 'ticket', 'ticket_assigned', 'New ticket has been assigned to you', '<!doctype html>\n<html lang=\"en\">\n<head>\n    <!-- Required meta tags -->\n    <meta charset=\"utf-8\">\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n    <title>:: Email ::</title>\n    <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n</head>\n<body>\n    <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n        <thead>\n            <tr>\n                <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                        <tbody>\n                            <tr>                                <td align=\"left\" valign=\"top\">\n                                <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                            </td>    \n                            <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                            </td>\n                        </tr>    \n\n                    </tbody>            \n                </table>\n            </th>\n        </tr>\n    </thead>\n    <tr>\n        <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n            <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n        </td>\n    </tr>\n    <tr>\n        <td align=\"center\" valign=\"top\">\n            <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                <tbody>\n                    <tr>\n                        <td>\n                            <div style=\"padding:8px 60px 0px 60px;\">\n                                <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {assigned}</h6>\n                            </div>\n                        </td>\n                    </tr>    \n\n                </tbody>            \n            </table>\n        </td>\n    </tr>\n    <tr>\n        <td align=\"center\" valign=\"top\">\n            <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                <tbody>\n                    <tr>\n                        <td align=\"left\" valign=\"top\">\n                            <div style=\"padding:8px 60px 60px 60px;\">\n                                <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                  A new support ticket has been assigned to you.\n                              </p>\n                              <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                <strong>Subject:</strong> {ticket_subject}<br><strong>Department:</strong> {ticket_department}<br><strong>Priority:</strong> {ticket_priority}                   \n                             </p> \n                             <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                <strong>Customer:</strong>{customer}\n                             </p>\n                             <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                <strong>Ticket message:</strong><br/><span>{ticket_message}</span>\n                             </p>\n                           \n                            <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p>\n                        </div>  \n                    </td>\n\n                </tr>\n            </tbody>\n\n        </table>\n\n\n    </td>\n\n</tr>\n\n\n\n<tr>\n    <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n            <tbody>\n                <tr>\n                    <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                    <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                        <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                        <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                    </td>\n                    <td align=\"right\" valign=\"middle\">\n                        <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                        <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                        <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                    </td>\n                </tr>\n                <tr>\n                    <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                        &copy;2019 {company_name} All rights reserved.\n                    </td>\n                </tr>\n            </tbody>\n        </table>\n    </td>\n</tr>\n</table>\n</body>\n</html>', 'CiusiCRM', 1, 1, 0),
(18, 'ticket', 'ticket_reply_to_staff', 'Ticket Reply', '<!doctype html>\n<html lang=\"en\">\n<head>\n    <!-- Required meta tags -->\n    <meta charset=\"utf-8\">\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n    <title>:: Email ::</title>\n    <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n</head>\n<body>\n    <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n        <thead>\n            <tr>\n                <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                        <tbody>\n                            <tr>                                <td align=\"left\" valign=\"top\">\n                                <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                            </td>    \n                            <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                            </td>\n                        </tr>    \n\n                    </tbody>            \n                </table>\n            </th>\n        </tr>\n    </thead>\n    <tr>\n        <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n            <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n        </td>\n    </tr>\n    <tr>\n        <td align=\"center\" valign=\"top\">\n            <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                <tbody>\n                    <tr>\n                        <td>\n                            <div style=\"padding:8px 60px 0px 60px;\">\n                                <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear Staff</h6>\n                            </div>\n                        </td>\n                    </tr>    \n\n                </tbody>            \n            </table>\n        </td>\n    </tr>\n    <tr>\n        <td align=\"center\" valign=\"top\">\n            <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                <tbody>\n                    <tr>\n                        <td align=\"left\" valign=\"top\">\n                            <div style=\"padding:8px 60px 60px 60px;\">\n                                <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                  A new support ticket reply from {customer}\n                              </p>\n                              <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                <strong>Subject:</strong> {ticket_subject}<br><strong>Department:</strong> {ticket_department}<br><strong>Priority:</strong> {ticket_priority}                   \n                             </p> \n                             <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                <strong>Ticket message:</strong><br/><span>{ticket_message}</span>\n                             </p>\n                           \n                            <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p>\n                        </div>  \n                    </td>\n\n                </tr>\n            </tbody>\n\n        </table>\n\n\n    </td>\n\n</tr>\n\n\n\n<tr>\n    <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n            <tbody>\n                <tr>\n                    <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                    <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                        <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                        <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                    </td>\n                    <td align=\"right\" valign=\"middle\">\n                        <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                        <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                        <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                    </td>\n                </tr>\n                <tr>\n                    <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                        &copy;2019 {company_name} All rights reserved.\n                    </td>\n                </tr>\n            </tbody>\n        </table>\n    </td>\n</tr>\n</table>\n</body>\n</html>', 'CiusiCRM', 1, 1, 0);
INSERT INTO `email_templates` (`id`, `relation`, `name`, `subject`, `message`, `from_name`, `status`, `display`, `attachment`) VALUES
(19, 'ticket', 'ticket_autoresponse', 'New Ticket Opened', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {customer}</h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            Thank you for contacting our team. A ticket has now been created for your request.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            You will be notified when a response is made by email.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            <strong>Subject:</strong> {ticket_subject}<br><strong>Department:</strong> {ticket_department}<br><strong>Priority:</strong> {ticket_priority}                   \n                                        </p> \n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            <strong>Ticket message:</strong><br/><span>{ticket_message}</span>\n                                        </p>\n\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p>\n                                    </div>  \n                                </td>\n\n                            </tr>\n                        </tbody>\n\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 0),
(20, 'ticket', 'ticket_reply_to_customer', 'New Ticket Reply', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {customer}</h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            You have a new ticket reply to ticket.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            You will be notified when a response is made by email.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            <strong>Subject:</strong> {ticket_subject}                  \n                                        </p> \n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            <strong>Ticket message:</strong><br/><span>{ticket_message}</span>\n                                        </p>\n\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p>\n                                    </div>  \n                                </td>\n\n                            </tr>\n                        </tbody>\n\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 0),
(21, 'proposal', 'send_proposal', 'Proposal With Number {proposal_number} Created', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {proposal_to}</h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            Please find our attached proposal.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            This proposal is valid until: {open_till}\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            <strong>Proposal Subject:</strong> {subject}                  \n                                        </p> \n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            <strong>Proposal Details:</strong><br/><span>{details}</span>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            Please don\'t hesitate to comment online if you have any questions.We look forward to your communication.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p>\n                                    </div>  \n                                </td>\n\n                            </tr>\n                        </tbody>\n\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 1),
(22, 'proposal', 'thankyou_email', 'Thank for you accepting the proposal', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {proposal_to}</h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            Thank for for accepting the proposal.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            We look forward to doing business with you.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            We will contact you as soon as possible             \n                                        </p> \n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p>\n                                    </div>  \n                                </td>\n\n                            </tr>\n                        </tbody>\n\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 0),
(23, 'proposal', 'customer_accepted_proposal', 'Customer Accepted Proposal', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear, </h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            Client <strong>{proposal_to}</strong> accepted the following proposal:\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                           <strong>Number:</strong> {proposal_number}<br><strong>Subject</strong>: {subject}<br><strong>Total</strong>: {proposal_total}\n                                        </p>\n                                       \n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p>\n                                    </div>  \n                                </td>\n\n                            </tr>\n                        </tbody>\n\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 0),
(24, 'proposal', 'customer_rejected_proposal', 'Client Declined Proposal', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear, </h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            Client <strong>{proposal_to}</strong> declined the proposal <strong>{subject}</strong>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            <strong>Proposal Number:</strong> {proposal_number}<br><strong>Total</strong>: {proposal_total}\n                                        </p>\n                                       \n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p>\n                                    </div>  \n                                </td>\n\n                            </tr>\n                        </tbody>\n\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 0),
(25, 'lead', 'lead_assigned', 'New lead assigned to you', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {lead_assigned_staff}, </h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                           New lead is assigned to you.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            <strong>Lead Name:</strong> {lead_name} <br>\n                                            <strong>Lead Email:</strong> {lead_email}\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            You can view the lead on the following link: <a href=\"{lead_url}\">View</a>\n                                        </p> \n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p> \n                                    </div>  \n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 0);
INSERT INTO `email_templates` (`id`, `relation`, `name`, `subject`, `message`, `from_name`, `status`, `display`, `attachment`) VALUES
(26, 'project', 'project_notification', 'New project created', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {customer}, </h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            New project is assigned to your company.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            <strong>Project Name:</strong> {project_name}<br><strong>Project Start Date:</strong> {project_start_date}\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            You can view the project on the following link: <a href=\"{project_url}\">{project_name}</a>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            We are looking forward hearing from you.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p>\n                                    </div>  \n                                </td>\n\n                            </tr>\n                        </tbody>\n\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 0),
(27, 'project', 'staff_added', 'New project assigned to you', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {staff}, </h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            New project has been assigned to you.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            You can view the project on the following link <a href=\"{project_url}\" href=\"{project_url}\">{project_name}</a>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p>\n                                    </div>  \n                                </td>\n\n                            </tr>\n                        </tbody>\n\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 0),
(28, 'project', 'new_file_uploaded_to_members', 'New Project File Uploaded - {project_name}', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {staff}, </h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            New project file is uploaded on <strong>{project_name}</strong> by <strong>{loggedin_staff}\n                                            </strong>.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            You can view the project on the following link <a href=\"{project_url}\" href=\"{project_url}\">{project_name}</a>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p>\n                                    </div>  \n                                </td>\n\n                            </tr>\n                        </tbody>\n\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 0),
(29, 'project', 'new_file_uploaded_to_customer', 'New Project File Uploaded - {project_name}', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {customer}, </h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            New project file is uploaded on <strong>{project_name}</strong> by <strong>{loggedin_staff}\n                                            </strong>.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            You can view the project on the following link <a href=\"{project_url}\" href=\"{project_url}\">{project_name}</a>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p>\n                                    </div>  \n                                </td>\n\n                            </tr>\n                        </tbody>\n\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 0),
(30, 'project', 'new_note_to_members', 'New Note on Project - {project_name}', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {staff}, </h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            New note has been made on project <strong>{project_name}</strong> by <strong>{loggedin_staff}\n                                            </strong>.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            <strong>Note</strong>:<br/>{note}.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            You can view the project on the following link <a href=\"{project_url}\">{project_name}</a>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p>\n                                    </div>  \n                                </td>\n\n                            </tr>\n                        </tbody>\n\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 0),
(31, 'project', 'new_note_to_customers', 'New Note on Project - {project_name}', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {customer}, </h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            New note has been made on project <strong>{project_name}</strong> by <strong>{loggedin_staff}\n                                            </strong>.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            <strong>Note</strong>:<br/>{note}.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            You can view the project on the following link <a href=\"{project_url}\">{project_name}</a>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p>\n                                    </div>  \n                                </td>\n\n                            </tr>\n                        </tbody>\n\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 0),
(32, 'project', 'project_status_changed', 'Project Status Changed', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {customer }, </h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            New note has been made on project <strong>{project_name}</strong> by <strong>{loggedin_staff}\n                                            </strong>.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            <strong>Project Name: </strong>{project_name}<br><strong>Project End Date:</strong> {project_end_date}\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            You can view the project on the following link <a href=\"{project_url}\">{project_name}</a>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p>\n                                    </div>  \n                                </td>\n\n                            </tr>\n                        </tbody>\n\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 0);
INSERT INTO `email_templates` (`id`, `relation`, `name`, `subject`, `message`, `from_name`, `status`, `display`, `attachment`) VALUES
(33, 'expense', 'expense_created', 'Expense Created - {expense_number}', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {customer}, </h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                           We have prepared the following expense for you: # <strong>{expense_number}</strong>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            <strong>Expense Title:</strong> {expense_title} <br>\n                                            <strong>Expense Category:</strong> {expense_category} <br>\n                                            <strong>Expense Date:</strong> {expense_date} <br>\n                                            <strong>Expense Description:</strong> {expense_description} <br>\n                                            <strong>Expense Amount:</strong> {expense_amount}\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            Please contact us for more information.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p> \n                                    </div>  \n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 1),
(34, 'staff', 'customer_forgot_password', 'Reset password', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {customer}</h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            Forgot your password?<br>To create a new password, just follow this link:\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            <a href=\"{password_url}\">Reset Password</a>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                           You received this email, because it was requested by a user. This is part of the procedure to create a new password on the system. If you DID NOT request a new password then please ignore this email and your password will remain the same.\n                                        </p> \n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p> \n                                    </div>  \n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 0),
(35, 'staff', 'customer_password_reset', 'Your password has been changed', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear, </h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            <strong>You have changed your password.</strong>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            Please, keep it in your records so you don\'t forget it.<br>Your email address for login is: \n                                            <span style=\"color: rgb(0, 0, 255)\">{email}</span>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            If this was not you, please contact us.\n                                        </p> \n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p> \n                                    </div>  \n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 0),
(36, 'invoice', 'invoice_recurring', 'Recurring Invoice with number {invoice_number} created', '<!doctype html>\n<html lang=\"en\">\n  <head>\n    <!-- Required meta tags -->\n    <meta charset=\"utf-8\">\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n    <title>:: Email ::</title>\n    <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n  </head>\n <body>\n    <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n        <thead>\n            <tr>\n                <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                        <tbody>\n                            <tr>                                <td align=\"left\" valign=\"top\">\n                                    <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                </td>    \n                                <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                    <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </th>\n            </tr>\n        </thead>\n        <tr>\n            <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n            </td>\n        </tr>\n        <tr>\n            <td align=\"center\" valign=\"top\">\n                <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                    <tbody>\n                        <tr>\n                            <td>\n                                <div style=\"padding:8px 60px 0px 60px;\">\n                                    <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {customer}</h6>\n                                </div>\n                            </td>\n                        </tr>    \n\n                    </tbody>            \n                </table>\n            </td>\n        </tr>\n        <tr>\n            <td align=\"center\" valign=\"top\">\n                <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                    <tbody>\n                        <tr>\n                            <td align=\"left\" valign=\"top\">\n                                <div style=\"padding:8px 60px 60px 60px;\">\n                                    <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                      Invoice {invoice_number}\n                                   </p>\n                                    <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                       We have prepared following invoice for you.: #{invoice_number}                              \n                                    </p> \n                                   <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                          You can view the invoice on the following link: <a href=\"{invoice_link}\">Invoice Link</a>\n                                   </p>\n                                   <p>Invoice Status: {invoice_status} </p>\n                                   <p>please contact us for following information.</p>\n                           \n                               \n\n                                    <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p> \n                                </div>  \n                            </td>\n                            \n                        </tr>\n                    </tbody>\n                \n                </table>\n                \n            \n            </td>\n            \n        </tr>\n        \n     \n      \n        <tr>\n            <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                    <tbody>\n                        <tr>\n                            <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                            <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                            </td>\n                            <td align=\"right\" valign=\"middle\">\n                                <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                            </td>\n                        </tr>\n                        <tr>\n                            <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                &copy;2019 {company_name} All rights reserved.\n                            </td>\n                        </tr>\n                    </tbody>\n                </table>\n            </td>\n        </tr>\n    </table>\n</body>\n</html>', 'CiusiCRM', 1, 1, 1),
(37, 'lead', 'web_lead_created', 'New Online Web lead created', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {lead_assigned_staff}, </h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                           New lead is assigned to you.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            <strong>Lead Name:</strong> {lead_name} <br>\n                                            <strong>Lead Email:</strong> {lead_email}\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            You can view the lead on the following link: <a href=\"{lead_url}\">View</a>\n                                        </p> \n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p> \n                                    </div>  \n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 0, 1, 0),
(38, 'lead', 'lead_submitted', 'New lead has been created for you', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {lead_name}, </h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                           New lead has been created for you.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            <strong>Lead Email:</strong> {lead_email}\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p> \n                                    </div>  \n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 0, 1, 0),
(39, 'expense', 'expense_recurring', 'Recurring Expense with number {expense_number} created', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {customer}, </h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                           We have prepared the following expense for you: # <strong>{expense_number}</strong>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            <strong>Expense Title:</strong> {expense_title} <br>\n                                            <strong>Expense Category:</strong> {expense_category} <br>\n                                            <strong>Expense Date:</strong> {expense_date} <br>\n                                            <strong>Expense Amount:</strong> {expense_amount}\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            Please contact us for more information.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p> \n                                    </div>  \n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 0, 1, 1);
INSERT INTO `email_templates` (`id`, `relation`, `name`, `subject`, `message`, `from_name`, `status`, `display`, `attachment`) VALUES
(40, 'project', 'new_note_to_members_by_customer', 'New Note on Project by customer - {project_name}', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Hello, </h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            New note has been made on project <strong>{project_name}</strong> by <strong>{loggedin_staff}\n                                            </strong>.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            <strong>Note</strong>:<br/>{note}.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            You can view the project on the following link <a href=\"{project_url}\">{project_name}</a>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p>\n                                    </div>  \n                                </td>\n\n                            </tr>\n                        </tbody>\n\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 0),
(41, 'project', 'new_file_uploaded_by_customer', 'New Project File Uploaded By Customer - {project_name}', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Hello, </h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            New project file is uploaded on <strong>{project_name}</strong> by <strong>{loggedin_staff}\n                                            </strong>.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            You can find the attachment below attached.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            You can view the project on the following link <a href=\"{project_url}\">{project_name}</a>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p>\n                                    </div>  \n                                </td>\n\n                            </tr>\n                        </tbody>\n\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 0),
(42, 'order', 'order_message', 'Order {order_number} confirmed', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {customer_name}, </h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            Thank you very much for your recent order with {company_name}.  Your order is currently being processed and you will receive a shipping confirmation once the order has been shipped.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            Please contact us for more information.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p> \n                                    </div>  \n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 1),
(43, 'quote', 'request_quote', 'New Quote requested by {customer_name}', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {staff}, </h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                           <strong>{customer_name}</strong> has requested a new quote.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            <strong>Quote Subject:</strong> {subject} <br/>\n                                            <strong>Quote Details:</strong> {details} <br/>\n                                            <strong>Quote Link:</strong> <a href=\"{quote_link}\">{quote_link}</a>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p> \n                                    </div>  \n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 0),
(44, 'quote', 'quote_status_changed', 'Quote Status has Changed by {staff}', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {customer_name}, </h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                           <strong>{staff}</strong> marked quote as <strong>{quote_status}</strong>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            <strong>Quote Subject:</strong> {subject} <br/>\n                                            <strong>Quote Details:</strong> {details} <br/>\n                                            <strong>Quote Link:</strong> <a href=\"{quote_link}\">{quote_link}</a>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p> \n                                    </div>  \n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 0),
(45, 'staff', 'event_reminder', 'Event Reminder', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {staff}, </h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            This is the <strong>{event_title}</strong> reminder.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p> \n                                    </div>  \n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 0),
(46, 'purchase', 'purchase_message', 'purchase with number {purchase_number} created', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {vendor_name}, </h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            We have prepared the following purchase  for you: # <strong>{purchase_number}</strong>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            <strong>Purchase status:</strong> {purchase_status}\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                           You can view the purchase on the following link: <a href=\"{purchase_link}\">{purchase_number}</a>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            Please contact us for more information.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p> \n                                    </div>  \n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 1);
INSERT INTO `email_templates` (`id`, `relation`, `name`, `subject`, `message`, `from_name`, `status`, `display`, `attachment`) VALUES
(47, 'purchase', 'purchase_payment', 'Purchase Payment Recorded', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {vendor_name}</h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                          Thank you for the payment. Find the payment details below:\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            Amount: <strong>{payment_amount}</strong><br/>\n                                            Date: <strong>{payment_date}</strong><br/>\n                                            Purchase Number: #<strong>{purchase_number}</strong>                                                                  \n                                        </p> \n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            You can always view the purchase for this payment at the following link: \n                                            <a href=\"{purchase_link}\">{purchase_number}</a>\n                                        </p>                                  \n                                        <p>We are looking forward working with you.</p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p> \n                                    </div>  \n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 0),
(48, 'purchase', 'purchase_recurring', 'Recurring Purchase with number {purchase_number} created', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {vendor_name}, </h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            We have prepared the following purchase  for you: # <strong>{purchase_number}</strong>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            <strong>Purchase status:</strong> {purchase_status}\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                           You can view the purchase on the following link: <a href=\"{purchase_link}\">{purchase_number}</a>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            Please contact us for more information.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p> \n                                    </div>  \n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 1),
(49, 'deposit', 'deposit_message', 'Deposit with number {deposit_number} created', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {customer_name}, </h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            We have prepared the following deposit for you: # <strong>{deposit_number}</strong>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            <strong>Deposit status:</strong> {deposit_status}\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                           You can view the deposit on the following link: <a href=\"{deposit_link}\">{deposit_number}</a>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            Please contact us for more information.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p> \n                                    </div>  \n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 1),
(50, 'deposit', 'recurring_deposit', 'Recurring Deposit with number {deposit_number} created', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {customer_name}, </h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            We have prepared the following deposit for you: # <strong>{deposit_number}</strong>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            <strong>Deposit status:</strong> {deposit_status}\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                           You can view the deposit on the following link: <a href=\"{deposit_link}\">{deposit_number}</a>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            Please contact us for more information.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p> \n                                    </div>  \n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 1),
(51, 'staff', 'new_appointment', 'New Appointment', '<!doctype html>\n<html lang=\"en\">\n    <head>\n        <!-- Required meta tags -->\n        <meta charset=\"utf-8\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n        <title>:: Email ::</title>\n        <link href=\"https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,600,700,800,900&display=swap\" rel=\"stylesheet\" type=\"text/css\" >\n    </head>\n    <body>\n        <table style=\"border:1px solid #bcb5b9; font-family: \'Blinker\';\" width=\"600\" align=\"center\" cellspacing=\"0\"  cellpadding=\"0\">\n            <thead>\n                <tr>\n                    <th align=\"center\" valign=\"top\" cellspacing=\"0\"  cellpadding=\"0\">\n                        <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\" border: 0;\">\n                            <tbody>\n                                <tr>                                \n                                    <td align=\"left\" valign=\"top\">\n                                        <a style=\"display:inline-block; border-top: 7px solid #49b232; padding:27px 0px 0px 0px;\"><img src=\"{site_url}uploads/ciuis_settings/{logo}\"/></a>\n                                    </td>    \n                                    <td align=\"right\" valign=\"bottom\" style=\"font-weight: 300;\">\n                                        <a style=\"display:inline-block; color:#959eac; font-size:12px; border-bottom:1px solid #ece8e8; padding-bottom:2px; text-decoration:none\" href=\"#\">View in Browser</a>\n                                    </td>\n                                </tr>    \n\n                            </tbody>            \n                        </table>\n                    </th>\n                </tr>\n            </thead>\n            <tr>\n                <td align=\"center\" valign=\"top\" style=\"padding-top:16px\">\n                    <img src=\"{site_url}uploads/ciuis_settings/{email_banner}\" alt=\"\"/>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td>\n                                    <div style=\"padding:8px 60px 0px 60px;\">\n                                        <h6 style=\"margin:0px 0px 0px 0px; font-weight:400; color:#192030; font-size:17px; font-weight:600;\">Dear {staff_name}, </h6>\n                                    </div>\n                                </td>\n                            </tr>    \n\n                        </tbody>            \n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td align=\"center\" valign=\"top\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\"  style=\"border:0\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\">\n                                    <div style=\"padding:8px 60px 60px 60px;\">\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                           <strong>{contact_name}</strong> has requested for appointment.\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            Appointment Date: <strong>{appointment_date}</strong><br>\n                                            Appointment Time: <strong>{appointment_time}</strong>\n                                        </p>\n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\">\n                                            Please contact us for more information.\n                                        </p> \n                                        <p style=\"color:#192030; margin:20px 0px 20px 0px; line-height:22px;\"><strong>Kind Regards,</strong><br/>The {company_name} team</p> \n                                    </div>  \n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n            <tr>\n                <td style=\"background:#1c2238; padding:10px 0px;\" align=\"center\" valign=\"middle\">\n                    <table width=\"88%\" cellspacing=\"0\"  cellpadding=\"0\" style=\" border: 0;\">\n                        <tbody>\n                            <tr>\n                                <td align=\"left\" valign=\"top\" width=\"30\"><img src=\"{site_url}uploads/ciuis_settings/{footer_logo}\"/></td>\n                                <td align=\"left\" valign=\"top\" style=\"padding:0px 0px 20px 20px;\">\n                                    <h5 style=\"margin:0px 0px 0px 0px; color:#49b232; text-align:left; font-size:14px; font-weight:600;\">Contact Us</h5>\n                                    <p style=\"color:#bfc5d2; margin:0px 0px 0px 0px; font-size:14px;\">{company_email}</p>\n                                </td>\n                                <td align=\"right\" valign=\"middle\">\n                                    <img src=\"{site_url}assets/img/email/linkedin.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/twitter.jpg\"/>\n                                    <img src=\"{site_url}assets/img/email/youtube.jpg\"/>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td colspan=\"3\" style=\"border-top:1px solid #bfc5d2; padding:16px 0px 20px 0px; color:#bfc5d2; font-size:14px;\">\n                                    &copy;2019 {company_name} All rights reserved.\n                                </td>\n                            </tr>\n                        </tbody>\n                    </table>\n                </td>\n            </tr>\n        </table>\n    </body>\n</html>', 'CiusiCRM', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `email_template_fields`
--

CREATE TABLE `email_template_fields` (
  `id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `field_name` varchar(255) NOT NULL,
  `field_value` varchar(255) NOT NULL,
  `template_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `email_template_fields`
--

INSERT INTO `email_template_fields` (`id`, `template_id`, `field_name`, `field_value`, `template_name`) VALUES
(1, 1, 'customer', 'customer', 'invoice_message'),
(2, 1, 'company_name', 'company_name', 'invoice_message'),
(3, 1, 'company_email', 'company_email', 'invoice_message'),
(4, 1, 'name', 'name', 'invoice_message'),
(5, 1, 'invoice_number', 'invoice_number', 'invoice_message'),
(6, 1, 'invoice_status', 'invoice_status', 'invoice_message'),
(7, 1, 'invoice_link', 'invoice_link', 'invoice_message'),
(8, 1, 'email_signature', 'email_signature', 'invoice_message'),
(9, 1, 'site_url', 'site_url', 'invoice_message'),
(10, 3, 'customer', 'customer', 'invoice_payment'),
(11, 3, 'company_name', 'company_name', 'invoice_payment'),
(12, 3, 'company_email', 'company_email', 'invoice_payment'),
(13, 3, 'payment_total', 'payment_total', 'invoice_payment'),
(14, 3, 'payment_date', 'payment_date', 'invoice_payment'),
(15, 3, 'invoice_number', 'invoice_number', 'invoice_payment'),
(16, 3, 'invoice_link', 'invoice_link', 'invoice_payment'),
(17, 3, 'email_signature', 'email_signature', 'invoice_payment'),
(18, 3, 'site_url', 'site_url', 'invoice_payment'),
(19, 4, 'invoice_number', 'invoice_number', 'invoice_overdue'),
(20, 4, 'invoice_duedate', 'invoice_duedate', 'invoice_overdue'),
(21, 4, 'name', 'name', 'invoice_overdue'),
(22, 4, 'email_signature', 'email_signature', 'invoice_overdue'),
(23, 4, 'customer', 'customer', 'invoice_overdue'),
(24, 5, 'customer', 'customer', 'new_contact_added'),
(25, 5, 'company_name', 'company_name', 'new_contact_added'),
(26, 5, 'company_email', 'company_email', 'new_contact_added'),
(27, 5, 'name', 'name', 'new_contact_added'),
(28, 5, 'companyname', 'companyname', 'new_contact_added'),
(29, 5, 'app_url', 'app_url', 'new_contact_added'),
(30, 5, 'login_email', 'login_email', 'new_contact_added'),
(31, 5, 'login_password', 'login_password', 'new_contact_added'),
(32, 5, 'email_signature', 'email_signature', 'new_contact_added'),
(33, 5, 'site_url', 'site_url', 'new_contact_added'),
(34, 6, 'name', 'name', 'new_customer'),
(35, 6, 'customer_email', 'customer_email', 'new_customer'),
(36, 6, 'company_name', 'company_name', 'new_customer'),
(37, 6, 'company_email', 'company_email', 'new_customer'),
(38, 6, 'customer_type', 'customer_type', 'new_customer'),
(39, 6, 'site_url', 'site_url', 'new_customer'),
(40, 7, 'staff', 'staff', 'new_staff'),
(41, 7, 'staff_email', 'staff_email', 'new_staff'),
(42, 7, 'company_name', 'company_name', 'new_staff'),
(43, 7, 'company_email', 'company_email', 'new_staff'),
(44, 7, 'name', 'name', 'new_staff'),
(45, 7, 'password', 'password', 'new_staff'),
(46, 7, 'email_signature', 'email_signature', 'new_staff'),
(47, 7, 'login_url', 'login_url', 'new_staff'),
(48, 7, 'site_url', 'site_url', 'new_staff'),
(49, 8, 'staffname', 'staffname', 'forgot_password'),
(50, 8, 'password_url', 'password_url', 'forgot_password'),
(51, 8, 'email_signature', 'email_signature', 'forgot_password'),
(52, 8, 'company_name', 'company_name', 'forgot_password'),
(53, 8, 'company_email', 'company_email', 'forgot_password'),
(54, 8, 'site_url', 'site_url', 'forgot_password'),
(55, 9, 'staff_email', 'staff_email', 'password_reset'),
(56, 9, 'email_signature', 'email_signature', 'password_reset'),
(57, 9, 'staffname', 'staffname', 'password_reset'),
(58, 9, 'company_name', 'company_name', 'password_reset'),
(59, 9, 'company_email', 'company_email', 'password_reset'),
(60, 9, 'site_url', 'site_url', 'password_reset'),
(61, 11, 'name', 'name', 'new_task_assigned'),
(62, 11, 'staffname', 'staffname', 'new_task_assigned'),
(63, 11, 'task_name', 'task_name', 'new_task_assigned'),
(64, 11, 'task_priority', 'task_priority', 'new_task_assigned'),
(65, 11, 'task_startdate', 'task_startdate', 'new_task_assigned'),
(66, 11, 'task_duedate', 'task_duedate', 'new_task_assigned'),
(67, 11, 'task_url', 'task_url', 'new_task_assigned'),
(68, 11, 'task_status', 'task_status', 'new_task_assigned'),
(69, 11, 'task_description', 'task_description', 'new_task_assigned'),
(70, 11, 'email_signature', 'email_signature', 'new_task_assigned'),
(71, 11, 'company_name', 'company_name', 'new_task_assigned'),
(72, 11, 'company_email', 'company_email', 'new_task_assigned'),
(73, 11, 'site_url', 'site_url', 'new_task_assigned'),
(74, 12, 'name', 'name', 'task_comments'),
(75, 12, 'staffname', 'staffname', 'task_comments'),
(76, 12, 'task_name', 'task_name', 'task_comments'),
(77, 12, 'task_status', 'task_status', 'task_comments'),
(78, 12, 'task_startdate', 'task_startdate', 'task_comments'),
(79, 12, 'task_duedate', 'task_duedate', 'task_comments'),
(80, 12, 'task_priority', 'task_priority', 'task_comments'),
(81, 12, 'task_url', 'task_url', 'task_comments'),
(82, 12, 'task_comment', 'task_comment', 'task_comments'),
(83, 12, 'company_name', 'company_name', 'task_comments'),
(84, 12, 'company_email', 'company_email', 'task_comments'),
(85, 12, 'email_signature', 'email_signature', 'task_comments'),
(86, 12, 'site_url', 'site_url', 'task_comments'),
(87, 13, 'task_name', 'task_name', 'task_attachment'),
(88, 13, 'task_status', 'task_status', 'task_attachment'),
(89, 13, 'task_startdate', 'task_startdate', 'task_attachment'),
(90, 13, 'task_duedate', 'task_duedate', 'task_attachment'),
(91, 13, 'task_priority', 'task_priority', 'task_attachment'),
(92, 13, 'task_url', 'task_url', 'task_attachment'),
(93, 13, 'name', 'name', 'task_attachment'),
(94, 13, 'staffname', 'staffname', 'task_attachment'),
(95, 13, 'company_name', 'company_name', 'task_attachment'),
(96, 13, 'company_email', 'company_email', 'task_attachment'),
(97, 13, 'logged_in_user', 'logged_in_user', 'task_attachment'),
(98, 13, 'email_signature', 'email_signature', 'task_attachment'),
(99, 13, 'site_url', 'site_url', 'task_attachment'),
(100, 14, 'task_name', 'task_name', 'task_updated'),
(101, 14, 'task_status', 'task_status', 'task_updated'),
(102, 14, 'task_startdate', 'task_startdate', 'task_updated'),
(103, 14, 'task_duedate', 'task_duedate', 'task_updated'),
(104, 14, 'task_priority', 'task_priority', 'task_updated'),
(105, 14, 'task_url', 'task_url', 'task_updated'),
(106, 14, 'name', 'name', 'task_updated'),
(107, 14, 'staffname', 'staffname', 'task_updated'),
(108, 14, 'logged_in_user', 'logged_in_user', 'task_updated'),
(109, 14, 'email_signature', 'email_signature', 'task_updated'),
(110, 14, 'company_name', 'company_name', 'task_updated'),
(111, 14, 'company_email', 'company_email', 'task_updated'),
(112, 14, 'site_url', 'site_url', 'task_updated'),
(113, 15, 'name', 'name', 'new_ticket'),
(114, 15, 'customer', 'customer', 'new_ticket'),
(115, 15, 'ticket_subject', 'ticket_subject', 'new_ticket'),
(116, 15, 'ticket_department', 'ticket_department', 'new_ticket'),
(117, 15, 'ticket_priority', 'ticket_priority', 'new_ticket'),
(118, 15, 'ticket_message', 'ticket_message', 'new_ticket'),
(119, 15, 'email_signature', 'email_signature', 'new_ticket'),
(120, 15, 'company_name', 'company_name', 'new_ticket'),
(121, 15, 'company_email', 'company_email', 'new_ticket'),
(122, 15, 'site_url', 'site_url', 'new_ticket'),
(123, 16, 'ticket_subject', 'ticket_subject', 'new_customer_ticket'),
(124, 16, 'ticket_department', 'ticket_department', 'new_customer_ticket'),
(125, 16, 'ticket_priority', 'ticket_priority', 'new_customer_ticket'),
(126, 16, 'ticket_message', 'ticket_message', 'new_customer_ticket'),
(127, 16, 'name', 'name', 'new_customer_ticket'),
(128, 16, 'email_signature', 'email_signature', 'new_customer_ticket'),
(129, 16, 'company_name', 'company_name', 'new_customer_ticket'),
(130, 16, 'company_email', 'company_email', 'new_customer_ticket'),
(131, 16, 'site_url', 'site_url', 'new_customer_ticket'),
(132, 17, 'ticket_subject', 'ticket_subject', 'ticket_assigned'),
(133, 17, 'ticket_department', 'ticket_department', 'ticket_assigned'),
(134, 17, 'ticket_priority', 'ticket_priority', 'ticket_assigned'),
(135, 17, 'ticket_message', 'ticket_message', 'ticket_assigned'),
(136, 17, 'name', 'name', 'ticket_assigned'),
(137, 17, 'assigned', 'assigned', 'ticket_assigned'),
(138, 17, 'company_name', 'company_name', 'ticket_assigned'),
(139, 17, 'company_email', 'company_email', 'ticket_assigned'),
(140, 17, 'email_signature', 'email_signature', 'ticket_assigned'),
(141, 17, 'site_url', 'site_url', 'ticket_assigned'),
(142, 18, 'ticket_subject', 'ticket_subject', 'ticket_reply_to_staff'),
(143, 18, 'ticket_department', 'ticket_department', 'ticket_reply_to_staff'),
(144, 18, 'ticket_priority', 'ticket_priority', 'ticket_reply_to_staff'),
(145, 18, 'ticket_message', 'ticket_message', 'ticket_reply_to_staff'),
(146, 18, 'name', 'name', 'ticket_reply_to_staff'),
(147, 18, 'email_signature', 'email_signature', 'ticket_reply_to_staff'),
(148, 18, 'company_name', 'company_name', 'ticket_reply_to_staff'),
(149, 18, 'company_email', 'company_email', 'ticket_reply_to_staff'),
(150, 18, 'site_url', 'site_url', 'ticket_reply_to_staff'),
(151, 19, 'ticket_subject', 'ticket_subject', 'ticket_autoresponse'),
(152, 19, 'ticket_department', 'ticket_department', 'ticket_autoresponse'),
(153, 19, 'ticket_priority', 'ticket_priority', 'ticket_autoresponse'),
(154, 19, 'ticket_message', 'ticket_message', 'ticket_autoresponse'),
(155, 19, 'name', 'name', 'ticket_autoresponse'),
(156, 19, 'customer', 'customer', 'ticket_autoresponse'),
(157, 19, 'email_signature', 'email_signature', 'ticket_autoresponse'),
(158, 19, 'company_name', 'company_name', 'ticket_autoresponse'),
(159, 19, 'company_email', 'company_email', 'ticket_autoresponse'),
(160, 19, 'site_url', 'site_url', 'ticket_autoresponse'),
(161, 20, 'ticket_subject', 'ticket_subject', 'ticket_reply_to_customer'),
(162, 20, 'ticket_message', 'ticket_message', 'ticket_reply_to_customer'),
(163, 20, 'name', 'name', 'ticket_reply_to_customer'),
(164, 20, 'customer', 'customer', 'ticket_reply_to_customer'),
(165, 20, 'company_name', 'company_name', 'ticket_reply_to_customer'),
(166, 20, 'company_email', 'company_email', 'ticket_reply_to_customer'),
(167, 20, 'email_signature', 'email_signature', 'ticket_reply_to_customer'),
(168, 20, 'site_url', 'site_url', 'ticket_reply_to_customer'),
(169, 21, 'name', 'name', 'send_proposal'),
(170, 21, 'proposal_to', 'proposal_to', 'send_proposal'),
(171, 21, 'subject', 'subject', 'send_proposal'),
(172, 21, 'open_till', 'open_till', 'send_proposal'),
(173, 21, 'details', 'details', 'send_proposal'),
(174, 21, 'proposal_link', 'proposal_link', 'send_proposal'),
(175, 21, 'company_name', 'company_name', 'send_proposal'),
(176, 21, 'company_email', 'company_email', 'send_proposal'),
(177, 21, 'email_signature', 'email_signature', 'send_proposal'),
(178, 21, 'site_url', 'site_url', 'send_proposal'),
(179, 22, 'name', 'name', 'thankyou_email'),
(180, 22, 'proposal_to', 'proposal_to', 'thankyou_email'),
(181, 22, 'subject', 'subject', 'thankyou_email'),
(182, 22, 'details', 'details', 'thankyou_email'),
(183, 22, 'proposal_number', 'proposal_number', 'thankyou_email'),
(184, 22, 'email_signature', 'email_signature', 'thankyou_email'),
(185, 22, 'company_name', 'company_name', 'thankyou_email'),
(186, 22, 'company_email', 'company_email', 'thankyou_email'),
(187, 22, 'site_url', 'site_url', 'thankyou_email'),
(188, 23, 'name', 'name', 'customer_accepted_proposal'),
(189, 23, 'proposal_to', 'proposal_to', 'customer_accepted_proposal'),
(190, 23, 'subject', 'subject', 'customer_accepted_proposal'),
(191, 23, 'details', 'details', 'customer_accepted_proposal'),
(192, 23, 'email_signature', 'email_signature', 'customer_accepted_proposal'),
(193, 23, 'proposal_number', 'proposal_number', 'customer_accepted_proposal'),
(194, 23, 'proposal_total', 'proposal_total', 'customer_accepted_proposal'),
(195, 23, 'company_name', 'company_name', 'customer_accepted_proposal'),
(196, 23, 'company_email', 'company_email', 'customer_accepted_proposal'),
(197, 23, 'site_url', 'site_url', 'customer_accepted_proposal'),
(198, 24, 'name', 'name', 'customer_rejected_proposal'),
(199, 24, 'proposal_to', 'proposal_to', 'customer_rejected_proposal'),
(200, 24, 'subject', 'subject', 'customer_rejected_proposal'),
(201, 24, 'details', 'details', 'customer_rejected_proposal'),
(202, 24, 'proposal_number', 'proposal_number', 'customer_rejected_proposal'),
(203, 24, 'proposal_total', 'proposal_total', 'customer_rejected_proposal'),
(204, 24, 'company_name', 'company_name', 'customer_rejected_proposal'),
(205, 24, 'company_email', 'company_email', 'customer_rejected_proposal'),
(206, 24, 'email_signature', 'email_signature', 'customer_rejected_proposal'),
(207, 24, 'site_url', 'site_url', 'customer_rejected_proposal'),
(208, 25, 'lead_name', 'lead_name', 'lead_assigned'),
(209, 25, 'lead_email', 'lead_email', 'lead_assigned'),
(210, 25, 'lead_url', 'lead_url', 'lead_assigned'),
(211, 25, 'lead_assigned_staff', 'lead_assigned_staff', 'lead_assigned'),
(212, 25, 'name', 'name', 'lead_assigned'),
(213, 25, 'email_signature', 'email_signature', 'lead_assigned'),
(214, 25, 'company_name', 'company_name', 'lead_assigned'),
(215, 25, 'company_email', 'company_email', 'lead_assigned'),
(216, 25, 'site_url', 'site_url', 'lead_assigned'),
(217, 26, 'name', 'name', 'project_notification'),
(218, 26, 'customer', 'customer', 'project_notification'),
(219, 26, 'project_name', 'project_name', 'project_notification'),
(220, 26, 'project_url', 'project_url', 'project_notification'),
(221, 26, 'project_start_date', 'project_start_date', 'project_notification'),
(222, 26, 'project_end_date', 'project_end_date', 'project_notification'),
(223, 26, 'project_value', 'project_value', 'project_notification'),
(224, 26, 'project_status', 'project_status', 'project_notification'),
(225, 26, 'project_tax', 'project_tax', 'project_notification'),
(226, 26, 'project_description', 'project_description', 'project_notification'),
(227, 26, 'company_name', 'company_name', 'project_notification'),
(228, 26, 'company_email', 'company_email', 'project_notification'),
(229, 26, 'email_signature', 'email_signature', 'project_notification'),
(230, 26, 'site_url', 'site_url', 'project_notification'),
(231, 27, 'name', 'name', 'staff_added'),
(232, 27, 'customer', 'customer', 'staff_added'),
(233, 27, 'project_name', 'project_name', 'staff_added'),
(234, 27, 'project_start_date', 'project_start_date', 'staff_added'),
(235, 27, 'project_end_date', 'project_end_date', 'staff_added'),
(236, 27, 'project_value', 'project_value', 'staff_added'),
(237, 27, 'project_tax', 'project_tax', 'staff_added'),
(238, 27, 'project_url', 'project_url', 'staff_added'),
(239, 27, 'staff', 'staff', 'staff_added'),
(240, 27, 'loggedin_staff', 'loggedin_staff', 'staff_added'),
(241, 27, 'company_name', 'company_name', 'staff_added'),
(242, 27, 'company_email', 'company_email', 'staff_added'),
(243, 27, 'email_signature', 'email_signature', 'staff_added'),
(244, 27, 'site_url', 'site_url', 'staff_added'),
(245, 28, 'customer', 'customer', 'new_file_uploaded_to_members'),
(246, 28, 'staff', 'staff', 'new_file_uploaded_to_members'),
(247, 28, 'project_name', 'project_name', 'new_file_uploaded_to_members'),
(248, 28, 'project_start_date', 'project_start_date', 'new_file_uploaded_to_members'),
(249, 28, 'project_end_date', 'project_end_date', 'new_file_uploaded_to_members'),
(250, 28, 'project_value', 'project_value', 'new_file_uploaded_to_members'),
(251, 28, 'project_tax', 'project_tax', 'new_file_uploaded_to_members'),
(252, 28, 'project_url', 'project_url', 'new_file_uploaded_to_members'),
(253, 28, 'name', 'name', 'new_file_uploaded_to_members'),
(254, 28, 'email_signature', 'email_signature', 'new_file_uploaded_to_members'),
(255, 28, 'loggedin_staff', 'loggedin_staff', 'new_file_uploaded_to_members'),
(256, 28, 'company_name', 'company_name', 'new_file_uploaded_to_members'),
(257, 28, 'company_email', 'company_email', 'new_file_uploaded_to_members'),
(258, 28, 'site_url', 'site_url', 'new_file_uploaded_to_members'),
(259, 29, 'name', 'name', 'new_file_uploaded_to_customer'),
(260, 29, 'customer', 'customer', 'new_file_uploaded_to_customer'),
(261, 29, 'project_name', 'project_name', 'new_file_uploaded_to_customer'),
(262, 29, 'project_value', 'project_value', 'new_file_uploaded_to_customer'),
(263, 29, 'project_start_date', 'project_start_date', 'new_file_uploaded_to_customer'),
(264, 29, 'project_end_date', 'project_end_date', 'new_file_uploaded_to_customer'),
(265, 29, 'project_tax', 'project_tax', 'new_file_uploaded_to_customer'),
(266, 29, 'project_url', 'project_url', 'new_file_uploaded_to_customer'),
(267, 29, 'email_signature', 'email_signature', 'new_file_uploaded_to_customer'),
(268, 29, 'loggedin_staff', 'loggedin_staff', 'new_file_uploaded_to_customer'),
(269, 29, 'company_name', 'company_name', 'new_file_uploaded_to_customer'),
(270, 29, 'company_email', 'company_email', 'new_file_uploaded_to_customer'),
(271, 29, 'site_url', 'site_url', 'new_file_uploaded_to_customer'),
(272, 30, 'note', 'note', 'new_note_to_members'),
(273, 30, 'customer', 'customer', 'new_note_to_members'),
(274, 30, 'project_name', 'project_name', 'new_note_to_members'),
(275, 30, 'project_value', 'project_value', 'new_note_to_members'),
(276, 30, 'project_start_date', 'project_start_date', 'new_note_to_members'),
(277, 30, 'project_end_date', 'project_end_date', 'new_note_to_members'),
(278, 30, 'project_tax', 'project_tax', 'new_note_to_members'),
(279, 30, 'project_url', 'project_url', 'new_note_to_members'),
(280, 30, 'name', 'name', 'new_note_to_members'),
(281, 30, 'email_signature', 'email_signature', 'new_note_to_members'),
(282, 30, 'loggedin_staff', 'loggedin_staff', 'new_note_to_members'),
(283, 30, 'company_name', 'company_name', 'new_note_to_members'),
(284, 30, 'company_email', 'company_email', 'new_note_to_members'),
(285, 30, 'site_url', 'site_url', 'new_note_to_members'),
(286, 31, 'customer', 'customer', 'new_note_to_customers'),
(287, 31, 'note', 'note', 'new_note_to_customers'),
(288, 31, 'project_name', 'project_name', 'new_note_to_customers'),
(289, 31, 'project_start_date', 'project_start_date', 'new_note_to_customers'),
(290, 31, 'project_end_date', 'project_end_date', 'new_note_to_customers'),
(291, 31, 'project_value', 'project_value', 'new_note_to_customers'),
(292, 31, 'project_tax', 'project_tax', 'new_note_to_customers'),
(293, 31, 'project_url', 'project_url', 'new_note_to_customers'),
(294, 31, 'name', 'name', 'new_note_to_customers'),
(295, 31, 'email_signature', 'email_signature', 'new_note_to_customers'),
(296, 31, 'loggedin_staff', 'loggedin_staff', 'new_note_to_customers'),
(297, 31, 'company_name', 'company_name', 'new_note_to_customers'),
(298, 31, 'company_email', 'company_email', 'new_note_to_customers'),
(299, 31, 'site_url', 'site_url', 'new_note_to_customers'),
(300, 32, 'name', 'name', 'project_status_changed'),
(301, 32, 'customer', 'customer', 'project_status_changed'),
(302, 32, 'project_name', 'project_name', 'project_status_changed'),
(303, 32, 'project_value', 'project_value', 'project_status_changed'),
(304, 32, 'project_start_date', 'project_start_date', 'project_status_changed'),
(305, 32, 'project_end_date', 'project_end_date', 'project_status_changed'),
(306, 32, 'project_tax', 'project_tax', 'project_status_changed'),
(307, 32, 'project_url', 'project_url', 'project_status_changed'),
(308, 32, 'email_signature', 'email_signature', 'project_status_changed'),
(309, 32, 'loggedin_staff', 'loggedin_staff', 'project_status_changed'),
(310, 32, 'company_name', 'company_name', 'project_status_changed'),
(311, 32, 'company_email', 'company_email', 'project_status_changed'),
(312, 32, 'site_url', 'site_url', 'project_status_changed'),
(313, 33, 'customer', 'customer', 'expense_created'),
(314, 33, 'expense_number', 'expense_number', 'expense_created'),
(315, 33, 'expense_title', 'expense_title', 'expense_created'),
(316, 33, 'expense_category', 'expense_category', 'expense_created'),
(317, 33, 'expense_date', 'expense_date', 'expense_created'),
(318, 33, 'expense_amount', 'expense_amount', 'expense_created'),
(319, 33, 'name', 'name', 'expense_created'),
(320, 33, 'email_signature', 'email_signature', 'expense_created'),
(321, 33, 'company_name', 'company_name', 'expense_created'),
(322, 33, 'company_email', 'company_email', 'expense_created'),
(323, 33, 'site_url', 'site_url', 'expense_created'),
(324, 34, 'customer', 'customer', 'customer_forgot_password'),
(325, 34, 'email_signature', 'email_signature', 'customer_forgot_password'),
(326, 34, 'company_name', 'company_name', 'customer_forgot_password'),
(327, 34, 'company_email', 'company_email', 'customer_forgot_password'),
(328, 34, 'site_url', 'site_url', 'customer_forgot_password'),
(329, 35, 'email', 'email', 'customer_password_reset'),
(330, 35, 'email_signature', 'email_signature', 'customer_password_reset'),
(331, 35, 'company_name', 'company_name', 'customer_password_reset'),
(332, 35, 'company_email', 'company_email', 'customer_password_reset'),
(333, 35, 'site_url', 'site_url', 'customer_password_reset'),
(334, 36, 'name', 'name', 'invoice_recurring'),
(335, 36, 'customer', 'customer', 'invoice_recurring'),
(336, 36, 'invoice_number', 'invoice_number', 'invoice_recurring'),
(337, 36, 'invoice_link', 'invoice_link', 'invoice_recurring'),
(338, 36, 'invoice_status', 'invoice_status', 'invoice_recurring'),
(339, 36, 'email_signature', 'email_signature', 'invoice_recurring'),
(340, 36, 'company_name', 'company_name', 'invoice_recurring'),
(341, 36, 'company_email', 'company_email', 'invoice_recurring'),
(342, 36, 'site_url', 'site_url', 'invoice_recurring'),
(343, 37, 'lead_assigned_staff', 'lead_assigned_staff', 'web_lead_created'),
(344, 37, 'lead_name', 'lead_name', 'web_lead_created'),
(345, 37, 'lead_email', 'lead_email', 'web_lead_created'),
(346, 37, 'lead_url', 'lead_url', 'web_lead_created'),
(347, 37, 'email_signature', 'email_signature', 'web_lead_created'),
(348, 37, 'name', 'name', 'web_lead_created'),
(349, 37, 'company_name', 'company_name', 'web_lead_created'),
(350, 37, 'company_email', 'company_email', 'web_lead_created'),
(351, 37, 'site_url', 'site_url', 'web_lead_created'),
(352, 39, 'expense_title', 'expense_title', 'expense_recurring'),
(353, 39, 'expense_number', 'expense_number', 'expense_recurring'),
(354, 39, 'expense_amount', 'expense_amount', 'expense_recurring'),
(355, 39, 'expense_category', 'expense_category', 'expense_recurring'),
(356, 39, 'expense_date', 'expense_date', 'expense_recurring'),
(357, 39, 'customer', 'customer', 'expense_recurring'),
(358, 39, 'name', 'name', 'expense_recurring'),
(359, 39, 'site_url', 'site_url', 'expense_recurring'),
(360, 39, 'company_name', 'company_name', 'expense_recurring'),
(361, 39, 'company_email', 'company_email', 'expense_recurring'),
(362, 39, 'email_signature', 'email_signature', 'expense_recurring'),
(363, 40, 'note', 'note', 'new_note_to_members_by_customer'),
(364, 40, 'project_name', 'project_name', 'new_note_to_members_by_customer'),
(365, 40, 'project_start_date', 'project_start_date', 'new_note_to_members_by_customer'),
(366, 40, 'project_end_date', 'project_end_date', 'new_note_to_members_by_customer'),
(367, 40, 'project_value', 'project_value', 'new_note_to_members_by_customer'),
(368, 40, 'project_tax', 'project_tax', 'new_note_to_members_by_customer'),
(369, 40, 'project_url', 'project_url', 'new_note_to_members_by_customer'),
(370, 40, 'name', 'name', 'new_note_to_members_by_customer'),
(371, 40, 'email_signature', 'email_signature', 'new_note_to_members_by_customer'),
(372, 40, 'loggedin_staff', 'loggedin_staff', 'new_note_to_members_by_customer'),
(373, 40, 'company_name', 'company_name', 'new_note_to_members_by_customer'),
(374, 40, 'company_email', 'company_email', 'new_note_to_members_by_customer'),
(375, 40, 'site_url', 'site_url', 'new_note_to_members_by_customer'),
(376, 41, 'project_name', 'project_name', 'new_file_uploaded_by_customer'),
(377, 41, 'project_value', 'project_value', 'new_file_uploaded_by_customer'),
(378, 41, 'project_start_date', 'project_start_date', 'new_file_uploaded_by_customer'),
(379, 41, 'project_end_date', 'project_end_date', 'new_file_uploaded_by_customer'),
(380, 41, 'project_tax', 'project_tax', 'new_file_uploaded_by_customer'),
(381, 41, 'project_url', 'project_url', 'new_file_uploaded_by_customer'),
(382, 41, 'name', 'name', 'new_file_uploaded_by_customer'),
(383, 41, 'loggedin_staff', 'loggedin_staff', 'new_file_uploaded_by_customer'),
(384, 41, 'company_name', 'company_name', 'new_file_uploaded_by_customer'),
(385, 41, 'company_email', 'company_email', 'new_file_uploaded_by_customer'),
(386, 41, 'email_signature', 'email_signature', 'new_file_uploaded_by_customer'),
(387, 41, 'site_url', 'site_url', 'new_file_uploaded_by_customer'),
(388, 42, 'customer', 'customer', 'order_message'),
(389, 42, 'order_to', 'order_to', 'order_message'),
(390, 42, 'order_number', 'order_number', 'order_message'),
(391, 42, 'app_name', 'app_name', 'order_message'),
(392, 42, 'email_signature', 'email_signature', 'order_message'),
(393, 42, 'name', 'name', 'order_message'),
(394, 42, 'company_name', 'company_name', 'order_message'),
(395, 42, 'company_email', 'company_email', 'order_message'),
(396, 42, 'site_url', 'site_url', 'order_message'),
(397, 43, 'staff', 'staff', 'request_quote'),
(398, 43, 'customer_name', 'customer_name', 'request_quote'),
(399, 43, 'subject', 'subject', 'request_quote'),
(400, 43, 'details', 'details', 'request_quote'),
(401, 43, 'quote_link', 'quote_link', 'request_quote'),
(402, 43, 'company_name', 'company_name', 'request_quote'),
(403, 43, 'company_email', 'company_email', 'request_quote'),
(404, 43, 'site_url', 'site_url', 'request_quote'),
(405, 44, 'staff', 'staff', 'quote_status_changed'),
(406, 44, 'customer_name', 'customer_name', 'quote_status_changed'),
(407, 44, 'subject', 'subject', 'quote_status_changed'),
(408, 44, 'details', 'details', 'quote_status_changed'),
(409, 44, 'quote_status', 'quote_status', 'quote_status_changed'),
(410, 44, 'quote_link', 'quote_link', 'quote_status_changed'),
(411, 44, 'company_name', 'company_name', 'quote_status_changed'),
(412, 44, 'company_email', 'company_email', 'quote_status_changed'),
(413, 44, 'site_url', 'site_url', 'quote_status_changed'),
(414, 45, 'company_name', 'company_name', 'event_reminder'),
(415, 45, 'company_email', 'company_email', 'event_reminder'),
(416, 45, 'staff', 'staff', 'event_reminder'),
(417, 45, 'staff_email', 'staff_email', 'event_reminder'),
(418, 45, 'event_type', 'event_type', 'event_reminder'),
(419, 45, 'event_title', 'event_title', 'event_reminder'),
(420, 45, 'event_details', 'event_details', 'event_reminder'),
(421, 45, 'site_url', 'site_url', 'event_reminder'),
(422, 46, 'vendor_name', 'vendor_name', 'purchase_message'),
(423, 46, 'purchsae_link', 'purchsae_link', 'purchase_message'),
(424, 46, 'due_date', 'due_date', 'purchase_message'),
(425, 46, 'issuance_date', 'issuance_date', 'purchase_message'),
(426, 46, 'due_note', 'due_note', 'purchase_message'),
(427, 46, 'purchase_number', 'purchase_number', 'purchase_message'),
(428, 46, 'purchase_status', 'purchase_status', 'purchase_message'),
(429, 46, 'total_amount', 'total_amount', 'purchase_message'),
(430, 46, 'company_name', 'company_name', 'purchase_message'),
(431, 46, 'company_email', 'company_email', 'purchase_message'),
(432, 46, 'site_url', 'site_url', 'purchase_message'),
(433, 47, 'purchase_number', 'purchase_number', 'purchase_payment'),
(434, 47, 'vendor_name', 'vendor_name', 'purchase_payment'),
(435, 47, 'issuance_date', 'issuance_date', 'purchase_payment'),
(436, 47, 'due_date', 'due_date', 'purchase_payment'),
(437, 47, 'payment_date', 'payment_date', 'purchase_payment'),
(438, 47, 'payment_account', 'payment_account', 'purchase_payment'),
(439, 47, 'payment_amount', 'payment_amount', 'purchase_payment'),
(440, 47, 'payment_description', 'payment_description', 'purchase_payment'),
(441, 47, 'payment_made_by', 'payment_made_by', 'purchase_payment'),
(442, 47, 'purchase_status', 'purchase_status', 'purchase_payment'),
(443, 47, 'purchase_link', 'purchase_link', 'purchase_payment'),
(444, 47, 'company_name', 'company_name', 'purchase_payment'),
(445, 47, 'company_email', 'company_email', 'purchase_payment'),
(446, 47, 'total_amount', 'total_amount', 'purchase_payment'),
(447, 47, 'site_url', 'site_url', 'purchase_payment'),
(448, 48, 'purchase_number', 'purchase_number', 'purchase_recurring'),
(449, 48, 'vendor_name', 'vendor_name', 'purchase_recurring'),
(450, 48, 'issuance_date', 'issuance_date', 'purchase_recurring'),
(451, 48, 'due_date', 'due_date', 'purchase_recurring'),
(452, 48, 'purchase_status', 'purchase_status', 'purchase_recurring'),
(453, 48, 'purchase_link', 'purchase_link', 'purchase_recurring'),
(454, 48, 'total_amount', 'total_amount', 'purchase_recurring'),
(455, 48, 'due_note', 'due_note', 'purchase_recurring'),
(456, 48, 'company_name', 'company_name', 'purchase_recurring'),
(457, 48, 'company_email', 'company_email', 'purchase_recurring'),
(458, 48, 'site_url', 'site_url', 'purchase_recurring'),
(459, 49, 'deposit_number', 'deposit_number', 'deposit_message'),
(460, 49, 'customer_name', 'customer_name', 'deposit_message'),
(461, 49, 'deposit_date', 'deposit_date', 'deposit_message'),
(462, 49, 'deposit_amount', 'deposit_amount', 'deposit_message'),
(463, 49, 'deposit_status', 'deposit_status', 'deposit_message'),
(464, 49, 'deposit_link', 'deposit_link', 'deposit_message'),
(465, 49, 'company_name', 'company_name', 'deposit_message'),
(466, 49, 'company_email', 'company_email', 'deposit_message'),
(467, 49, 'site_url', 'site_url', 'deposit_message'),
(468, 50, 'deposit_number', 'deposit_number', 'recurring_deposit'),
(469, 50, 'customer_name', 'customer_name', 'recurring_deposit'),
(470, 50, 'deposit_date', 'deposit_date', 'recurring_deposit'),
(471, 50, 'deposit_amount', 'deposit_amount', 'recurring_deposit'),
(472, 50, 'deposit_status', 'deposit_status', 'recurring_deposit'),
(473, 50, 'deposit_link', 'deposit_link', 'recurring_deposit'),
(474, 50, 'company_name', 'company_name', 'recurring_deposit'),
(475, 50, 'company_email', 'company_email', 'recurring_deposit'),
(476, 50, 'site_url', 'site_url', 'recurring_deposit'),
(477, 51, 'staff_name', 'staff_name', 'new_appointment'),
(478, 51, 'customer_name', 'customer_name', 'new_appointment'),
(479, 51, 'contact_name', 'contact_name', 'new_appointment'),
(480, 51, 'appointment_date', 'appointment_date', 'new_appointment'),
(481, 51, 'appointment_time', 'appointment_time', 'new_appointment'),
(482, 51, 'company_name', 'company_name', 'new_appointment'),
(483, 51, 'company_email', 'company_email', 'new_appointment'),
(484, 51, 'site_url', 'site_url', 'new_appointment'),
(485, 38, 'lead_name', 'lead_name', 'lead_submitted'),
(486, 38, 'lead_email', 'lead_email', 'lead_submitted'),
(487, 38, 'lead_assigned_staff', 'lead_assigned_staff', 'lead_submitted'),
(488, 38, 'email_signature', 'email_signature', 'lead_submitted'),
(489, 38, 'company_name', 'company_name', 'lead_submitted'),
(490, 38, 'company_email', 'company_email', 'lead_submitted'),
(491, 38, 'site_url', 'site_url', 'lead_submitted'),
(492, 34, 'password_url', 'password_url', 'customer_forgot_password'),
(493, 33, 'expense_description', 'expense_description', 'expense_created');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `detail` varchar(255) NOT NULL,
  `staff_id` int(5) NOT NULL,
  `added_by` int(5) DEFAULT NULL,
  `staffname` varchar(255) NOT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `color` varchar(100) DEFAULT NULL,
  `public` varchar(10) DEFAULT '0',
  `reminder` tinyint(1) DEFAULT NULL,
  `event_type` int(5) DEFAULT NULL,
  `is_all` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `detail`, `staff_id`, `added_by`, `staffname`, `start`, `end`, `color`, `public`, `reminder`, `event_type`, `is_all`, `created`) VALUES
(1, 'Lorem Ipsum', 'Today is good.', 1, NULL, 'Lance Bogrol', '2018-02-01 00:05:22', '2018-01-30 20:05:28', NULL, 'true', NULL, NULL, 0, NULL),
(2, 'Sample Event', 'Today is good.', 1, NULL, 'Lance Bogrol', '2018-02-02 00:05:22', '2018-02-02 20:05:28', NULL, 'true', NULL, NULL, 0, NULL),
(3, 'Go Client Meet', 'Today is good.', 1, NULL, 'Lance Bogrol', '2018-02-03 00:05:22', '2018-02-03 20:05:28', NULL, 'true', NULL, NULL, 0, NULL),
(4, 'Web Design', 'Today is good.', 1, NULL, 'Lance Bogrol', '2018-02-04 00:05:22', '2018-02-04 20:05:28', NULL, 'true', NULL, NULL, 0, NULL),
(5, 'Hola!', 'Today is good.', 1, NULL, 'Lance Bogrol', '2018-02-06 00:05:22', '2018-02-06 20:05:28', NULL, 'true', NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `event_triggers`
--

CREATE TABLE `event_triggers` (
  `id` int(11) NOT NULL,
  `relation_type` varchar(100) DEFAULT NULL,
  `relation` int(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `duration_type` int(11) DEFAULT NULL COMMENT '0 = minutes | 1 = hours | 2 = days | 3 = weeks',
  `duration_period` varchar(100) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `event_types`
--

CREATE TABLE `event_types` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL,
  `public` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `expensecat`
--

CREATE TABLE `expensecat` (
  `id` int(11) NOT NULL,
  `name` varchar(300) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `expensecat`
--

INSERT INTO `expensecat` (`id`, `name`, `description`) VALUES
(1, 'Office Expenses', 'Office Expenses'),
(2, 'Other Expenses', 'Other Expenses'),
(3, 'Trivia', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `expense_number` varchar(100) DEFAULT NULL,
  `number` varchar(100) DEFAULT NULL,
  `hash` varchar(6) NOT NULL,
  `relation_type` varchar(100) DEFAULT NULL,
  `relation` int(5) DEFAULT '0',
  `title` varchar(200) DEFAULT NULL,
  `description` text,
  `category_id` int(5) DEFAULT NULL,
  `account_id` int(5) NOT NULL,
  `staff_id` int(5) NOT NULL,
  `customer_id` int(5) DEFAULT NULL,
  `invoice_id` int(5) DEFAULT NULL,
  `purchase_id` int(5) DEFAULT NULL,
  `created` datetime NOT NULL,
  `date` date NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `sub_total` decimal(20,2) DEFAULT NULL,
  `total_discount` decimal(20,2) DEFAULT NULL,
  `total_tax` decimal(20,2) DEFAULT NULL,
  `internal` tinyint(1) NOT NULL DEFAULT '0',
  `recurring` int(5) DEFAULT NULL,
  `last_recurring` date DEFAULT NULL,
  `pdf_status` tinyint(1) DEFAULT '0',
  `expense_created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `expense_number`, `number`, `hash`, `relation_type`, `relation`, `title`, `description`, `category_id`, `account_id`, `staff_id`, `customer_id`, `invoice_id`, `purchase_id`, `created`, `date`, `amount`, `sub_total`, `total_discount`, `total_tax`, `internal`, `recurring`, `last_recurring`, `pdf_status`, `expense_created_by`) VALUES
(1, NULL, NULL, '', 'project', 1, 'Sample Expense', 'Lorem ipsum sit dolor amet.', 3, 1, 1, 17, NULL, NULL, '2018-01-05 21:22:56', '2018-01-05', '20.00', NULL, NULL, NULL, 0, NULL, NULL, 0, NULL),
(3, NULL, NULL, '', NULL, 0, 'Food Expenses', 'Other Expenses', 1, 3, 1, 0, NULL, NULL, '2018-01-06 04:26:16', '2018-01-06', '20.00', NULL, NULL, NULL, 0, NULL, NULL, 0, NULL),
(4, NULL, NULL, '', 'project', 1, 'Sample', 'Sample', 3, 1, 1, 17, NULL, NULL, '2018-01-25 19:30:44', '2018-01-25', '10.00', NULL, NULL, NULL, 0, NULL, NULL, 0, NULL),
(5, NULL, NULL, '33fa04', NULL, 0, 'Sample', 'Lorem ipsum dolor sit amet', 2, 1, 1, 0, NULL, NULL, '2018-04-11 22:07:27', '2018-04-11', '20.00', NULL, NULL, NULL, 0, NULL, NULL, 0, NULL),
(7, NULL, NULL, '9bdb1f', NULL, 0, 'Test', 'Test', 1, 3, 1, 16, NULL, NULL, '2018-04-11 22:32:14', '2018-04-11', '20.00', NULL, NULL, NULL, 0, NULL, NULL, 0, NULL),
(8, NULL, NULL, '', NULL, 0, 'Test', 'test', 3, 1, 1, 18, 15, NULL, '2018-05-20 17:29:39', '2018-05-20', '20.00', NULL, NULL, NULL, 0, NULL, NULL, 0, NULL),
(9, NULL, NULL, '', NULL, 0, 'Test', 'Test', 2, 4, 1, 0, NULL, NULL, '2018-06-01 19:29:37', '2018-06-01', '10.00', NULL, NULL, NULL, 0, NULL, NULL, 0, NULL),
(10, NULL, '2', '', NULL, 0, 'Telephone charges', NULL, 1, 1, 1, 0, NULL, NULL, '2018-11-13 19:18:34', '2018-11-13', '210.00', '200.00', NULL, '10.00', 1, NULL, '2018-11-13', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `relation_type` varchar(100) NOT NULL,
  `relation` int(5) DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `is_old` tinyint(1) DEFAULT '1',
  `filetype` varchar(50) DEFAULT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `relation_type`, `relation`, `file_name`, `is_old`, `filetype`, `created`) VALUES
(2, 'project', 11, 'Document.pdf', 1, '.doc', '2017-11-04 00:00:00'),
(6, 'project', 11, 'Chaim.doc', 1, '.doc', '2017-11-04 00:00:00'),
(8, 'project', 9, 'Sample_File2.png', 1, NULL, '2017-11-16 01:48:03'),
(9, 'task', 25, 'Sample_File3.png', 1, NULL, '2017-11-23 21:28:35'),
(10, 'task', 25, 'ticket.png', 1, NULL, '2017-11-23 21:29:10'),
(11, 'task', 27, 'Sample_File4.png', 1, NULL, '2017-11-23 23:16:21'),
(12, 'task', 30, 'Sample_File5.png', 1, NULL, '2017-11-23 23:43:52'),
(16, 'task', 2, '1_9PnPjPI65fGwLiMfluVLrw.jpg', 0, NULL, '2019-04-15 19:22:00');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `invoice_number` varchar(100) DEFAULT NULL,
  `invoiceId` varchar(10) DEFAULT NULL,
  `token` varchar(100) NOT NULL,
  `no` varchar(50) DEFAULT NULL,
  `serie` varchar(100) DEFAULT NULL,
  `created` date DEFAULT NULL,
  `duedate` date DEFAULT NULL,
  `customer_id` int(5) NOT NULL,
  `expense_id` int(5) DEFAULT NULL,
  `proposal_id` int(5) DEFAULT NULL,
  `project_id` int(5) DEFAULT NULL,
  `staff_id` int(5) DEFAULT NULL,
  `datesend` datetime DEFAULT NULL,
  `datepayment` date DEFAULT NULL,
  `duenote` varchar(255) DEFAULT NULL,
  `status_id` int(5) DEFAULT NULL,
  `sub_total` decimal(20,2) DEFAULT NULL,
  `total_discount` decimal(20,2) DEFAULT NULL,
  `total_tax` decimal(20,2) DEFAULT NULL,
  `total` decimal(20,2) DEFAULT NULL,
  `amount_paying` varchar(50) DEFAULT NULL,
  `default_payment_method` varchar(50) DEFAULT NULL,
  `CustomField` varchar(255) NOT NULL,
  `billing_street` varchar(100) NOT NULL,
  `billing_city` varchar(100) NOT NULL,
  `billing_state` varchar(100) NOT NULL,
  `billing_state_id` int(5) DEFAULT NULL,
  `billing_zip` varchar(50) NOT NULL,
  `billing_country` int(5) NOT NULL,
  `shipping_street` varchar(100) NOT NULL,
  `shipping_city` varchar(100) NOT NULL,
  `shipping_state` varchar(100) NOT NULL,
  `shipping_state_id` int(5) DEFAULT NULL,
  `shipping_zip` varchar(100) NOT NULL,
  `shipping_country` int(5) NOT NULL,
  `recurring` int(2) NOT NULL DEFAULT '0',
  `last_recurring` date DEFAULT NULL,
  `pdf_status` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_number`, `invoiceId`, `token`, `no`, `serie`, `created`, `duedate`, `customer_id`, `expense_id`, `proposal_id`, `project_id`, `staff_id`, `datesend`, `datepayment`, `duenote`, `status_id`, `sub_total`, `total_discount`, `total_tax`, `total`, `amount_paying`, `default_payment_method`, `CustomField`, `billing_street`, `billing_city`, `billing_state`, `billing_state_id`, `billing_zip`, `billing_country`, `shipping_street`, `shipping_city`, `shipping_state`, `shipping_state_id`, `shipping_zip`, `shipping_country`, `recurring`, `last_recurring`, `pdf_status`) VALUES
(1, NULL, NULL, '9289e7e9faf3b97032dc96e367e69b23', '6', 'A', '2018-01-01', '0000-00-00', 17, NULL, NULL, NULL, 1, NULL, NULL, 'Please pay on time.', 2, '200.00', '0.00', '0.00', '200.00', NULL, NULL, '', '', '', '', NULL, '', 0, '', '', '', NULL, '', 0, 0, NULL, 0),
(5, NULL, NULL, '2d78f01034c59352131086ab2995cd59', '2', 'A', '2018-01-05', NULL, 16, NULL, NULL, NULL, 1, NULL, NULL, NULL, 2, '400.00', '0.00', '10.00', '410.00', NULL, NULL, '', '', '', '', NULL, '', 0, '', '', '', NULL, '', 0, 0, NULL, 0),
(6, NULL, NULL, '431f5592a096e81c18de0be1b34af5bc', '23', 'A', '2018-01-06', NULL, 12, NULL, NULL, NULL, 1, '2018-01-21 16:21:09', '2018-01-06', NULL, 2, '200.00', '0.00', '0.00', '200.00', NULL, NULL, '', '', '', '', NULL, '', 0, '', '', '', NULL, '', 0, 0, NULL, 0),
(7, NULL, NULL, '7f2088df0ff31cb17341e29826e83eb6', '12', 'A', '2018-01-22', '2018-12-12', 17, NULL, NULL, NULL, 1, '2018-01-25 05:51:06', NULL, 'Sample', 3, '200.00', '0.00', '0.00', '200.00', NULL, NULL, '', '', '', '', NULL, '', 0, '', '', '', NULL, '', 0, 0, NULL, 0),
(8, NULL, NULL, 'c8031bdc83af8bf95f6e455ef12c042c', '102', 'a', '2018-02-12', '2018-04-11', 6, NULL, NULL, NULL, 1, NULL, NULL, 'Please pay on time.', 4, '200.00', '0.00', '0.00', '200.00', NULL, NULL, '', '', '', '', NULL, '', 0, '', '', '', NULL, '', 0, 0, NULL, 0),
(9, NULL, NULL, 'd9d400ebda1d350da0bff978ac606959', '2332', 'A', '2018-02-11', NULL, 1, NULL, NULL, NULL, 1, NULL, '2018-02-13', NULL, 2, '200.00', '0.00', '10.00', '210.00', NULL, NULL, '', '', '', '', NULL, '', 0, '', '', '', NULL, '', 0, 0, NULL, 0),
(10, NULL, NULL, '0dbffee1accb51b774c6274a1ba74c90', '102', 'a', '2018-02-13', '2019-02-06', 6, NULL, NULL, NULL, 2, '2018-03-18 04:42:34', NULL, 'Please pay on time.', 3, '200.00', '0.00', '0.00', '200.00', NULL, NULL, '', '', '', '', NULL, '', 0, '', '', '', NULL, '', 0, 13, NULL, 0),
(11, NULL, NULL, 'e4304c0de5cdc010f2b63d90def71d9b', '12', '12', '2018-03-09', '0000-00-00', 17, NULL, NULL, NULL, 1, NULL, NULL, 'Please pay on time.', 2, '100.00', '0.00', '0.00', '100.00', NULL, NULL, '', '', '', '', NULL, '', 0, '', '', '', NULL, '', 0, 0, NULL, 0),
(12, NULL, NULL, '5436b282ebbd7e40ba6655bbd7d0e62d', '12', 'a', '2018-03-25', '0000-00-00', 17, NULL, NULL, NULL, 1, '2018-04-08 16:59:58', NULL, 'adf', 2, '200.00', '0.00', '10.00', '210.00', NULL, NULL, '', '', '', '', NULL, '', 0, '', '', '', NULL, '', 0, 0, NULL, 0),
(13, NULL, NULL, '1e0aee98391a3d89525d12f09b28e19c', '23', 'A', '2018-04-22', '2018-10-30', 18, NULL, NULL, NULL, 1, NULL, NULL, 'Pay on time.', 3, '200.00', '0.00', '10.00', '210.00', NULL, NULL, '', 'Example Address', 'Los Angeles', 'California', NULL, '2233', 236, 'Example Address', 'Los Angeles', 'California', NULL, '2233', 1, 0, NULL, 0),
(14, NULL, NULL, '', NULL, NULL, '2018-05-20', NULL, 18, 8, NULL, NULL, 1, NULL, NULL, NULL, 3, '20.00', NULL, NULL, '20.00', NULL, NULL, '', '', '', '', NULL, '', 0, '', '', '', NULL, '', 0, 0, NULL, 0),
(15, NULL, NULL, '', NULL, NULL, '2018-05-20', NULL, 18, 8, NULL, NULL, 1, NULL, NULL, NULL, 3, '20.00', NULL, NULL, '20.00', NULL, NULL, '', '', '', '', NULL, '', 0, '', '', '', NULL, '', 0, 0, NULL, 0),
(16, NULL, NULL, '5af6a98d566d216a16d9a26e8559cbb6', '0', 'A', '2018-06-20', '2018-06-27', 12, NULL, 5, NULL, 1, NULL, '0000-00-00', 'TEST', 3, '200.00', '0.00', '10.00', '210.00', NULL, NULL, '', '', '', '', NULL, '', 0, '', '', '', NULL, '', 0, 0, NULL, 0),
(17, NULL, NULL, 'b32c25e711a8c18f8cb7da09842a3cb8', '1', '1', '2018-08-11', '2019-08-20', 16, NULL, NULL, NULL, 1, NULL, NULL, 'Pay on time', 3, '100.00', '0.00', '0.00', '100.00', NULL, NULL, '', '', '', '', NULL, '', 0, '', '', '', NULL, '', 0, 0, NULL, 0),
(18, NULL, NULL, 'b12880099b999862fcc47d67b90e19bf', '7', '01', '2018-09-19', NULL, 18, NULL, NULL, NULL, 1, NULL, '2018-09-19', NULL, 2, '1000.00', '0.00', '0.00', '1000.00', NULL, NULL, '', 'Example Address', 'Los Angeles', 'California', NULL, '2233', 236, 'Example Address', 'Los Angeles', 'California', NULL, '2233', 236, 0, NULL, 0),
(19, NULL, NULL, '85dd8412b3f8d532f3c6da6793d1f5a5', '12', 'Test', '2018-11-12', '2019-12-24', 18, NULL, NULL, NULL, 1, NULL, NULL, 'pay on time', 3, '100.00', '0.00', '0.00', '100.00', NULL, NULL, '', 'Example Address', 'Los Angeles', 'California', NULL, '2233', 236, 'Example Address', 'Los Angeles', 'California', NULL, '2233', 236, 0, NULL, 0),
(22, NULL, NULL, '68605ed0278edc00434f461ad4ce04f3', '0', '', '2018-11-12', '2018-11-12', 0, NULL, NULL, NULL, 1, NULL, NULL, '', 3, '0.00', '0.00', '0.00', '0.00', NULL, NULL, '', '------', ',---- ', ',----', NULL, '----', 0, '------', ',---- ', ',----', NULL, '----', 0, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `invoicestatus`
--

CREATE TABLE `invoicestatus` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `invoicestatus`
--

INSERT INTO `invoicestatus` (`id`, `name`, `color`) VALUES
(1, 'Draft', '#7d7d7d'),
(2, 'Paid', '#26c281'),
(3, 'Unpaid', '#ff3b30'),
(4, 'Cancelled', '#dd2c00');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `relation_type` varchar(100) DEFAULT NULL,
  `relation` int(5) DEFAULT NULL,
  `product_id` int(5) DEFAULT NULL,
  `product_type` int(5) DEFAULT NULL,
  `warehouse_id` int(5) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `quantity` decimal(20,2) DEFAULT NULL,
  `unit` varchar(200) DEFAULT NULL,
  `price` decimal(20,2) DEFAULT NULL,
  `tax` decimal(20,2) DEFAULT '0.00',
  `discount` decimal(20,2) DEFAULT '0.00',
  `total` decimal(20,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `relation_type`, `relation`, `product_id`, `product_type`, `warehouse_id`, `code`, `name`, `description`, `quantity`, `unit`, `price`, `tax`, `discount`, `total`) VALUES
(1, 'invoice', 1, 4, NULL, NULL, 'WEB', 'Consultance', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent sit amet iaculis risus.', '1.00', 'Unit', '200.00', '0.00', '0.00', '200.00'),
(5, 'invoice', 5, 4, NULL, NULL, 'WEB', 'Consultance', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent sit amet iaculis risus.', '1.00', 'Unit', '200.00', '0.00', '0.00', '200.00'),
(8, 'proposal', 2, 2, NULL, NULL, 'WEB', 'Seo Consultant', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent sit amet iaculis risus.', '1.00', 'Unit', '200.00', '0.00', '0.00', '200.00'),
(10, 'proposal', 4, 5, NULL, NULL, 'GRA-24', 'Graphic Design', 'Graphic Design Services', '1.00', 'Unit', '100.00', '0.00', '0.00', '100.00'),
(11, 'proposal', 5, 1, NULL, NULL, 'WEB', 'Web Design', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent sit amet iaculis risus.', '1.00', 'Unit', '200.00', '5.00', '0.00', '210.00'),
(12, 'invoice', 6, 3, NULL, NULL, 'WEB-204', 'Logo Design', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent sit amet iaculis risus.', '1.00', 'Unit', '200.00', '0.00', '0.00', '200.00'),
(13, 'invoice', 7, 2, NULL, NULL, 'WEB', 'Seo Consultant', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent sit amet iaculis risus.', '1.00', 'Unit', '200.00', '0.00', '0.00', '200.00'),
(14, 'invoice', 8, 2, NULL, NULL, 'WEB', 'Seo Consultant', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent sit amet iaculis risus.', '1.00', 'Unit', '200.00', '0.00', '0.00', '200.00'),
(15, 'invoice', 9, 1, NULL, NULL, 'WEB', 'Web Design', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent sit amet iaculis risus.', '1.00', 'Unit', '200.00', '5.00', '0.00', '210.00'),
(16, 'invoice', 10, 2, NULL, NULL, 'WEB', 'Seo Consultant', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent sit amet iaculis risus.', '1.00', 'Unit', '200.00', '0.00', '0.00', '200.00'),
(17, 'invoice', 11, 5, NULL, NULL, 'GRA-24', 'Graphic Design', 'Graphic Design Services', '1.00', 'Unit', '100.00', '0.00', '0.00', '100.00'),
(18, 'invoice', 12, 1, NULL, NULL, 'WEB', 'Web Design', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent sit amet iaculis risus.', '1.00', 'Unit', '200.00', '5.00', '0.00', '210.00'),
(19, 'invoice', 13, 1, NULL, NULL, 'WEB', 'Web Design', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent sit amet iaculis risus.', '1.00', 'Unit', '200.00', '5.00', '0.00', '210.00'),
(20, 'invoice', 5, 1, NULL, NULL, 'WEB', 'Web Design', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent sit amet iaculis risus.', '1.00', 'Unit', '200.00', '5.00', '0.00', '210.00'),
(21, 'invoice', 15, NULL, NULL, NULL, NULL, 'Test', 'test', '1.00', 'Unit', '20.00', '0.00', '0.00', '20.00'),
(22, 'invoice', 16, 1, NULL, NULL, 'WEB', 'Web Design', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent sit amet iaculis risus.', '1.00', 'Unit', '200.00', '5.00', '0.00', '210.00'),
(23, 'order', 1, 1, NULL, NULL, 'WEB', 'Web Design', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent sit amet iaculis risus.', '1.00', 'Unit', '200.00', '5.00', '10.00', '190.00'),
(24, 'invoice', 19, 5, NULL, NULL, 'GRA-24', 'Graphic Design', 'Graphic Design Services', '1.00', 'Unit', '100.00', '0.00', '0.00', '100.00'),
(27, 'invoice', 22, 0, NULL, NULL, '', 'New', '', '1.00', 'Unit', '0.00', '0.00', '0.00', '0.00'),
(29, 'expense', 10, 1, NULL, NULL, 'WEB', 'Web Design', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent sit amet iaculis risus.', '1.00', 'Unit', '200.00', '5.00', '0.00', '210.00');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `langcode` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `foldername` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `langcode`, `name`, `foldername`) VALUES
(1, 'de_De', 'german', 'german'),
(2, 'en_US', 'english', 'english'),
(3, 'es_ES', 'spanish', 'spanish'),
(4, 'fr_FR', 'french', 'french'),
(5, 'pt-pt', 'portuguese_pt', 'portuguese_pt'),
(6, 'pt-BR', 'portuguese_br', 'portuguese_br'),
(7, 'tr_TR', 'turkish', 'turkish'),
(8, 'ru_RU', 'russian', 'russian'),
(9, 'sv_SV', 'swedish', 'swedish'),
(10, 'it-ch', 'italian', 'italian'),
(11, 'bg_BG', 'bulgarian', 'bulgarian'),
(12, 'id-ID', 'indonesian', 'indonesian');

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `id` int(11) NOT NULL,
  `lead_number` varchar(100) DEFAULT NULL,
  `date_contacted` datetime NOT NULL,
  `type` int(11) DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `company` varchar(200) DEFAULT NULL,
  `description` text,
  `country_id` int(11) NOT NULL DEFAULT '0',
  `zip` varchar(15) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `state_id` int(5) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `website` varchar(150) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `assigned_id` int(5) NOT NULL,
  `created` date NOT NULL,
  `status` int(5) NOT NULL,
  `source` int(5) NOT NULL,
  `lastcontact` datetime DEFAULT NULL,
  `dateassigned` date DEFAULT NULL,
  `staff_id` int(5) NOT NULL,
  `dateconverted` datetime DEFAULT NULL,
  `lost` tinyint(1) DEFAULT '0',
  `junk` int(5) DEFAULT '0',
  `public` tinyint(1) DEFAULT '0',
  `weblead` int(5) DEFAULT NULL,
  `lead_status_id` int(5) DEFAULT '1' COMMENT '0 = Inactive | 1 = Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`id`, `lead_number`, `date_contacted`, `type`, `name`, `title`, `company`, `description`, `country_id`, `zip`, `city`, `state`, `state_id`, `email`, `address`, `website`, `phone`, `assigned_id`, `created`, `status`, `source`, `lastcontact`, `dateassigned`, `staff_id`, `dateconverted`, `lost`, `junk`, `public`, `weblead`, `lead_status_id`) VALUES
(1, NULL, '0000-00-00 00:00:00', 0, 'Judy Youngs', 'Lorem Ipsum', 'Northern Star', 'Proin tempor tortor ac sem sollicitudin, eu ornare lacus rutrum.', 90, '54617', 'New York', 'NC', NULL, 'judyyoung@example.com', '1333 Deerfield Dr, State College, PA, 16803', 'www.example.com', '(140) 211 2494', 2, '2017-11-11', 3, 1, NULL, '2017-11-11', 1, '2017-08-22 04:35:57', 0, 0, 0, NULL, 1),
(2, NULL, '0000-00-00 00:00:00', 0, 'Joyce McCoy', 'Lorem Ipsum', 'Codelam LLC.', 'Proin tempor tortor ac sem sollicitudin, eu ornare lacus rutrum.', 23, '54617', 'New York', 'GA', NULL, 'joycemccoy@example.com', '1398 N 80th W, Orem, UT, 84057', 'www.example.com', '(296) 452 9522', 2, '2017-11-11', 1, 2, NULL, '2017-11-11', 1, '2017-08-24 22:13:34', 0, 0, 1, NULL, 1),
(3, NULL, '0000-00-00 00:00:00', 0, 'Jane Carpenter', 'Lorem Ipsum', 'Unadoncare INC.', 'Proin tempor tortor ac sem sollicitudin, eu ornare lacus rutrum.', 55, '54617', 'New York', 'CT', NULL, 'jane-85@example.com', '245 Bourbon Acres Rd, Paris, KY, 40361', 'www.example.com', '(432) 156 5172', 3, '2018-01-26', 1, 1, NULL, '2018-01-26', 2, '2017-08-24 17:45:07', NULL, NULL, 0, NULL, 1),
(4, NULL, '0000-00-00 00:00:00', 0, 'William Patel', 'Lorem Ipsum', 'Canelectrics INC.', 'Proin tempor tortor ac sem sollicitudin, eu ornare lacus rutrum.', 11, '54617', 'New York', 'VA', NULL, 'abaris@null.net', '2806 Mimi Ave, Chester, VA, 23831', 'www.example.com', '(269) 364 3098', 4, '2018-09-28', 4, 2, NULL, '2018-09-28', 1, '2017-08-31 03:23:26', NULL, NULL, 0, NULL, 1),
(5, NULL, '0000-00-00 00:00:00', 1, 'Danielle Burns', 'Lorem Ipsum', 'Donway INC.', 'Proin tempor tortor ac sem sollicitudin, eu ornare lacus rutrum.', 23, '54617', 'New York', 'MI', NULL, 'danielle-92@example.com', '5094 Vidrine Rd, Ville Platte, LA, 22356', 'www.example.com', '(610) 465 2198', 1, '2018-01-26', 2, 1, NULL, '2018-01-26', 2, '2017-11-12 00:17:05', NULL, NULL, 0, NULL, 1),
(6, NULL, '0000-00-00 00:00:00', 0, 'Nicholas Walters', 'Lorem Ipsum', 'Transhex LLC.', 'Proin tempor tortor ac sem sollicitudin, eu ornare lacus rutrum.', 12, '54617', 'New York', 'CT', NULL, 'nicholas-90@example.com', '1911 Crestview Dr, Johnstown, CO, 80534', 'www.example.com', '(954) 630 6210', 3, '2018-01-26', 4, 2, NULL, '2018-01-26', 2, '2017-08-22 04:40:32', NULL, NULL, 0, NULL, 1),
(7, NULL, '0000-00-00 00:00:00', 0, 'Evelyn Bradley', 'Lorem Ipsum', 'Latdoace AG.', 'Proin tempor tortor ac sem sollicitudin, eu ornare lacus rutrum.', 32, '54617', 'New York', 'GA', NULL, 'evelyn-96@example.com', 'Po Box 961, Thibodaux, LA, 703024', 'www.example.com', '(489) 588 6002', 2, '2017-11-01', 1, 1, NULL, '2017-11-01', 1, NULL, 0, 0, 0, NULL, 1),
(11, NULL, '0000-00-00 00:00:00', 1, 'Roger H Barnett', 'Roger H Barnett', 'Roger H Barnett', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 235, '91744', 'Denge', 'Conda', NULL, 'roger@example.com', 'Sample adress will placed here!', 'example.com', '626-931-8754', 3, '2018-11-13', 1, 6, NULL, '2018-11-13', 1, NULL, NULL, NULL, 0, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `leadssources`
--

CREATE TABLE `leadssources` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `leadssources`
--

INSERT INTO `leadssources` (`id`, `name`) VALUES
(1, 'WEB'),
(2, 'EMAIL'),
(6, 'TELEPHONE'),
(7, 'SOCIAL MEDIA');

-- --------------------------------------------------------

--
-- Table structure for table `leadsstatus`
--

CREATE TABLE `leadsstatus` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `color` varchar(10) DEFAULT '#28B8DA'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `leadsstatus`
--

INSERT INTO `leadsstatus` (`id`, `name`, `color`) VALUES
(1, 'NEW', NULL),
(2, 'CONTACTED', '#fff3d1'),
(3, 'INPROGRESS', '#ffdc77'),
(4, 'CONVERTED', '#daf196'),
(5, 'LOST', 'pink');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `detail` mediumtext NOT NULL,
  `date` datetime NOT NULL,
  `staff_id` varchar(5) DEFAULT NULL,
  `customer_id` int(5) DEFAULT NULL,
  `project_id` int(5) NOT NULL,
  `vendor_id` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `detail`, `date`, `staff_id`, `customer_id`, `project_id`, `vendor_id`) VALUES
(753, 'Lance Bogrol added new member to project', '2018-06-20 16:57:23', '1', NULL, 1, NULL),
(754, 'Lance Bogrol added new member to project', '2018-06-20 16:57:27', '1', NULL, 1, NULL),
(755, 'Sue Shei added <a href=\"tickets/ticket/3\"> TICKET-3</a>', '2018-06-20 19:23:49', NULL, 23, 0, NULL),
(756, 'Lance Bogrol updated project.', '2018-06-20 19:42:36', '1', NULL, 1, NULL),
(757, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"tasks/task/1\">Task-1</a>.', '2018-06-20 19:42:52', '1', NULL, 0, NULL),
(758, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-06-20 20:24:35', '1', NULL, 0, NULL),
(759, 'Lance Bogrol updated project.', '2018-06-20 20:26:59', '1', NULL, 1, NULL),
(760, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-06-25 15:58:19', '1', NULL, 0, NULL),
(761, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-06-25 16:34:07', '1', NULL, 0, NULL),
(762, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-06-28 14:50:37', '1', NULL, 0, NULL),
(763, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-06-29 20:36:47', '1', NULL, 0, NULL),
(764, 'Lance Bogrol changed Ruby Von Rails\'s login password.', '2018-06-29 20:37:23', '1', NULL, 0, NULL),
(765, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-06-29 20:38:32', '1', NULL, 0, NULL),
(766, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-06-29 20:38:46', '1', NULL, 0, NULL),
(767, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-06-30 17:03:04', '1', NULL, 0, NULL),
(768, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-06-30 17:45:49', '1', NULL, 0, NULL),
(769, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-07-02 16:46:02', '1', NULL, 0, NULL),
(770, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-07-03 12:56:03', '1', NULL, 0, NULL),
(771, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-07-04 16:42:35', '1', NULL, 0, NULL),
(772, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-07-06 19:01:38', '1', NULL, 0, NULL),
(773, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-07-06 19:46:36', '1', NULL, 0, NULL),
(774, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/7\"> Product7</a>', '2018-07-06 19:46:57', '1', NULL, 0, NULL),
(775, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-7', '2018-07-06 19:47:11', '1', NULL, 0, NULL),
(776, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-07-08 00:40:50', '1', NULL, 0, NULL),
(777, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-07-11 21:59:15', '1', NULL, 0, NULL),
(778, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-07-12 17:22:16', '1', NULL, 0, NULL),
(779, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> replied <a href=\"tickets/ticket/2\"> TICKET-2</a>', '2018-07-12 17:22:36', '1', NULL, 0, NULL),
(780, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-07-13 16:02:14', '1', NULL, 0, NULL),
(781, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-07-15 13:13:32', '1', NULL, 0, NULL),
(782, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-15 13:13:43', '1', NULL, 0, NULL),
(783, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-07-15 13:13:48', '1', NULL, 0, NULL),
(784, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-07-15 13:18:55', '1', NULL, 0, NULL),
(785, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-07-15 13:21:05', '1', NULL, 0, NULL),
(786, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-15 13:21:13', '1', NULL, 0, NULL),
(787, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-07-15 13:21:18', '1', NULL, 0, NULL),
(788, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-07-16 04:12:00', '1', NULL, 0, NULL),
(789, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-07-21 22:24:12', '1', NULL, 0, NULL),
(790, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-07-25 02:22:13', '1', NULL, 0, NULL),
(791, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-07-25 04:12:13', '1', NULL, 0, NULL),
(792, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-07-25 21:25:22', '1', NULL, 0, NULL),
(793, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-07-29 22:41:08', '1', NULL, 0, NULL),
(794, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 22:42:08', '1', NULL, 0, NULL),
(795, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 22:42:20', '1', NULL, 0, NULL),
(796, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 22:42:31', '1', NULL, 0, NULL),
(797, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 22:42:39', '1', NULL, 0, NULL),
(798, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 22:42:51', '1', NULL, 0, NULL),
(799, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 22:43:04', '1', NULL, 0, NULL),
(800, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 22:43:13', '1', NULL, 0, NULL),
(801, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 22:43:25', '1', NULL, 0, NULL),
(802, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 22:43:46', '1', NULL, 0, NULL),
(803, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 22:44:49', '1', NULL, 0, NULL),
(804, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 22:45:14', '1', NULL, 0, NULL),
(805, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 22:45:34', '1', NULL, 0, NULL),
(806, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 22:45:46', '1', NULL, 0, NULL),
(807, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 22:45:57', '1', NULL, 0, NULL),
(808, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 22:46:07', '1', NULL, 0, NULL),
(809, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 22:46:15', '1', NULL, 0, NULL),
(810, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 22:56:23', '1', NULL, 0, NULL),
(811, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 22:58:54', '1', NULL, 0, NULL),
(812, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 22:59:05', '1', NULL, 0, NULL),
(813, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 22:59:13', '1', NULL, 0, NULL),
(814, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 22:59:21', '1', NULL, 0, NULL),
(815, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 22:59:32', '1', NULL, 0, NULL),
(816, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 22:59:45', '1', NULL, 0, NULL),
(817, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 22:59:54', '1', NULL, 0, NULL),
(818, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 23:00:04', '1', NULL, 0, NULL),
(819, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 23:00:12', '1', NULL, 0, NULL),
(820, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 23:00:46', '1', NULL, 0, NULL),
(821, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 23:00:55', '1', NULL, 0, NULL),
(822, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 23:01:03', '1', NULL, 0, NULL),
(823, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 23:01:17', '1', NULL, 0, NULL),
(824, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 23:01:34', '1', NULL, 0, NULL),
(825, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 23:01:45', '1', NULL, 0, NULL),
(826, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 23:01:54', '1', NULL, 0, NULL),
(827, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 23:02:12', '1', NULL, 0, NULL),
(828, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 23:02:23', '1', NULL, 0, NULL),
(829, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 23:02:32', '1', NULL, 0, NULL),
(830, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 23:02:40', '1', NULL, 0, NULL),
(831, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 23:02:49', '1', NULL, 0, NULL),
(832, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 23:02:59', '1', NULL, 0, NULL),
(833, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 23:04:32', '1', NULL, 0, NULL),
(834, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 23:04:46', '1', NULL, 0, NULL),
(835, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 23:04:51', '1', NULL, 0, NULL),
(836, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 23:04:59', '1', NULL, 0, NULL),
(837, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 23:05:07', '1', NULL, 0, NULL),
(838, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 23:05:15', '1', NULL, 0, NULL),
(839, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 23:05:36', '1', NULL, 0, NULL),
(840, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 23:05:45', '1', NULL, 0, NULL),
(841, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 23:05:53', '1', NULL, 0, NULL),
(842, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-07-29 23:06:02', '1', NULL, 0, NULL),
(843, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-08-02 21:12:45', '1', NULL, 0, NULL),
(844, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-08-02 21:13:04', '1', NULL, 0, NULL),
(845, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-08-02 21:13:31', '1', NULL, 0, NULL),
(846, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-08-11 04:13:29', '1', NULL, 0, NULL),
(847, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added <a href=\"invoices/invoice/17\">INV-17</a>.', '2018-08-11 06:16:05', '1', 16, 0, NULL),
(848, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"invoices/invoice/10\">INV-10</a>.', '2018-08-11 06:23:26', '1', 6, 0, NULL),
(849, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-08-18 22:08:29', '1', NULL, 0, NULL),
(850, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-08-19 00:44:38', '1', NULL, 0, NULL),
(851, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-08-19 12:39:40', '1', NULL, 0, NULL),
(852, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-08-19 15:40:29', '1', NULL, 0, NULL),
(853, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-08-20 16:06:25', '1', NULL, 0, NULL),
(854, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-08-22 02:23:08', '1', NULL, 0, NULL),
(855, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-08-23 22:52:31', '1', NULL, 0, NULL),
(856, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-08-24 01:42:54', '1', NULL, 0, NULL),
(857, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-08-24 21:32:46', '1', NULL, 0, NULL),
(858, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-08-25 22:37:03', '1', NULL, 0, NULL),
(859, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-08-27 04:33:51', '1', NULL, 0, NULL),
(860, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-08-27 17:01:47', '1', NULL, 0, NULL),
(861, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-08-28 03:05:56', '1', NULL, 0, NULL),
(862, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-08-28 22:38:59', '1', NULL, 0, NULL),
(863, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-08-28 22:39:31', '1', NULL, 0, NULL),
(864, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-08-28 22:47:27', '1', NULL, 0, NULL),
(865, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-08-30 22:31:21', '1', NULL, 0, NULL),
(866, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-09-02 19:02:17', '1', NULL, 0, NULL),
(867, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-09-03 01:39:48', '1', NULL, 0, NULL),
(868, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-09-08 18:59:46', '1', NULL, 0, NULL),
(869, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-09-08 19:00:31', '1', NULL, 0, NULL),
(870, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-09-08 19:02:12', '1', NULL, 0, NULL),
(871, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-09-19 03:37:48', '1', NULL, 0, NULL),
(872, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added <a href=\"invoices/invoice/18\">INV-18</a>.', '2018-09-19 03:47:05', '1', 18, 0, NULL),
(873, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-09-19 03:52:16', '1', NULL, 0, NULL),
(874, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-09-19 03:52:32', '1', NULL, 0, NULL),
(875, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-09-19 03:54:36', '1', NULL, 0, NULL),
(876, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-09-19 03:54:58', '1', NULL, 0, NULL),
(877, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-09-19 03:55:06', '1', NULL, 0, NULL),
(878, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-09-19 03:55:14', '1', NULL, 0, NULL),
(879, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-09-19 03:55:23', '1', NULL, 0, NULL),
(880, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-09-19 03:57:28', '1', NULL, 0, NULL),
(881, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-09-19 03:57:38', '1', NULL, 0, NULL),
(882, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-09-19 03:57:46', '1', NULL, 0, NULL),
(883, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-09-19 03:57:59', '1', NULL, 0, NULL),
(884, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-09-19 18:01:05', '1', NULL, 0, NULL),
(885, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-09-19 21:31:03', '1', NULL, 0, NULL),
(886, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-09-20 01:19:38', '1', NULL, 0, NULL),
(887, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-09-25 17:38:45', '1', NULL, 0, NULL),
(888, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-09-28 06:41:16', '1', NULL, 0, NULL),
(889, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-09-28 11:25:21', '1', NULL, 0, NULL),
(890, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-09-28 20:35:53', '1', NULL, 0, NULL),
(891, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/7\"> Product7</a>', '2018-09-29 03:47:43', '1', NULL, 0, NULL),
(892, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/8\"> Product8</a>', '2018-09-29 04:00:39', '1', NULL, 0, NULL),
(893, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-09-29 09:29:02', '1', NULL, 0, NULL),
(894, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-09-30 16:23:56', '1', NULL, 0, NULL),
(895, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-09-30 22:18:54', '1', NULL, 0, NULL),
(896, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-09-30 22:49:45', '1', NULL, 0, NULL),
(897, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/9\"> Product9</a>', '2018-09-30 22:59:59', '1', NULL, 0, NULL),
(898, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/10\"> Product10</a>', '2018-09-30 23:13:12', '1', NULL, 0, NULL),
(899, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/11\"> Product11</a>', '2018-09-30 23:13:24', '1', NULL, 0, NULL),
(900, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/12\"> Product12</a>', '2018-09-30 23:13:58', '1', NULL, 0, NULL),
(901, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/13\"> Product13</a>', '2018-09-30 23:14:34', '1', NULL, 0, NULL),
(902, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/14\"> Product14</a>', '2018-09-30 23:15:47', '1', NULL, 0, NULL),
(903, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/15\"> Product15</a>', '2018-09-30 23:17:37', '1', NULL, 0, NULL),
(904, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/16\"> Product16</a>', '2018-09-30 23:19:42', '1', NULL, 0, NULL),
(905, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/17\"> Product17</a>', '2018-09-30 23:20:36', '1', NULL, 0, NULL),
(906, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/18\"> Product18</a>', '2018-09-30 23:21:03', '1', NULL, 0, NULL),
(907, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/19\"> Product19</a>', '2018-09-30 23:23:21', '1', NULL, 0, NULL),
(908, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/20\"> Product20</a>', '2018-09-30 23:25:02', '1', NULL, 0, NULL),
(909, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/21\"> Product21</a>', '2018-09-30 23:27:10', '1', NULL, 0, NULL),
(910, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/22\"> Product22</a>', '2018-10-01 00:10:06', '1', NULL, 0, NULL),
(911, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/23\"> Product23</a>', '2018-10-01 00:12:29', '1', NULL, 0, NULL),
(912, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/24\"> Product24</a>', '2018-10-01 00:26:09', '1', NULL, 0, NULL),
(913, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/25\"> Product25</a>', '2018-10-01 00:27:50', '1', NULL, 0, NULL),
(914, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/26\"> Product26</a>', '2018-10-01 00:28:57', '1', NULL, 0, NULL),
(915, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-26', '2018-10-01 00:33:38', '1', NULL, 0, NULL),
(916, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-25', '2018-10-01 00:33:41', '1', NULL, 0, NULL),
(917, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-24', '2018-10-01 00:33:44', '1', NULL, 0, NULL),
(918, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-23', '2018-10-01 00:33:46', '1', NULL, 0, NULL),
(919, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-22', '2018-10-01 00:33:48', '1', NULL, 0, NULL),
(920, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-01 04:12:04', '1', NULL, 0, NULL),
(921, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/27\"> Product27</a>', '2018-10-01 04:38:18', '1', NULL, 0, NULL),
(922, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/27\"> Product27</a>', '2018-10-01 05:10:24', '1', NULL, 0, NULL),
(923, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/27\"> Product27</a>', '2018-10-01 05:10:39', '1', NULL, 0, NULL),
(924, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/27\"> Product27</a>', '2018-10-01 05:11:14', '1', NULL, 0, NULL),
(925, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/27\"> Product27</a>', '2018-10-01 05:11:30', '1', NULL, 0, NULL),
(926, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/27\"> Product27</a>', '2018-10-01 05:12:47', '1', NULL, 0, NULL),
(927, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/27\"> Product27</a>', '2018-10-01 05:14:32', '1', NULL, 0, NULL),
(928, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/27\"> Product27</a>', '2018-10-01 05:16:47', '1', NULL, 0, NULL),
(929, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/27\"> Product27</a>', '2018-10-01 05:19:28', '1', NULL, 0, NULL),
(930, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/27\"> Product27</a>', '2018-10-01 05:20:21', '1', NULL, 0, NULL),
(931, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/27\"> Product27</a>', '2018-10-01 05:20:54', '1', NULL, 0, NULL),
(932, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/27\"> Product27</a>', '2018-10-01 05:22:10', '1', NULL, 0, NULL),
(933, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/27\"> Product27</a>', '2018-10-01 05:23:39', '1', NULL, 0, NULL),
(934, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/27\"> Product27</a>', '2018-10-01 05:24:01', '1', NULL, 0, NULL),
(935, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/27\"> Product27</a>', '2018-10-01 05:24:22', '1', NULL, 0, NULL),
(936, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/27\"> Product27</a>', '2018-10-01 05:26:15', '1', NULL, 0, NULL),
(937, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/27\"> Product27</a>', '2018-10-01 05:26:29', '1', NULL, 0, NULL),
(938, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/27\"> Product27</a>', '2018-10-01 05:26:33', '1', NULL, 0, NULL),
(939, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/27\"> Product27</a>', '2018-10-01 05:26:45', '1', NULL, 0, NULL),
(940, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/27\"> Product27</a>', '2018-10-01 05:27:32', '1', NULL, 0, NULL),
(941, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/27\"> Product27</a>', '2018-10-01 05:28:53', '1', NULL, 0, NULL),
(942, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/27\"> Product27</a>', '2018-10-01 05:29:14', '1', NULL, 0, NULL),
(943, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/27\"> Product27</a>', '2018-10-01 05:29:31', '1', NULL, 0, NULL),
(944, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/27\"> Product27</a>', '2018-10-01 05:35:26', '1', NULL, 0, NULL),
(945, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/27\"> Product27</a>', '2018-10-01 05:39:16', '1', NULL, 0, NULL),
(946, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/27\"> Product27</a>', '2018-10-01 05:39:28', '1', NULL, 0, NULL),
(947, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/27\"> Product27</a>', '2018-10-01 05:39:40', '1', NULL, 0, NULL),
(948, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/27\"> Product27</a>', '2018-10-01 05:39:56', '1', NULL, 0, NULL),
(949, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/27\"> Product27</a>', '2018-10-01 05:41:48', '1', NULL, 0, NULL),
(950, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/27\"> Product27</a>', '2018-10-01 05:42:50', '1', NULL, 0, NULL),
(951, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/27\"> Product27</a>', '2018-10-01 05:43:54', '1', NULL, 0, NULL),
(952, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/27\"> Product27</a>', '2018-10-01 05:52:56', '1', NULL, 0, NULL),
(953, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/27\"> Product27</a>', '2018-10-01 05:53:45', '1', NULL, 0, NULL),
(954, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/27\"> Product27</a>', '2018-10-01 05:56:45', '1', NULL, 0, NULL),
(955, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-27', '2018-10-01 05:57:37', '1', NULL, 0, NULL),
(956, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/28\"> Product28</a>', '2018-10-01 05:58:52', '1', NULL, 0, NULL),
(957, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/28\"> Product28</a>', '2018-10-01 06:29:17', '1', NULL, 0, NULL),
(958, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/28\"> Product28</a>', '2018-10-01 06:30:30', '1', NULL, 0, NULL),
(959, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/28\"> Product28</a>', '2018-10-01 06:30:58', '1', NULL, 0, NULL),
(960, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/28\"> Product28</a>', '2018-10-01 06:31:08', '1', NULL, 0, NULL),
(961, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/28\"> Product28</a>', '2018-10-01 06:32:42', '1', NULL, 0, NULL),
(962, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/28\"> Product28</a>', '2018-10-01 06:40:10', '1', NULL, 0, NULL),
(963, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/28\"> Product28</a>', '2018-10-01 06:40:34', '1', NULL, 0, NULL),
(964, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/28\"> Product28</a>', '2018-10-01 06:41:10', '1', NULL, 0, NULL),
(965, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/28\"> Product28</a>', '2018-10-01 06:43:01', '1', NULL, 0, NULL),
(966, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/29\"> Product29</a>', '2018-10-01 06:45:12', '1', NULL, 0, NULL),
(967, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/29\"> Product29</a>', '2018-10-01 06:47:10', '1', NULL, 0, NULL),
(968, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/29\"> Product29</a>', '2018-10-01 07:04:19', '1', NULL, 0, NULL),
(969, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/29\"> Product29</a>', '2018-10-01 07:05:27', '1', NULL, 0, NULL),
(970, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/29\"> Product29</a>', '2018-10-01 07:05:52', '1', NULL, 0, NULL),
(971, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/29\"> Product29</a>', '2018-10-01 07:06:45', '1', NULL, 0, NULL),
(972, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/29\"> Product29</a>', '2018-10-01 07:08:04', '1', NULL, 0, NULL),
(973, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/29\"> Product29</a>', '2018-10-01 07:12:52', '1', NULL, 0, NULL),
(974, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/29\"> Product29</a>', '2018-10-01 07:15:59', '1', NULL, 0, NULL),
(975, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/29\"> Product29</a>', '2018-10-01 07:16:12', '1', NULL, 0, NULL),
(976, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/30\"> Product30</a>', '2018-10-01 07:16:37', '1', NULL, 0, NULL),
(977, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/30\"> Product30</a>', '2018-10-01 07:17:13', '1', NULL, 0, NULL),
(978, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/30\"> Product30</a>', '2018-10-01 07:17:33', '1', NULL, 0, NULL),
(979, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/30\"> Product30</a>', '2018-10-01 07:19:54', '1', NULL, 0, NULL),
(980, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/30\"> Product30</a>', '2018-10-01 07:20:35', '1', NULL, 0, NULL),
(981, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-30', '2018-10-01 07:21:57', '1', NULL, 0, NULL),
(982, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-29', '2018-10-01 07:22:00', '1', NULL, 0, NULL),
(983, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-28', '2018-10-01 07:22:03', '1', NULL, 0, NULL),
(984, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/6\"> Product6</a>', '2018-10-01 07:22:26', '1', NULL, 0, NULL),
(985, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/6\"> Product6</a>', '2018-10-01 07:26:26', '1', NULL, 0, NULL),
(986, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/6\"> Product6</a>', '2018-10-01 07:35:38', '1', NULL, 0, NULL),
(987, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/6\"> Product6</a>', '2018-10-01 07:36:08', '1', NULL, 0, NULL),
(988, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/6\"> Product6</a>', '2018-10-01 07:46:22', '1', NULL, 0, NULL),
(989, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/6\"> Product6</a>', '2018-10-01 07:47:51', '1', NULL, 0, NULL),
(990, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/6\"> Product6</a>', '2018-10-01 07:50:33', '1', NULL, 0, NULL),
(991, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-10-01 08:46:32', '1', NULL, 0, NULL),
(992, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-01 08:46:36', '1', NULL, 0, NULL),
(993, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-01 12:54:55', '1', NULL, 0, NULL),
(994, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-01 20:29:40', '1', NULL, 0, NULL),
(995, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-02 00:11:54', '1', NULL, 0, NULL),
(996, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-02 21:39:36', '1', NULL, 0, NULL),
(997, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-04 00:16:12', '1', NULL, 0, NULL),
(998, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-04 00:16:30', '1', NULL, 0, NULL),
(999, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/6\"> Product6</a>', '2018-10-04 04:14:33', '1', NULL, 0, NULL),
(1000, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/6\"> Product6</a>', '2018-10-04 04:14:50', '1', NULL, 0, NULL),
(1001, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/6\"> Product6</a>', '2018-10-04 04:20:22', '1', NULL, 0, NULL),
(1002, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/6\"> Product6</a>', '2018-10-04 04:23:40', '1', NULL, 0, NULL),
(1003, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-04 12:15:25', '1', NULL, 0, NULL),
(1004, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/6\"> Product6</a>', '2018-10-04 13:05:51', '1', NULL, 0, NULL),
(1005, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-04 16:53:10', '1', NULL, 0, NULL),
(1006, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-04 16:53:23', '1', NULL, 0, NULL),
(1007, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/31\"> Product31</a>', '2018-10-04 20:10:32', '1', NULL, 0, NULL),
(1008, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/32\"> Product32</a>', '2018-10-04 20:10:44', '1', NULL, 0, NULL),
(1009, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/33\"> Product33</a>', '2018-10-04 20:12:01', '1', NULL, 0, NULL),
(1010, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-32', '2018-10-04 20:13:30', '1', NULL, 0, NULL),
(1011, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-33', '2018-10-04 20:13:33', '1', NULL, 0, NULL),
(1012, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-31', '2018-10-04 20:13:35', '1', NULL, 0, NULL),
(1013, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/34\"> Product34</a>', '2018-10-04 20:34:13', '1', NULL, 0, NULL),
(1014, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/35\"> Product35</a>', '2018-10-04 20:35:03', '1', NULL, 0, NULL),
(1015, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/36\"> Product36</a>', '2018-10-04 21:51:24', '1', NULL, 0, NULL),
(1016, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-36', '2018-10-04 21:53:36', '1', NULL, 0, NULL),
(1017, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-35', '2018-10-04 21:53:38', '1', NULL, 0, NULL),
(1018, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-34', '2018-10-04 21:53:41', '1', NULL, 0, NULL),
(1019, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/37\"> Product37</a>', '2018-10-04 21:53:54', '1', NULL, 0, NULL),
(1020, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-37', '2018-10-04 21:54:12', '1', NULL, 0, NULL),
(1021, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/38\"> Product38</a>', '2018-10-04 21:54:27', '1', NULL, 0, NULL),
(1022, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/39\"> Product39</a>', '2018-10-04 21:55:29', '1', NULL, 0, NULL),
(1023, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-39', '2018-10-04 21:56:01', '1', NULL, 0, NULL),
(1024, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-38', '2018-10-04 21:56:08', '1', NULL, 0, NULL),
(1025, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/40\"> Product40</a>', '2018-10-04 21:56:19', '1', NULL, 0, NULL),
(1026, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-40', '2018-10-04 21:57:17', '1', NULL, 0, NULL),
(1027, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/41\"> Product41</a>', '2018-10-04 21:57:32', '1', NULL, 0, NULL),
(1028, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-41', '2018-10-04 21:57:40', '1', NULL, 0, NULL),
(1029, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/42\"> Product42</a>', '2018-10-04 21:58:17', '1', NULL, 0, NULL),
(1030, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-42', '2018-10-04 21:58:52', '1', NULL, 0, NULL),
(1031, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/43\"> Product43</a>', '2018-10-04 21:59:09', '1', NULL, 0, NULL),
(1032, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/44\"> Product44</a>', '2018-10-04 22:01:08', '1', NULL, 0, NULL),
(1033, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/45\"> Product45</a>', '2018-10-04 22:02:26', '1', NULL, 0, NULL),
(1034, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/46\"> Product46</a>', '2018-10-04 22:03:31', '1', NULL, 0, NULL),
(1035, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/47\"> Product47</a>', '2018-10-04 22:04:08', '1', NULL, 0, NULL),
(1036, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/48\"> Product48</a>', '2018-10-04 22:04:52', '1', NULL, 0, NULL),
(1037, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-48', '2018-10-04 22:10:07', '1', NULL, 0, NULL),
(1038, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-47', '2018-10-04 22:10:10', '1', NULL, 0, NULL),
(1039, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-46', '2018-10-04 22:10:12', '1', NULL, 0, NULL),
(1040, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-45', '2018-10-04 22:10:15', '1', NULL, 0, NULL),
(1041, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-44', '2018-10-04 22:10:18', '1', NULL, 0, NULL),
(1042, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-43', '2018-10-04 22:10:21', '1', NULL, 0, NULL),
(1043, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/49\"> Product49</a>', '2018-10-04 22:10:49', '1', NULL, 0, NULL),
(1044, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/50\"> Product50</a>', '2018-10-04 22:12:13', '1', NULL, 0, NULL),
(1045, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/51\"> Product51</a>', '2018-10-04 22:13:55', '1', NULL, 0, NULL),
(1046, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/52\"> Product52</a>', '2018-10-04 22:14:13', '1', NULL, 0, NULL),
(1047, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/53\"> Product53</a>', '2018-10-04 22:16:03', '1', NULL, 0, NULL),
(1048, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/54\"> Product54</a>', '2018-10-04 22:16:55', '1', NULL, 0, NULL),
(1049, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-54', '2018-10-04 22:27:13', '1', NULL, 0, NULL),
(1050, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-53', '2018-10-04 22:27:15', '1', NULL, 0, NULL),
(1051, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-52', '2018-10-04 22:27:18', '1', NULL, 0, NULL),
(1052, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-51', '2018-10-04 22:27:21', '1', NULL, 0, NULL),
(1053, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-50', '2018-10-04 22:27:24', '1', NULL, 0, NULL),
(1054, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-49', '2018-10-04 22:27:27', '1', NULL, 0, NULL),
(1055, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-6', '2018-10-04 22:27:29', '1', NULL, 0, NULL),
(1056, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-5', '2018-10-04 22:27:32', '1', NULL, 0, NULL),
(1057, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-3', '2018-10-04 22:27:35', '1', NULL, 0, NULL),
(1058, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-2', '2018-10-04 22:27:38', '1', NULL, 0, NULL),
(1059, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-1', '2018-10-04 22:28:05', '1', NULL, 0, NULL),
(1060, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/7\"> Product7</a>', '2018-10-04 22:30:21', '1', NULL, 0, NULL),
(1061, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-7', '2018-10-04 22:31:00', '1', NULL, 0, NULL),
(1062, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/8\"> Product8</a>', '2018-10-04 22:31:11', '1', NULL, 0, NULL),
(1063, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-8', '2018-10-04 22:33:40', '1', NULL, 0, NULL),
(1064, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a new product <a href=\"products/product/9\"> Product9</a>', '2018-10-04 22:44:41', '1', NULL, 0, NULL),
(1065, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted Product-9', '2018-10-04 22:45:03', '1', NULL, 0, NULL),
(1066, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/6\"> Product6</a>', '2018-10-04 22:47:09', '1', NULL, 0, NULL),
(1067, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-05 07:08:13', '1', NULL, 0, NULL),
(1068, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-10-05 07:37:17', '1', NULL, 0, NULL),
(1069, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-05 16:07:30', '1', NULL, 0, NULL),
(1070, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-07 15:52:26', '1', NULL, 0, NULL),
(1071, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/6\"> Product6</a>', '2018-10-07 15:53:38', '1', NULL, 0, NULL),
(1072, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-08 17:48:03', '1', NULL, 0, NULL),
(1073, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-10 18:12:41', '1', NULL, 0, NULL),
(1074, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-14 10:45:05', '1', NULL, 0, NULL),
(1075, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-14 10:54:33', '1', NULL, 0, NULL),
(1076, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-14 10:55:18', '1', NULL, 0, NULL),
(1077, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-14 10:56:24', '1', NULL, 0, NULL),
(1078, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-14 11:03:53', '1', NULL, 0, NULL),
(1079, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-14 11:08:34', '1', NULL, 0, NULL),
(1080, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added <a href=\"orders/order/1\">-1</a>.', '2018-10-14 14:52:18', '1', NULL, 0, NULL),
(1081, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added <a href=\"orders/order/2\">-2</a>.', '2018-10-14 14:52:28', '1', NULL, 0, NULL),
(1082, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added <a href=\"orders/order/3\">-3</a>.', '2018-10-14 14:55:26', '1', NULL, 0, NULL),
(1083, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted PRO-3', '2018-10-14 15:25:33', '1', NULL, 0, NULL),
(1084, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted PRO-1', '2018-10-14 15:25:45', '1', NULL, 0, NULL),
(1085, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted -3', '2018-10-14 15:26:58', '1', NULL, 0, NULL),
(1086, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted -2', '2018-10-14 15:27:06', '1', NULL, 0, NULL),
(1087, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-14 21:21:01', '1', NULL, 0, NULL),
(1088, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-14 21:23:12', '1', NULL, 0, NULL),
(1089, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-15 00:27:07', '1', NULL, 0, NULL),
(1090, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-15 01:40:21', '1', NULL, 0, NULL),
(1091, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-16 12:55:29', '1', NULL, 0, NULL),
(1092, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-25 23:32:41', '1', NULL, 0, NULL),
(1093, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-25 23:33:02', '1', NULL, 0, NULL),
(1094, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-25 23:35:07', '1', NULL, 0, NULL),
(1095, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-26 11:27:53', '1', NULL, 0, NULL),
(1096, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-10-26 11:57:37', '1', NULL, 0, NULL),
(1097, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2018-10-26 11:57:53', '1', NULL, 0, NULL),
(1098, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-26 11:58:24', '1', NULL, 0, NULL),
(1099, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-26 11:59:15', '1', NULL, 0, NULL),
(1100, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-26 11:59:51', '1', NULL, 0, NULL),
(1101, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-26 12:00:25', '1', NULL, 0, NULL),
(1102, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-10-27 16:10:59', '1', NULL, 0, NULL),
(1103, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-11-07 12:50:39', '1', NULL, 0, NULL),
(1104, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-11-12 02:24:38', '1', NULL, 0, NULL),
(1105, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"products/product/6\"> Product6</a>', '2018-11-12 02:25:50', '1', NULL, 0, NULL),
(1106, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added <a href=\"invoices/invoice/19\">INV-19</a>.', '2018-11-12 02:27:01', '1', 18, 0, NULL),
(1107, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added <a href=\"invoices/invoice/20\">INV-20</a>.', '2018-11-12 02:27:58', '1', 0, 0, NULL),
(1108, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted INV-20', '2018-11-12 02:28:07', '1', NULL, 0, NULL),
(1109, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added <a href=\"invoices/invoice/21\">INV-21</a>.', '2018-11-12 02:28:21', '1', 0, 0, NULL),
(1110, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted INV-21', '2018-11-12 02:28:48', '1', NULL, 0, NULL),
(1111, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added <a href=\"invoices/invoice/22\">INV-22</a>.', '2018-11-12 02:29:01', '1', 0, 0, NULL),
(1112, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added <a href=\"invoices/invoice/23\">INV-23</a>.', '2018-11-12 02:31:24', '1', 18, 0, NULL),
(1113, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted INV-23', '2018-11-12 02:32:19', '1', NULL, 0, NULL),
(1114, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"invoices/invoice/19\">INV-19</a>.', '2018-11-12 02:37:27', '1', 18, 0, NULL),
(1115, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-11-12 15:53:24', '1', NULL, 0, NULL),
(1116, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2018-11-13 19:05:56', '1', NULL, 0, NULL),
(1117, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added <a href=\"proposals/proposal/6\">PRO-6</a>.', '2018-11-13 19:06:36', '1', NULL, 0, NULL),
(1118, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"proposals/proposal/6\">PRO-6</a>.', '2018-11-13 19:17:43', '1', 0, 0, NULL),
(1119, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"proposals/proposal/6\">PRO-6</a>.', '2018-11-13 19:17:58', '1', 0, 0, NULL),
(1120, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a expense. <a href=\"expenses/receipt/10\">EXP-10</a>.', '2018-11-13 19:18:34', '1', 0, 0, NULL),
(1121, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"expenses/receipt/10\">EXP-10</a>.', '2018-11-13 19:24:52', '1', 0, 0, NULL),
(1122, 'Lance Bogrol updated project.', '2018-11-13 19:46:19', '1', NULL, 1, NULL);
INSERT INTO `logs` (`id`, `detail`, `date`, `staff_id`, `customer_id`, `project_id`, `vendor_id`) VALUES
(1123, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"tasks/task/1\">Task-1</a>.', '2018-11-13 19:48:43', '1', NULL, 0, NULL),
(1124, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2019-04-08 18:30:45', '1', NULL, 0, NULL),
(1125, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2019-04-15 11:52:28', '1', NULL, 0, NULL),
(1126, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2019-04-15 16:22:40', '1', NULL, 0, NULL),
(1127, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2019-04-15 19:10:51', '1', NULL, 0, NULL),
(1128, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> deleted PRO-6', '2019-04-15 19:17:03', '1', NULL, 0, NULL),
(1129, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"tasks/task/1\">Task-1</a>.', '2019-04-15 19:18:20', '1', NULL, 0, NULL),
(1130, 'Lance Bogrol added new task', '2019-04-15 19:20:21', '1', NULL, 1, NULL),
(1131, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"tasks/task/2\">Task-2</a>.', '2019-04-15 19:20:41', '1', NULL, 0, NULL),
(1132, 'Lance Bogrol added new task', '2019-04-15 20:13:26', '1', NULL, 1, NULL),
(1133, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated <a href=\"expenses/receipt/10\">EXP-10</a>.', '2019-04-15 20:22:46', '1', 0, 0, NULL),
(1134, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> added a online lead form <a href=\"leads/form/1\">Form</a>.', '2019-04-15 20:29:48', '1', NULL, 0, NULL),
(1135, 'Lance Bogrol created new project', '2019-04-15 20:43:48', '1', 0, 2, NULL),
(1136, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2019-04-15 20:45:43', '1', NULL, 0, NULL),
(1137, '<a href=\"staff/staffmember/\"> Lance Bogrol</a> deleted Customer-4', '2019-04-15 14:03:10', '1', NULL, 0, NULL),
(1138, '<a href=\"staff/staffmember/\"> Lance Bogrol</a> deleted Customer-3', '2019-04-15 14:04:48', '1', NULL, 0, NULL),
(1139, 'Lance Bogrol added New Milestone', '2019-04-15 16:20:52', '1', NULL, 2, NULL),
(1140, 'Lance Bogrol added New Milestone', '2019-04-15 16:21:20', '1', NULL, 2, NULL),
(1141, 'Lance Bogrol added New Milestone', '2019-04-15 16:21:59', '1', NULL, 2, NULL),
(1142, 'Sue Shei added <a href=\"tickets/ticket/4\"> TICKET-4</a>', '2019-04-15 16:49:41', NULL, 23, 0, NULL),
(1143, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2019-04-15 16:51:19', '1', NULL, 0, NULL),
(1144, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2019-04-16 02:03:57', '1', NULL, 0, NULL),
(1145, '<a href=\"staff/staffmember/3\"> Guy Mann</a> logged in the system', '2019-04-16 02:09:59', '3', NULL, 0, NULL),
(1146, '<a href=\"staff/staffmember/3\"> Guy Mann</a> logged in the system', '2019-04-16 02:35:14', '3', NULL, 0, NULL),
(1147, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2019-04-16 02:35:47', '1', NULL, 0, NULL),
(1148, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2019-04-16 05:08:33', '1', NULL, 0, NULL),
(1149, '', '2019-04-16 05:15:38', '1', NULL, 0, NULL),
(1150, '<a href=\"staff/staffmember/5\"> Root Admin</a> logged in the system', '2019-04-16 05:17:20', '5', NULL, 0, NULL),
(1151, '<a href=\"staff/staffmember/3\"> Guy Mann</a> logged in the system', '2019-04-18 03:29:35', '3', NULL, 0, NULL),
(1152, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> logged in the system', '2019-04-18 03:29:56', '1', NULL, 0, NULL),
(1153, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2019-04-18 03:32:17', '1', NULL, 0, NULL),
(1154, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2019-04-18 03:32:22', '1', NULL, 0, NULL),
(1155, '<a href=\"staff/staffmember/1\"> Lance Bogrol</a> updated settings', '2019-04-18 03:32:27', '1', NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

CREATE TABLE `meetings` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `customer_id` int(5) NOT NULL,
  `staff_id` int(5) NOT NULL,
  `date` date NOT NULL,
  `start` time NOT NULL,
  `end` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `meetings`
--

INSERT INTO `meetings` (`id`, `title`, `description`, `customer_id`, `staff_id`, `date`, `start`, `end`) VALUES
(1, 'Toyota Dallas Meet', 'Im going to DHARMA Initiative this day.', 17, 1, '2018-04-16', '13:00:00', '14:00:00'),
(2, 'Wallmart Dallas Meet', 'Im going to Parallax Corporation this day.', 18, 1, '2018-04-17', '16:00:00', '17:00:00'),
(3, 'Test', 'Test', 16, 2, '2018-04-20', '13:00:00', '15:00:00'),
(4, 'asdfsa', '', 0, 0, '2018-04-16', '04:43:07', '04:43:07'),
(5, 'Customer Visit', 'Visit', 17, 1, '2018-05-02', '15:00:00', '17:00:00'),
(6, 'Customer Visit', 'Visit', 18, 1, '2018-05-03', '15:00:00', '17:00:00'),
(7, 'Bla Bla', 'Test', 17, 1, '2018-05-30', '15:00:00', '18:00:00'),
(8, 'Test', 'Tes', 16, 1, '2018-05-15', '16:35:33', '18:35:58');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `order_id` int(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `main_menu` int(5) DEFAULT '0',
  `icon` varchar(100) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `show_staff` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `order_id`, `name`, `description`, `main_menu`, `icon`, `url`, `show_staff`) VALUES
(1, 1, 'x_menu_panel', NULL, 0, NULL, 'panel', 0),
(2, 2, 'x_menu_finance', NULL, 0, NULL, NULL, 0),
(3, 3, 'x_menu_customers_and_lead', NULL, 0, NULL, NULL, 0),
(4, 4, 'x_menu_track', NULL, 0, NULL, NULL, 0),
(5, 5, 'x_menu_others', NULL, 0, NULL, NULL, 1),
(6, 6, 'x_menu_purchases', NULL, 0, NULL, NULL, 0),
(8, 1, 'x_menu_invoices', 'manage_invoices', 2, 'ico-ciuis-invoices', 'invoices', 0),
(9, 2, 'x_menu_deposits', 'manage_deposits', 2, 'ion-ios-paper-outline', 'deposits', 0),
(10, 3, 'x_menu_expenses', 'manage_expenses', 2, 'ico-ciuis-expenses', 'expenses', 0),
(11, 4, 'x_menu_accounts', 'manage_accounts', 2, 'ico-ciuis-accounts', 'accounts', 0),
(12, 1, 'x_menu_orders', 'manage_orders', 3, 'ion-ios-filing-outline', 'orders', 0),
(13, 2, 'x_menu_proposals', 'manage_proposals', 3, 'ico-ciuis-proposals', 'proposals', 0),
(14, 3, 'x_menu_customers', 'manage_customers', 3, 'ico-ciuis-customers', 'customers', 0),
(15, 4, 'x_menu_leads', 'manage_leads', 3, 'ico-ciuis-leads', 'leads', 0),
(16, 5, 'x_menu_products', 'manage_products', 3, 'ico-ciuis-products', 'products', 0),
(17, 1, 'x_menu_projects', 'manage_projects', 4, 'ico-ciuis-projects', 'projects', 0),
(18, 2, 'x_menu_tasks', 'manage_tasks', 4, 'ico-ciuis-tasks', 'tasks', 0),
(19, 3, 'x_menu_timesheets', 'manage_timesheets', 4, 'ion-ios-clock-outline', 'timesheets', 0),
(20, 4, 'x_menu_tickets', 'manage_tickets', 4, 'ico-ciuis-supports', 'tickets', 0),
(21, 4, 'x_menu_reports', 'manage_reports', 5, 'ico-ciuis-reports', 'report', 0),
(22, 1, 'x_menu_staff', 'manage_staff', 5, 'ico-ciuis-staff', 'staff', 0),
(23, 2, 'x_menu_calendar', 'manage_calendar', 5, 'ion-android-calendar', 'calendar', 0),
(24, 3, 'x_menu_emails', 'manage_emails', 5, 'ion-ios-email-outline', 'emails', 0),
(25, 1, 'x_menu_vendors', 'manage_vendor', 6, 'ion-social-buffer-outline', 'vendors', 0),
(27, 6, 'x_menu_inventory', 'manage_inventory', 3, 'ion-cube', 'inventories', 0),
(28, 5, 'x_menu_filemanager', 'manage_files', 5, 'ion-ios-folder-outline', 'filemanager', 0);

-- --------------------------------------------------------

--
-- Table structure for table `milestones`
--

CREATE TABLE `milestones` (
  `id` int(11) NOT NULL,
  `order` int(5) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL,
  `description` text,
  `duedate` date NOT NULL,
  `project_id` int(5) NOT NULL,
  `color` varchar(10) DEFAULT NULL,
  `created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `milestones`
--

INSERT INTO `milestones` (`id`, `order`, `name`, `description`, `duedate`, `project_id`, `color`, `created`) VALUES
(1, 1, 'Make a Design', 'Make a amazing design.', '2018-01-31', 1, 'green', '2018-01-02'),
(2, 2, 'Develop', 'Develop', '2018-01-31', 1, 'green', '2018-01-02'),
(3, 3, 'Start Coding', 'Start Coding', '2018-01-31', 1, 'green', '2018-01-02'),
(5, 1, 'Begin', 'Test', '2018-01-07', 3, 'green', '2018-01-07'),
(7, 2, 'Finish', 'Finish this job.', '2018-02-08', 3, 'green', '2018-02-08'),
(8, 1, 'Phase1', 'Phase1', '2019-04-27', 2, 'green', '2019-04-15'),
(9, 2, 'Phase2', 'Phase2', '2019-05-15', 2, 'green', '2019-04-15'),
(10, 3, 'Go-live', 'Go-Live', '2019-05-31', 2, 'green', '2019-04-15');

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `license` varchar(255) DEFAULT NULL,
  `version` varchar(10) DEFAULT NULL,
  `last_updated` date DEFAULT NULL,
  `last_version` varchar(10) DEFAULT NULL,
  `updatedat` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `relation_type` varchar(100) NOT NULL,
  `relation` int(5) NOT NULL,
  `description` text,
  `addedfrom` int(5) DEFAULT NULL,
  `customer_id` int(5) DEFAULT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id`, `relation_type`, `relation`, `description`, `addedfrom`, `customer_id`, `created`) VALUES
(2, 'customer', 2, 'Proin tellus mi, dignissim eget purus sit amet, egestas sodales lectus. Proin ac risus a velit tempor tincidunt. Mauris sapien odio, tincidunt eget magna nec, luctus scelerisque velit.', 1, NULL, '2017-08-25 02:26:46'),
(4, 'customer', 5, 'Proin tellus mi, dignissim eget purus sit amet, egestas sodales lectus. Proin ac risus a velit tempor tincidunt. Mauris sapien odio, tincidunt eget magna nec, luctus scelerisque velit.', 1, NULL, '2017-08-25 02:27:00'),
(5, 'customer', 6, 'Mauris sapien odio, tincidunt eget magna nec, luctus scelerisque velit.', 1, NULL, '2017-08-25 02:27:12'),
(7, 'customer', 5, 'Quisque commodo ornare nisi sed sagittis. Donec vitae feugiat odio.', 1, NULL, '2017-08-25 21:18:13'),
(9, 'customer', 6, 'Donec volutpat massa id justo lacinia, quis cursus lorem consectetur.', 1, NULL, '2017-08-26 15:51:45'),
(10, 'customer', 7, 'Lorem ipsum sit dolor amet.', 1, NULL, '2017-08-27 08:09:38'),
(11, 'customer', 8, 'Proin tellus mi, dignissim eget purus sit amet, egestas sodales lectus. Proin ac risus a velit tempor tincidunt. Mauris sapien odio, tincidunt eget magna nec, luctus scelerisque velit.', 1, NULL, '2017-08-28 20:55:19'),
(13, 'proposal', 2, 'Test', 1, NULL, '2017-08-31 00:46:45'),
(15, 'proposal', 2, 'Test', 1, NULL, '2017-08-31 00:48:55'),
(16, 'lead', 1, 'Test', 1, NULL, '2017-08-31 03:49:26'),
(19, 'customer', 16, 'Test', 1, NULL, '2017-08-31 03:56:39'),
(22, 'lead', 6, 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur.', 1, NULL, '2017-09-03 02:27:14'),
(24, 'customer', 1, 'Lorem ipsum dolor sit amet.', 1, NULL, '2017-09-06 17:29:26'),
(25, 'lead', 2, 'Test', 1, NULL, '2017-09-11 04:59:12'),
(35, 'project', 11, 'Sample Details', 1, NULL, '2017-11-14 02:10:46'),
(38, 'project', 0, 'Test', 1, NULL, '2017-11-23 01:48:24'),
(39, 'proposal', 0, 'Test', 1, NULL, '2017-11-23 02:05:42'),
(40, 'proposal', 0, 'test', 1, NULL, '2017-11-23 02:07:03'),
(45, 'customer', 9, 'Lorem ipsum sit dolor amet.', 1, NULL, '2017-11-23 02:24:09'),
(46, 'proposal', 7, 'Sample proposal note.', 1, NULL, '2017-11-23 02:28:59'),
(47, 'proposal', 7, 'Lorem ipsum dolor sit amet.', 1, NULL, '2017-11-23 02:29:09'),
(48, 'proposal', 7, 'Another note.', 2, NULL, '2017-11-23 02:29:59'),
(50, 'lead', 7, 'Sample lead note', 1, NULL, '2017-11-23 02:39:19'),
(51, 'lead', 7, 'Lorem ipsum sit dolor amet.', 1, NULL, '2017-11-23 02:39:28'),
(52, 'customer', 17, 'This page of this web site has a good collection of Zen Tales. Why are we suggesting that you tell these stories to your neighbors?', 1, NULL, '2017-11-23 03:54:59'),
(53, 'customer', 17, 'Or maybe it\'s just because they are fun to tell.', 1, NULL, '2017-11-23 03:55:13'),
(54, 'customer', 17, 'Think of these tales as conversation pieces, as handy tools that you can lift out of your pocket to help you and others talk, think and laugh about the wondrous and mysterious details of this thing we call Life. ', 1, NULL, '2017-11-23 03:55:34'),
(55, 'customer', 17, 'Lorem ipsum dolor sit amet', 1, NULL, '2017-11-23 03:58:58'),
(56, 'proposal', 5, 'Sample proposal note', 1, NULL, '2017-11-25 05:54:50'),
(63, 'project', 11, 'Sample note', 1, NULL, '2017-12-11 14:50:32'),
(64, 'proposal', 5, 'Sample note', 1, NULL, '2017-12-11 14:51:56'),
(66, 'lead', 11, 'Sample note', 1, NULL, '2017-12-11 14:52:10'),
(67, 'lead', 11, 'Lorem ipsum dolor sit amet.', 1, NULL, '2017-12-12 03:59:35'),
(69, 'customer', 1, 'Sample', 1, NULL, '2018-01-01 16:36:05'),
(70, 'proposal', 1, 'Lorem ipsum dolor sit amet.', 1, NULL, '2018-01-01 23:15:32'),
(71, 'invoice', 10, 'Lorem ipsum sit dolor amet.', 1, NULL, '2018-03-05 00:00:00'),
(72, 'project', 1, 'Sample test note.', 1, NULL, '2018-06-25 15:59:56');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `target` varchar(255) NOT NULL,
  `markread` tinyint(2) NOT NULL DEFAULT '0',
  `customerread` int(5) NOT NULL,
  `date` datetime NOT NULL,
  `detail` text NOT NULL,
  `staff_id` int(5) NOT NULL,
  `contact_id` int(5) NOT NULL,
  `customer_id` int(5) NOT NULL,
  `vendor_id` int(5) NOT NULL,
  `public` int(5) DEFAULT NULL,
  `perres` varchar(100) NOT NULL,
  `relation_type` varchar(100) DEFAULT NULL,
  `relation` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `target`, `markread`, `customerread`, `date`, `detail`, `staff_id`, `contact_id`, `customer_id`, `vendor_id`, `public`, `perres`, `relation_type`, `relation`) VALUES
(72, 'http://localhost/ciuiscrm/tasks/task/2', 0, 0, '2019-04-15 19:20:21', 'You have been added a new task', 2, 0, 0, 0, NULL, 'pm.jpg', NULL, NULL),
(73, 'http://localhost/ciuiscrm/tasks/task/3', 0, 0, '2019-04-15 20:13:26', 'You have been added a new task', 4, 0, 0, 0, NULL, 'pm.jpg', NULL, NULL),
(74, 'http://localhost/ciuiscrm/tickets/ticket/4', 1, 0, '2019-04-15 16:49:41', 'Sue Shei added new ticket', 0, 0, 0, 0, 1, 'n-img.png', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_number` varchar(100) DEFAULT NULL,
  `token` mediumtext NOT NULL,
  `subject` varchar(300) DEFAULT NULL,
  `content` longtext,
  `date` date NOT NULL,
  `created` date NOT NULL,
  `opentill` date DEFAULT NULL,
  `relation_type` varchar(100) DEFAULT NULL,
  `relation` int(5) DEFAULT NULL,
  `assigned` int(5) DEFAULT NULL,
  `addedfrom` int(5) NOT NULL,
  `datesend` datetime DEFAULT NULL,
  `comment` int(5) DEFAULT NULL,
  `status_id` int(5) NOT NULL DEFAULT '0',
  `invoice_id` int(5) DEFAULT NULL,
  `dateconverted` datetime DEFAULT NULL,
  `sub_total` decimal(20,2) DEFAULT NULL,
  `total_discount` decimal(20,2) DEFAULT NULL,
  `total_tax` decimal(20,2) DEFAULT NULL,
  `total` decimal(20,2) DEFAULT NULL,
  `billing_street` varchar(100) DEFAULT NULL,
  `billing_city` varchar(20) DEFAULT NULL,
  `billing_state` int(5) DEFAULT NULL,
  `billing_country` int(5) DEFAULT NULL,
  `billing_zip` varchar(20) DEFAULT NULL,
  `shipping_street` varchar(100) DEFAULT NULL,
  `shipping_city` varchar(20) DEFAULT NULL,
  `shipping_state` int(5) DEFAULT NULL,
  `shipping_country` int(5) DEFAULT NULL,
  `shipping_zip` varchar(20) DEFAULT NULL,
  `pdf_status` tinyint(1) DEFAULT '0',
  `recurring` int(2) NOT NULL DEFAULT '0',
  `last_recurring` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `token`, `subject`, `content`, `date`, `created`, `opentill`, `relation_type`, `relation`, `assigned`, `addedfrom`, `datesend`, `comment`, `status_id`, `invoice_id`, `dateconverted`, `sub_total`, `total_discount`, `total_tax`, `total`, `billing_street`, `billing_city`, `billing_state`, `billing_country`, `billing_zip`, `shipping_street`, `shipping_city`, `shipping_state`, `shipping_country`, `shipping_zip`, `pdf_status`, `recurring`, `last_recurring`) VALUES
(1, NULL, 'ad794d7fa6507aa3fd93218c26d9b6f0', 'Sample Order', 'Order is added.', '2018-10-14', '2018-10-14', '2018-10-14', 'customer', 18, 2, 1, '0000-00-00 00:00:00', 0, 1, NULL, NULL, '200.00', '20.00', '10.00', '190.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `transactiontype` int(5) NOT NULL,
  `is_transfer` int(5) DEFAULT NULL,
  `deposit_id` int(5) DEFAULT NULL,
  `invoice_id` int(5) DEFAULT NULL,
  `expense_id` int(5) DEFAULT NULL,
  `purchase_id` int(5) DEFAULT NULL,
  `customer_id` int(5) DEFAULT NULL,
  `vendor_id` int(5) DEFAULT NULL,
  `payslip_id` int(5) DEFAULT NULL,
  `amount` decimal(11,2) NOT NULL,
  `account_id` int(5) DEFAULT NULL,
  `mode` varchar(255) DEFAULT NULL,
  `date` datetime NOT NULL,
  `not` varchar(255) NOT NULL,
  `attachment` varchar(200) DEFAULT NULL,
  `staff_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `transactiontype`, `is_transfer`, `deposit_id`, `invoice_id`, `expense_id`, `purchase_id`, `customer_id`, `vendor_id`, `payslip_id`, `amount`, `account_id`, `mode`, `date`, `not`, `attachment`, `staff_id`) VALUES
(1, 0, 0, NULL, 5, 0, NULL, 16, NULL, NULL, '100.00', 1, NULL, '2018-01-05 00:00:00', 'Cash', NULL, 1),
(2, 1, 0, NULL, 0, 1, NULL, 17, NULL, NULL, '20.00', 1, NULL, '2018-01-05 00:00:00', 'Payment for <a href=\"http://localhost:8888/ciuis/expenses/edit/1\">EXP-1</a>', NULL, 1),
(3, 0, 0, NULL, 6, 0, NULL, 12, NULL, NULL, '200.00', 3, NULL, '2018-01-06 00:00:00', 'Payment for INV-6.', NULL, 1),
(5, 1, 0, NULL, 0, 3, NULL, 0, NULL, NULL, '20.00', 3, NULL, '2018-01-06 00:00:00', 'Payment for <a href=\"http://localhost:8888/ciuis/expenses/edit/3\">EXP-3</a>', NULL, 1),
(6, 0, 0, NULL, 7, 0, NULL, 17, NULL, NULL, '100.00', 1, NULL, '2018-01-22 19:22:38', 'Sample', NULL, 1),
(7, 1, 0, NULL, 0, 4, NULL, 17, NULL, NULL, '10.00', 1, NULL, '2018-01-25 00:00:00', 'Outgoings for <a href=\"http://localhost:8888/ciuis/expenses/receipt/4\">EXP-4</a>', NULL, 1),
(8, 0, 0, NULL, 9, 0, NULL, 1, NULL, NULL, '210.00', 1, NULL, '2018-02-13 00:00:00', 'Payment for INV-9.', NULL, 1),
(9, 0, 0, NULL, 1, 0, NULL, 17, NULL, NULL, '200.00', 1, NULL, '2018-03-09 01:11:22', 'Payment for INV-Array.', NULL, 1),
(10, 0, 0, NULL, 11, 0, NULL, 17, NULL, NULL, '100.00', 1, NULL, '2018-03-09 01:14:12', 'Payment for INV-Array.', NULL, 1),
(11, 1, 0, NULL, 0, 5, NULL, 0, NULL, NULL, '20.00', 1, NULL, '2018-04-11 00:00:00', 'Outgoings for <a href=\"http://localhost:8888/ciuis/expenses/receipt/5\">EXP-5</a>', NULL, 1),
(13, 1, 0, NULL, 0, 7, NULL, 16, NULL, NULL, '20.00', 3, NULL, '2018-04-11 00:00:00', 'Outgoings for <a href=\"http://localhost:8888/ciuis/expenses/receipt/7\">EXP-7</a>', NULL, 1),
(17, 0, 0, NULL, 12, 0, NULL, 17, NULL, NULL, '210.00', 3, NULL, '2018-04-22 22:41:05', 'Payment for INV-12.', NULL, 1),
(18, 0, 0, NULL, 13, 0, NULL, 18, NULL, NULL, '20.00', 1, NULL, '2018-04-25 19:02:44', '232', NULL, 1),
(19, 0, 0, NULL, 10, 0, NULL, 6, NULL, NULL, '23.00', 1, NULL, '2018-04-25 19:03:44', '232', NULL, 1),
(20, 0, 0, NULL, 13, 0, NULL, 18, NULL, NULL, '10.00', 1, NULL, '2018-04-25 19:05:36', 'Sale', NULL, 1),
(21, 1, 0, NULL, 0, 8, NULL, 18, NULL, NULL, '20.00', 1, NULL, '2018-05-20 00:00:00', 'Outgoings for <a href=\"http://localhost:8888/ciuis/expenses/receipt/8\">EXP-8</a>', NULL, 1),
(22, 0, 1, NULL, 0, 0, NULL, 0, NULL, NULL, '20.00', 1, NULL, '2018-06-01 06:59:56', 'Money transfer transaction between accounts.', NULL, 1),
(23, 1, 1, NULL, 0, 0, NULL, 0, NULL, NULL, '20.00', 3, NULL, '2018-06-01 06:59:56', 'Money transfer transaction between accounts.', NULL, 1),
(24, 1, 0, NULL, 0, 9, NULL, 0, NULL, NULL, '10.00', 4, NULL, '2018-06-01 00:00:00', 'Outgoings for <a href=\"http://localhost:8888/ciuis/expenses/receipt/9\">EXP-9</a>', NULL, 1),
(25, 0, 1, NULL, 0, 0, NULL, 0, NULL, NULL, '100.00', 4, NULL, '2018-06-01 07:31:05', 'Money transfer transaction between accounts.', NULL, 1),
(26, 1, 1, NULL, 0, 0, NULL, 0, NULL, NULL, '100.00', 1, NULL, '2018-06-01 07:31:05', 'Money transfer transaction between accounts.', NULL, 1),
(27, 0, 1, NULL, 0, 0, NULL, 0, NULL, NULL, '13.00', 4, NULL, '2018-06-01 07:40:06', 'Money transfer transaction between accounts.', NULL, 1),
(28, 1, 1, NULL, 0, 0, NULL, 0, NULL, NULL, '13.00', 1, NULL, '2018-06-01 07:40:06', 'Money transfer transaction between accounts.', NULL, 1),
(29, 0, 0, NULL, 18, 0, NULL, 18, NULL, NULL, '1000.00', 1, NULL, '2018-09-19 00:00:00', 'Payment for INV-18.', NULL, 1),
(30, 1, 0, NULL, 0, 10, NULL, 0, NULL, NULL, '20.00', 1, NULL, '2018-11-13 00:00:00', 'Payment for <a href=\"http://localhost/ciuiscrm/expenses/edit/10\">EXP-10</a>', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `input_label1` varchar(255) DEFAULT NULL,
  `input_label2` varchar(255) DEFAULT NULL,
  `input_label3` varchar(255) DEFAULT NULL,
  `active` varchar(1) DEFAULT '0',
  `input_value1` varchar(255) DEFAULT NULL,
  `input_value2` varchar(255) DEFAULT NULL,
  `input_value3` varchar(255) DEFAULT NULL,
  `sandbox_account` varchar(1) DEFAULT '0',
  `payment_record_account` varchar(11) DEFAULT NULL,
  `relation` varchar(255) DEFAULT NULL,
  `payment_url` varchar(255) DEFAULT NULL,
  `gateway_note` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name`, `image`, `input_label1`, `input_label2`, `input_label3`, `active`, `input_value1`, `input_value2`, `input_value3`, `sandbox_account`, `payment_record_account`, `relation`, `payment_url`, `gateway_note`, `updated_at`) VALUES
(1, 'PayPal', 'paypal.png', 'paypalemail', 'paypalcurrency', NULL, '0', '', '', '', '1', '', 'paypal', 'gateway/paypal/', NULL, '2019-08-07 04:03:22'),
(2, 'CCAvenue', 'ccavenue.png', 'ccavenue_marchent_key', 'ccavenue_working_key', 'ccavenue_access_code', '0', '', '', '', '1', '', 'ccavenue', 'gateway/ccavenue/', 'CCAvenue Gateway uses mcrypt encryption. \r\n Please make sure you\'re using PHP 7.0 or Older and mcrypt extension is enabled.', '2019-08-07 04:22:31'),
(3, 'PayUmoney', 'payumoney.png', 'payu_money_key', 'payu_money_salt', NULL, '0', '', '', '', '1', '', 'payumoney', 'gateway/payumoney/', NULL, '2019-08-07 06:04:23'),
(4, 'Stripe', 'stripe.png', 'stripe_api_secret_key', 'stripe_public_key', NULL, '0', '', '', '', '1', '', 'stripe', 'gateway/stripe/', NULL, '2019-08-07 04:09:00'),
(5, 'Authorize.net AIM', 'authorize.png', 'authorize_aim_api_login_id', 'authorize_aim_api_transaction_key', NULL, '0', '', '', NULL, '1', '', 'authorize', 'gateway/authorize/', NULL, '2019-08-08 00:00:00'),
(6, 'Razorpay', 'razorpay.png', 'key_id', 'razorpay_key_secret', NULL, '0', '', '', '', '1', '0', 'razorpay', 'gateway/razorpay/', NULL, '2019-08-07 05:35:40'),
(7, 'Bank', 'bank.png', NULL, NULL, NULL, '0', '', '', '', '0', '1', 'bank', NULL, NULL, '2019-08-07 02:15:40');

-- --------------------------------------------------------

--
-- Table structure for table `payment_modes`
--

CREATE TABLE `payment_modes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `value` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payment_modes`
--

INSERT INTO `payment_modes` (`id`, `name`, `value`) VALUES
(1, 'authorize_aim_active', '0'),
(2, 'authorize_aim_api_login_id', ''),
(3, 'authorize_aim_api_transaction_key', ''),
(4, 'authorize_aim_payment_record_account', ''),
(5, 'paypal_active', '0'),
(6, 'paypal_username', ''),
(7, 'paypal_currency', ''),
(8, 'paypal_test_mode_enabled', '1'),
(9, 'paypal_payment_record_account', ''),
(10, 'stripe_active', '0'),
(11, 'stripe_api_secret_key', ''),
(12, 'stripe_api_publishable_key', ''),
(13, 'payu_money_active', '0'),
(14, 'payu_money_key', ''),
(15, 'payu_money_salt', ''),
(16, 'payu_money_test_mode_enabled', '1'),
(17, 'stripe_record_account', ''),
(18, 'ccavenue_record_account', ''),
(19, 'ccavenue_active', '0'),
(20, 'ccavenue_marchent_key', ''),
(21, 'ccavenue_working_key', ''),
(22, 'ccavenue_access_code', ''),
(23, 'ccavenue_test_mode', '1'),
(24, 'payu_money_record_account', ''),
(25, 'stripe_test_mode_enabled', '1'),
(26, 'razorpay_active', '0'),
(27, 'razorpay_key', ''),
(28, 'razorpay_test_mode_enabled', '1'),
(29, 'razorpay_payment_record_account', '0'),
(30, 'primary_bank_account', '1'),
(31, 'authorize_test_mode_enabled', '1'),
(32, 'razorpay_key_secret', '');

-- --------------------------------------------------------

--
-- Table structure for table `payment_transactions`
--

CREATE TABLE `payment_transactions` (
  `id` int(11) NOT NULL,
  `relation_type` varchar(100) DEFAULT NULL,
  `relation_id` int(11) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `token` mediumtext,
  `method` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pending_process`
--

CREATE TABLE `pending_process` (
  `process_id` int(11) NOT NULL,
  `process_type` varchar(100) DEFAULT 'pdf',
  `process_relation` int(5) DEFAULT NULL,
  `process_relation_type` varchar(100) DEFAULT NULL,
  `process_template_name` varchar(200) DEFAULT NULL,
  `process_created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `permission` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `key` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `permission`, `type`, `key`) VALUES
(1, 'x_menu_invoices', 'common', 'invoices'),
(2, 'x_menu_proposals', 'common', 'proposals'),
(3, 'x_menu_expenses', 'non-common', 'expenses'),
(4, 'x_menu_accounts', 'non-common', 'accounts'),
(5, 'x_menu_customers', 'non-common', 'customers'),
(6, 'x_menu_leads', 'non-common', 'leads'),
(7, 'x_menu_projects', 'common', 'projects'),
(8, 'x_menu_tasks', 'non-common', 'tasks'),
(9, 'x_menu_tickets', 'common', 'tickets'),
(10, 'x_menu_products', 'non-common', 'products'),
(11, 'x_menu_staff', 'non-common', 'staff'),
(12, 'x_menu_reports', 'non-common', 'report'),
(13, 'x_menu_orders', 'non-common', 'orders'),
(14, 'x_menu_emails', 'non-common', 'emails'),
(15, 'x_menu_timesheets', 'non-common', 'timesheets'),
(16, 'x_menu_quotes', 'common', 'quotes'),
(17, 'x_menu_vendor', 'non-common', 'vendors'),
(18, 'x_menu_purchases', 'non-common', 'purchases'),
(19, 'x_menu_deposits', 'non-common', 'deposits'),
(20, 'x_menu_settings', 'non-common', 'settings'),
(21, 'x_menu_inventory', 'non-common', 'inventories'),
(22, 'x_menu_warehouses', 'non-common', 'warehouses'),
(23, 'x_menu_filemanager', 'non-common', 'filemanager');

-- --------------------------------------------------------

--
-- Table structure for table `privileges`
--

CREATE TABLE `privileges` (
  `relation` int(5) NOT NULL,
  `relation_type` varchar(255) NOT NULL,
  `permission_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `privileges`
--

INSERT INTO `privileges` (`relation`, `relation_type`, `permission_id`) VALUES
(1, 'staff', 3),
(1, 'staff', 4),
(1, 'staff', 5),
(1, 'staff', 6),
(1, 'staff', 7),
(1, 'staff', 8),
(1, 'staff', 9),
(3, 'staff', 3),
(15, 'contact', 1),
(15, 'contact', 2),
(15, 'contact', 7),
(15, 'contact', 9),
(2, 'staff', 1),
(2, 'staff', 2),
(2, 'staff', 3),
(2, 'staff', 4),
(2, 'staff', 5),
(2, 'staff', 6),
(2, 'staff', 7),
(2, 'staff', 8),
(2, 'staff', 9),
(2, 'staff', 10),
(2, 'staff', 11),
(2, 'staff', 12),
(23, 'contact', 1),
(23, 'contact', 2),
(23, 'contact', 7),
(23, 'contact', 9),
(4, 'staff', 1),
(1, 'staff', 2),
(1, 'staff', 1),
(1, 'staff', 11),
(1, 'staff', 12),
(1, 'staff', 10),
(1, 'staff', 14),
(1, 'staff', 15),
(1, 'staff', 13),
(3, 'staff', 1),
(1, 'staff', 16),
(23, 'contact', 16),
(5, 'staff', 1),
(5, 'staff', 2),
(5, 'staff', 3),
(5, 'staff', 4),
(5, 'staff', 5),
(5, 'staff', 6),
(5, 'staff', 7),
(5, 'staff', 8),
(5, 'staff', 9),
(5, 'staff', 10),
(5, 'staff', 11),
(5, 'staff', 12),
(5, 'staff', 13),
(5, 'staff', 14),
(5, 'staff', 15),
(5, 'staff', 16);

-- --------------------------------------------------------

--
-- Table structure for table `productcategories`
--

CREATE TABLE `productcategories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_number` varchar(100) DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `productname` varchar(255) DEFAULT NULL,
  `unit_id` int(5) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `warehouse_id` int(5) NOT NULL,
  `product_type` int(2) NOT NULL,
  `description` text NOT NULL,
  `productimage` varchar(255) DEFAULT NULL,
  `purchase_price` decimal(20,2) DEFAULT NULL,
  `sale_price` decimal(20,2) DEFAULT NULL,
  `stock` bigint(20) DEFAULT NULL,
  `vat` decimal(20,2) DEFAULT NULL,
  `status_id` enum('0','1') DEFAULT NULL,
  `product_created_by` int(5) DEFAULT '0',
  `createdat` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_number`, `code`, `productname`, `unit_id`, `categoryid`, `warehouse_id`, `product_type`, `description`, `productimage`, `purchase_price`, `sale_price`, `stock`, `vat`, `status_id`, `product_created_by`, `createdat`) VALUES
(1, NULL, 'WEB', 'Web Design', 0, 0, 0, 0, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent sit amet iaculis risus.', NULL, '20.00', '200.00', 200, '5.00', NULL, 0, NULL),
(2, NULL, 'WEB', 'Seo Consultant', 0, 0, 0, 0, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent sit amet iaculis risus.', NULL, '10.00', '200.00', 200, '0.00', NULL, 0, NULL),
(3, NULL, 'WEB-204', 'Logo Design', 0, 0, 0, 0, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent sit amet iaculis risus.', NULL, '10.00', '200.00', 200, '0.00', NULL, 0, NULL),
(5, NULL, 'GRA-24', 'Graphic Design', 0, 0, 0, 0, 'Graphic Design Services', NULL, '0.00', '100.00', 10000, '0.00', NULL, 0, NULL),
(6, NULL, 'SRV-2324', 'Server Customization', 0, 0, 0, 0, 'Server Customization.', NULL, '0.00', '1000.00', 0, '0.00', NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_inv`
--

CREATE TABLE `product_inv` (
  `inventory_id` int(5) NOT NULL,
  `inventory_number` varchar(20) DEFAULT NULL,
  `product_id` int(5) NOT NULL,
  `product_type` int(3) NOT NULL,
  `category_id` int(3) NOT NULL,
  `cost_price` int(10) NOT NULL,
  `stock_qty` int(5) NOT NULL,
  `warehouse` int(3) NOT NULL,
  `move_type` int(3) NOT NULL,
  `inventory_created_by` int(5) NOT NULL,
  `createdat` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_movement`
--

CREATE TABLE `product_movement` (
  `movement_id` int(5) NOT NULL,
  `movement_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_movement`
--

INSERT INTO `product_movement` (`movement_id`, `movement_name`) VALUES
(1, 'stock_created'),
(2, 'stock_removed'),
(3, 'stock_transfers'),
(4, 'stock_reversal'),
(5, 'stock_shipped'),
(6, 'stock_shipped_reversal'),
(7, 'stock_purchase'),
(8, 'stock_purchase_reversal');

-- --------------------------------------------------------

--
-- Table structure for table `projectmembers`
--

CREATE TABLE `projectmembers` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `projectmembers`
--

INSERT INTO `projectmembers` (`id`, `project_id`, `staff_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `project_number` varchar(100) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `projectvalue` decimal(20,2) DEFAULT '0.00',
  `tax` decimal(20,2) DEFAULT '0.00',
  `status_id` int(5) NOT NULL DEFAULT '0',
  `customer_id` int(5) NOT NULL,
  `invoice_id` int(5) NOT NULL,
  `start_date` date NOT NULL,
  `deadline` date DEFAULT NULL,
  `created` date NOT NULL,
  `finished` datetime DEFAULT NULL,
  `pinned` int(5) NOT NULL,
  `staff_id` int(5) NOT NULL,
  `template` tinyint(1) DEFAULT '0',
  `pdf_report` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `project_number`, `name`, `description`, `projectvalue`, `tax`, `status_id`, `customer_id`, `invoice_id`, `start_date`, `deadline`, `created`, `finished`, `pinned`, `staff_id`, `template`, `pdf_report`) VALUES
(1, NULL, 'Web Design', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', '0.00', '0.00', 5, 17, 0, '2018-06-01', '2018-08-02', '2018-06-01', NULL, 1, 1, 0, 0),
(2, NULL, 'Website Template', 'Website for a Big Marketing Agency Project Template', '3000.00', '19.00', 1, 0, 0, '2019-04-15', '2019-08-10', '2019-04-15', NULL, 0, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `projectservices`
--

CREATE TABLE `projectservices` (
  `id` int(11) NOT NULL,
  `projectid` int(5) DEFAULT NULL,
  `categoryid` int(5) DEFAULT NULL,
  `categoryname` varchar(255) DEFAULT NULL,
  `productid` int(5) DEFAULT NULL,
  `servicename` varchar(255) DEFAULT NULL,
  `serviceprice` decimal(20,2) DEFAULT NULL,
  `quantity` varchar(20) DEFAULT '1',
  `unit` varchar(100) DEFAULT 'Unit',
  `servicetax` decimal(20,2) DEFAULT NULL,
  `servicedescription` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `proposals`
--

CREATE TABLE `proposals` (
  `id` int(11) NOT NULL,
  `proposal_number` varchar(100) DEFAULT NULL,
  `token` varchar(200) NOT NULL,
  `subject` varchar(300) DEFAULT NULL,
  `content` longtext,
  `customer_quote` longtext,
  `date` date NOT NULL,
  `created` date NOT NULL,
  `opentill` date DEFAULT NULL,
  `relation_type` varchar(100) DEFAULT NULL,
  `relation` int(5) DEFAULT NULL,
  `assigned` int(5) DEFAULT NULL,
  `addedfrom` int(5) NOT NULL,
  `datesend` datetime DEFAULT NULL,
  `comment` int(5) DEFAULT NULL,
  `status_id` int(5) NOT NULL DEFAULT '0',
  `invoice_id` int(5) DEFAULT NULL,
  `project_id` int(5) DEFAULT NULL,
  `dateconverted` datetime DEFAULT NULL,
  `sub_total` decimal(20,2) DEFAULT NULL,
  `total_discount` decimal(20,2) DEFAULT NULL,
  `total_tax` decimal(20,2) DEFAULT NULL,
  `total` decimal(20,2) DEFAULT NULL,
  `is_requested` tinyint(1) DEFAULT '0',
  `pdf_status` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `proposals`
--

INSERT INTO `proposals` (`id`, `proposal_number`, `token`, `subject`, `content`, `customer_quote`, `date`, `created`, `opentill`, `relation_type`, `relation`, `assigned`, `addedfrom`, `datesend`, `comment`, `status_id`, `invoice_id`, `project_id`, `dateconverted`, `sub_total`, `total_discount`, `total_tax`, `total`, `is_requested`, `pdf_status`) VALUES
(2, NULL, '2d5525f66e8e3bdc29d6b2c1bb834e48', 'Seo Consultant', 'Seo Consultant', NULL, '2018-01-10', '2018-01-10', '2018-03-13', 'customer', 17, 2, 1, '0000-00-00 00:00:00', 1, 2, NULL, NULL, NULL, '200.00', '0.00', '0.00', '200.00', 0, 0),
(4, NULL, '23fc708ebbc362838b681fac51046ab8', 'Poster Design', 'Poster design.', NULL, '2018-01-11', '2018-01-11', '2018-03-22', 'customer', 16, 4, 1, '0000-00-00 00:00:00', 0, 4, NULL, NULL, NULL, '100.00', '0.00', '0.00', '100.00', 0, 0),
(5, NULL, '31e3fe3b03d23ad26a774feb4553694a', 'Mobile Application', 'Lorem ipsum dolor sit amet, id quaeque disputationi est. Sit quando recteque ad, inermis vivendo mei te, minim feugait adversarium eu qui. Id utamur placerat adolescens est. Eu eam postea commodo corpora, no ius vidisse tibique sensibus. Duo noster euismod ex, in tale aeterno epicurei mei. Tota cotidieque cum ex, mea no reque dolorum deserunt, soluta phaedrum vix ea. Errem tollit concludaturque vix no.\n\nAd pro accumsan adipiscing. No duo equidem delicata, no dolorum electram sed, quo quis tota facilisis cu. Ut reque velit tincidunt has, per an case option utamur, ad est dolorem ponderum inciderint. His ea prompta expetenda, no aliquid facilisis dissentias vim.\n\nUt deleniti electram mel, sit te suas assum laboramus, sit id erat verterem interpretaris. Ei vix debet dissentias, vero accusata evertitur usu ut. Qui audiam accusamus id. An vix maiestatis interpretaris, est dictas inermis mediocrem no. Inermis referrentur pri id, iudico integre copiosae mea ex.', NULL, '2017-08-24', '2017-08-24', '2018-06-19', 'customer', 12, 1, 1, '2018-10-01 08:15:07', 1, 6, 16, NULL, '2018-06-20 16:44:43', '200.00', '0.00', '10.00', '210.00', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(11) NOT NULL,
  `purchase_number` varchar(100) DEFAULT NULL,
  `token` varchar(200) NOT NULL,
  `no` int(11) DEFAULT NULL,
  `serie` varchar(255) DEFAULT NULL,
  `created` date DEFAULT NULL,
  `duedate` date DEFAULT NULL,
  `vendor_id` int(5) NOT NULL,
  `expense_id` int(5) DEFAULT NULL,
  `proposal_id` int(5) DEFAULT NULL,
  `project_id` int(5) DEFAULT NULL,
  `staff_id` int(5) DEFAULT NULL,
  `datesend` datetime DEFAULT NULL,
  `datepayment` date DEFAULT NULL,
  `duenote` text,
  `status_id` int(5) DEFAULT NULL,
  `sub_total` decimal(11,2) DEFAULT NULL,
  `total_discount` decimal(11,2) DEFAULT NULL,
  `total_tax` decimal(11,2) DEFAULT NULL,
  `total` decimal(11,2) DEFAULT NULL,
  `recurring` int(5) NOT NULL DEFAULT '0',
  `last_recurring` date DEFAULT NULL,
  `pdf_status` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `recurring`
--

CREATE TABLE `recurring` (
  `id` int(11) NOT NULL,
  `relation_type` varchar(100) NOT NULL,
  `relation` int(5) NOT NULL DEFAULT '0',
  `period` int(5) NOT NULL DEFAULT '0',
  `type` int(5) NOT NULL DEFAULT '0' COMMENT '0 = day | 1 = week | 2 = month | 3 = years',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_date` varchar(100) DEFAULT 'Invalid date',
  `status` int(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `recurring`
--

INSERT INTO `recurring` (`id`, `relation_type`, `relation`, `period`, `type`, `created_at`, `end_date`, `status`) VALUES
(13, 'invoice', 8, 1, 0, '2018-02-11 21:00:00', '2018-04-28 00:00:00', 0),
(14, 'invoice', 9, 1, 0, '2018-02-13 08:21:22', '2018-02-13 00:00:00', 1),
(15, 'invoice', 10, 0, 0, '2018-04-11 19:38:59', '1970-01-01 00:00:00', 1),
(16, 'invoice', 7, 0, 0, '2018-04-11 19:39:32', 'Invalid date', 0),
(17, 'invoice', 5, 0, 0, '2018-05-19 20:32:00', 'Invalid date', 0),
(18, 'invoice', 16, 0, 0, '2018-06-20 13:45:32', 'Invalid date', 0),
(19, 'invoice', 19, 0, 0, '2018-11-11 23:37:27', 'Invalid date', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reminders`
--

CREATE TABLE `reminders` (
  `id` int(11) NOT NULL,
  `relation_type` varchar(255) NOT NULL,
  `relation` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `description` text,
  `date` datetime NOT NULL,
  `isnotified` int(11) NOT NULL DEFAULT '0',
  `addedfrom` int(11) NOT NULL,
  `public` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reminders`
--

INSERT INTO `reminders` (`id`, `relation_type`, `relation`, `staff_id`, `description`, `date`, `isnotified`, `addedfrom`, `public`) VALUES
(1, 'lead', 1, 1, 'Donec nisl risus, dignissim at.', '2017-09-05 17:16:25', 1, 1, 0),
(9, 'lead', 4, 4, 'Test', '2017-03-30 11:55:00', 0, 1, 0),
(10, 'lead', 2, 3, 'Lorem ipsum sit dolor amet.', '2017-09-30 12:50:00', 0, 1, 0),
(11, 'lead', 6, 3, 'Please check proposals.', '2017-09-03 03:25:00', 0, 1, 0),
(12, 'lead', 7, 2, 'Meet Evelyn Bradley.', '2017-09-03 03:35:00', 0, 1, 0),
(13, 'proposal', 2, 1, 'Lorem ipsum dolor sit amet.', '2017-09-07 01:20:00', 1, 1, 0),
(16, 'customer', 16, 1, 'Test', '2017-09-11 05:01:00', 1, 1, 0),
(19, 'proposal', 1, 2, 'Test reminder for this proposal.', '2017-09-11 10:35:00', 1, 1, 0),
(20, 'lead', 5, 1, 'Test', '2017-11-12 01:30:00', 1, 1, 0),
(21, 'lead', 11, 1, 'Sample reminder for lead', '2018-08-02 02:10:00', 1, 1, 0),
(24, 'customer', 17, 1, 'Test reminder', '2017-12-02 03:35:00', 1, 1, 0),
(62, 'proposal', 5, 3, 'Lorem ipsum dolor sit amet ectum veritas.', '2017-12-12 00:50:52', 0, 1, 0),
(63, 'customer', 17, 1, 'Sample reminder for me.', '2018-01-01 23:10:28', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(100) NOT NULL,
  `role_type` varchar(10) NOT NULL,
  `role_createdat` datetime DEFAULT NULL,
  `role_updatedat` datetime DEFAULT NULL,
  `created_by` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`, `role_type`, `role_createdat`, `role_updatedat`, `created_by`) VALUES
(1, 'Admin Role', 'admin', '2019-08-09 08:04:18', '2019-08-16 07:13:48', 1),
(2, 'Staff Role', 'staff', '2019-08-16 09:32:37', '2019-08-16 09:32:37', 1),
(3, 'VAT Consultant', 'other', '2019-08-16 09:32:57', '2019-08-16 09:32:57', 1);

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `role_permission_id` int(5) NOT NULL,
  `permission_id` int(5) NOT NULL,
  `permission_view_own` tinyint(1) NOT NULL,
  `permission_view_all` tinyint(1) NOT NULL,
  `permission_edit` tinyint(1) NOT NULL,
  `permission_delete` tinyint(1) NOT NULL,
  `permission_create` tinyint(1) NOT NULL,
  `role_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`role_permission_id`, `permission_id`, `permission_view_own`, `permission_view_all`, `permission_edit`, `permission_delete`, `permission_create`, `role_id`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1),
(2, 2, 1, 1, 1, 1, 1, 1),
(3, 3, 1, 1, 1, 1, 1, 1),
(4, 4, 1, 1, 1, 1, 1, 1),
(5, 5, 1, 1, 1, 1, 1, 1),
(6, 6, 1, 1, 1, 1, 1, 1),
(7, 7, 1, 0, 1, 1, 1, 1),
(8, 8, 1, 1, 1, 1, 1, 1),
(9, 9, 1, 1, 1, 1, 1, 1),
(10, 10, 1, 1, 1, 1, 1, 1),
(11, 11, 1, 1, 1, 1, 1, 1),
(12, 12, 0, 1, 0, 0, 0, 1),
(13, 13, 1, 1, 1, 1, 1, 1),
(14, 14, 0, 1, 1, 0, 0, 1),
(15, 15, 1, 1, 1, 1, 1, 1),
(16, 16, 0, 0, 0, 0, 0, 1),
(17, 17, 1, 1, 1, 1, 1, 1),
(18, 18, 1, 1, 1, 1, 1, 1),
(19, 19, 1, 1, 1, 1, 1, 1),
(20, 20, 1, 1, 1, 1, 1, 1),
(21, 1, 1, 1, 1, 1, 1, 2),
(22, 2, 1, 1, 1, 1, 1, 2),
(23, 3, 1, 1, 1, 1, 1, 2),
(24, 4, 1, 1, 1, 1, 1, 2),
(25, 5, 1, 1, 1, 1, 1, 2),
(26, 6, 1, 1, 1, 1, 1, 2),
(27, 7, 1, 1, 1, 1, 1, 2),
(28, 8, 1, 1, 1, 1, 1, 2),
(29, 9, 1, 1, 1, 1, 1, 2),
(30, 10, 1, 1, 1, 1, 1, 2),
(31, 11, 1, 1, 1, 1, 1, 2),
(32, 12, 1, 1, 1, 1, 1, 2),
(33, 13, 1, 1, 1, 1, 1, 2),
(34, 14, 1, 1, 1, 1, 1, 2),
(35, 15, 1, 1, 1, 1, 1, 2),
(36, 16, 1, 1, 1, 1, 1, 2),
(37, 17, 1, 1, 1, 1, 1, 2),
(38, 18, 1, 1, 1, 1, 1, 2),
(39, 19, 1, 1, 1, 1, 1, 2),
(40, 1, 1, 1, 1, 1, 1, 3),
(41, 3, 1, 1, 1, 1, 1, 3),
(42, 21, 1, 1, 1, 1, 1, 1),
(43, 22, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `total` decimal(11,2) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `invoice_id`, `status_id`, `customer_id`, `staff_id`, `total`, `date`) VALUES
(1, 1, 2, 17, 1, '200.00', '2018-01-01'),
(7, 7, 3, 17, 1, '200.00', '2018-01-22'),
(9, 9, 2, 1, 1, '210.00', '2018-02-13'),
(10, 10, 3, 6, 1, '200.00', '2018-02-13'),
(11, 11, 2, 17, 1, '100.00', '2018-03-09'),
(12, 12, 2, 17, 1, '210.00', '2017-03-25'),
(13, 13, 3, 18, 1, '210.00', '2018-04-22'),
(14, 15, 3, 18, 1, '20.00', '2018-05-20'),
(15, 16, 3, 12, 1, '210.00', '2018-06-20'),
(16, 17, 3, 16, 1, '100.00', '2018-08-11'),
(17, 18, 2, 18, 1, '1000.00', '2018-09-19'),
(18, 19, 3, 18, 1, '100.00', '2018-11-12'),
(21, 22, 3, 0, 1, '0.00', '2018-11-12');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('97v2nf6f047nqm1g3glvkmn68chqcqgh', '::1', 1555572893, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535353537323839333b7573725f69647c733a313a2231223b73746166666e616d657c733a31323a224c616e636520426f67726f6c223b656d61696c7c733a31373a226c616e6365406578616d706c652e636f6d223b726f6f747c4e3b6c616e67756167657c733a373a22656e676c697368223b61646d696e7c733a313a2231223b73746166666d656d6265727c4e3b73746166666176617461727c733a363a22706d2e6a7067223b6f746865727c4e3b4c6f67696e4f4b7c623a313b),
('egkif0sg486j7kvah7g43l529uahqb4f', '::1', 1555405635, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535353430353633353b7573725f69647c733a313a2231223b73746166666e616d657c733a31323a224c616e636520426f67726f6c223b656d61696c7c733a31373a226c616e6365406578616d706c652e636f6d223b726f6f747c4e3b6c616e67756167657c733a373a22656e676c697368223b61646d696e7c733a313a2231223b73746166666d656d6265727c4e3b73746166666176617461727c733a363a22706d2e6a7067223b6f746865727c4e3b4c6f67696e4f4b7c623a313b),
('fnt3cg20ud6f570i3cnilgd3rs7e4jcf', '::1', 1555572970, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535353537323839333b7573725f69647c733a313a2231223b73746166666e616d657c733a31323a224c616e636520426f67726f6c223b656d61696c7c733a31373a226c616e6365406578616d706c652e636f6d223b726f6f747c4e3b6c616e67756167657c733a373a22656e676c697368223b61646d696e7c733a313a2231223b73746166666d656d6265727c4e3b73746166666176617461727c733a363a22706d2e6a7067223b6f746865727c4e3b4c6f67696e4f4b7c623a313b),
('h85ga2vmvq37brum4o2i95f3vn35o6ua', '::1', 1555406293, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535353430363233353b7573725f69647c733a313a2235223b73746166666e616d657c733a31303a22526f6f742041646d696e223b656d61696c7c733a31343a22726f6f744063697569732e636f6d223b726f6f747c4e3b6c616e67756167657c733a373a22656e676c697368223b61646d696e7c733a313a2231223b73746166666d656d6265727c4e3b73746166666176617461727c733a393a226a2d696d672e6a7067223b6f746865727c4e3b4c6f67696e4f4b7c623a313b),
('k62169ssu1bc2sq16m6mbu2dp0qk0uo0', '::1', 1555402324, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535353430323332343b7573725f69647c733a313a2231223b73746166666e616d657c733a31323a224c616e636520426f67726f6c223b656d61696c7c733a31373a226c616e6365406578616d706c652e636f6d223b726f6f747c4e3b6c616e67756167657c733a373a22656e676c697368223b61646d696e7c733a313a2231223b73746166666d656d6265727c4e3b73746166666176617461727c733a363a22706d2e6a7067223b6f746865727c4e3b4c6f67696e4f4b7c623a313b),
('lri8gclsv7h6joidp0p6qk7ng7l53s33', '::1', 1555406074, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535353430363037343b7573725f69647c733a313a2231223b73746166666e616d657c733a31323a224c616e636520426f67726f6c223b656d61696c7c733a31373a226c616e6365406578616d706c652e636f6d223b726f6f747c4e3b6c616e67756167657c733a373a22656e676c697368223b61646d696e7c733a313a2231223b73746166666d656d6265727c4e3b73746166666176617461727c733a363a22706d2e6a7067223b6f746865727c4e3b4c6f67696e4f4b7c623a313b);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `settingname` varchar(255) NOT NULL,
  `crm_name` varchar(255) NOT NULL DEFAULT 'CiuisCRM',
  `company` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `country_id` int(5) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `state_id` int(5) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `town` varchar(255) DEFAULT NULL,
  `zipcode` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `fax` varchar(50) NOT NULL,
  `taxoffice` varchar(100) DEFAULT NULL,
  `vatnumber` varchar(100) DEFAULT NULL,
  `thousand_separator` varchar(50) DEFAULT 'auto',
  `currencyid` int(5) NOT NULL,
  `currency_position` varchar(50) DEFAULT 'auto',
  `decimal_separator` varchar(50) DEFAULT 'auto',
  `currency_display` varchar(50) DEFAULT 'code',
  `termtitle` varchar(255) NOT NULL,
  `termdescription` varchar(255) NOT NULL,
  `dateformat` varchar(100) DEFAULT NULL,
  `default_timezone` varchar(100) NOT NULL,
  `languageid` varchar(100) NOT NULL,
  `email_type` tinyint(1) DEFAULT '1',
  `smtphost` varchar(255) DEFAULT NULL,
  `smtpport` varchar(255) DEFAULT NULL,
  `emailcharset` varchar(255) DEFAULT NULL,
  `email_encryption` int(5) NOT NULL,
  `smtpusername` varchar(255) DEFAULT NULL,
  `smtppassoword` varchar(255) DEFAULT NULL,
  `sendermail` varchar(255) DEFAULT NULL,
  `sender_name` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `app_logo` varchar(255) DEFAULT NULL,
  `accepted_files_formats` varchar(255) NOT NULL DEFAULT 'jpg,jpeg,doc,png,txt,docx',
  `allowed_ip_adresses` varchar(255) DEFAULT NULL,
  `pushState` int(5) NOT NULL,
  `voicenotification` int(5) NOT NULL,
  `converted_lead_status_id` int(5) DEFAULT NULL,
  `two_factor_authentication` int(5) DEFAULT NULL,
  `is_demo` tinyint(1) DEFAULT '0',
  `is_mysql` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`settingname`, `crm_name`, `company`, `email`, `address`, `country_id`, `state`, `state_id`, `city`, `town`, `zipcode`, `phone`, `fax`, `taxoffice`, `vatnumber`, `thousand_separator`, `currencyid`, `currency_position`, `decimal_separator`, `currency_display`, `termtitle`, `termdescription`, `dateformat`, `default_timezone`, `languageid`, `email_type`, `smtphost`, `smtpport`, `emailcharset`, `email_encryption`, `smtpusername`, `smtppassoword`, `sendermail`, `sender_name`, `logo`, `app_logo`, `accepted_files_formats`, `allowed_ip_adresses`, `pushState`, `voicenotification`, `converted_lead_status_id`, `two_factor_authentication`, `is_demo`, `is_mysql`) VALUES
('ciuis', 'CiuisCRM', 'Acme Business INC', 'info@businessaddress.com', 'P.O. Box 929 4189 Nunc RoadLebanon KY 69409', 236, 'DC', NULL, 'New York', 'New Jersey', '34400', '+1 (389) 737-2852', '+1 (389) 737-2852', 'New York Tax Office', '4530685631', '.', 159, 'before', 'auto', 'code', 'Terms & Conditions', 'Maecenas facilisis ultrices purus non vehicula. Nulla dignissim enim a libero tincidunt, consequat molestie nisi mattis. Phasellus scelerisque fringilla lectus vel tempor.', 'dd.mm.yy', 'America/New_York', 'english', 1, '', '587', 'utf-8', 0, '', '', '', '', 'ciuis-icon.png', 'ciuis-icon.png', 'zip|rar|tar|gif|jpg|png|jpeg|pdf|doc|docx|xls|xlsx|mp4|txt|csv|ppt|opt', '', 0, 1, 4, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `staff_number` varchar(100) DEFAULT NULL,
  `role_id` int(5) NOT NULL,
  `language` varchar(100) NOT NULL,
  `staffname` varchar(255) DEFAULT NULL,
  `staffavatar` varchar(300) DEFAULT 'n-img.jpg',
  `department_id` int(5) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `root` tinyint(1) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `staffmember` tinyint(1) DEFAULT NULL,
  `other` tinyint(1) DEFAULT NULL,
  `last_login` datetime NOT NULL,
  `timezone` varchar(200) DEFAULT NULL,
  `appointment_availability` int(5) NOT NULL,
  `inactive` tinyint(1) DEFAULT NULL,
  `google_calendar_enable` int(5) NOT NULL,
  `google_calendar_id` varchar(255) NOT NULL,
  `google_calendar_api_key` varchar(255) NOT NULL,
  `createdat` datetime DEFAULT NULL,
  `updatedAt` datetime DEFAULT NULL,
  `tour_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT ' 0=Not Shown, 1=Shown'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `staff_number`, `role_id`, `language`, `staffname`, `staffavatar`, `department_id`, `phone`, `address`, `email`, `birthday`, `password`, `root`, `admin`, `staffmember`, `other`, `last_login`, `timezone`, `appointment_availability`, `inactive`, `google_calendar_enable`, `google_calendar_id`, `google_calendar_api_key`, `createdat`, `updatedAt`, `tour_status`) VALUES
(1, NULL, 1, 'english', 'Lance Bogrol', 'pm.jpg', 1, '+1-202-555-0160', '71 Pilgrim Avenue Chevy Chase, MD 20815', 'lance@example.com', '1992-12-05', 'fe01ce2a7fbac8fafaed7c982a04e229', NULL, 1, NULL, NULL, '2017-08-05 03:02:42', NULL, 1, NULL, 0, 'abaris@sdf.net', 'AIzaSyA1sWdokA3dVTzk7gNN58NztVw3kbPhJX8', NULL, NULL, 1),
(2, NULL, 0, 'english', 'Emma Durst', 'emma.jpg', 2, '+1-202-555-0158', '70 Bowman St. South Windsor, CT 06074', 'emma@example.com', '2017-07-03', 'fe01ce2a7fbac8fafaed7c982a04e229', NULL, NULL, 1, NULL, '0000-00-00 00:00:00', NULL, 1, NULL, 0, '', '', NULL, NULL, 1),
(3, NULL, 0, 'english', 'Guy Mann', 'guy.jpg', 4, '+1-202-555-0129', '123 6th St. Melbourne, FL 32904', 'guy@example.com', '1992-12-05', 'fe01ce2a7fbac8fafaed7c982a04e229', NULL, NULL, 1, 1, '0000-00-00 00:00:00', NULL, 0, NULL, 0, '', '', NULL, NULL, 1),
(4, NULL, 0, 'english', 'Ruby Von Rails', 'ruby.jpg', 3, '+1-202-555-0143', '4 Goldfield Rd. Honolulu, HI 96815', 'ruby@example.com', '1992-12-05', 'fe01ce2a7fbac8fafaed7c982a04e229', NULL, NULL, 1, NULL, '0000-00-00 00:00:00', NULL, 0, NULL, 0, '', '', NULL, NULL, 1),
(5, NULL, 1, 'english', 'Root Admin', 'j-img.jpg', 1, '+457-8899-856', 'Root street', 'root@ciuis.com', '2019-04-16', '63a9f0ea7bb98050796b649e85481845', NULL, 1, NULL, NULL, '0000-00-00 00:00:00', NULL, 0, NULL, 0, '', '', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `staff_work_plan`
--

CREATE TABLE `staff_work_plan` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `work_plan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `staff_work_plan`
--

INSERT INTO `staff_work_plan` (`id`, `staff_id`, `work_plan`) VALUES
(1, 1, '[{\"day\":\"Monday\",\"status\":true,\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":{\"start\":\"14:30\",\"end\":\"15:00\"},\"$$hashKey\":\"object:360\"},{\"day\":\"Tuesday\",\"status\":true,\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":{\"start\":\"14:30\",\"end\":\"15:00\"},\"$$hashKey\":\"object:361\"},{\"day\":\"Wednesday\",\"status\":true,\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":{\"start\":\"14:30\",\"end\":\"15:00\"},\"$$hashKey\":\"object:362\"},{\"day\":\"Thursday\",\"status\":true,\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":{\"start\":\"14:30\",\"end\":\"15:00\"},\"$$hashKey\":\"object:363\"},{\"day\":\"Friday\",\"status\":true,\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":{\"start\":\"14:30\",\"end\":\"15:00\"},\"$$hashKey\":\"object:364\"},{\"day\":\"Saturday\",\"status\":false,\"start\":\"\",\"end\":\"\",\"breaks\":{\"start\":\"\",\"end\":\"\"},\"$$hashKey\":\"object:365\"},{\"day\":\"Sunday\",\"status\":false,\"start\":\"\",\"end\":\"\",\"breaks\":{\"start\":\"\",\"end\":\"\"},\"$$hashKey\":\"object:366\"}]'),
(2, 2, '[{\"day\":\"Monday\",\"status\":true,\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":{\"start\":\"14:30\",\"end\":\"15:00\"},\"$$hashKey\":\"object:360\"},{\"day\":\"Tuesday\",\"status\":true,\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":{\"start\":\"14:30\",\"end\":\"15:00\"},\"$$hashKey\":\"object:361\"},{\"day\":\"Wednesday\",\"status\":true,\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":{\"start\":\"14:30\",\"end\":\"15:00\"},\"$$hashKey\":\"object:362\"},{\"day\":\"Thursday\",\"status\":true,\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":{\"start\":\"14:30\",\"end\":\"15:00\"},\"$$hashKey\":\"object:363\"},{\"day\":\"Friday\",\"status\":true,\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":{\"start\":\"14:30\",\"end\":\"15:00\"},\"$$hashKey\":\"object:364\"},{\"day\":\"Saturday\",\"status\":false,\"start\":\"\",\"end\":\"\",\"breaks\":{\"start\":\"\",\"end\":\"\"},\"$$hashKey\":\"object:365\"},{\"day\":\"Sunday\",\"status\":false,\"start\":\"\",\"end\":\"\",\"breaks\":{\"start\":\"\",\"end\":\"\"},\"$$hashKey\":\"object:366\"}]'),
(3, 3, '[{\"day\":\"Monday\",\"status\":false,\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":{\"start\":\"14:30\",\"end\":\"15:00\"},\"$$hashKey\":\"object:360\"},{\"day\":\"Tuesday\",\"status\":false,\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":{\"start\":\"14:30\",\"end\":\"15:00\"},\"$$hashKey\":\"object:361\"},{\"day\":\"Wednesday\",\"status\":false,\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":{\"start\":\"14:30\",\"end\":\"15:00\"},\"$$hashKey\":\"object:362\"},{\"day\":\"Thursday\",\"status\":false,\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":{\"start\":\"14:30\",\"end\":\"15:00\"},\"$$hashKey\":\"object:363\"},{\"day\":\"Friday\",\"status\":false,\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":{\"start\":\"14:30\",\"end\":\"15:00\"},\"$$hashKey\":\"object:364\"},{\"day\":\"Saturday\",\"status\":false,\"start\":\"\",\"end\":\"\",\"breaks\":{\"start\":\"\",\"end\":\"\"},\"$$hashKey\":\"object:365\"},{\"day\":\"Sunday\",\"status\":false,\"start\":\"\",\"end\":\"\",\"breaks\":{\"start\":\"\",\"end\":\"\"},\"$$hashKey\":\"object:366\"}]'),
(4, 4, '[{\"day\":\"Monday\",\"status\":true,\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":{\"start\":\"14:30\",\"end\":\"15:00\"},\"$$hashKey\":\"object:360\"},{\"day\":\"Tuesday\",\"status\":true,\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":{\"start\":\"14:30\",\"end\":\"15:00\"},\"$$hashKey\":\"object:361\"},{\"day\":\"Wednesday\",\"status\":true,\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":{\"start\":\"14:30\",\"end\":\"15:00\"},\"$$hashKey\":\"object:362\"},{\"day\":\"Thursday\",\"status\":true,\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":{\"start\":\"14:30\",\"end\":\"15:00\"},\"$$hashKey\":\"object:363\"},{\"day\":\"Friday\",\"status\":true,\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":{\"start\":\"14:30\",\"end\":\"15:00\"},\"$$hashKey\":\"object:364\"},{\"day\":\"Saturday\",\"status\":false,\"start\":\"\",\"end\":\"\",\"breaks\":{\"start\":\"\",\"end\":\"\"},\"$$hashKey\":\"object:365\"},{\"day\":\"Sunday\",\"status\":false,\"start\":\"\",\"end\":\"\",\"breaks\":{\"start\":\"\",\"end\":\"\"},\"$$hashKey\":\"object:366\"}]'),
(5, 5, '[{\"day\":\"Monday\",\"status\":true,\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":{\"start\":\"14:30\",\"end\":\"15:00\"},\"$$hashKey\":\"object:360\"},{\"day\":\"Tuesday\",\"status\":true,\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":{\"start\":\"14:30\",\"end\":\"15:00\"},\"$$hashKey\":\"object:361\"},{\"day\":\"Wednesday\",\"status\":true,\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":{\"start\":\"14:30\",\"end\":\"15:00\"},\"$$hashKey\":\"object:362\"},{\"day\":\"Thursday\",\"status\":true,\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":{\"start\":\"14:30\",\"end\":\"15:00\"},\"$$hashKey\":\"object:363\"},{\"day\":\"Friday\",\"status\":true,\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":{\"start\":\"14:30\",\"end\":\"15:00\"},\"$$hashKey\":\"object:364\"},{\"day\":\"Saturday\",\"status\":false,\"start\":\"\",\"end\":\"\",\"breaks\":{\"start\":\"\",\"end\":\"\"},\"$$hashKey\":\"object:365\"},{\"day\":\"Sunday\",\"status\":false,\"start\":\"\",\"end\":\"\",\"breaks\":{\"start\":\"\",\"end\":\"\"},\"$$hashKey\":\"object:366\"}]'),
(6, 5, '[{\"day\":\"Monday\",\"status\":true,\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":{\"start\":\"14:30\",\"end\":\"15:00\"},\"$$hashKey\":\"object:360\"},{\"day\":\"Tuesday\",\"status\":true,\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":{\"start\":\"14:30\",\"end\":\"15:00\"},\"$$hashKey\":\"object:361\"},{\"day\":\"Wednesday\",\"status\":true,\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":{\"start\":\"14:30\",\"end\":\"15:00\"},\"$$hashKey\":\"object:362\"},{\"day\":\"Thursday\",\"status\":true,\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":{\"start\":\"14:30\",\"end\":\"15:00\"},\"$$hashKey\":\"object:363\"},{\"day\":\"Friday\",\"status\":true,\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":{\"start\":\"14:30\",\"end\":\"15:00\"},\"$$hashKey\":\"object:364\"},{\"day\":\"Saturday\",\"status\":false,\"start\":\"\",\"end\":\"\",\"breaks\":{\"start\":\"\",\"end\":\"\"},\"$$hashKey\":\"object:365\"},{\"day\":\"Sunday\",\"status\":false,\"start\":\"\",\"end\":\"\",\"breaks\":{\"start\":\"\",\"end\":\"\"},\"$$hashKey\":\"object:366\"}]');

-- --------------------------------------------------------

--
-- Table structure for table `subtasks`
--

CREATE TABLE `subtasks` (
  `id` int(11) NOT NULL,
  `taskid` int(11) NOT NULL,
  `description` varchar(500) NOT NULL,
  `finished` int(11) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `staff_id` int(11) NOT NULL,
  `complete` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subtasks`
--

INSERT INTO `subtasks` (`id`, `taskid`, `description`, `finished`, `created`, `staff_id`, `complete`) VALUES
(37, 27, 'Sample sub task.', 0, '2017-11-23 23:15:30', 1, 1),
(38, 27, 'Lorem ipsum dolor sit amet.', 0, '2017-11-23 23:15:36', 1, 1),
(39, 27, 'Hello darkness my old friend.', 0, '2017-11-23 23:15:44', 1, 0),
(40, 29, 'Sample Subtask', 0, '2017-11-23 23:37:44', 1, 0),
(41, 29, 'There is no pain you are receding.', 0, '2017-11-23 23:37:57', 1, 0),
(42, 29, 'Hello darkness my old friend.', 0, '2017-11-23 23:38:07', 1, 1),
(43, 30, 'Hello darkness my old friend', 0, '2017-11-23 23:39:25', 1, 1),
(44, 30, 'Loose yourself to dance', 0, '2017-11-23 23:39:58', 1, 1),
(45, 30, 'One day in the year of the fox', 0, '2017-11-23 23:40:15', 1, 1),
(48, 32, 'Make smiler logo', 0, '2017-11-24 04:53:46', 1, 1),
(49, 32, 'Change color', 0, '2017-11-24 04:53:48', 1, 1),
(50, 32, 'Send customer', 0, '2017-11-24 04:53:55', 1, 1),
(51, 35, 'Check availability of the most common tlds including com, net, org. Also, checks the hyphenated version of your preferred domain name.', 0, '2017-11-25 06:12:16', 2, 1),
(53, 35, 'Preserve the main keywords entered in the final domain name and use the following to preserve SEO', 0, '2017-11-25 06:12:40', 2, 1),
(54, 35, 'Simple Portmanteau - smartly merge popular suffixes like ly, ify, er, ish, ism and many more', 0, '2017-11-25 06:12:51', 2, 1),
(55, 32, '\"What\'s happened to me?\" he thought. It wasn\'t a dream. His room, a proper human', 0, '2017-11-25 06:18:25', 2, 0),
(56, 31, 'Li Europan lingues es membres del sam familie. Lor separat existentie es un myth. Por scientie, musica, sport etc, litot Europa usa li sam vocabular.', 0, '2017-11-25 06:18:44', 2, 1),
(57, 31, 'Li nov lingua franca va esser plu simplic e regulari quam li existent Europan', 0, '2017-11-25 06:19:04', 2, 1),
(58, 36, 'Altera perfecto philosophia et eum. Facete aliquip epicurei sed te, ex sed clita legendos atomorum.', 0, '2017-11-25 17:03:08', 1, 1),
(59, 36, 'Mei no alia cibo virtute. Has minim labores te, no quo viderer menandri, ut autem regione delicatissimi mea. Choro pertinacia in vis.', 0, '2017-11-25 17:03:16', 1, 1),
(60, 36, 'Mazim admodum epicurei pro cu. Per at veritus torquatos. Legimus laoreet persecuti ius ex, cu summo falli ius.', 0, '2017-11-25 17:03:25', 1, 1),
(62, 1, 'Sample sub task', 0, '2018-01-06 02:43:49', 1, 0),
(63, 1, 'There is no pain', 0, '2018-01-06 02:43:57', 1, 1),
(64, 11, 'Test', 0, '2018-01-07 22:16:35', 1, 0),
(65, 2, 'Lorem ipsum dolor sit amet.', 0, '2018-01-07 22:53:08', 1, 1),
(66, 2, 'Populo honestatis vel eu, duo in inani possim scriptorem', 0, '2018-01-07 22:53:15', 1, 1),
(67, 2, 'Mundi dolores antiopam eam id.', 0, '2018-01-07 22:53:21', 1, 1),
(68, 1, 'Test', 0, '2018-08-27 05:16:19', 1, 1),
(69, 2, 'Pending Server Conffig', 0, '2019-04-15 19:21:00', 1, 0),
(70, 3, 'We can solve this problem by solving the HTML issue', 0, '2019-04-15 20:14:10', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `table_columns`
--

CREATE TABLE `table_columns` (
  `id` int(11) NOT NULL,
  `relation` varchar(255) DEFAULT NULL,
  `table_column` varchar(255) DEFAULT NULL,
  `display` tinyint(1) DEFAULT '1',
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `table_columns`
--

INSERT INTO `table_columns` (`id`, `relation`, `table_column`, `display`, `updated_at`) VALUES
(1, 'projects', 'name', 1, '2019-07-30 08:02:20'),
(2, 'projects', 'startdate', 1, '2019-08-06 03:13:11'),
(3, 'projects', 'customer', 1, '2019-08-06 03:13:11'),
(4, 'projects', 'deadline', 1, '2019-08-06 03:13:12'),
(5, 'projects', 'value', 1, '2019-08-06 03:13:14'),
(6, 'projects', 'status', 0, '2019-08-06 03:13:29'),
(7, 'projects', 'members', 0, '2019-08-06 03:13:19'),
(8, 'projects', 'actions', 1, '2019-08-06 03:13:13'),
(9, 'projects', 'list_view', 1, '2019-08-06 03:13:06'),
(10, 'invoices', 'customer', 1, NULL),
(11, 'invoices', 'staff', 0, NULL),
(12, 'invoices', 'created', 1, NULL),
(13, 'invoices', 'duedate', 1, NULL),
(14, 'invoices', 'status', 1, NULL),
(15, 'invoices', 'total', 1, NULL),
(16, 'expenses', 'title', 1, NULL),
(17, 'expenses', 'category', 1, NULL),
(18, 'expenses', 'customer', 0, NULL),
(19, 'expenses', 'staff', 0, NULL),
(20, 'expenses', 'date', 1, NULL),
(21, 'expenses', 'status', 1, NULL),
(22, 'expenses', 'total', 1, NULL),
(23, 'deposits', 'title', 1, NULL),
(24, 'deposits', 'category', 1, NULL),
(25, 'deposits', 'customer', 0, NULL),
(26, 'deposits', 'staff', 0, NULL),
(27, 'deposits', 'date', 1, NULL),
(28, 'deposits', 'status', 1, NULL),
(29, 'deposits', 'total', 1, NULL),
(30, 'orders', 'subject', 1, NULL),
(31, 'orders', 'customer', 1, NULL),
(32, 'orders', 'date', 1, NULL),
(33, 'orders', 'opentill', 1, NULL),
(34, 'orders', 'assigned', 0, NULL),
(35, 'orders', 'status', 1, NULL),
(36, 'orders', 'total', 1, NULL),
(37, 'proposals', 'subject', 1, NULL),
(38, 'proposals', 'customer', 1, NULL),
(39, 'proposals', 'date', 1, NULL),
(40, 'proposals', 'opentill', 1, NULL),
(41, 'proposals', 'assigned', 1, NULL),
(42, 'proposals', 'status', 1, NULL),
(43, 'proposals', 'total', 1, NULL),
(44, 'products', 'code', 0, NULL),
(45, 'products', 'name', 1, NULL),
(46, 'products', 'category', 1, NULL),
(47, 'products', 'purchase_price', 1, NULL),
(48, 'products', 'sales_price', 1, NULL),
(49, 'products', 'stock', 1, NULL),
(50, 'products', 'vat', 1, NULL),
(51, 'tasks', 'name', 1, NULL),
(52, 'tasks', 'priority', 0, NULL),
(53, 'tasks', 'startdate', 1, NULL),
(54, 'tasks', 'duedate', 1, NULL),
(55, 'tasks', 'relation', 0, NULL),
(56, 'tasks', 'status', 1, NULL),
(57, 'tasks', 'assigned', 0, NULL),
(58, 'tickets', 'subject', 1, NULL),
(59, 'tickets', 'customer', 0, NULL),
(60, 'tickets', 'contact', 1, NULL),
(61, 'tickets', 'department', 0, NULL),
(62, 'tickets', 'priority', 1, NULL),
(63, 'tickets', 'status', 1, NULL),
(64, 'tickets', 'last_reply', 1, NULL),
(65, 'tickets', 'assigned', 0, NULL),
(66, 'leads', 'name', 1, NULL),
(67, 'leads', 'date_connected', 0, NULL),
(68, 'leads', 'customer', 1, NULL),
(69, 'leads', 'phone', 1, NULL),
(70, 'leads', 'status', 1, NULL),
(71, 'leads', 'source', 1, NULL),
(72, 'leads', 'value', 0, NULL),
(73, 'leads', 'assigned', 1, NULL),
(74, 'staff', 'name', 1, NULL),
(75, 'staff', 'type', 1, NULL),
(76, 'staff', 'email', 1, NULL),
(77, 'staff', 'department', 1, NULL),
(78, 'staff', 'phone', 1, NULL),
(79, 'staff', 'role', 0, NULL),
(80, 'staff', 'timezone', 0, NULL),
(81, 'staff', 'language', 0, NULL),
(82, 'vendors', 'company', 1, NULL),
(83, 'vendors', 'group', 1, NULL),
(84, 'vendors', 'address', 1, NULL),
(85, 'vendors', 'balance', 1, NULL),
(86, 'purchases', 'vendor', 1, NULL),
(87, 'purchases', 'staff', 0, NULL),
(88, 'purchases', 'created', 1, NULL),
(89, 'purchases', 'duedate', 1, NULL),
(90, 'purchases', 'status', 1, NULL),
(91, 'purchases', 'total', 1, NULL),
(92, 'customers', 'name', 1, NULL),
(93, 'customers', 'group', 1, NULL),
(94, 'customers', 'address', 1, NULL),
(95, 'customers', 'balance', 1, NULL),
(96, 'leads', 'list_view', 0, NULL),
(97, 'tasks', 'list_view', 1, NULL),
(98, 'tickets', 'list_view', 1, NULL),
(99, 'products', 'product_type', 1, NULL),
(100, 'inventories', 'product_name', 1, NULL),
(101, 'inventories', 'product_type', 1, NULL),
(102, 'inventories', 'category', 1, NULL),
(103, 'inventories', 'cost_price', 1, NULL),
(104, 'inventories', 'stock', 0, NULL),
(105, 'inventories', 'warehouse', 0, NULL),
(106, 'inventories', 'created_by', 0, NULL),
(107, 'inventories', 'move_type', 1, NULL),
(108, 'warehouse', 'name', 1, NULL),
(109, 'warehouse', 'city', 0, NULL),
(110, 'warehouse', 'state', 1, NULL),
(111, 'warehouse', 'address', 1, NULL),
(112, 'warehouse', 'total_product', 1, NULL),
(113, 'warehouse', 'created', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `relation_type` varchar(255) NOT NULL,
  `relation` int(11) NOT NULL,
  `data` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `relation_type`, `relation`, `data`) VALUES
(1, 'lead', 11, '[\"test\"]'),
(2, 'lead', 12, '[]'),
(3, 'lead', 13, '[]');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `task_number` varchar(100) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `priority` int(5) DEFAULT NULL,
  `assigned` int(5) DEFAULT NULL,
  `created` datetime NOT NULL,
  `startdate` date NOT NULL,
  `duedate` date DEFAULT NULL,
  `datefinished` datetime NOT NULL,
  `addedfrom` int(5) NOT NULL,
  `status_id` int(5) NOT NULL DEFAULT '0',
  `relation` int(5) DEFAULT NULL,
  `relation_type` varchar(30) DEFAULT NULL,
  `public` tinyint(1) DEFAULT '0',
  `billable` tinyint(1) DEFAULT '0',
  `billed` tinyint(1) DEFAULT '0',
  `hourly_rate` decimal(20,2) DEFAULT '0.00',
  `milestone` int(5) DEFAULT '0',
  `visible` tinyint(1) DEFAULT '0',
  `timer` int(5) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `task_number`, `name`, `description`, `priority`, `assigned`, `created`, `startdate`, `duedate`, `datefinished`, `addedfrom`, `status_id`, `relation`, `relation_type`, `public`, `billable`, `billed`, `hourly_rate`, `milestone`, `visible`, `timer`) VALUES
(1, NULL, 'Install Wordpress', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 1, 1, '2018-06-01 20:51:46', '2018-06-01', '2019-06-14', '0000-00-00 00:00:00', 1, 4, 1, 'project', 1, 1, 0, '10.00', 1, 1, 0),
(2, NULL, 'Design Frontend', 'InnoDB Issues with the database, Need to solve the issue.', 2, 2, '2019-04-15 19:20:21', '2019-04-15', '2019-06-15', '0000-00-00 00:00:00', 1, 2, 1, 'project', 1, 0, 0, '0.00', 2, 1, 0),
(3, NULL, 'Coding PHP backend', 'Customer needs to provide clarifications', 2, 4, '2019-04-15 20:13:26', '2019-04-15', '2019-04-30', '0000-00-00 00:00:00', 1, 3, 1, 'project', 1, 1, 0, '15.00', 2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tasktimer`
--

CREATE TABLE `tasktimer` (
  `id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `task_id` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `start` varchar(64) DEFAULT NULL,
  `end` varchar(64) DEFAULT NULL,
  `timed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `note` text,
  `project_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tasktimer`
--

INSERT INTO `tasktimer` (`id`, `status`, `task_id`, `staff_id`, `start`, `end`, `timed`, `note`, `project_id`) VALUES
(14, 1, 1, 1, '2018-06-01 20:59', '2018-06-01 21:01', '2018-06-01 17:59:25', 'test', 1),
(15, 0, 2, 1, '2019-04-15 20:13:47', '2019-04-15 13:58:30', '2019-04-15 17:13:47', 'Frontend Completed', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ticketreplies`
--

CREATE TABLE `ticketreplies` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `contact_id` int(11) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL,
  `message` text,
  `attachment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ticketreplies`
--

INSERT INTO `ticketreplies` (`id`, `ticket_id`, `staff_id`, `name`, `contact_id`, `date`, `message`, `attachment`) VALUES
(1, 1, 1, 'Lance Bogrol', 23, '2018-01-23 02:07:45', 'Hi, how can i help you?', ''),
(2, 1, 1, 'Sue', 23, '2018-02-01 08:04:27', 'Hi i have a question.', ''),
(3, 2, 1, 'Lance Bogrol', 14, '2018-07-12 05:22:36', 'Test', ''),
(4, 3, 1, 'Sue', 23, '2018-08-02 20:52:45', 'Sample', ''),
(5, 3, 1, 'Sue', 23, '2018-08-02 20:53:19', 'Tets', '');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `ticket_number` varchar(100) DEFAULT NULL,
  `contact_id` int(5) NOT NULL DEFAULT '0',
  `customer_id` int(5) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `department_id` int(5) NOT NULL,
  `priority` enum('1','2','3') NOT NULL,
  `status_id` enum('1','2','3','4') NOT NULL,
  `relation` varchar(100) DEFAULT NULL,
  `relation_id` int(11) DEFAULT NULL,
  `subject` varchar(300) NOT NULL,
  `message` text,
  `date` datetime NOT NULL,
  `lastreply` datetime DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `staff_id` int(5) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `ticket_number`, `contact_id`, `customer_id`, `email`, `department_id`, `priority`, `status_id`, `relation`, `relation_id`, `subject`, `message`, `date`, `lastreply`, `attachment`, `staff_id`) VALUES
(1, NULL, 23, 17, 'sue@example.com', 3, '3', '4', NULL, NULL, 'Hi Please Help Me', 'Hi could you help me?', '2018-01-23 14:06:46', '2018-02-01 08:04:27', '', 1),
(2, NULL, 14, 0, NULL, 3, '1', '3', NULL, NULL, 'Sample Ticket', 'Sample ticket detail.', '2018-01-23 15:47:56', '2018-07-12 17:22:36', '', 1),
(3, NULL, 23, 17, 'sue@example.com', 3, '3', '1', NULL, NULL, 'Hi, Can you help me?', 'Hi, i need some help.', '2018-06-20 19:23:49', '2018-08-02 20:53:19', '', 3),
(4, NULL, 23, 17, 'sue@example.com', 3, '2', '1', NULL, NULL, 'Zclus Site Similar On siteGround', 'Need help with the website ? ', '2019-04-15 16:49:41', NULL, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ticketstatus`
--

CREATE TABLE `ticketstatus` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `color` varchar(10) DEFAULT '#28B8DA	'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ticketstatus`
--

INSERT INTO `ticketstatus` (`id`, `name`, `color`) VALUES
(1, 'OPEN', '#28B8DA	'),
(2, 'INPROGRESS', '#28B8DA	'),
(3, 'ANSWERED', '#28B8DA	'),
(4, 'CLOSED', '#28B8DA	');

-- --------------------------------------------------------

--
-- Table structure for table `todo`
--

CREATE TABLE `todo` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `staff_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `done` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `todo`
--

INSERT INTO `todo` (`id`, `description`, `staff_id`, `date`, `done`) VALUES
(2, 'Donec volutpat massa id justo lacinia, quis cursus lorem consectetur.', 1, '2017-08-25 21:17:08', 0),
(5, 'Mauris fringilla tincidunt mi at faucibus.', 1, '2017-08-25 21:17:53', 1),
(6, 'Donec volutpat massa id justo lacinia, quis cursus lorem consectetur.', 2, '2017-08-25 21:19:09', 1),
(7, 'Cras felis elit, vehicula id consectetur eu, cursus vel elit.', 2, '2017-08-25 21:19:17', 1),
(8, 'Vestibulum dolor felis, porta id auctor sollicitudin', 2, '2017-08-25 21:19:27', 0),
(9, 'Maecenas vel ultrices justo, nec consequat ipsum.', 2, '2017-08-25 21:19:35', 0),
(12, 'Test', 1, '2017-12-22 20:12:48', 1),
(13, 'Lorem ipsum dolor sit amet.', 1, '2018-01-21 19:02:18', 0),
(14, 'Sample to-do item.', 1, '2018-10-15 00:44:07', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `user_id` int(10) NOT NULL,
  `contact_id` int(10) NOT NULL,
  `created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`id`, `token`, `user_id`, `contact_id`, `created`) VALUES
(1, '46e684b53f71f476b8f152f0cf41ae', 0, 23, '2018-09-26');

-- --------------------------------------------------------

--
-- Table structure for table `unit_of_measure`
--

CREATE TABLE `unit_of_measure` (
  `unit_id` int(5) NOT NULL,
  `name` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` int(11) NOT NULL,
  `vendor_number` varchar(100) DEFAULT NULL,
  `type` int(5) DEFAULT NULL,
  `created` date NOT NULL,
  `staff_id` int(5) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `namesurname` varchar(255) DEFAULT NULL,
  `groupid` int(5) DEFAULT NULL,
  `taxoffice` varchar(255) DEFAULT NULL,
  `taxnumber` varchar(50) DEFAULT NULL,
  `ssn` varchar(255) DEFAULT NULL,
  `executive` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `zipcode` varchar(50) DEFAULT NULL,
  `country_id` int(5) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `town` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `fax` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `web` varchar(255) DEFAULT NULL,
  `risk` int(5) DEFAULT '0',
  `vendor_status_id` int(5) DEFAULT '1' COMMENT '0 = Inactive | 1 = Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vendors_groups`
--

CREATE TABLE `vendors_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vendor_sales`
--

CREATE TABLE `vendor_sales` (
  `id` int(11) NOT NULL,
  `purchase_id` int(5) NOT NULL,
  `status_id` int(5) NOT NULL,
  `vendor_id` int(5) NOT NULL,
  `staff_id` int(5) NOT NULL,
  `total` decimal(11,2) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `versions`
--

CREATE TABLE `versions` (
  `id` int(11) NOT NULL,
  `versions_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_version` varchar(255) DEFAULT NULL,
  `last_updated` date DEFAULT NULL,
  `is_update_available` tinyint(1) DEFAULT '0',
  `last_checked` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `versions`
--

INSERT INTO `versions` (`id`, `versions_name`, `created_at`, `last_version`, `last_updated`, `is_update_available`, `last_checked`) VALUES
(1, '2.6.9', '2022-06-28 12:00:00', '2.6.9', '2022-06-28', 0, '2022-06-28');

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `warehouse_id` int(5) NOT NULL,
  `warehouse_number` varchar(20) DEFAULT NULL,
  `warehouse_name` varchar(50) NOT NULL,
  `country` int(5) NOT NULL,
  `state` int(5) NOT NULL,
  `city` varchar(50) NOT NULL,
  `zip` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `created_by` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `webleads`
--

CREATE TABLE `webleads` (
  `id` int(11) NOT NULL,
  `token` text NOT NULL,
  `lead_source` int(5) NOT NULL,
  `lead_status` int(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `submit_text` varchar(255) NOT NULL,
  `success_message` mediumtext NOT NULL,
  `notification` tinyint(1) NOT NULL DEFAULT '1',
  `duplicate` tinyint(1) NOT NULL DEFAULT '1',
  `assigned_id` int(5) NOT NULL,
  `form_data` longtext NOT NULL,
  `custom_css` longtext COMMENT 'Custom Style Sheets',
  `created` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `webleads`
--

INSERT INTO `webleads` (`id`, `token`, `lead_source`, `lead_status`, `name`, `submit_text`, `success_message`, `notification`, `duplicate`, `assigned_id`, `form_data`, `custom_css`, `created`, `status`) VALUES
(1, '041f395da6d63183a9adf42a8bee1023', 1, 1, 'Customer Entry Form', '', 'Succesfully Added!', 1, 1, 1, '[{\"label\":\"Name\",\"type\":\"textfield\",\"key\":\"lName\",\"input\":true,\"tableView\":true},{\"label\":\"E-Mail\",\"type\":\"email\",\"key\":\"lEmail\",\"input\":true,\"tableView\":true},{\"label\":\"Phone\",\"type\":\"number\",\"title\":\"Phone\",\"key\":\"lPhone\",\"input\":true,\"tableView\":true},{\"label\":\"Description\",\"isUploadEnabled\":false,\"type\":\"textarea\",\"key\":\"lDescription\",\"input\":true,\"tableView\":true},{\"label\":\"Submit\",\"type\":\"button\",\"key\":\"lSubmit\",\"input\":true,\"tableView\":true}]', NULL, '2019-04-15 20:29:48', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appconfig`
--
ALTER TABLE `appconfig`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branding`
--
ALTER TABLE `branding`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customergroups`
--
ALTER TABLE `customergroups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_fields`
--
ALTER TABLE `custom_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_fields_data`
--
ALTER TABLE `custom_fields_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `db_backup`
--
ALTER TABLE `db_backup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `depositcat`
--
ALTER TABLE `depositcat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discussions`
--
ALTER TABLE `discussions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discussion_comments`
--
ALTER TABLE `discussion_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_queue`
--
ALTER TABLE `email_queue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_template_fields`
--
ALTER TABLE `email_template_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_triggers`
--
ALTER TABLE `event_triggers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_types`
--
ALTER TABLE `event_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expensecat`
--
ALTER TABLE `expensecat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoicestatus`
--
ALTER TABLE `invoicestatus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leadssources`
--
ALTER TABLE `leadssources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leadsstatus`
--
ALTER TABLE `leadsstatus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `milestones`
--
ALTER TABLE `milestones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_modes`
--
ALTER TABLE `payment_modes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_transactions`
--
ALTER TABLE `payment_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pending_process`
--
ALTER TABLE `pending_process`
  ADD PRIMARY KEY (`process_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productcategories`
--
ALTER TABLE `productcategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_inv`
--
ALTER TABLE `product_inv`
  ADD PRIMARY KEY (`inventory_id`);

--
-- Indexes for table `product_movement`
--
ALTER TABLE `product_movement`
  ADD PRIMARY KEY (`movement_id`);

--
-- Indexes for table `projectmembers`
--
ALTER TABLE `projectmembers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projectservices`
--
ALTER TABLE `projectservices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `proposals`
--
ALTER TABLE `proposals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recurring`
--
ALTER TABLE `recurring`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reminders`
--
ALTER TABLE `reminders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`role_permission_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`settingname`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_work_plan`
--
ALTER TABLE `staff_work_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subtasks`
--
ALTER TABLE `subtasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_columns`
--
ALTER TABLE `table_columns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasktimer`
--
ALTER TABLE `tasktimer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticketreplies`
--
ALTER TABLE `ticketreplies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticketstatus`
--
ALTER TABLE `ticketstatus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `todo`
--
ALTER TABLE `todo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit_of_measure`
--
ALTER TABLE `unit_of_measure`
  ADD PRIMARY KEY (`unit_id`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendors_groups`
--
ALTER TABLE `vendors_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor_sales`
--
ALTER TABLE `vendor_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `versions`
--
ALTER TABLE `versions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`warehouse_id`);

--
-- Indexes for table `webleads`
--
ALTER TABLE `webleads`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `appconfig`
--
ALTER TABLE `appconfig`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `branding`
--
ALTER TABLE `branding`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `customergroups`
--
ALTER TABLE `customergroups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `custom_fields`
--
ALTER TABLE `custom_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_fields_data`
--
ALTER TABLE `custom_fields_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `db_backup`
--
ALTER TABLE `db_backup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `depositcat`
--
ALTER TABLE `depositcat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discussions`
--
ALTER TABLE `discussions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `discussion_comments`
--
ALTER TABLE `discussion_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `email_queue`
--
ALTER TABLE `email_queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `email_template_fields`
--
ALTER TABLE `email_template_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=494;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `event_triggers`
--
ALTER TABLE `event_triggers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_types`
--
ALTER TABLE `event_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expensecat`
--
ALTER TABLE `expensecat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `invoicestatus`
--
ALTER TABLE `invoicestatus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `leadssources`
--
ALTER TABLE `leadssources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `leadsstatus`
--
ALTER TABLE `leadsstatus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1156;

--
-- AUTO_INCREMENT for table `meetings`
--
ALTER TABLE `meetings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `milestones`
--
ALTER TABLE `milestones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payment_modes`
--
ALTER TABLE `payment_modes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `payment_transactions`
--
ALTER TABLE `payment_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pending_process`
--
ALTER TABLE `pending_process`
  MODIFY `process_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `productcategories`
--
ALTER TABLE `productcategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product_inv`
--
ALTER TABLE `product_inv`
  MODIFY `inventory_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_movement`
--
ALTER TABLE `product_movement`
  MODIFY `movement_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `projectmembers`
--
ALTER TABLE `projectmembers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `projectservices`
--
ALTER TABLE `projectservices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `proposals`
--
ALTER TABLE `proposals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recurring`
--
ALTER TABLE `recurring`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `reminders`
--
ALTER TABLE `reminders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `role_permission_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `staff_work_plan`
--
ALTER TABLE `staff_work_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `subtasks`
--
ALTER TABLE `subtasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `table_columns`
--
ALTER TABLE `table_columns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tasktimer`
--
ALTER TABLE `tasktimer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `ticketreplies`
--
ALTER TABLE `ticketreplies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ticketstatus`
--
ALTER TABLE `ticketstatus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `todo`
--
ALTER TABLE `todo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `unit_of_measure`
--
ALTER TABLE `unit_of_measure`
  MODIFY `unit_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendors_groups`
--
ALTER TABLE `vendors_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendor_sales`
--
ALTER TABLE `vendor_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `versions`
--
ALTER TABLE `versions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `warehouse_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `webleads`
--
ALTER TABLE `webleads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
