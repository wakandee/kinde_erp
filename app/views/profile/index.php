<!-- File: public/assets/css/profile.css -->
<style>
	.profile-container {
    max-width: 600px;
    margin: 2em auto;
    font-family: Arial, sans-serif;
}

.profile-card {
    display: flex;
    align-items: center;
    padding: 1em;
    border: 1px solid #ccc;
    border-radius: 8px;
}

.profile-avatar {
    flex-shrink: 0;

    margin-right: 1em;
}

.profile-avatar img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
}

.profile-details p {
    margin: 0.2em 0;
}

.profile-actions {
    margin-top: 1em;
}

.profile-button {
    display: inline-block;
    padding: 0.5em 1em;
    margin-right: 0.5em;
    border-radius: 4px;
    text-decoration: none;
    font-size: 0.95em;
}

.profile-button.change-password {
    border: 1px solid #007bff;
    color: #007bff;
}

.profile-button.logout {
    border: 1px solid #dc3545;
    color: #dc3545;
}
</style>

<!-- File: profile/index.php -->
<?php
// profile/index.php
?>
<link rel="stylesheet" href="<?= $base_url ?>assets/css/profile.css">

<div class="profile-container">
  <h3>My Profile</h3>
  <hr>

  <div class="profile-card">
    <div class="profile-avatar">
      <img
        src="<?= htmlspecialchars($user->avatar_url ?? $base_url . 'assets/img/avatar-placeholder.png') ?>"
        alt="Your Avatar"
      >
    </div>

    <div class="profile-details">
      <p><strong>Name:</strong> <?= htmlspecialchars($user->name); ?></p>
      <p><strong>Email:</strong> <?= htmlspecialchars($user->email); ?></p>
      <p><strong>Username:</strong> <?= htmlspecialchars($user->username); ?></p>
      <p><strong>Phone:</strong> <?= htmlspecialchars($user->phone_number ?? 'N/A'); ?></p>
      <p><strong>Department:</strong> <?= htmlspecialchars($user->department_name ?? 'Not assigned'); ?></p>
      <p><strong>Designation:</strong> <?= htmlspecialchars($user->designation_name ?? 'Not assigned'); ?></p>

      <div class="profile-actions">
        <a href="<?= $base_url ?>change-password" class="profile-button change-password">Change Password</a>
        <a href="<?= $base_url ?>logout" class="profile-button logout">Logout</a>
      </div>
    </div>

  </div>
</div>
