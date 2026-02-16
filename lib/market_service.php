<?php

declare(strict_types=1);

require_once __DIR__ . '/lmsr.php';
require_once __DIR__ . '/market_accounts.php';

function market_fetch(PDO $pdo, int $marketId, bool $forUpdate = false): ?array {
  $lock = $forUpdate ? ' FOR UPDATE' : '';
  $stmt = $pdo->prepare("SELECT m.*, COALESCE(s.q_sim, 0) AS q_sim, COALESCE(s.q_nao, 0) AS q_nao, COALESCE(s.cost_total, 0) AS cost_total, s.updated_at AS state_updated_at FROM markets m LEFT JOIN market_state s ON s.market_id = m.id WHERE m.id = ?{$lock}");
  $stmt->execute([$marketId]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  return $row ?: null;
}

function market_prices(array $market): array {
  $qSim = (int)$market['q_sim'];
  $qNao = (int)$market['q_nao'];
  $b = (float)$market['b'];
  $pSim = lmsr_price_sim($qSim, $qNao, $b);
  return [
    'p_sim' => round($pSim, 10),
    'p_nao' => round(1 - $pSim, 10),
  ];
}

function market_quote(array $market, string $side, int $shares): array {
  $qSim = (int)$market['q_sim'];
  $qNao = (int)$market['q_nao'];
  $b = (float)$market['b'];
  $pBefore = lmsr_price_sim($qSim, $qNao, $b);

  $shares = max(0, $shares);
  $qSimAfter = $qSim;
  $qNaoAfter = $qNao;

  if ($side === 'SIM') {
    $qSimAfter += $shares;
  } else {
    $qNaoAfter += $shares;
  }

  $costBefore = lmsr_cost($qSim, $qNao, $b);
  $costAfter = lmsr_cost($qSimAfter, $qNaoAfter, $b);
  $deltaCost = $costAfter - $costBefore;
  $feeRate = (float)$market['fee_rate'];
  $fee = $deltaCost * $feeRate;
  $deltaRounded = round($deltaCost, 8);
  $feeRounded = round($fee, 8);
  $total = $deltaRounded + $feeRounded;
  $pAfter = lmsr_price_sim($qSimAfter, $qNaoAfter, $b);

  return [
    'delta_cost' => $deltaRounded,
    'fee' => $feeRounded,
    'total' => round($total, 8),
    'p_sim_before' => round($pBefore, 10),
    'p_sim_after' => round($pAfter, 10),
    'q_sim_after' => $qSimAfter,
    'q_nao_after' => $qNaoAfter,
  ];
}

function market_fetch_last_trades(PDO $pdo, int $marketId, int $limit = 10): array {
  $stmt = $pdo->prepare('SELECT * FROM market_trades WHERE market_id = ? ORDER BY id DESC LIMIT ?');
  $stmt->bindValue(1, $marketId, PDO::PARAM_INT);
  $stmt->bindValue(2, $limit, PDO::PARAM_INT);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
}

function market_fetch_position(PDO $pdo, int $marketId, int $userId): array {
  $stmt = $pdo->prepare('SELECT side, shares, avg_cost FROM market_positions WHERE market_id = ? AND user_id = ?');
  $stmt->execute([$marketId, $userId]);
  $positions = [
    'SIM' => ['shares' => 0, 'avg_cost' => 0.0],
    'NAO' => ['shares' => 0, 'avg_cost' => 0.0],
  ];

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $side = $row['side'] === 'NAO' ? 'NAO' : 'SIM';
    $positions[$side] = [
      'shares' => (int)$row['shares'],
      'avg_cost' => (float)$row['avg_cost'],
    ];
  }

  return $positions;
}