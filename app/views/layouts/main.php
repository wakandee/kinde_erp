<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'Kinde ERP', ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/style.css">
    <script src="<?= $base_url ?>assets/js/main.js"></script>
</head>
<body class="light-mode">
    <?php require_once __DIR__ . '/../partials/header.php'; ?>

    <main class="container">
        <?= $content; ?>
    </main>

    <?php require_once __DIR__ . '/../partials/footer.php'; ?>

</body>
</html>
