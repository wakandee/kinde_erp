<?php
// app/Views/auth/login.php
$title = 'Login - Kinde ERP';
?>

<section class="auth-form">
    <h2>Login</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" action="<?= $base_url ?>login">
        <div class="form-group">
            <label for="identifier">Email or Username</label>
            <input type="text" id="identifier" name="identifier" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit">Login</button>
    </form>

    <p><a href="<?= $base_url ?>forgot-password">Forgot your password?</a></p>
</section>
