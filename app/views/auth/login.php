<section class="login-form">
    <h2>Welcome to Kinde ERP</h2>
    <?php if (!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>
    <form method="POST" action="<?= $base_url ?>login">
        <label for="identifier">Email or Username</label>
        <input type="text" name="identifier" id="identifier" required>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Login</button>
    </form>
    <p><a href="<?= $base_url ?>forgot-password">Forgot your password?</a></p>
</section>
    