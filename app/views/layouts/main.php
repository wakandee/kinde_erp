<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'Kinde ERP', ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/style.css">
    <script src="<?= $base_url ?>assets/js/main.js"></script>
</head>
<body class="light-mode">
    <?php require_once "../app/views/partials/header.php"; ?>

    <main class="container">
        <?php require_once $viewFile; ?>
    </main>

    <?php require_once "../app/views/partials/footer.php"; ?>

</body>
</html>
