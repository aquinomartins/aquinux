<?php

declare(strict_types=1);

function base_url(string $path = ''): string
{
    $normalized = ltrim($path, '/');
    return $normalized === '' ? '/' : '/' . $normalized;
}

function render_page(string $contentView, array $data = []): void
{
    $basePath = dirname(__DIR__);
    $viewsPath = $basePath . '/views';
    $contentViewFile = $viewsPath . '/pages/' . $contentView . '.php';

    if (!is_file($contentViewFile)) {
        http_response_code(500);
        echo 'View não encontrada: ' . htmlspecialchars($contentView, ENT_QUOTES, 'UTF-8');
        return;
    }

    extract($data, EXTR_SKIP);
    $pageTitle = $data['pageTitle'] ?? 'Ergastério';
    $pageDescription = $data['pageDescription'] ?? 'Plataforma Ergastério';

    require $viewsPath . '/layout/header.php';
    require $viewsPath . '/layout/navbar.php';
    echo '<main class="container" id="server-view">';
    require $contentViewFile;
    echo '</main>';
    require $viewsPath . '/layout/footer.php';
}
