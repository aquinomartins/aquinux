<?php

declare(strict_types=1);

require_once __DIR__ . '/../core/View.php';

final class MercadosLmsrController
{
    public function index(): void
    {
        render_page('mercados-lmsr', [
            'pageTitle' => 'Mercados LMSR • Ergastério',
            'pageDescription' => 'Mercados LMSR integrados ao layout, sem iframe.',
        ]);
    }
}
