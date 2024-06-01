<?php
require_once $abs_us_root . $us_url_root . 'users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/dbconfig.php';

$db = DB::getInstance();
$table_name = 'mailgun_scheduled_emails';

$emails = $db->query("SELECT * FROM {$table_name} WHERE status = 'pending' AND scheduled_time <= NOW()")->results();

foreach ($emails as $email) {
    try {
        sendMailgunEmail($email->to_email, $email->subject, $email->body);
        $db->update($table_name, $email->id, ['status' => 'sent']);
    } catch (Exception $e) {
        $db->update($table_name, $email->id, ['status' => 'failed']);
        error_log('Failed to send scheduled email: ' . $e->getMessage());
    }
}

echo 'Scheduled emails processed.';
?>
