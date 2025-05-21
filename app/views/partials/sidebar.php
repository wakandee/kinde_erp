<?php
use App\Helpers\UrlHelper;
use App\Middleware\Rbac;

$base_url   = UrlHelper::getBaseUrl();
$currentTab = UrlHelper::getCurrentTab();
// $allowed    = MenuHelper::allowedViewRoutes();

// var_dump($currentTab);

// Sidebar items: [ path => [icon, label], … ]
$items = [
    ''                           => ['home',             'Dashboard'],
    'activities'                 => ['clipboard-list',   'Activity Tracker'],
    'departments'                => ['building',         'Departments'],
    'designations'               => ['badge-check',      'Designations'],
    'users'                      => ['users',            'Staff'],

    // ─── RBAC Management ──────────────────────────────────────
    'rbac_module_groups'  => ['layers',           'Module Groups'],
    'rbac_routes'         => ['list-check',       'Manage Routes'],
    // 'rbac_permissions'    => ['key-round',        'Permissions'],
    'rbac_access_control' => ['settings',         'Access Control'],

    // Always visible:
    'profile'                    => ['user-circle',      'Profile'],
];

?>

<button class="sidebar-toggle" id="sidebarToggle"><i data-lucide="menu"></i></button>
<aside class="sidebar" id="sidebar">
  <nav>
    <ul>
      <?php
      foreach ($items as $path => [$icon,$label]) {
          if (! in_array($path, ['', 'profile'], true)
           && ! Rbac::check('View', $path)) {
              continue;
          }
          $active = $currentTab === $path ? ' active' : '';
          echo "<li class=\"{$active}\"><a href=\"{$base_url}{$path}\">
                   <i data-lucide=\"{$icon}\"></i> {$label}
                </a></li>";
      }
      ?>
    </ul>
  </nav>
</aside>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<script>
  lucide.createIcons();
  const toggle  = document.getElementById("sidebarToggle");
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