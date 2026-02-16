<?php

declare(strict_types=1);
?><!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars((string) ($title ?? 'Ergastério São Lucas'), ENT_QUOTES, 'UTF-8') ?></title>
    <style>
      body{font-family:Arial,sans-serif;background:#f8fafc;color:#0f172a;margin:0;padding:2rem}
      .card{max-width:720px;margin:0 auto;background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:1.25rem}
      a{color:#2563eb}
    </style>
</head>
<body>
<main class="card">
<?= $content ?>
</main>
</body>
</html>
