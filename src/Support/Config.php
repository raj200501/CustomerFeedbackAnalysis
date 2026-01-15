<?php

namespace App\Support;

class Config
{
    private string $databasePath;
    private string $environment;
    private string $basePath;
    private bool $seedOnBoot;

    public function __construct(string $databasePath, string $environment, string $basePath, bool $seedOnBoot)
    {
        $this->databasePath = $databasePath;
        $this->environment = $environment;
        $this->basePath = $basePath;
        $this->seedOnBoot = $seedOnBoot;
    }

    public static function fromEnv(string $rootPath): self
    {
        $databasePath = getenv('DB_PATH') ?: $rootPath . '/storage/feedback.sqlite';
        $environment = getenv('APP_ENV') ?: 'development';
        $basePath = getenv('BASE_PATH') ?: '/';
        $seedOnBoot = strtolower(getenv('SEED_ON_BOOT') ?: 'true') === 'true';

        return new self($databasePath, $environment, rtrim($basePath, '/') . '/', $seedOnBoot);
    }

    public function databasePath(): string
    {
        return $this->databasePath;
    }

    public function environment(): string
    {
        return $this->environment;
    }

    public function basePath(): string
    {
        return $this->basePath;
    }

    public function seedOnBoot(): bool
    {
        return $this->seedOnBoot;
    }
}
