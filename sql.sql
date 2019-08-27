/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  mahdy
 * Created: Sep 13, 2018
 */

-- residential
ALTER TABLE `requests` 
CHANGE COLUMN `unit_type` `unit_type` VARCHAR(200) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT 'personal' ;
select distinct(unit_type) from requests;
update requests set unit_type = 'residential' where unit_type = 'personal' or unit_type = '';


ALTER TABLE `requests` 
CHANGE COLUMN `unit_type` `unit_type` ENUM('residential', 'commercial', 'land') COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT 'residential' ;

-- ---------------------------------------------------------------------------------------------------------------------

CREATE TABLE `user_edits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` enum('deskEdit') COLLATE utf8_unicode_ci NOT NULL,
  `data` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci


-- ----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `admin_notifications` CHANGE `type` `type` ENUM('switch','task','to_do','close_deal','finish_task','project','added_lead','note_lead','broadcast','broadcast_event') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;

-- ----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `leads` ADD `form_source_id` INT NULL DEFAULT NULL AFTER `seen`;

UPDATE `leads` SET form_source_id = 3 WHERE id = 17523;

----------------------------------------------------------------------------------------------------------------------

CREATE TABLE `lead_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lead_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci

----------------------------------------------------------------------------------------------------------------------

CREATE TABLE `suggestions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lead_id` int(11) NOT NULL,
  `type` varchar(191) NULL DEFAULT NULL,
  `title` varchar(191) NULL DEFAULT NULL,
  `price` varchar(191) NULL DEFAULT NULL,
  `area` int(11) NULL DEFAULT NULL,
  `location_id` int(11) NOT NULL,  
  `user_id` int(11) NOT NULL,  
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci

--
-- Table structure for table `duplicates`
--

CREATE TABLE `duplicates` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `prefix_name` enum('mr','mrs','ms') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ar_first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ar_last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ar_middle_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` text COLLATE utf8mb4_unicode_ci,
  `other_emails` text COLLATE utf8mb4_unicode_ci,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `club` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `religion` enum('muslim','christian','jewish','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` int(11) DEFAULT NULL,
  `social` text COLLATE utf8mb4_unicode_ci,
  `other_phones` text COLLATE utf8mb4_unicode_ci,
  `address` text COLLATE utf8mb4_unicode_ci,
  `title_id` int(10) UNSIGNED DEFAULT NULL,
  `country_id` int(10) UNSIGNED DEFAULT NULL,
  `city_id` int(10) UNSIGNED DEFAULT NULL,
  `nationality` int(10) UNSIGNED DEFAULT NULL,
  `lead_source_id` int(10) UNSIGNED DEFAULT NULL,
  `industry_id` int(10) UNSIGNED DEFAULT NULL,
  `campain_id` int(10) UNSIGNED DEFAULT NULL,
  `company` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `facebook` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('new','unqualified','working') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirm` tinyint(1) DEFAULT '0',
  `favorite` tinyint(1) DEFAULT '0',
  `hot` tinyint(1) DEFAULT '0',
  `agent_id` int(10) UNSIGNED DEFAULT '0',
  `commercial_agent_id` int(11) DEFAULT '0',
  `agent_flag` int(11) NOT NULL DEFAULT '0',
  `user_id` int(10) UNSIGNED NOT NULL,
  `refresh_token` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` text COLLATE utf8mb4_unicode_ci,
  `id_number` bigint(20) DEFAULT NULL,
  `subscriber_id` int(11) DEFAULT NULL,
  `reference` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seen` tinyint(4) DEFAULT '0',
  `form_source_id` int(11) DEFAULT NULL,
  `lead_id` int(10) UNSIGNED DEFAULT NULL,
  `archive_id` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `archives` ADD `lead_id` INT(11) NULL DEFAULT NULL AFTER `id`;

----------------------------------------------------------------------------------------------------------------------

CREATE TABLE `lead_summaries` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `national_leads_count` int(11) DEFAULT NULL,
  `international_leads_count` int(11) DEFAULT NULL,
  `duplicated_leads_count` int(11) DEFAULT NULL,
  `wrong_numbers_count` int(11) DEFAULT NULL,
  `assigned_agents_count` int(11) DEFAULT NULL,
  `unassigned_agents_count` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `leads` ADD `phone_iso` VARCHAR(191) NULL AFTER `phone`;

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `duplicates` ADD `phone_iso` VARCHAR(191) NULL AFTER `phone`;

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `archives` ADD `phone_iso` VARCHAR(191) NULL AFTER `phone`;

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `lead_summaries` ADD `updated_leads_count` int(11) DEFAULT NULL AFTER `unassigned_agents_count`;

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `resale_units` ADD `website_show` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER `featured`;

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `cils` ADD `user_id` INT(11) NOT NULL AFTER `lead_id`;


----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `cils` ADD `sent_date` TIMESTAMP NULL DEFAULT NULL AFTER `user_id`;

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `cils` ADD `expire_on` TIMESTAMP NULL DEFAULT NULL AFTER `sent_date`;

----------------------------------------------------------------------------------------------------------------------

CREATE TABLE `cils_info` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cil_id` int(10) UNSIGNED NOT NULL,
  `sheet` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `personal_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `corporate_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profession` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `own_property` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `educational_degree` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `club_membership` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `knowledge_source` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kids_education` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `occupation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `property_interest` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `residence` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nationality` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comments` text COLLATE utf8mb4_unicode_ci,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `resale_units` CHANGE `lng` `lng` VARCHAR(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `resale_units` CHANGE `lat` `lat` VARCHAR(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `resale_units` CHANGE `zoom` `zoom` VARCHAR(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;

----------------------------------------------------------------------------------------------------------------------

CREATE TABLE `cils_mail_settings` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `signature` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

----------------------------------------------------------------------------------------------------------------------

CREATE TABLE `cils_emails` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

----------------------------------------------------------------------------------------------------------------------

 ALTER TABLE `resale_units` ADD `status` ENUM('pending','done') NOT NULL AFTER `completed`;

-----------------------------------------------------------------------------------------------------------------------

UPDATE `resale_units` SET status = "done" WHERE status="pending";

------------------------------------------------------------------------------------------------------------------------

ALTER TABLE `rental_units` ADD `status` ENUM('pending','done') NOT NULL AFTER `completed`;

------------------------------------------------------------------------------------------------------------------------

ALTER TABLE `rental_units` CHANGE `ar_notes` `ar_notes` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, CHANGE `ar_description` `ar_description` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL, CHANGE `ar_title` `ar_title` VARCHAR(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, CHANGE `ar_address` `ar_address` VARCHAR(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;

-----------------------------------------------------------------------------------------------------------------------


CREATE TABLE `cil_keywords` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `keyword` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('rejected','accepted') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

----------------------------------------------------------------------------------------------------------------------
 CREATE TABLE `collections` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `value` int(20) NOT NULL,
  `date` date NOT NULL,
  `collected` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
-----------------------------------------------------------------------------------------------------------

CREATE TABLE `dues` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `value` int(20) NOT NULL,
  `date` date NOT NULL,
  `collected` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-----------------------------------------------------------------------------------------------------------

ALTER TABLE `resale_units` CHANGE `type` `type` ENUM('commercial','personal') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;

ALTER TABLE `resale_units` CHANGE `total` `total` INT(10) UNSIGNED NULL DEFAULT NULL;

ALTER TABLE `resale_units` CHANGE `finishing` `finishing` ENUM('finished','semi_finished','not_finished') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;

ALTER TABLE `resale_units` CHANGE `en_address` `en_address` VARCHAR(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;

ALTER TABLE `resale_units` CHANGE `area` `area` INT(10) UNSIGNED NULL DEFAULT NULL;

ALTER TABLE `resale_units` CHANGE `price` `price` INT(10) UNSIGNED NULL DEFAULT NULL;

ALTER TABLE `resale_units` CHANGE `payment_method` `payment_method` ENUM('cash','installment','cash_or_installment') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;

ALTER TABLE `resale_units` CHANGE `view` `view` ENUM('main_street','bystreet','garden','corner','sea_or_river') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;

ALTER TABLE `resale_units` CHANGE `availability` `availability` ENUM('available','sold') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;

ALTER TABLE `resale_units` CHANGE `due_now` `due_now` INT(10) UNSIGNED NULL DEFAULT NULL;

ALTER TABLE `resale_units` CHANGE `featured` `featured` TINYINT(1) NULL DEFAULT NULL;

ALTER TABLE `resale_units` CHANGE `website_show` `website_show` TINYINT(1) NULL DEFAULT NULL;

ALTER TABLE `resale_units` CHANGE `priority` `priority` INT(10) UNSIGNED NULL DEFAULT NULL;

ALTER TABLE `resale_units` CHANGE `maintenance_fees` `maintenance_fees` INT(11) NULL DEFAULT NULL;

ALTER TABLE `resale_units` CHANGE `completed` `completed` TINYINT(4) NULL DEFAULT NULL;

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `developers` ADD `cil_expire_date` TIMESTAMP NULL AFTER `updated_at`;

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `cils` ADD `sender_id` INT(10) NULL AFTER `user_id`;

----------------------------------------------------------------------------------------------------------------------

CREATE TABLE `lead_data` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lead_first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lead_last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_phones` text COLLATE utf8mb4_unicode_ci,
  `tag_id` int(10) UNSIGNED DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `agent_id` int(10) UNSIGNED DEFAULT '0',
  `commercial_agent_id` int(11) DEFAULT '0',
  `user_id` int(10) UNSIGNED NOT NULL,

  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `cils` ADD `replies_status` TINYINT NOT NULL DEFAULT '0' AFTER `status`;

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `developers` ADD `xls_url` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL AFTER `updated_at`;

----------------------------------------------------------------------------------------------------------------------

CREATE TABLE Admin_seo( id int(1) PRIMARY KEY, meta_ar text, meta_en text, google_js_f text, google_js_s text, created_at timestamp DEFAULT CURRENT_TIMESTAMP, updated_at timestamp DEFAULT CURRENT_TIMESTAMP );


----------------------------------------------------------------------------------------------------------------------

CREATE TABLE admin_ar_meta( id int(11) unsigned AUTO_INCREMENT NOT null PRIMARY KEY, name varchar(50) NOT null, created_at timestamp DEFAULT CURRENT_TIMESTAMP, updated_at timestamp DEFAULT CURRENT_TIMESTAMP );


----------------------------------------------------------------------------------------------------------------------

CREATE TABLE admin_en_meta( id int(11) unsigned AUTO_INCREMENT NOT null PRIMARY KEY, name varchar(50) NOT null, created_at timestamp DEFAULT CURRENT_TIMESTAMP, updated_at timestamp DEFAULT CURRENT_TIMESTAMP );


----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `admin_ar_meta` ADD `seo_id` INT(1) NOT NULL AFTER `name`;

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `admin_en_meta` ADD `seo_id` INT(1) NOT NULL AFTER `name`;

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `admin_en_meta` ADD FOREIGN KEY (`seo_id`) REFERENCES `Admin_seo`(`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `admin_ar_meta` ADD FOREIGN KEY (`seo_id`) REFERENCES `Admin_seo`(`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `calls` CHANGE `probability` `probability` ENUM('lowest','low','normal','high','highest','Follow Up') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'normal';

----------------------------------------------------------------------------------------------------------------------

update calls set probability = "Follow Up";

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `calls` CHANGE `probability` `probability` ENUM('Follow Up','On going','Expected Closing','Closed','Rotation') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Follow Up';

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `meetings` CHANGE `probability` `probability` ENUM('lowest','low','normal','high','highest','Follow Up') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'normal';

----------------------------------------------------------------------------------------------------------------------

update meetings set probability = "Follow Up";

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `meetings` CHANGE `probability` `probability` ENUM('Follow Up','On going','Expected Closing','Closed','Rotation') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Follow Up';

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `events` ADD `pdf` TEXT NULL AFTER `image`;
----------------------------------------------------------------------------------------------------------------------
ALTER TABLE `admin_notifications` CHANGE `type` `type` ENUM('switch','task','to_do','close_deal','finish_task','project_added','added_lead','note_lead','meeting') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;

----------------------------------------------------------------------------------------------------------------------
ALTER TABLE `admin_notifications` CHANGE `type` `type` ENUM('switch','task','to_do','close_deal','finish_task','project_added','added_lead','note_lead','meeting','call') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `admin_notifications` CHANGE `type` `type` ENUM('switch','task','to_do','close_deal','finish_task','project_added','added_lead','note_lead','meeting','call','cil') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `developers` CHANGE `cil_expire_date` `cil_expire_date` INT(11) NULL DEFAULT NULL;

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `cils_mail_settings` CHANGE `signature` `signature` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `cils_mail_settings` CHANGE `message` `message` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `developers` ADD `message` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL AFTER `cil_expire_date`;

----------------------------------------------------------------------------------------------------------------------

INSERT INTO `roles` (`id`, `name`, `roles`, `user_id`, `created_at`, `updated_at`) VALUES (NULL, 'operation', '{\"add_leads\":\"1\",\"hard_delete_leads\":\"1\",\"soft_delete_leads\":\"1\",\"switch_leads\":\"1\",\"edit_leads\":\"1\",\"show_all_leads\":\"1\",\"send_cil\":\"1\",\"calls\":\"1\",\"meetings\":\"1\",\"requests\":\"1\",\"developers\":\"1\",\"projects\":\"1\",\"phases\":\"1\",\"properties\":\"1\",\"resale_units\":\"1\",\"rental_units\":\"1\",\"lands\":\"1\",\"marketing\":\"1\",\"proposals\":\"1\",\"deals\":\"1\",\"finance\":\"1\",\"reports\":\"1\",\"settings\":\"1\",\"export_excel\":\"1\"}', '11', NULL, NULL);

----------------------------------------------------------------------------------------------------------------------

CREATE TABLE onesignal( id int(1) unsigned AUTO_INCREMENT PRIMARY KEY, api_key text, created_at timestamp DEFAULT CURRENT_TIMESTAMP, updated_at timestamp DEFAULT CURRENT_TIMESTAMP );

----------------------------------------------------------------------------------------------------------------------

INSERT INTO `onesignal` (`id`, `api_key`, `created_at`, `updated_at`) VALUES (NULL, '3c515ba6-fe76-4329-b6d4-0767f26b99ec', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `onesignal` ADD `rest_key` TEXT NOT NULL AFTER `api_key`;

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `users` ADD `assistant` INT(1) NOT NULL DEFAULT '0' AFTER `flag`;

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `cils` ADD `seen` INT(1) NOT NULL DEFAULT '0' AFTER `status`;

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `resale_units` ADD `order_web` INT(11) NULL AFTER `status`;

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `rental_units` ADD `order_web` INT(11) NULL AFTER `status`;

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `resale_units` ADD `order_mobile` INT(11) NULL AFTER `order_web`, ADD `mobile` INT(1) NOT NULL DEFAULT '1' AFTER `order_mobile`;

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `rental_units` ADD `order_mobile` INT(11) NULL AFTER `order_web`;

----------------------------------------------------------------------------------------------------------------------

CREATE table hr_new_settings( id int(1) DEFAULT 1 PRIMARY KEY, working_days int(2), start_work time, special_reward int(11), unscheduled_vacation int(11), over_time int(11), working_hours int(11), end_work time, annual_increase int(11), annual_vacation int(11), Tax int(11), Punishment int(11), created_at timestamp DEFAULT CURRENT_TIMESTAMP, updated_at timestamp DEFAULT CURRENT_TIMESTAMP )

----------------------------------------------------------------------------------------------------------------------

CREATE table workDays( id int(11) unsigned AUTO_INCREMENT NOT null PRIMARY KEY, ar_day varchar(100) not null, en_day varchar(100) not null, created_at timestamp DEFAULT CURRENT_TIMESTAMP, updated_at timestamp DEFAULT CURRENT_TIMESTAMP )

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `workDays` ADD `status` INT(1) NOT NULL DEFAULT '0' AFTER `en_day`;

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `calls` ADD `probability_status` INT(1) NOT NULL DEFAULT '0' AFTER `probability`;


----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `incomes` CHANGE `status` `status` ENUM('collected','postponed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `incomes` CHANGE `date` `date` DATE NOT NULL;

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `outcomes` CHANGE `status` `status` ENUM('paid','not_paid') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;

----------------------------------------------------------------------------------------------------------------------

ALTER TABLE `outcomes` CHANGE `date` `date` DATE NOT NULL;

----------------------------------------------------------------------------------------------------------------------
