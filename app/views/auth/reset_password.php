<?php
// app/Views/auth/reset_password.php
$title = 'Reset Password - Kinde ERP';
?>

<section class="auth-form">
    <h2>Reset Password</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" action="<?= $base_url ?>reset-password">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

        <div class="form-group">
            <label for="password">New Password</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="password_confirm">Confirm New Password</label>
            <input type="password" id="password_confirm" name="password_confirm" required>
        </div>

        <button type="submit">Reset Password</button>
    </form>
</section>
