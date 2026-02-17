<?php declare(strict_types=1); ?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
  <meta name="description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8') ?>" />
  <link rel="stylesheet" href="<?= base_url('ergasterio-unificado.css') ?>" />
  <style>
    body.server-layout{background:#0f172a;color:#e2e8f0;min-height:100vh;margin:0}
    .container{max-width:1200px;margin:0 auto;padding:1rem}
    .server-nav{display:flex;gap:1rem;flex-wrap:wrap;background:#111827;padding:1rem;border-bottom:1px solid #1f2937}
    .server-nav a{color:#93c5fd;text-decoration:none;font-weight:600}
    .server-nav a:hover{text-decoration:underline}
    .server-card{background:#111827;border:1px solid #1f2937;border-radius:14px;padding:1rem;margin-bottom:1rem}
    .server-grid{display:grid;gap:1rem;grid-template-columns:repeat(auto-fit,minmax(260px,1fr))}
    .server-table{width:100%;border-collapse:collapse}
    .server-table th,.server-table td{border-bottom:1px solid #1f2937;padding:.5rem;text-align:left}
    .page-hero h1{margin:.4rem 0}
    .subtle{color:#94a3b8}
  </style>
</head>
<body class="server-layout<?= !empty($pageBodyClass) ? ' ' . htmlspecialchars((string) $pageBodyClass, ENT_QUOTES, 'UTF-8') : '' ?>">
