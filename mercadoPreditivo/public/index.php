<?php
// public/index.php

declare(strict_types=1);

require_once __DIR__ . '/../../lib/auth.php';
require_once __DIR__ . '/../includes/navbar_context.php';

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Mercado Preditivo</title>
    <link rel="stylesheet" href="/styles.css">
    <link rel="stylesheet" href="/mercadoPreditivo/assets/styles.css">
</head>
<body class="prediction-market-page">
<?php require __DIR__ . '/../../app/views/layout/navbar.php'; ?>
<main class="container prediction-container">

    <section class="market-list" data-market-list></section>
</main>
<script src="/mercadoPreditivo/assets/prediction.js" defer></script>
</body>
</html>