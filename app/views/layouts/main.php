<?php use App\Helpers\SessionHelper; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'Kinde ERP', ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/style.css">
    <script src="<?= $base_url ?>assets/js/main.js" defer></script>
    <link rel="icon" type="image/png" href="<?= $base_url ?>assets/icons/favicon.png">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    $theme = $_SESSION['theme'] ?? 'light';
    $isLoggedIn = isset($_SESSION['user_id']);
?>
<body class="<?= htmlspecialchars($theme . '-mode', ENT_QUOTES, 'UTF-8') ?>">
    <!-- Add flash -->

    <div id="flash-container">
        <?php if ($message = \App\Helpers\SessionHelper::getFlash('success')): ?>
            <div class="alert alert-success">
                <span class="closebtn">&times;</span>
                <?= htmlspecialchars($message) ?>
                <div class="progress-bar"></div>
            </div>
        <?php endif; ?>
        <?php if ($message = \App\Helpers\SessionHelper::getFlash('error')): ?>
            <div class="alert alert-danger">
                <span class="closebtn">&times;</span>
                <?= htmlspecialchars($message) ?>
                <div class="progress-bar"></div>
            </div>
        <?php endif; ?>
    </div>



    <?php //var_dump($_SESSION); //exit;
    if ($isLoggedIn):?>
        
            <?php require_once __DIR__ . '/../partials/header.php'; ?>
        <!-- <div class="layout"> -->
            <div class="main-container">
                <?php require_once __DIR__ . '/../partials/sidebar.php'; ?>
                <main class="content">
                    <?= $content; ?>
                </main>
            </div>
        <!-- </div> -->
            <?php require_once __DIR__ . '/../partials/footer.php'; ?>
        
    <?php else: ?>
        <main class="login-container">
            <?= $content; ?>
        </main>
    <?php endif; ?>

    <script>
        window.APP_CONFIG = {
            baseUrl: "<?= htmlspecialchars(\App\Helpers\UrlHelper::getBaseUrl(), ENT_QUOTES, 'UTF-8') ?>"
        };
    </script>

</body>


</html>
