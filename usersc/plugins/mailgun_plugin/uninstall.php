<?php
require_once '../../../users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/dbconfig.php';

// Define table names
$email_logs_table = 'mailgun_email_logs';
$email_templates_table = 'mailgun_email_templates';
$scheduled_emails_table = 'mailgun_scheduled_emails';
$email_stats_table = 'mailgun_email_stats';
$recipients_table = 'mailgun_recipients';
$error_logs_table = 'mailgun_error_logs';

// Drop tables if they exist
$db = DB::getInstance();
$db->query("DROP TABLE IF EXISTS `{$email_logs_table}`");
$db->query("DROP TABLE IF EXISTS `{$email_templates_table}`");
$db->query("DROP TABLE IF EXISTS `{$scheduled_emails_table}`");
$db->query("DROP TABLE IF EXISTS `{$email_stats_table}`");
$db->query("DROP TABLE IF EXISTS `{$recipients_table}`");
$db->query("DROP TABLE IF EXISTS `{$error_logs_table}`");

echo 'Mailgun plugin uninstalled successfully!';
?>
