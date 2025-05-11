<?php
// app/Views/auth/forgot_password.php
$title = 'Forgot Password - Kinde ERP';
?>

<section class="auth-form">
    <h2>Forgot Password</h2>

    <?php if (!empty($status)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($status) ?></div>
    <?php endif; ?>

    <form method="post" action="<?= $base_url ?>forgot-password">
        <div class="form-group">
            <label for="email">Enter your email address</label>
            <input type="email" id="email" name="email" required>
        </div>

        <button type="submit">Send Reset Link</button>
    </form>

    <p><a href="<?= $base_url ?>login">Back to Login</a></p>
</section>
