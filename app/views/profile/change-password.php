<!-- File: app/Views/profile/change-password.php -->
<link rel="stylesheet" href="<?= $base_url ?>assets/css/profile.css">

<div class="profile-container">
  <h3>Change Password</h3>
  <hr>

  <?php if (! empty($error)): ?>
    <div style="color:#c00; margin-bottom:1em;"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST" action="<?= $base_url ?>change-password">
    <div style="margin-bottom:0.8em;">
      <label for="current_password"><strong>Current Password</strong></label><br>
      <input
        type="password"
        id="current_password"
        name="current_password"
        required
        style="width:30%; padding:0.5em;"
      >
    </div>

    <div style="margin-bottom:0.8em;">
      <label for="new_password"><strong>New Password</strong></label><br>
      <input
        type="password"
        id="new_password"
        name="new_password"
        required
        style="width:30%; padding:0.5em;"
      >
    </div>

    <div style="margin-bottom:1em;">
      <label for="confirm_password"><strong>Confirm New Password</strong></label><br>
      <input
        type="password"
        id="confirm_password"
        name="confirm_password"
        required
        style="width:30%; padding:0.5em;"
      >
    </div>

    <button type="submit" class="profile-button change-password">
      Update Password
    </button>
    <a href="<?= $base_url ?>profile" class="profile-button logout">
      Cancel
    </a>
  </form>
</div>
