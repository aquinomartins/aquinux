<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$uriPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');

if (PHP_SAPI === 'cli-server') {
    $requestedFile = $root . $uriPath;
    if (is_file($requestedFile)) {
        return false;
    }
}

$normalizedPath = '/' . trim($uriPath, '/');
if ($normalizedPath === '//') {
    $normalizedPath = '/';
}

$routes = require $root . '/app/routes.php';
$handler = $routes[$method][$normalizedPath] ?? null;

if (!$handler || !is_callable($handler)) {
    http_response_code(404);
    echo '<!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><title>404</title></head><body>';
    echo '<h1>404 - Página não encontrada</h1>';
    echo '<p>Rota não mapeada no front controller.</p>';
    echo '<p><a href="/">Voltar ao início</a></p>';
    echo '</body></html>';
    exit;
}

call_user_func($handler);
