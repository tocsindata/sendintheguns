<?php
require_once $abs_us_root . $us_url_root . 'users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/header.php';
require_once $abs_us_root . $us_url_root . 'users/includes/navigation.php';

if (!securePage($_SERVER['PHP_SELF'])){die();}

$db = DB::getInstance();
$table_name = 'mailgun_email_templates';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create_template'])) {
        $db->insert($table_name, [
            'template_name' => $_POST['template_name'],
            'subject' => $_POST['subject'],
            'body' => $_POST['body'],
        ]);
        $message = 'Template created successfully!';
    } elseif (isset($_POST['edit_template'])) {
        $db->update($table_name, $_POST['template_id'], [
            'template_name' => $_POST['template_name'],
            'subject' => $_POST['subject'],
            'body' => $_POST['body'],
        ]);
        $message = 'Template updated successfully!';
    } elseif (isset($_POST['delete_template'])) {
        $db->delete($table_name, $_POST['template_id']);
        $message = 'Template deleted successfully!';
    }
}
$templates = $db->query("SELECT * FROM {$table_name}")->results();
?>

<div class="container">
    <h2>Email Templates</h2>
    <?php if (isset($message)): ?>
        <div class="alert alert-success"><?php echo $message; ?></div>
    <?php endif; ?>
    <form method="post">
        <input type="hidden" name="template_id" id="template_id">
        <div class="form-group">
            <label for="template_name">Template Name:</label>
            <input type="text" class="form-control" id="template_name" name="template_name" required>
        </div>
        <div class="form-group">
            <label for="subject">Subject:</label>
            <input type="text" class="form-control" id="subject" name="subject" required>
        </div>
        <div class="form-group">
            <label for="body">Body:</label>
            <textarea class="form-control" id="body" name="body" rows="10" required></textarea>
        </div>
        <button type="submit" name="create_template" class="btn btn-primary">Create Template</button>
        <button type="submit" name="edit_template" class="btn btn-warning">Edit Template</button>
        <button type="submit" name="delete_template" class="btn btn-danger">Delete Template</button>
    </form>
    <h3>Existing Templates</h3>
    <ul class="list-group">
        <?php foreach ($templates as $template): ?>
            <li class="list-group-item">
                <strong><?php echo htmlspecialchars($template->template_name); ?></strong>
                <button class="btn btn-sm btn-warning" onclick="editTemplate(<?php echo $template->id; ?>, '<?php echo addslashes($template->template_name); ?>', '<?php echo addslashes($template->subject); ?>', '<?php echo addslashes($template->body); ?>')">Edit</button>
                <button class="btn btn-sm btn-danger" onclick="deleteTemplate(<?php echo $template->id; ?>)">Delete</button>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<script>
    function editTemplate(id, name, subject, body) {
        document.getElementById('template_id').value = id;
        document.getElementById('template_name').value = name;
        document.getElementById('subject').value = subject;
        document.getElementById('body').value = body;
    }
    function deleteTemplate(id) {
        if (confirm('Are you sure you want to delete this template?')) {
            document.getElementById('template_id').value = id;
            document.getElementsByName('delete_template')[0].click();
        }
    }
</script>

<?php require_once $abs_us_root . $us_url_root . 'users/includes/footer.php'; ?>
