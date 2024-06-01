<?php
require_once '../../../users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/dbconfig.php';

// Define table names
$email_logs_table = 'mailgun_email_logs';
$email_templates_table = 'mailgun_email_templates';
$scheduled_emails_table = 'mailgun_scheduled_emails';
$email_stats_table = 'mailgun_email_stats';
$recipients_table = 'mailgun_recipients';

// Create email logs table if it doesn't exist
$db = DB::getInstance();
$email_logs_query = "
    CREATE TABLE IF NOT EXISTS `{$email_logs_table}` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `to_email` varchar(255) NOT NULL,
        `subject` varchar(255) NOT NULL,
        `body` text NOT NULL,
        `status` varchar(50) NOT NULL,
        `response` text,
        `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `opens` int(11) NOT NULL DEFAULT 0,
        `clicks` int(11) NOT NULL DEFAULT 0,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";
$db->query($email_logs_query);

// Create email templates table if it doesn't exist
$email_templates_query = "
    CREATE TABLE IF NOT EXISTS `{$email_templates_table}` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `template_name` varchar(255) NOT NULL,
        `subject` varchar(255) NOT NULL,
        `body` text NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";
$db->query($email_templates_query);

// Create scheduled emails table if it doesn't exist
$scheduled_emails_query = "
    CREATE TABLE IF NOT EXISTS `{$scheduled_emails_table}` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `to_email` varchar(255) NOT NULL,
        `subject` varchar(255) NOT NULL,
        `body` text NOT NULL,
        `scheduled_time` datetime NOT NULL,
        `status` varchar(50) NOT NULL DEFAULT 'pending',
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";
$db->query($scheduled_emails_query);

// Create email stats table if it doesn't exist
$email_stats_query = "
    CREATE TABLE IF NOT EXISTS `{$email_stats_table}` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `email_id` int(11) NOT NULL,
        `event_type` varchar(50) NOT NULL,
        `event_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        FOREIGN KEY (`email_id`) REFERENCES `{$email_logs_table}`(`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";
$db->query($email_stats_query);

// Create recipients table if it doesn't exist
$recipients_query = "
    CREATE TABLE IF NOT EXISTS `{$recipients_table}` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `email` varchar(255) NOT NULL,
        `name` varchar(255),
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";
$db->query($recipients_query);

echo 'Mailgun plugin installed successfully!';
