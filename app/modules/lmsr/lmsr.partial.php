<section class="lmsr-module" aria-label="Módulo LMSR">
  <header>
    <h2>Mercados LMSR em aberto</h2>
    <p class="subtle">Módulo integrado (sem iframe), com atualização em tempo real do endpoint canônico <code>/api/markets/list.php</code>.</p>
  </header>
  <div class="server-grid" id="lmsrMarketList">
    <p class="subtle">Carregando mercados...</p>
  </div>
</section>

<script>
(async function initLmsrModule(){
  const root = document.getElementById('lmsrMarketList');
  if (!root) return;

  const formatNumber = (value, digits = 2) => {
    const num = Number(value);
    if (!Number.isFinite(num)) return '—';
    return num.toLocaleString('pt-BR', { minimumFractionDigits: digits, maximumFractionDigits: digits });
  };

  const render = (markets) => {
    if (!Array.isArray(markets) || markets.length === 0) {
      root.innerHTML = '<p class="subtle">Nenhum mercado LMSR aberto no momento.</p>';
      return;
    }

    root.innerHTML = markets.map((market) => {
      const title = market?.title || `Mercado #${market?.id || '—'}`;
      const pSim = formatNumber((Number(market?.p_sim) || 0) * 100, 1);
      const pNao = formatNumber((Number(market?.p_nao) || 0) * 100, 1);
      const status = String(market?.status || 'desconhecido').toUpperCase();
      return `
        <article class="server-card">
          <h3>${title}</h3>
          <p class="subtle">Status: ${status}</p>
          <p>SIM: <strong>${pSim}%</strong></p>
          <p>NÃO: <strong>${pNao}%</strong></p>
        </article>
      `;
    }).join('');
  };

  try {
    const response = await fetch('/api/markets/list.php', { credentials: 'include' });
    const payload = await response.json().catch(() => ({}));
    if (!response.ok) {
      throw new Error(payload?.error || `HTTP ${response.status}`);
    }
    render(payload?.markets || []);
  } catch (error) {
    root.innerHTML = '<p class="subtle">Não foi possível carregar os mercados LMSR agora.</p>';
  }
})();
</script>
