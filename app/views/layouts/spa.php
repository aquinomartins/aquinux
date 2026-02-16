<?php

declare(strict_types=1);

$indexFile = dirname(__DIR__, 3) . '/index.html';

if (!is_file($indexFile)) {
    http_response_code(500);
    echo 'Arquivo index.html não encontrado.';
    return;
}

readfile($indexFile);

echo $content;
