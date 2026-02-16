<?php
declare(strict_types=1);

require_once __DIR__ . '/../../lib/session.php';

start_app_session();

if (!isset($_SESSION['uid']) && isset($_SESSION['user_id'])) {
    $_SESSION['uid'] = (int) $_SESSION['user_id'];
}

if (!isset($_SESSION['user_id']) && isset($_SESSION['uid'])) {
    $_SESSION['user_id'] = (int) $_SESSION['uid'];
}

$navbarLinkOverrides = [
    'mercado_preditivo' => '/mercadoPreditivo/public/index.php',
    'user_assets' => '/mercadoPreditivo/public/me.php',
    'admin' => '/mercadoPreditivo/admin/',
];

$navbarUseServerAuthLinks = true;

