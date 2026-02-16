(function (global) {
  'use strict';

  function escapeHtml(value) {
    return String(value == null ? '' : value)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#39;');
  }

  function toNumber(value, fallback) {
    var num = Number(value);
    return Number.isFinite(num) ? num : fallback;
  }

  function formatBRL(value) {
    return new Intl.NumberFormat('pt-BR', {
      style: 'currency',
      currency: 'BRL',
      maximumFractionDigits: 2,
    }).format(toNumber(value, 0));
  }

  function formatDateTime(value) {
    if (!value) return 'Data a confirmar';
    var date = new Date(value);
    if (Number.isNaN(date.getTime())) return 'Data a confirmar';
    return new Intl.DateTimeFormat('pt-BR', {
      dateStyle: 'short',
      timeStyle: 'short',
    }).format(date);
  }

  function buildCard(item) {
    return [
      '<article class="server-card">',
      '<h3>' + escapeHtml(item.title) + '</h3>',
      '<p class="subtle">' + escapeHtml(item.description) + '</p>',
      '</article>'
    ].join('');
  }

  function setHidden(element, hidden) {
    if (!element) return;
    element.hidden = Boolean(hidden);
  }

  function buildTrendingEventCards(events) {
    if (!Array.isArray(events) || events.length === 0) {
      return [
        {
          title: 'Eventos',
          description: 'Nenhum evento disponível no momento.'
        }
      ];
    }

    return events.map(function (event, index) {
      var eventTitle = event && event.title ? event.title : 'Evento #' + (index + 1);
      var location = event && event.location ? ' · ' + event.location : '';
      return {
        title: eventTitle,
        description: formatDateTime(event && event.date) + location,
      };
    });
  }

  function loadTrendingItems(payload) {
    var safePayload = payload && typeof payload === 'object' ? payload : {};

    var openMarkets = Array.isArray(safePayload.openMarkets) ? safePayload.openMarkets : [];
    var runningAuctions = Array.isArray(safePayload.runningAuctions) ? safePayload.runningAuctions : [];
    var recentTrades = Array.isArray(safePayload.recentTrades) ? safePayload.recentTrades : [];
    var events = buildTrendingEventCards(Array.isArray(safePayload.events) ? safePayload.events : []);

    var cards = [];

    if (openMarkets.length === 0) {
      cards.push(buildCard({
        title: 'Mercados LMSR',
        description: 'Nenhum mercado aberto encontrado.'
      }));
    } else {
      openMarkets.forEach(function (market, index) {
        cards.push(buildCard({
          title: market && market.title ? market.title : 'Mercado #' + (index + 1),
          description: 'Status: ' + (market && market.status ? market.status : 'open') +
            ' · SIM (q): ' + toNumber(market && market.q_sim, 0) +
            ' · NÃO (q): ' + toNumber(market && market.q_nao, 0)
        }));
      });
    }

    if (runningAuctions.length === 0) {
      cards.push(buildCard({
        title: 'Leilões',
        description: 'Nenhum leilão em execução no momento.'
      }));
    } else {
      runningAuctions.forEach(function (auction, index) {
        cards.push(buildCard({
          title: 'Leilão #' + (auction && auction.id ? auction.id : (index + 1)),
          description: 'Lance atual: ' + formatBRL(auction && auction.highest_bid) +
            ' · Termina em: ' + formatDateTime(auction && auction.ends_at)
        }));
      });
    }

    if (recentTrades.length === 0) {
      cards.push(buildCard({
        title: 'Trades recentes',
        description: 'Nenhuma negociação recente encontrada.'
      }));
    } else {
      recentTrades.forEach(function (trade, index) {
        cards.push(buildCard({
          title: 'Trade #' + (trade && trade.id ? trade.id : (index + 1)),
          description: 'Quantidade: ' + toNumber(trade && trade.qty, 0) +
            ' · Preço: ' + formatBRL(trade && trade.price) +
            ' · Data: ' + formatDateTime(trade && trade.created_at)
        }));
      });
    }

    return {
      cardsHtml: cards.join(''),
      eventsHtml: events.map(buildCard).join(''),
    };
  }

  async function initTrendingPage(config) {
    var options = config && typeof config === 'object' ? config : {};
    var endpoint = typeof options.endpoint === 'string' && options.endpoint ? options.endpoint : '/api/trending';
    var selectors = options.selectors && typeof options.selectors === 'object' ? options.selectors : {};
    var containerSelector = selectors.cardsContainer || '[data-trending-cards]';
    var eventsSelector = selectors.eventsContainer || '[data-trending-events]';
    var statusSelector = selectors.status || '[data-trending-status]';
    var loadingSelector = selectors.loading || '[data-trending-loading]';
    var errorSelector = selectors.error || '[data-trending-error]';

    var container = document.querySelector(containerSelector);
    var eventsContainer = document.querySelector(eventsSelector);
    var status = document.querySelector(statusSelector);
    var loading = document.querySelector(loadingSelector);
    var error = document.querySelector(errorSelector);

    if (!container) return;

    try {
      setHidden(loading, false);
      setHidden(error, true);
      if (status) status.textContent = 'Atualizando destaques...';
      var response = await fetch(endpoint, {
        method: 'GET',
        credentials: 'include',
        headers: { 'Accept': 'application/json' },
      });
      if (!response.ok) {
        throw new Error('Falha ao carregar endpoint de trending');
      }

      var payload = await response.json();
      var rendered = loadTrendingItems(payload);
      container.innerHTML = rendered.cardsHtml;
      if (eventsContainer) eventsContainer.innerHTML = rendered.eventsHtml;
      if (status) status.textContent = 'Destaques atualizados.';
      setHidden(loading, true);
      setHidden(error, true);
    } catch (_error) {
      setHidden(loading, true);
      setHidden(error, false);
      if (status) status.textContent = 'Não foi possível atualizar os destaques agora.';
    }
  }

  global.buildTrendingEventCards = buildTrendingEventCards;
  global.loadTrendingItems = loadTrendingItems;
  global.initTrendingPage = initTrendingPage;
  global.__TrendingPage = {
    buildTrendingEventCards: buildTrendingEventCards,
    loadTrendingItems: loadTrendingItems,
    initTrendingPage: initTrendingPage,
  };
})(window);
