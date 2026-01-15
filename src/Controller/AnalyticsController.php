<?php

namespace App\Controller;

use App\Repository\AnalyticsRepository;

class AnalyticsController
{
    private AnalyticsRepository $repository;

    public function __construct(AnalyticsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function all(): array
    {
        return $this->repository->all();
    }
}
