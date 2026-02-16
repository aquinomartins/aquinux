<?php

declare(strict_types=1);
?>
<main id="view" class="landing-view" data-default-view="home"></main>

<section class="auth-overlay" data-role="auth-overlay" hidden>
  <div class="auth-overlay__backdrop" data-role="auth-overlay-close" aria-hidden="true"></div>
  <div class="auth-overlay__panel" role="dialog" aria-modal="true" aria-label="Entrar no Ergastério">
    <button type="button" class="auth-overlay__close ghost" data-role="auth-overlay-close">Fechar</button>
    <h2>Entrar</h2>
    <p class="subtle">Faça login para operar e acompanhar seus ativos.</p>
    <div data-role="auth-overlay-slot"></div>
  </div>
</section>

<script src="<?= htmlspecialchars(base_url('app.js'), ENT_QUOTES, 'UTF-8') ?>" defer></script>
