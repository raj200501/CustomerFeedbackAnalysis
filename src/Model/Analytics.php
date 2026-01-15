<?php

namespace App\Model;

use App\Entity\AnalyticsEntry;
use App\Repository\AnalyticsRepository;

class Analytics
{
    private AnalyticsRepository $repository;

    public function __construct(AnalyticsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function addAnalytics(int $feedbackId, string $keyword, float $sentimentScore): AnalyticsEntry
    {
        return $this->repository->create($feedbackId, $keyword, $sentimentScore);
    }

    public function getAnalytics(): array
    {
        return $this->repository->all();
    }
}
