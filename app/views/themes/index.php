<!-- app/Views/themes/index.php -->
<!-- <h1>Select a Theme</h1>
<ul>
    <a href="<?= $base_url ?>theme/switch/light">Light Mode</a> |
    <a href="<?= $base_url ?>theme/switch/dark">Dark Mode</a>
</ul> -->


<h2>UI Theme Preferences</h2>
<form method="POST" action="<?= $this->baseUrl ?>themes/update">
    <label for="theme">Select Theme:</label>
    <select name="theme">
        <option value="light" <?= $currentTheme === 'light' ? 'selected' : '' ?>>Light</option>
        <option value="dark" <?= $currentTheme === 'dark' ? 'selected' : '' ?>>Dark</option>
    </select>
    <button type="submit">Save</button>
</form>
