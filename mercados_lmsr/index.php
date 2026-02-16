<!DOCTYPE html>
<?php
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$isHome = $currentPath === '/';
$isTrending = rtrim($currentPath, '/') === '/trending';
$isMercadosLmsr = in_array(rtrim($currentPath, '/'), ['/mercados_lmsr', '/mercados-lmsr'], true);
?>

<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ergastério • Mercados LMSR</title>
  <link rel="stylesheet" href="./styles.css" />
</head>
<body>
<header class="menu site-header" id="appMenu">
    <div class="menu-top">

      <div class="menu-actions">
        <div class="menu-brand">
        <a class="menu-logo" data-view="home" href="/">
  <span>Ergastério São Lucas</span>
</a>
      </div>

        <div class="menu-brand"><button class="auth-trigger" id="authOverlayButton" type="button">Entrar</button></div>
        <div id="authBoxAnchor">
          <div id="authBox" class="card">
            <form id="loginForm">
              <input type="email" id="email" placeholder="email" required />
              <input type="password" id="password" placeholder="senha" required />
              <button type="submit">Entrar</button>
            </form>

            <div id="loggedBox" style="display:none">
              <p class="ok" id="sessionInfo">Conectado</p>
              <button id="logoutBtn">Sair</button>
            </div>

            <hr/>

            <button id="toggleRegister" class="ghost">Registrar novo usuário</button>
            <form id="registerForm" style="display:none; margin-top:8px;">
              <input type="text" id="r_name" placeholder="nome" required />
              <input type="email" id="r_email" placeholder="email" required />
              <input type="tel" id="r_phone" placeholder="telefone com DDD (opcional)" />
              <input type="password" id="r_password" placeholder="senha" required />
              <button type="submit">Criar conta</button>
            </form>
            <p id="authMsg" class="msg"></p>
          </div>
        </div>
      </div>
    </div>

    <div class="menu-content2" id="menuContent">
      <nav class="menu-nav" aria-label="Navegação principal">
        <ul>
          <li><a href="/" data-view="home"<?= $isHome ? ' aria-current="page"' : '' ?>>Home</a></li>
          <li><a href="/trending" data-view="trending"<?= $isTrending ? ' aria-current="page"' : '' ?>>Trending</a></li>
          <li><a href="#" data-view="mechanics">Mecânica Unificada</a></li>
          <li><a href="#" data-view="live_market">Mercado ao vivo</a></li>
          <li><a href="#" data-view="mercado_preditivo">Mercado preditivo</a></li>
          <li><a href="#" data-view="collections">Coleções</a></li>
          <li><a href="#" data-view="auctions">Leilões</a></li>
          <li><a href="#" data-view="events">Eventos</a></li>
          <li><a href="#" data-view="user_assets">Meus Ativos</a></li>
          <li><a href="#" data-view="pending_transactions">Transações pendentes</a></li>
          <li><a href="#" data-view="liquidity_game">Simulador</a></li>
          <li><a href="/mercados_lmsr/" data-view="mercados_lmsr"<?= $isMercadosLmsr ? ' aria-current="page"' : '' ?>>Mercados LMSR</a></li>
          <li><a href="/materiais/">Materiais</a></li>
          <li class="admin-only"><a href="#" data-view="admin">Painel Administrativo</a></li>
          <li class="admin-only"><a href="#" data-view="admin_mint">Mint de NFT</a></li>
        </ul>
      </nav>
    </div>
  </header>

<main class="container market-shell">
    

    <header class="market-hero">
      <div>
        <p class="market-hero__eyebrow subtle subtle--caps">Mercados LMSR</p>
        <h1 class="heading heading--xl">Fluxo canônico de mercados</h1>
        <p class="market-hero__subtitle subtle">
          Use o módulo local ./api/markets/* com contrato JSON canônico yes/no (compatível com SIM/NAO durante transição).
        </p>
      </div>
      <div class="market-hero__actions">
        <button type="button" class="ghost" data-action="refresh">Atualizar painel</button>
      </div>
    </header>

    <section class="market-overview" id="marketOverview"></section>

    <section class="market-toolbar">
      <div class="market-toolbar__filters">
        <button type="button" class="ghost is-active" data-filter="all">Todos</button>
        <button type="button" class="ghost" data-filter="open">Abertos</button>
        <button type="button" class="ghost" data-filter="resolved">Resolvidos</button>
      </div>
      <label class="market-toolbar__search">
        <span>Buscar</span>
        <input type="search" placeholder="Digite o nome do mercado" data-role="search" />
      </label>
    </section>

    <section class="market-grid">
      <div class="market-list card" id="marketList"></div>
      <div class="market-detail card" id="marketDetail"></div>
    </section>

    <section class="market-actions">
      <div class="card">
        <h2 class="heading heading--md">Criar mercado (admin)</h2>
        <form data-role="create-market-form">
          <label>Título
            <input type="text" name="title" required />
          </label>
          <label>Descrição
            <textarea name="description" rows="3"></textarea>
          </label>
          <label>Risco máximo (BRL)
            <input type="number" name="risk_max" step="0.01" min="1" placeholder="100" />
          </label>
          <label>Taxa (%)
            <input type="number" name="fee_rate" step="0.01" min="0" value="1" />
          </label>
          <label>Buffer (%)
            <input type="number" name="buffer_rate" step="0.01" min="0" value="15" />
          </label>
          <button type="submit">Criar mercado</button>
          <p class="msg" data-role="create-market-msg"></p>
        </form>
      </div>
      <div class="card">
        <h2 class="heading heading--md">Resolver mercado (admin)</h2>
        <form data-role="resolve-market-form">
          <p class="subtle" data-role="resolve-target">Selecione um mercado para resolver.</p>
          <input type="hidden" name="market_id" />
          <label>Outcome vencedor
            <select name="outcome" required>
              <option value="yes">YES (SIM)</option>
              <option value="no">NO (NÃO)</option>
            </select>
          </label>
          <button type="submit" data-role="resolve-submit">Resolver</button>
          <p class="msg" data-role="resolve-market-msg"></p>
        </form>
      </div>
      <div class="card">
        <h2 class="heading heading--md">Reclamar payout</h2>
        <form data-role="claim-market-form">
          <p class="subtle" data-role="claim-target">Selecione um mercado para reclamar payout.</p>
          <input type="hidden" name="market_id" />
          <button type="submit" data-role="claim-submit">Reclamar</button>
          <p class="msg" data-role="claim-market-msg"></p>
        </form>
      </div>
    </section>

    <dialog id="resolveConfirmDialog">
      <form method="dialog" class="card">
        <h3 class="heading heading--md">Confirmar resolução</h3>
        <p class="subtle" data-role="resolve-confirm-summary"></p>
        <p class="subtle">Esta ação encerra a negociação do mercado selecionado e habilita reclamações de payout.</p>
        <div class="market-detail__actions">
          <button type="button" class="ghost" data-role="resolve-cancel">Cancelar</button>
          <button type="button" data-role="resolve-confirm">Confirmar resolução</button>
        </div>
      </form>
    </dialog>
  </main>
  <script src="../login-continuity.js" defer></script>
  <script src="./app.js" defer></script>
</body>
</html>
