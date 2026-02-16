<?php

declare(strict_types=1);
?>
<h1>Página não encontrada</h1>
<p>A rota <strong><?= htmlspecialchars((string) ($path ?? '/'), ENT_QUOTES, 'UTF-8') ?></strong> não existe.</p>
<p><a href="/">Voltar para a página inicial</a></p>
