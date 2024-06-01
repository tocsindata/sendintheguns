<?php
require_once '../../../users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/header.php';
require_once $abs_us_root . $us_url_root . 'users/includes/navigation.php';

if (!securePage($_SERVER['PHP_SELF'])){die();}

$db = DB::getInstance();
$table_name = 'mailgun_recipients';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create_recipient'])) {
        $db->insert($table_name, [
            'email' => $_POST['email'],
            'name' => $_POST['name'],
        ]);
        $message = 'Recipient created successfully!';
    } elseif (isset($_POST['edit_recipient'])) {
        $db->update($table_name, $_POST['recipient_id'], [
            'email' => $_POST['email'],
            'name' => $_POST['name'],
        ]);
        $message = 'Recipient updated successfully!';
    } elseif (isset($_POST['delete_recipient'])) {
        $db->delete($table_name, $_POST['recipient_id']);
        $message = 'Recipient deleted successfully!';
    }
}
$recipients = $db->query("SELECT * FROM {$table_name}")->results();
?>

<div class="container">
    <h2>Manage Recipients</h2>
    <?php if (isset($message)): ?>
        <div class="alert alert-success"><?php echo $message; ?></div>
    <?php endif; ?>
    <form method="post">
        <input type="hidden" name="recipient_id" id="recipient_id">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <button type="submit" name="create_recipient" class="btn btn-primary">Create Recipient</button>
        <button type="submit" name="edit_recipient" class="btn btn-warning">Edit Recipient</button>
        <button type="submit" name="delete_recipient" class="btn btn-danger">Delete Recipient</button>
    </form>
    <h3>Existing Recipients</h3>
    <ul class="list-group">
        <?php foreach ($recipients as $recipient): ?>
            <li class="list-group-item">
                <strong><?php echo htmlspecialchars($recipient->email); ?></strong>
                (<?php echo htmlspecialchars($recipient->name); ?>)
                <button class="btn btn-sm btn-warning" onclick="editRecipient(<?php echo $recipient->id; ?>, '<?php echo addslashes($recipient->email); ?>', '<?php echo addslashes($recipient->name); ?>')">Edit</button>
                <button class="btn btn-sm btn-danger" onclick="deleteRecipient(<?php echo $recipient->id; ?>)">Delete</button>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<script>
    function editRecipient(id, email, name) {
        document.getElementById('recipient_id').value = id;
        document.getElementById('email').value = email;
        document.getElementById('name').value = name;
    }
    function deleteRecipient(id) {
        if (confirm('Are you sure you want to delete this recipient?')) {
            document.getElementById('recipient_id').value = id;
            document.getElementsByName('delete_recipient')[0].click();
        }
    }
</script>

<?php require_once $abs_us_root . $us_url_root . 'users/includes/footer.php'; ?>
