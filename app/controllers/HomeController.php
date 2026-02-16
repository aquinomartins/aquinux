<?php

declare(strict_types=1);

require_once __DIR__ . '/../core/View.php';

final class HomeController
{
    public function index(): void
    {
        render_page('home', [
            'pageTitle' => 'Ergastério São Lucas',
            'pageDescription' => 'Painel principal do Ergastério com módulos interativos.',
        ]);
    }
}
