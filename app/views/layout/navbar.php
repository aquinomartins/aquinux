<?php declare(strict_types=1); ?>
<?php
$rawRequestUri = (string) ($_SERVER['REQUEST_URI'] ?? '/');
$currentPath = (string) (parse_url($rawRequestUri, PHP_URL_PATH) ?: '/');
$normalizedPath = '/' . trim($currentPath, '/');
if ($normalizedPath === '//') {
    $normalizedPath = '/';
}

$isHome = $normalizedPath === '/';
$isTrending = $normalizedPath === '/trending';
$isMercadosLmsr = in_array($normalizedPath, ['/mercados_lmsr', '/mercados-lmsr'], true);
?>
<header class="menu site-header" id="appMenu">
    <div class="menu-top">

      <div class="menu-actions">
        <div class="menu-brand">
        <a class="menu-logo" data-view="home" href="/">
  <!--img src="uploads/logoErgasterio.svg" alt="Logo Ergastério São Lucas"-->
  <span>Ergastério São Lucas</span>
</a>
        <!--span class="menu-tagline">Hub de leilões e ativos digitais</span-->
      </div>

        <div class="menu-brand"><button class="auth-trigger" id="authOverlayButton" type="button">Entrar</button></div>
        <div id="authBoxAnchor">
          <div id="authBox" class="card">
            <!-- Login -->
            <form id="loginForm">
              <input type="email" id="email" placeholder="email" required />
              <input type="password" id="password" placeholder="senha" required />
              <button type="submit">Entrar</button>
            </form>

            <!-- Sessão ativa -->
            <div id="loggedBox" style="display:none">
              <p class="ok" id="sessionInfo">Conectado</p>
              <button id="logoutBtn">Sair</button>
            </div>

            <hr/>

            <!-- Toggle Registro -->
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
        <!--div class="menu-brand"><span class="menu-actions__icon" aria-hidden="true">🔎</span></div-->
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
