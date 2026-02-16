<?php declare(strict_types=1); ?>
<section class="page-hero server-card">
  <p class="subtle">Trending</p>
  <h1>Destaques da plataforma</h1>
  <p class="subtle">Página SSR com atualização progressiva no cliente.</p>
</section>

<section class="server-grid" aria-label="Resumo de tendência">
  <article class="server-card">
    <h2>Mercados LMSR abertos</h2>
    <p class="subtle"><strong><?= count($openMarkets) ?></strong> mercado(s) ativo(s).</p>
  </article>
  <article class="server-card">
    <h2>Leilões em execução</h2>
    <p class="subtle"><strong><?= count($runningAuctions) ?></strong> leilão(ões) com status running.</p>
  </article>
  <article class="server-card">
    <h2>Trades recentes</h2>
    <p class="subtle"><strong><?= count($recentTrades) ?></strong> negociação(ões) mais recentes.</p>
  </article>
</section>

<section class="server-card" id="trending-dynamic-section" data-trending-root aria-live="polite">
  <h2>Cards dinâmicos</h2>
  <p class="subtle" id="trending-status" data-trending-status>Renderizando dados SSR...</p>

  <p class="subtle" id="trending-loading" data-trending-loading hidden>Carregando atualizações...</p>
  <p class="subtle" id="trending-error" data-trending-error hidden>Não foi possível atualizar agora. Exibindo dados iniciais da página.</p>

  <div class="server-grid" id="trending-cards" data-trending-cards>
    <?php if (!$openMarkets): ?>
      <article class="server-card">
        <h3>Mercados LMSR</h3>
        <p class="subtle">Nenhum mercado aberto encontrado.</p>
      </article>
    <?php else: ?>
      <?php foreach ($openMarkets as $market): ?>
        <article class="server-card">
          <h3><?= htmlspecialchars((string)($market['title'] ?? 'Mercado'), ENT_QUOTES, 'UTF-8') ?></h3>
          <p class="subtle">
            Status: <?= htmlspecialchars((string)($market['status'] ?? 'open'), ENT_QUOTES, 'UTF-8') ?> ·
            SIM (q): <?= (int)($market['q_sim'] ?? 0) ?> ·
            NÃO (q): <?= (int)($market['q_nao'] ?? 0) ?>
          </p>
        </article>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <div class="server-grid" id="trending-events" data-trending-events>
    <article class="server-card">
      <h3>Eventos</h3>
      <p class="subtle">Sem eventos dinâmicos no SSR.</p>
    </article>
  </div>
</section>

<script src="<?= htmlspecialchars(base_url('js/trending-page.js'), ENT_QUOTES, 'UTF-8') ?>" defer></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var isTrendingPath = window.location && window.location.pathname === '<?= htmlspecialchars(base_url('trending'), ENT_QUOTES, 'UTF-8') ?>';
    var hasTrendingSelectors = document.querySelector('[data-trending-root]') !== null;

    if (typeof window.initTrendingPage === 'function' && (isTrendingPath || hasTrendingSelectors)) {
      window.initTrendingPage({
        endpoint: '<?= htmlspecialchars(base_url('api/trending'), ENT_QUOTES, 'UTF-8') ?>',
        selectors: {
          cardsContainer: '[data-trending-cards]',
          eventsContainer: '[data-trending-events]',
          status: '[data-trending-status]',
          loading: '[data-trending-loading]',
          error: '[data-trending-error]'
        }
      });
    }
  });
</script>
