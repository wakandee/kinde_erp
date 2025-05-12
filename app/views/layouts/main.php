<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'Kinde ERP', ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/style.css">
    <script src="<?= $base_url ?>assets/js/main.js" defer></script>
</head>
<?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    $theme = $_SESSION['theme'] ?? 'light';
    $isLoggedIn = isset($_SESSION['user_id']);
?>
<body class="<?= htmlspecialchars($theme . '-mode', ENT_QUOTES, 'UTF-8') ?>">

<?php //var_dump($_SESSION); //exit;

if ($isLoggedIn):?>
    <?php require_once __DIR__ . '/../partials/header.php'; ?>
    <div class="main-container">
        <?php require_once __DIR__ . '/../partials/sidebar.php'; ?>
        <main class="content">
            <?= $content; ?>
        </main>
    </div>
    <?php require_once __DIR__ . '/../partials/footer.php'; ?>
<?php else: ?>
    <main class="login-container">
        <?= $content; ?>
    </main>
<?php endif; ?>

</body>
</html>
