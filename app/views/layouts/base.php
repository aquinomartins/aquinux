<?php

declare(strict_types=1);
?><!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars((string) ($title ?? 'Ergastério São Lucas'), ENT_QUOTES, 'UTF-8') ?></title>
<?php foreach (($stylesheets ?? []) as $stylesheet): ?>
    <link rel="stylesheet" href="<?= htmlspecialchars((string) $stylesheet, ENT_QUOTES, 'UTF-8') ?>">
<?php endforeach; ?>
</head>
<body>
<?= $content ?>
<?php foreach (($scripts ?? []) as $script): ?>
    <script src="<?= htmlspecialchars((string) $script, ENT_QUOTES, 'UTF-8') ?>" defer></script>
<?php endforeach; ?>
</body>
</html>
