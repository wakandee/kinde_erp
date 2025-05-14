<header class="app-header">
    <div class="logo-title">
        <img src="<?= $base_url . 'assets/icons/KINDE.jpg' ?>" alt="Kinde ERP Logo">
        <h3>Kinde ERP</h3>
    </div>
    
    <nav class="main-nav">
        <a href="<?= htmlspecialchars($base_url, ENT_QUOTES, 'UTF-8') ?>" class="nav-link">
            <i data-lucide="home"></i> Home
        </a>
       <button id="toggle-dark">
  <i id="theme-icon" data-lucide="<?= $theme === 'dark' ? 'sun' : 'moon' ?>"></i>
</button>

        <a href="<?= $base_url ?>logout" class="nav-link logout">
            <i data-lucide="log-out"></i> Logout
        </a>
    </nav>
</header>
