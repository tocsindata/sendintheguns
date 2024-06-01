<?php
require_once 'mailgun_config.php';

// Save settings if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $config['mailgun_api_key'] = $_POST['mailgun_api_key'];
    $config['mailgun_domain'] = $_POST['mailgun_domain'];
    $config['mailgun_from_name'] = $_POST['mailgun_from_name'];
    $config['mailgun_from_email'] = $_POST['mailgun_from_email'];
    $config['mailgun_reply_to'] = $_POST['mailgun_reply_to'];
    $config['mailgun_debug'] = isset($_POST['mailgun_debug']);

    // Save the configuration to a file
    file_put_contents(__DIR__ . '/mailgun_config.php', '<?php return ' . var_export($config, true) . ';');
    
    echo 'Settings saved successfully!';
} else {
    // Load existing settings
    $config = include __DIR__ . '/mailgun_config.php';
}
?>
<h2>Mailgun Plugin Settings</h2>
<form method="post">
    <label for="mailgun_api_key">Mailgun API Key:</label>
    <input type="text" id="mailgun_api_key" name="mailgun_api_key" value="<?php echo htmlspecialchars($config['mailgun_api_key']); ?>">
    <br><br>
    <label for="mailgun_domain">Mailgun Domain:</label>
    <input type="text" id="mailgun_domain" name="mailgun_domain" value="<?php echo htmlspecialchars($config['mailgun_domain']); ?>">
    <br><br>
    <label for="mailgun_from_name">From Name:</label>
    <input type="text" id="mailgun_from_name" name="mailgun_from_name" value="<?php echo htmlspecialchars($config['mailgun_from_name']); ?>">
    <br><br>
    <label for="mailgun_from_email">From Email:</label>
    <input type="email" id="mailgun_from_email" name="mailgun_from_email" value="<?php echo htmlspecialchars($config['mailgun_from_email']); ?>">
    <br><br>
    <label for="mailgun_reply_to">Reply-To Email:</label>
    <input type="email" id="mailgun_reply_to" name="mailgun_reply_to" value="<?php echo htmlspecialchars($config['mailgun_reply_to']); ?>">
    <br><br>
    <label for="mailgun_debug">Enable Debug:</label>
    <input type="checkbox" id="mailgun_debug" name="mailgun_debug" <?php if ($config['mailgun_debug']) echo 'checked'; ?>>
    <br><br>
    <input type="submit" value="Save Settings">
</form>
