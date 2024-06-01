<?php
require_once '../../../users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/header.php';
require_once $abs_us_root . $us_url_root . 'users/includes/navigation.php';

if (!securePage($_SERVER['PHP_SELF'])){die();}

$db = DB::getInstance();
$email_logs_table = 'mailgun_email_logs';

$emails = $db->query("SELECT * FROM {$email_logs_table}")->results();
?>

<div class="container">
    <h2>Email Statistics and Reporting</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Recipient</th>
                <th>Subject</th>
                <th>Status</th>
                <th>Opens</th>
                <th>Clicks</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($emails as $email): ?>
            <tr>
                <td><?php echo htmlspecialchars($email->to_email); ?></td>
                <td><?php echo htmlspecialchars($email->subject); ?></td>
                <td><?php echo htmlspecialchars($email->status); ?></td>
                <td><?php echo htmlspecialchars($email->opens); ?></td>
                <td><?php echo htmlspecialchars($email->clicks); ?></td>
                <td><?php echo htmlspecialchars($email->timestamp); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once $abs_us_root . $us_url_root . 'users/includes/footer.php'; ?>
