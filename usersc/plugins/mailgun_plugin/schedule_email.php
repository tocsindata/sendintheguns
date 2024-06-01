<?php
require_once '../../../users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/header.php';
require_once $abs_us_root . $us_url_root . 'users/includes/navigation.php';

if (!securePage($_SERVER['PHP_SELF'])){die();}

$db = DB::getInstance();
$table_name = 'mailgun_scheduled_emails';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db->insert($table_name, [
        'to_email' => $_POST['to_email'],
        'subject' => $_POST['subject'],
        'body' => $_POST['body'],
        'scheduled_time' => $_POST['scheduled_time'],
    ]);
    $message = 'Email scheduled successfully!';
}
$scheduled_emails = $db->query("SELECT * FROM {$table_name} ORDER BY scheduled_time ASC")->results();
?>

<div class="container">
    <h2>Schedule Email</h2>
    <?php if (isset($message)): ?>
        <div class="alert alert-success"><?php echo $message; ?></div>
    <?php endif; ?>
    <form method="post">
        <div class="form-group">
            <label for="to_email">Recipient Email:</label>
            <input type="email" class="form-control" id="to_email" name="to_email" required>
        </div>
        <div class="form-group">
            <label for="subject">Subject:</label>
            <input type="text" class="form-control" id="subject" name="subject" required>
        </div>
        <div class="form-group">
            <label for="body">Body:</label>
            <textarea class="form-control" id="body" name="body" rows="10" required></textarea>
        </div>
        <div class="form-group">
            <label for="scheduled_time">Scheduled Time:</label>
            <input type="datetime-local" class="form-control" id="scheduled_time" name="scheduled_time" required>
        </div>
        <button type="submit" class="btn btn-primary">Schedule Email</button>
    </form>
    <h3>Scheduled Emails</h3>
    <ul class="list-group">
        <?php foreach ($scheduled_emails as $email): ?>
            <li class="list-group-item">
                <strong><?php echo htmlspecialchars($email->subject); ?></strong>
                to <?php echo htmlspecialchars($email->to_email); ?>
                at <?php echo htmlspecialchars($email->scheduled_time); ?>
                <span class="badge badge-<?php echo $email->status == 'pending' ? 'warning' : 'success'; ?>">
                    <?php echo htmlspecialchars($email->status); ?>
                </span>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php require_once $abs_us_root . $us_url_root . 'users/includes/footer.php'; ?>
