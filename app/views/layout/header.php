<?php declare(strict_types=1); ?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
  <meta name="description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8') ?>" />
  <link rel="stylesheet" href="<?= base_url('styles.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('responsive-layout.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('cmss/estilos/www.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('cmss/estilos/www2.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('cmss/estilos/fgx0.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('cmss/estilos/mxk5.css') ?>" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="<?= base_url('cmss/estilos/sec-3-6.css') ?>" />
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
  <script src="<?= base_url('cmss/scripts2/background-image-lazy-load.js') ?>"></script>
  <script src="<?= base_url('cmss/scripts2/cm-app.min.js') ?>"></script>
  <script src="<?= base_url('cmss/scripts2/d51y.js') ?>"></script>
  <script src="<?= base_url('cmss/scripts2/g24t.js') ?>"></script>
  <script src="<?= base_url('cmss/scripts2/interactions.js') ?>"></script>
  <script src="<?= base_url('cmss/scripts2/picture-fill-background.js') ?>"></script>
  <script src="<?= base_url('cmss/scripts2/sec-cpt-3-6.js') ?>"></script>
  <script src="<?= base_url('cmss/scripts2/slick-sliders.js') ?>"></script>
  <script src="<?= base_url('cmss/scripts2/tables.js') ?>"></script>
  <script src="<?= base_url('cmss/scripts2/tactic.js') ?>"></script>
  <script src="<?= base_url('cmss/scripts2/tacticbindlinks.js') ?>"></script>
  <script src="<?= base_url('cmss/scripts2/widgets.js') ?>"></script>
  <script src="<?= base_url('cmss/scripts/www.js') ?>"></script>
  <script src="<?= base_url('cmss/scripts/www_original.js') ?>"></script>
</head>
<body class="server-layout<?= !empty($pageBodyClass) ? ' ' . htmlspecialchars((string) $pageBodyClass, ENT_QUOTES, 'UTF-8') : '' ?>">
