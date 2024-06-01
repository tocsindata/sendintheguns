<?php
use Mailgun\Mailgun;

function sendMailgunEmail($to, $subject, $body, $attachments = []) {
    global $config;

    $mg = Mailgun::create($config['mailgun_api_key']);
    $domain = $config['mailgun_domain'];

    $params = [
        'from'    => 'noreply@' . $domain,
        'to'      => $to,
        'subject' => $subject,
        'html'    => $body,
    ];

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
