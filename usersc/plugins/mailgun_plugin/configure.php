<?php
require_once '../../../../users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/header.php';
require_once $abs_us_root . $us_url_root . 'users/includes/navigation.php';

if (!securePage($_SERVER['PHP_SELF'])){die();}

$db = DB::getInstance();
$config = $db->query("SELECT * FROM `settings`")->first();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mailgun_api_key = Input::get('mailgun_api_key');
    $mailgun_domain = Input::get('mailgun_domain');
    $mailgun_from_name = Input::get('mailgun_from_name');
    $mailgun_from_email = Input::get('mailgun_from_email');
    $mailgun_reply_to = Input::get('mailgun_reply_to');
    $mailgun_custom_headers = Input::get('mailgun_custom_headers');
    $admin_email = Input::get('admin_email');

    $db->update('settings', 1, [
        'mailgun_api_key' => $mailgun_api_key,
        'mailgun_domain' => $mailgun_domain,
        'mailgun_from_name' => $mailgun_from_name,
        'mailgun_from_email' => $mailgun_from_email,
        'mailgun_reply_to' => $mailgun_reply_to,
        'mailgun_custom_headers' => $mailgun_custom_headers,
        'admin_email' => $admin_email,
    ]);
    $message = 'Settings updated successfully!';
}
?>

<div class="container">
    <h2>Mailgun Plugin Settings</h2>
    <?php if (isset($message)): ?>
        <div class="alert alert-success"><?php echo $message; ?></div>
    <?php endif; ?>
    <form method="post">
        <div class="form-group">
            <label for="mailgun_api_key">Mailgun API Key:</label>
            <input type="text" class="form-control" id="mailgun_api_key" name="mailgun_api_key" value="<?php echo $config->mailgun_api_key; ?>" required>
        </div>
        <div class="form-group">
            <label for="mailgun_domain">Mailgun Domain:</label>
            <input type="text" class="form-control" id="mailgun_domain" name="mailgun_domain" value="<?php echo $config->mailgun_domain; ?>" required>
        </div>
        <div class="form-group">
            <label for="mailgun_from_name">From Name:</label>
            <input type="text" class="form-control" id="mailgun_from_name" name="mailgun_from_name" value="<?php echo $config->mailgun_from_name; ?>" required>
        </div>
        <div class="form-group">
            <label for="mailgun_from_email">From Email:</label>
            <input type="email" class="form-control" id="mailgun_from_email" name="mailgun_from_email" value="<?php echo $config->mailgun_from_email; ?>" required>
        </div>
        <div class="form-group">
            <label for="mailgun_reply_to">Reply-To Email:</label>
            <input type="email" class="form-control" id="mailgun_reply_to" name="mailgun_reply_to" value="<?php echo $config->mailgun_reply_to; ?>">
        </div>
        <div class="form-group">
            <label for="mailgun_custom_headers">Custom Headers (JSON format):</label>
            <textarea class="form-control" id="mailgun_custom_headers" name="mailgun_custom_headers" rows="3"><?php echo htmlspecialchars($config->mailgun_custom_headers); ?></textarea>
        </div>
        <div class="form-group">
            <label for="admin_email">Admin Email for Notifications:</label>
            <input type="email" class="form-control" id="admin_email" name
