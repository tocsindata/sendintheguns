<?php
// Render settings form and save settings
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $config['mailgun_api_key'] = $_POST['mailgun_api_key'];
    $config['mailgun_domain'] = $_POST['mailgun_domain'];
    // Save to database or config file
}

?>
<form method="post">
    <label for="mailgun_api_key">Mailgun API Key:</label>
    <input type="text" id="mailgun_api_key" name="mailgun_api_key" value="<?php echo $config['mailgun_api_key']; ?>">
    <br>
    <label for="mailgun_domain">Mailgun Domain:</label>
    <input type="text" id="mailgun_domain" name="mailgun_domain" value="<?php echo $config['mailgun_domain']; ?>">
    <br>
    <input type="submit" value="Save Settings">
</form>
