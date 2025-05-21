<section class="login-form">
    <h2>Kinde ERP | Login</h2>
    <?php if (!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <form method="POST" action="<?= $base_url ?>login" id="loginForm">
        <label for="identifier">Email or Username</label>
        <input type="text" name="identifier" placeholder="Email or Username" id="identifier" required><br><br>

        <label for="password">Password</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="password" placeholder="Password" name="password" id="password" required><br><br><br>

        <center><button type="submit" >Login</button></center>
    </form>

    <!-- <p><a href="<?= $base_url ?>forgot-password">Forgot your password?</a></p> -->
    <p><a href="#">Forgot your password?</a></p>

    <hr>
    <div class="preset-logins">
        <p>Quick Login:</p>
        <button type="button" class="preset-btn superadmin" data-user="SuperAdmin" data-pass="kinde2030">Superadmin</button>
        <button type="button" class="preset-btn assistant-hr" data-user="Nickson" data-pass="kinde2030">Commercial officer</button>
        <button type="button" class="preset-btn administrator" data-user="Joseph" data-pass="kinde2030">HOD Commercial</button>
        <button type="button" class="preset-btn administrator" data-user="Bernard" data-pass="Bernard">PM - Bernard</button>
         <!-- Add more roles below and use any of the preset-btn color cla -->
        <!-- Example: <button type="button" class="preset-btn info" data-user="user@example.com" data-pass="Pass123">Info Role</button> -->
    </div>
</section>

<style>
.preset-logins {
    margin-top: 20px;
    text-align: center;
}
.preset-btn {
    margin: 5px;
    padding: 8px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    color: #fff;
    font-weight: bold;
    transition: opacity 0.2s ease;
}
.preset-btn:hover {
    opacity: 0.85;
}
/* Color variants */
.preset-btn.superadmin { background-color: #28a745; } /* Green */
.preset-btn.assistant-hr { background-color: #007bff; } /* Blue */
.preset-btn.administrator { background-color: #dc3545; } /* Red */
.preset-btn.primary { background-color: #007bff; }
.preset-btn.secondary { background-color: #6c757d; }
.preset-btn.success { background-color: #28a745; }
.preset-btn.danger { background-color: #dc3545; }
.preset-btn.warning { background-color: #ffc107; color: #212529; }
.preset-btn.info { background-color: #17a2b8; }
.preset-btn.light { background-color: #f8f9fa; color: #212529; }
.preset-btn.dark { background-color: #343a40; }
</style>

<script>
    document.querySelectorAll('.preset-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const user = btn.getAttribute('data-user');
            const pass = btn.getAttribute('data-pass');
            document.getElementById('identifier').value = user;
            document.getElementById('password').value = pass;
        });
    });
</script>
