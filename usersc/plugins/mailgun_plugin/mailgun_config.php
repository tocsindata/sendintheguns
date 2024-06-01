<?php
// Load existing settings if they exist
if (file_exists(__DIR__ . '/mailgun_config.php')) {
    $config = include __DIR__ . '/mailgun_config.php';
} else {
    $config = [
        'mailgun_api_key' => '',
        'mailgun_domain' => '',
        'mailgun_from_name' => '',
        'mailgun_from_email' => '',
        'mailgun_reply_to' => '',
        // Add any other default settings here
    ];
}
?>
