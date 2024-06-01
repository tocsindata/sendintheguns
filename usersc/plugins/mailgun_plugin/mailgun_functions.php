<?php
require_once $abs_us_root . $us_url_root . 'users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/dbconfig.php';

function sendMailgunEmail($to, $subject, $body, $attachments = []) {
    global $config;
    $db = DB::getInstance();
    $table_name = 'mailgun_email_logs';

    if (empty($config['mailgun_api_key']) || empty($config['mailgun_domain'])) {
        throw new Exception('Mailgun API key or domain is not set.');
    }

    // Generate tracking pixel URL
    $tracking_pixel_url = $config['base_url'] . '/usersc/plugins/mailgun_plugin/track_open.php?email_id=';

    // Generate tracking click URL
    $tracking_click_url = $config['base_url'] . '/usersc/plugins/mailgun_plugin/track_click.php?email_id=';

    // Generate unique email ID for tracking
    $db->insert($table_name, [
        'to_email' => $to,
        'subject' => $subject,
        'body' => $body,
        'status' => 'pending',
    ]);
    $email_id = $db->lastId();

    // Append tracking pixel to email body
    $body .= '<img src="' . $tracking_pixel_url . $email_id . '" width="1" height="1" style="display:none;" />';

    // Convert links in the email body to tracking links
    $body = preg_replace_callback(
        '/<a\s+href="([^"]+)"/i',
        function ($matches) use ($tracking_click_url, $email_id) {
            return '<a href="' . $tracking_click_url . $email_id . '&url=' . urlencode($matches[1]) . '"';
        },
        $body
    );

    $url = 'https://api.mailgun.net/v3/' . $config['mailgun_domain'] . '/messages';
    $params = [
        'from'    => $config['mailgun_from_name'] . ' <' . $config['mailgun_from_email'] . '>',
        'to'      => $to,
        'subject' => $subject,
        'html'    => $body,
    ];

    if (!empty($config['mailgun_reply_to'])) {
        $params['h:Reply-To'] = $config['mailgun_reply_to'];
    }

    // Include custom headers if any
    if (!empty($config['mailgun_custom_headers'])) {
        $custom_headers = json_decode($config['mailgun_custom_headers'], true);
        if (json_last_error() === JSON_ERROR_NONE) {
            foreach ($custom_headers as $header => $value) {
                $params[$header] = $value;
            }
        }
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, 'api:' . $config['mailgun_api_key']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

    if (!empty($attachments)) {
        foreach ($attachments as $file) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, [
                'attachment' => new CURLFile($file)
            ]);
        }
    }

    $result = curl_exec($ch);
    $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Update email status
    $status = ($httpStatus == 200) ? 'sent' : 'failed';
    $db->update($table_name, $email_id, ['status' => $status]);

    if ($httpStatus != 200) {
        $error_message = 'Mailgun API request failed with status ' . $httpStatus . ': ' . $result;
        logMailgunError($error_message);
        sendAdminNotification($error_message);
        throw new Exception($error_message);
    }

    curl_close($ch);
}

function trackEmailOpen($email_id) {
    $db = DB::getInstance();
    $table_name = 'mailgun_email_stats';
    $db->insert($table_name, [
        'email_id' => $email_id,
        'event_type' => 'open',
    ]);
}

function trackEmailClick($email_id) {
    $db = DB::getInstance();
    $table_name = 'mailgun_email_stats';
    $db->insert($table_name, [
        'email_id' => $email_id,
        'event_type' => 'click',
    ]);
}

function getEmailLogs() {
    $db = DB::getInstance();
    $table_name = 'mailgun_email_logs';
    return $db->query("SELECT * FROM {$table_name}")->results();
}

function logMailgunError($error_message) {
    $db = DB::getInstance();
    $table_name = 'mailgun_error_logs';
    $db->insert($table_name, [
        'error_message' => $error_message,
    ]);
}

function sendAdminNotification($error_message) {
    global $config;
    $admin_email = $config['admin_email'];
    $subject = 'Mailgun Plugin Error Notification';
    $body = 'An error occurred in the Mailgun Plugin: ' . $error_message;

    mail($admin_email, $subject, $body);
}
