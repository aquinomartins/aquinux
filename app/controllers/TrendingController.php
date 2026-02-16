<?php

declare(strict_types=1);

require_once __DIR__ . '/../core/View.php';
require_once __DIR__ . '/../models/MarketRepository.php';

final class TrendingController
{
    public function index(): void
    {
        $payload = $this->fetchTrendingPayload();

        render_page('trending', [
            'pageTitle' => 'Trending • Ergastério',
            'pageDescription' => 'Painel de tendências com mercados LMSR, leilões e negociações recentes.',
            'openMarkets' => $payload['openMarkets'],
            'runningAuctions' => $payload['runningAuctions'],
            'recentTrades' => $payload['recentTrades'],
        ]);
    }

    public function data(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        $payload = $this->fetchTrendingPayload();

        echo json_encode([
            'ok' => true,
            'openMarkets' => $payload['openMarkets'],
            'runningAuctions' => $payload['runningAuctions'],
            'recentTrades' => $payload['recentTrades'],
            'events' => $payload['events'],
        ], JSON_UNESCAPED_UNICODE);
    }

    private function fetchTrendingPayload(): array
    {
        try {
            $repo = new MarketRepository();
            return [
                'openMarkets' => $repo->getOpenLmsrMarkets(),
                'runningAuctions' => $repo->getRunningAuctions(),
                'recentTrades' => $repo->getLatestTrades(),
                'events' => [],
            ];
        } catch (Throwable $error) {
            return [
                'openMarkets' => [],
                'runningAuctions' => [],
                'recentTrades' => [],
                'events' => [],
            ];
        }
    }
}
