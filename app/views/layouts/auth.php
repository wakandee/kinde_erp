<?php use App\Core\SessionHelper; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'Login - Kinde ERP') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/style.css">
</head>
<body class="light-mode auth-layout">
    <main class="auth-container">
        <?= $content; ?>
    </main>
    <?php if ($msg = \App\Core\SessionHelper::flash('success')): ?>
        <div class="alert alert-success"><?= $msg ?></div>
    <?php endif; ?>
    <?php if ($msg = \App\Core\SessionHelper::flash('error')): ?>
        <div class="alert alert-danger"><?= $msg ?></div>
    <?php endif; ?>

</body>
</html>