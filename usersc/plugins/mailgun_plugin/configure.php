<?php
require_once $abs_us_root . $us_url_root . 'users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';

if (!securePage($_SERVER['PHP_SELF'])){die();}

$db = DB::getInstance();
$pluginSettings = $db->query("SELECT * FROM `settings` WHERE `name` LIKE 'mailgun_%'")->results();

$settings = [];
foreach ($pluginSettings as $setting) {
    $settings[$setting->name] = $setting->value;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newSettings = [
        'mailgun_api_key' => Input::get('mailgun_api_key'),
        'mailgun_domain' => Input::get('mailgun_domain'),
        'mailgun_from_name' => Input::get('mailgun_from_name'),
        'mailgun_from_email' => Input::get('mailgun_from_email'),
        'mailgun_reply_to' => Input::get('mailgun_reply_to'),
        'mailgun_custom_headers' => Input::get('mailgun_custom_headers'),
        'admin_email' => Input::get('admin_email')
    ];

    foreach ($newSettings as $key => $value) {
        $db->update('settings', $key, ['value' => $value]);
    }
    $message = 'Settings updated successfully!';
    $settings = $newSettings;
}
?>

<div class="content mt-3">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <strong>Mailgun Plugin Settings</strong>
                </div>
                <div class="card-body">
                    <?php if (isset($message)): ?>
                        <div class="alert alert-success"><?php echo $message; ?></div>
                    <?php endif; ?>
                    <form method="post">
                        <div class="form-group">
                            <label for="mailgun_api_key">Mailgun API Key:</label>
                            <input type="text" class="form-control" id="mailgun_api_key" name="mailgun_api_key" value="<?php echo $settings['mailgun_api_key']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="mailgun_domain">Mailgun Domain:</label>
                            <input type="text" class="form-control" id="mailgun_domain" name="mailgun_domain" value="<?php echo $settings['mailgun_domain']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="mailgun_from_name">From Name:</label>
                            <input type="text" class="form-control" id="mailgun_from_name" name="mailgun_from_name" value="<?php echo $settings['mailgun_from_name']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="mailgun_from_email">From Email:</label>
                            <input type="email" class="form-control" id="mailgun_from_email" name="mailgun_from_email" value="<?php echo $settings['mailgun_from_email']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="mailgun_reply_to">Reply-To Email:</label>
                            <input type="email" class="form-control" id="mailgun_reply_to" name="mailgun_reply_to" value="<?php echo $settings['mailgun_reply_to']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="mailgun_custom_headers">Custom Headers (JSON format):</label>
                            <textarea class="form-control" id="mailgun_custom_headers" name="mailgun_custom_headers" rows="3"><?php echo htmlspecialchars($settings['mailgun_custom_headers']); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="admin_email">Admin Email for Notifications:</label>
                            <input type="email" class="form-control" id="admin_email" name="admin_email" value="<?php echo $settings['admin_email']; ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Settings</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once $abs_us_root . $us_url_root . 'users/includes/template/footer.php'; ?>
