<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$uriPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');

$pathStartsWith = static function (string $haystack, string $needle): bool {
    if (function_exists('str_starts_with')) {
        return str_starts_with($haystack, $needle);
    }

    return $needle === '' || strncmp($haystack, $needle, strlen($needle)) === 0;
};

if ($method === 'GET' || $method === 'HEAD') {
    $requestedPath = $root . '/' . ltrim($uriPath, '/');
    $resolvedPath = realpath($requestedPath);

    if ($resolvedPath !== false && $pathStartsWith($resolvedPath, $root . DIRECTORY_SEPARATOR) && is_file($resolvedPath)) {
        $extension = strtolower(pathinfo($resolvedPath, PATHINFO_EXTENSION));
        $allowedExtensions = [
            'css', 'js', 'mjs', 'json', 'map', 'txt', 'xml',
            'png', 'jpg', 'jpeg', 'gif', 'svg', 'webp', 'ico',
            'woff', 'woff2', 'ttf', 'otf', 'eot',
            'mp4', 'webm', 'mp3', 'wav', 'pdf',
        ];

        if (in_array($extension, $allowedExtensions, true)) {
            $mimeType = mime_content_type($resolvedPath) ?: 'application/octet-stream';
            header('Content-Type: ' . $mimeType);
            header('Content-Length: ' . (string) filesize($resolvedPath));

            if ($method === 'GET') {
                readfile($resolvedPath);
            }

            exit;
        }
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
