<?php
require 'vendor/autoload.php';
use Mailgun\Mailgun;

function sendMailgunEmail($to, $subject, $body, $attachments = []) {
    global $config;

    if (empty($config['mailgun_api_key']) || empty($config['mailgun_domain'])) {
        throw new Exception('Mailgun API key or domain is not set.');
    }

    $mg = Mailgun::create($config['mailgun_api_key']);
    $domain = $config['mailgun_domain'];

    $params = [
        'from'    => $config['mailgun_from_name'] . ' <' . $config['mailgun_from_email'] . '>',
        'to'      => $to,
        'subject' => $subject,
        'html'    => $body,
    ];

    if (!empty($config['mailgun_reply_to'])) {
        $params['h:Reply-To'] = $config['mailgun_reply_to'];
    }

    if (!empty($attachments)) {
        $params['attachment'] = [];
        foreach ($attachments as $file) {
            $params['attachment'][] = ['filePath' => $file, 'filename' => basename($file)];
        }
    }

    $mg->messages()->send($domain, $params);
}

function getEmailLogs() {
    // Function to retrieve email logs.
}
