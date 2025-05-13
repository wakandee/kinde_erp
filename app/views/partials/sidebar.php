<?php
use App\Helpers\UrlHelper;

$base_url = UrlHelper::getBaseUrl();
$currentTab = UrlHelper::getCurrentTab();

?>
<aside class="sidebar">
    <nav>
        <ul>
            <li class="<?= $currentTab === '' ? 'active' : '' ?>">
                <a href="<?= $base_url ?>">Dashboard</a>
            </li>
            <li class="<?= $currentTab === 'tracker' ? 'active' : '' ?>">
                <a href="<?= $base_url ?>tracker">Activity Tracker</a>
            </li>
            <li class="<?= $currentTab === 'departments' ? 'active' : '' ?>">
                <a href="<?= $base_url ?>departments">Departments</a>
            </li>
            <li class="<?= $currentTab === 'designations' ? 'active' : '' ?>">
                <a href="<?= $base_url ?>designations">Designations</a>
            </li>
            <li class="<?= $currentTab === 'users' ? 'active' : '' ?>">
                <a href="<?= $base_url ?>users">Staff</a>
            </li>
            <li class="<?= $currentTab === 'profile' ? 'active' : '' ?>">
                <a href="<?= $base_url ?>profile">Profile</a>
            </li>
            <li>
                <a href="<?= $base_url ?>logout">Logout</a>
            </li>
        </ul>
    </nav>
</aside>
