<?php

declare(strict_types=1);

require_once __DIR__ . '/../../lib/db.php';

final class MarketRepository
{
    private PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo ?? db();
    }

    public function getOpenLmsrMarkets(int $limit = 8): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT m.id, m.title, m.status, m.created_at, ms.q_sim, ms.q_nao
             FROM markets m
             LEFT JOIN market_state ms ON ms.market_id = m.id
             WHERE m.status = :status
             ORDER BY m.created_at DESC
             LIMIT :max'
        );
        $stmt->bindValue(':status', 'open');
        $stmt->bindValue(':max', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll() ?: [];
    }

    public function getRunningAuctions(int $limit = 6): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT a.id, a.status, a.ends_at, a.reserve_price,
                    COALESCE(MAX(b.amount), 0) AS highest_bid
             FROM auctions a
             LEFT JOIN bids b ON b.auction_id = a.id AND b.status IN ("valid", "winner")
             WHERE a.status = :status
             GROUP BY a.id, a.status, a.ends_at, a.reserve_price
             ORDER BY a.ends_at ASC
             LIMIT :max'
        );
        $stmt->bindValue(':status', 'running');
        $stmt->bindValue(':max', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll() ?: [];
    }

    public function getLatestTrades(int $limit = 10): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT t.id, t.qty, t.price, t.created_at
             FROM trades t
             ORDER BY t.created_at DESC
             LIMIT :max'
        );
        $stmt->bindValue(':max', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll() ?: [];
    }
}
