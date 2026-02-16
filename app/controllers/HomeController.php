<?php

declare(strict_types=1);

final class HomeController
{
    public function index(): void
    {
        $legacyHomeFile = dirname(__DIR__, 2) . '/index.php';

        if (!is_file($legacyHomeFile)) {
            http_response_code(500);
            echo 'Arquivo index.php não encontrado.';
            return;
        }

        require $legacyHomeFile;
    }
}
