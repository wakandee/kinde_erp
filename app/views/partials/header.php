<header class="app-header">
    <div class="logo-title">
        <img src="<?= $base_url . 'assets/icons/KINDE.jpg' ?>" alt="Kinde ERP Logo">
        <h3>Kinde ERP</h3>
    </div>
    
    <nav class="main-nav">
        <a href="<?= htmlspecialchars($base_url, ENT_QUOTES, 'UTF-8') ?>">Home</a>
        <button id="toggle-dark">Toggle Dark Mode</button>
        <a href="<?= $base_url ?>logout" class="logout">Logout</a>
    </nav>
</header>
