<?php
require_once $abs_us_root . $us_url_root . 'users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/header.php';
require_once $abs_us_root . $us_url_root . 'users/includes/navigation.php';

if (!securePage($_SERVER['PHP_SELF'])){die();}
?>

<div class="container">
    <h2>How To Use the Mailgun Plugin</h2>
    <h3>1. Configuring Mailgun Settings</h3>
    <p>
        - Go to the Mailgun settings page in the UserSpice admin panel.<br>
        - Enter your Mailgun API key, domain, from name, from email address, and reply-to email.<br>
        - Enter custom headers in JSON format if needed.<br>
        - Enter the admin email for error notifications.<br>
        - Click the "Save Settings" button to save your configuration.
    </p>

    <h3>2. Sending Test Emails</h3>
    <p>
        - Navigate to the "Send Test Email" page in the UserSpice admin panel.<br>
        - Enter the recipient email address.<br>
        - Click the "Send Test Email" button to send a test email and verify the Mailgun configuration.
    </p>

    <h3>3. Managing Email Templates</h3>
    <p>
        - Navigate to the "Manage Email Templates" page in the UserSpice admin panel.<br>
        - To create a new template:<br>
          &nbsp;&nbsp; - Enter the template name, subject, and body.<br>
          &nbsp;&nbsp; - Click the "Create Template" button.<br>
        - To edit an existing template:<br>
          &nbsp;&nbsp; - Select the template from the list.<br>
          &nbsp;&nbsp; - Update the template name, subject, and body as needed.<br>
          &nbsp;&nbsp; - Click the "Edit Template" button.<br>
        - To delete a template:<br>
          &nbsp;&nbsp; - Select the template from the list.<br>
          &nbsp;&nbsp; - Click the "Delete Template" button.
    </p>

    <h3>4. Scheduling Emails</h3>
    <p>
        - Navigate to the "Schedule Email" page in the UserSpice admin panel.<br>
        - Enter the recipient email address, subject, body, and scheduled time.<br>
        - Click the "Schedule Email" button to schedule the email.
    </p>

    <h3>5. Viewing Email Logs</h3>
    <p>
        - Navigate to the "Email Logs" page in the UserSpice admin panel (if implemented).<br>
        - View the list of sent emails along with their status and response.
    </p>

    <h3>6. Viewing Email Statistics</h3>
    <p>
        - Navigate to the "Email Statistics" page in the UserSpice admin panel.<br>
        - View the list of sent emails along with their status, opens, clicks, and timestamps.
    </p>

    <h3>7. Managing Recipients</h3>
    <p>
        - Navigate to the "Manage Recipients" page in the UserSpice admin panel.<br>
        - To create a new recipient:<br>
          &nbsp;&nbsp; - Enter the recipient email and name.<br>
          &nbsp;&nbsp; - Click the "Create Recipient" button.<br>
        - To edit an existing recipient:<br>
          &nbsp;&nbsp; - Select the recipient from the list.<br>
          &nbsp;&nbsp; - Update the recipient email and name as needed.<br>
          &nbsp;&nbsp; - Click the "Edit Recipient" button.<br>
        - To delete a recipient:<br>
          &nbsp;&nbsp; - Select the recipient from the list.<br>
          &nbsp;&nbsp; - Click the "Delete Recipient" button.
    </p>

    <h3>8. Setting Up Cron Job</h3>
    <p>
        To ensure scheduled emails are sent at the specified times, you need to set up a cron job that runs the <code>cron_send_scheduled_emails.php</code> script at regular intervals. This script will check for scheduled emails and send them as needed.
    </p>

    <h4>For Linux/Unix Systems:</h4>
    <p>
        1. Open your crontab file for editing:<br>
           <code>crontab -e</code>
        <br>
        2. Add the following line to the crontab file to run the script every 5 minutes:<br>
           <code>*/5 * * * * /usr/bin/php /path/to/your/plugin/cron_send_scheduled_emails.php</code>
        <br>
           Replace <code>/path/to/your/plugin/</code> with the actual path to the <code>cron_send_scheduled_emails.php</code> script on your server.
        <br>
        3. Save and close the crontab file. The cron job will now run the script every 5 minutes to check for and send scheduled emails.
    </p>

    <h4>For Windows Systems:</h4>
    <p>
        1. Open Task Scheduler and create a new basic task.<br>
        2. Set the task to run a program and specify the path to your PHP executable and the <code>cron_send_scheduled_emails.php</code> script. For example:<br>
           <code>Program/script: php</code><br>
           <code>Add arguments: C:\path\to\your\plugin\cron_send_scheduled_emails.php</code>
        <br>
        3. Set the task to run every 5 minutes.<br>
        4. Save and close Task Scheduler. The task will now run the script every 5 minutes to check for and send scheduled emails.
    </p>

    <h3>Functions</h3>
    <p>
        - <code>sendMailgunEmail($to, $subject, $body, $attachments = [])</code>:<br>
          Sends an email using Mailgun.<br>
          Parameters:<br>
          &nbsp;&nbsp; - <code>$to</code>: Recipient email address.<br>
          &nbsp;&nbsp; - <code>$subject</code>: Email subject.<br>
          &nbsp;&nbsp; - <code>$body</code>: Email body (supports HTML).<br>
          &nbsp;&nbsp; - <code>$attachments</code>: Optional array of file paths to attach to the email.
    </p>
    <p>
        - <code>getEmailLogs()</code>:<br>
          Retrieves the log of sent emails.<br>
          Returns an array of email logs.
    </p>

    <h3>Troubleshooting</h3>
    <p>
        - Ensure that your Mailgun API key and domain are correctly entered in the plugin settings.<br>
        - Check your Mailgun account for any issues related to your domain or API key.<br>
        - Review UserSpice and PHP error logs for any error messages related to the plugin.
    </p>

    <h3>Support</h3>
    <p>
        For support and further assistance, please open an issue on the <a href="https://github.com/tocsindata/sendintheguns">GitHub repository</a> or contact the plugin maintainer.
    </p>

    <h3>Contributing</h3>
    <p>
        Contributions are welcome! Please fork the repository and submit pull requests with your improvements.
    </p>
</div>

<?php require_once $abs_us_root . $us_url_root . 'users/includes/footer.php'; ?>
