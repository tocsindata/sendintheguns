<?php
require_once '../../../users/init.php';
require_once 'mailgun_functions.php';

if (isset($_GET['email_id'])) {
    $email_id = intval($_GET['email_id']);
    trackEmailClick($email_id);
    // Redirect to the original URL
    if (isset($_GET['url'])) {
        $url = urldecode($_GET['url']);
        header("Location: $url");
    }
}
?>
