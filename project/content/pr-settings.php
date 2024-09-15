<?php
    $username_text=$user_data['username'];
    $email_text=$user_data['email'];
    $notification_option=$user_data['notification_frequency'];
?>

<h2 class="mb-3">Settings</h2>
<form class="mt-3" action="../actions/user-update-handler.php" method="POST">
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" id="username" value="<?php echo htmlspecialchars($username_text); ?>">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="email" value="<?php echo htmlspecialchars($email_text); ?>">
            </div>
            <div class="mb-3" style="margin-top:40px;">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="notificationFrequency" class="form-label">Notification Frequency</label>
                <select class="form-select" name="notificationFrequency" id="notificationFrequency">
                <option value="3" <?php echo ($notification_option == 3) ? 'selected' : ''; ?>>Twice a week</option>
                <option value="7" <?php echo ($notification_option == 7) ? 'selected' : ''; ?>>Once a week</option>
                <option value="14" <?php echo ($notification_option == 14) ? 'selected' : ''; ?>>Every 2 weeks</option>
                <option value="0" <?php echo ($notification_option == 0) ? 'selected' : ''; ?>>Disabled</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="language" class="form-label">Language</label>
                <select class="form-select" name="language" id="language">
                    <option selected>English</option>
                    <option disabled>More languages coming soon!</option>
                </select>
                <small class="form-text text-muted">Stay tuned for additional language options.</small>
            </div>
            <div class="mb-3">
                    <label for="passwordConfirm" class="form-label">Confirm password</label>
                    <input type="passwordConfirm" name="passwordConfirm" class="form-control" id="passwordConfirm">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Save Changes</button>
</form>