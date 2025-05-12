<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'Login - Kinde ERP', ENT_QUOTES, 'UTF-8') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/style.css">
</head>
<body class="light-mode">
    <main class="login-container">
        <?= $content; ?>
    </main>
</body>
</html>
