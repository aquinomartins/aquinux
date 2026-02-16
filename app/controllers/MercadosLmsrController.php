<?php

declare(strict_types=1);

final class MercadosLmsrController
{
    public function index(): void
    {
        header('Location: /mercados_lmsr/', true, 302);
    }
}
