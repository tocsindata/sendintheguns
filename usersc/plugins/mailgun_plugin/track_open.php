<?php
require_once $abs_us_root . $us_url_root . 'users/init.php';
require_once 'mailgun_functions.php';

if (isset($_GET['email_id'])) {
    $email_id = intval($_GET['email_id']);
    trackEmailOpen($email_id);
    // Output a 1x1 transparent pixel
    header('Content-Type: image/gif');
    echo base64_decode('R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==');
}
?>
