<?php
require_once $abs_us_root . $us_url_root . 'users/init.php';
$db = DB::getInstance();

$settings = [
    'mailgun_api_key' => '',
    'mailgun_domain' => '',
    'mailgun_from_name' => '',
    'mailgun_from_email' => '',
    'mailgun_reply_to' => '',
    'mailgun_custom_headers' => '',
    'admin_email' => ''
];

foreach ($settings as $key => $value) {
    $existingSetting = $db->query("SELECT * FROM `settings` WHERE `name` = ?", [$key])->count();
    if ($existingSetting == 0) {
        $db->insert('settings', [
            'name' => $key,
            'value' => $value
        ]);
    }
}
?>
