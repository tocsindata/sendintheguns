<?php
require_once 'mailgun_functions.php';
require_once 'mailgun_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $to = $_POST['test_email'];
    $subject = 'Test Email from Mailgun Plugin';
    $body = '<h1>This is a test email</h1><p>Sent using Mailgun plugin for UserSpice5.</p>';

    try {
        sendMailgunEmail($to, $subject, $body);
        $message = 'Test email sent successfully!';
    } catch (Exception $e) {
        $message = 'Failed to send test email: ' . $e->getMessage();
    }
}
?>

<h2>Send Test Email</h2>
<form method="post">
    <label for="test_email">Recipient Email:</label>
    <input type="email" id="test_email" name="test_email" required>
    <br><br>
    <input type="submit" value="Send Test Email">
</form>

<?php if (isset($message)) { echo '<p>' . $message . '</p>'; } ?>
