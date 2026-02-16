<?php

declare(strict_types=1);

require_once __DIR__ . '/controllers/TrendingController.php';
require_once __DIR__ . '/controllers/MercadosLmsrController.php';
require_once __DIR__ . '/controllers/HomeController.php';

return [
    'GET' => [
        '/' => [new HomeController(), 'index'],
        '/trending' => [new TrendingController(), 'index'],
        '/api/trending' => [new TrendingController(), 'data'],
        '/mercados-lmsr' => [new MercadosLmsrController(), 'index'],
        '/mercados_lmsr' => [new MercadosLmsrController(), 'index'],
    ],
];
