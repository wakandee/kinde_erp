<?php
use App\Helpers\UrlHelper;

$base_url = UrlHelper::getBaseUrl();
$currentTab = UrlHelper::getCurrentTab();

?>
<!-- Toggle Button -->
<button class="sidebar-toggle" id="sidebarToggle">
    <i data-lucide="menu"></i>
</button>


    <aside class="sidebar" id="sidebar">
        <nav>
            <ul>
                <li class="<?= $currentTab === '' ? 'active' : '' ?>">
                    <a href="<?= $base_url ?>">
                        <i data-lucide="home"></i>
                        Dashboard
                    </a>
                </li>
                <li class="<?= $currentTab === 'activities' ? 'active' : '' ?>">
                    <a href="<?= $base_url ?>activities">
                        <i data-lucide="clipboard-list"></i>
                        Activity Tracker
                    </a>
                </li>
                <li class="<?= $currentTab === 'departments' ? 'active' : '' ?>">
                    <a href="<?= $base_url ?>departments">
                        <i data-lucide="building"></i>
                        Departments
                    </a>
                </li>
                <li class="<?= $currentTab === 'designations' ? 'active' : '' ?>">
                    <a href="<?= $base_url ?>designations">
                        <i data-lucide="badge-check"></i>
                        Designations
                    </a>
                </li>
                <li class="<?= $currentTab === 'users' ? 'active' : '' ?>">
                    <a href="<?= $base_url ?>users">
                        <i data-lucide="users"></i>
                        Staff
                    </a>
                </li>
                <li class="<?= $currentTab === 'profile' ? 'active' : '' ?>">
                    <a href="<?= $base_url ?>profile">
                        <i data-lucide="user-circle"></i>
                        Profile
                    </a>
                </li>
                <li>
                    <a href="<?= $base_url ?>logout">
                        <i data-lucide="log-out"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </nav>
    </aside>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>


    


<script>
    lucide.createIcons();

    const toggle = document.getElementById("sidebarToggle");
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("sidebarOverlay");

    toggle.addEventListener("click", () => {
        sidebar.classList.toggle("collapsed");
        overlay.style.display = sidebar.classList.contains("collapsed") ? 'block' : 'none';
    });

    overlay.addEventListener("click", () => {
        sidebar.classList.remove("collapsed");
        overlay.style.display = 'none';
    });
</script>
