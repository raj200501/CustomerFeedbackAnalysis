<?php

namespace App;

use App\Database\Connection;
use App\Database\Migrator;
use App\Repository\AnalyticsRepository;
use App\Repository\CustomerRepository;
use App\Repository\FeedbackRepository;
use App\Repository\FeedbackResponseRepository;
use App\Repository\UserRepository;
use App\Service\AdminService;
use App\Service\AnalyticsService;
use App\Service\FeedbackService;
use App\Service\KeywordExtractor;
use App\Service\SentimentLexicon;
use App\Service\StopWords;
use App\Support\Config;
use App\Validation\FeedbackValidator;
use App\Validation\ResponseValidator;
use PDO;

class App
{
    private Config $config;
    private ?PDO $pdo = null;

    private ?CustomerRepository $customerRepository = null;
    private ?FeedbackRepository $feedbackRepository = null;
    private ?AnalyticsRepository $analyticsRepository = null;
    private ?UserRepository $userRepository = null;
    private ?FeedbackResponseRepository $feedbackResponseRepository = null;

    private ?AnalyticsService $analyticsService = null;
    private ?FeedbackService $feedbackService = null;
    private ?AdminService $adminService = null;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function config(): Config
    {
        return $this->config;
    }

    public function pdo(): PDO
    {
        if ($this->pdo === null) {
            $connection = new Connection($this->config->databasePath());
            $this->pdo = $connection->connect();
        }

        return $this->pdo;
    }

    public function migrate(string $schemaPath, ?string $seedPath = null): void
    {
        $migrator = new Migrator($this->pdo());
        $migrator->migrate($schemaPath);

        if ($seedPath !== null && $this->config->seedOnBoot() && $this->shouldSeed()) {
            $migrator->seed($seedPath);
        }
    }

    public function customerRepository(): CustomerRepository
    {
        if ($this->customerRepository === null) {
            $this->customerRepository = new CustomerRepository($this->pdo());
        }

        return $this->customerRepository;
    }

    public function feedbackRepository(): FeedbackRepository
    {
        if ($this->feedbackRepository === null) {
            $this->feedbackRepository = new FeedbackRepository($this->pdo());
        }

        return $this->feedbackRepository;
    }

    public function analyticsRepository(): AnalyticsRepository
    {
        if ($this->analyticsRepository === null) {
            $this->analyticsRepository = new AnalyticsRepository($this->pdo());
        }

        return $this->analyticsRepository;
    }

    public function userRepository(): UserRepository
    {
        if ($this->userRepository === null) {
            $this->userRepository = new UserRepository($this->pdo());
        }

        return $this->userRepository;
    }

    public function feedbackResponseRepository(): FeedbackResponseRepository
    {
        if ($this->feedbackResponseRepository === null) {
            $this->feedbackResponseRepository = new FeedbackResponseRepository($this->pdo());
        }

        return $this->feedbackResponseRepository;
    }

    public function analyticsService(): AnalyticsService
    {
        if ($this->analyticsService === null) {
            $lexicon = new SentimentLexicon();
            $stopWords = new StopWords();
            $keywordExtractor = new KeywordExtractor($stopWords);
            $this->analyticsService = new AnalyticsService($lexicon, $keywordExtractor);
        }

        return $this->analyticsService;
    }

    public function feedbackService(): FeedbackService
    {
        if ($this->feedbackService === null) {
            $this->feedbackService = new FeedbackService(
                $this->customerRepository(),
                $this->feedbackRepository(),
                $this->analyticsRepository(),
                $this->analyticsService(),
                new FeedbackValidator()
            );
        }

        return $this->feedbackService;
    }

    public function adminService(): AdminService
    {
        if ($this->adminService === null) {
            $this->adminService = new AdminService(
                $this->feedbackRepository(),
                $this->feedbackResponseRepository(),
                $this->userRepository(),
                new ResponseValidator()
            );
        }

        return $this->adminService;
    }

    private function shouldSeed(): bool
    {
        $tables = ['customers', 'feedback', 'analytics', 'users', 'feedback_responses'];

        foreach ($tables as $table) {
            try {
                $stmt = $this->pdo()->query('SELECT COUNT(*) AS count FROM ' . $table);
                $row = $stmt->fetch();
                if (($row['count'] ?? 0) > 0) {
                    return false;
                }
            } catch (\Throwable $exception) {
                return false;
            }
        }

        return true;
    }
}
