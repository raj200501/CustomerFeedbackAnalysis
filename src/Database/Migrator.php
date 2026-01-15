<?php

namespace App\Database;

use PDO;

class Migrator
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function migrate(string $schemaPath): void
    {
        $this->ensureMigrationsTable();

        $hash = $this->schemaHash($schemaPath);
        $applied = $this->currentSchemaHash();

        if ($hash !== null && $hash === $applied) {
            return;
        }

        $schema = file_get_contents($schemaPath);
        if ($schema === false) {
            throw new \RuntimeException('Failed to read schema file: ' . $schemaPath);
        }

        $this->pdo->beginTransaction();
        try {
            $this->pdo->exec($schema);
            $this->recordSchemaHash($hash);
            $this->pdo->commit();
        } catch (\Throwable $exception) {
            $this->pdo->rollBack();
            throw $exception;
        }
    }

    public function seed(string $seedPath): void
    {
        $seed = file_get_contents($seedPath);
        if ($seed === false) {
            throw new \RuntimeException('Failed to read seed file: ' . $seedPath);
        }

        $this->pdo->beginTransaction();
        try {
            $this->pdo->exec($seed);
            $this->pdo->commit();
        } catch (\Throwable $exception) {
            $this->pdo->rollBack();
            throw $exception;
        }
    }

    private function ensureMigrationsTable(): void
    {
        $this->pdo->exec(
            'CREATE TABLE IF NOT EXISTS schema_migrations (id INTEGER PRIMARY KEY AUTOINCREMENT, schema_hash TEXT NOT NULL, applied_at DATETIME DEFAULT CURRENT_TIMESTAMP)'
        );
    }

    private function schemaHash(string $schemaPath): ?string
    {
        $contents = file_get_contents($schemaPath);
        if ($contents === false) {
            return null;
        }

        return hash('sha256', $contents);
    }

    private function currentSchemaHash(): ?string
    {
        $stmt = $this->pdo->query('SELECT schema_hash FROM schema_migrations ORDER BY id DESC LIMIT 1');
        $row = $stmt->fetch();
        return $row['schema_hash'] ?? null;
    }

    private function recordSchemaHash(?string $hash): void
    {
        if ($hash === null) {
            return;
        }

        $stmt = $this->pdo->prepare('INSERT INTO schema_migrations (schema_hash) VALUES (:hash)');
        $stmt->execute(['hash' => $hash]);
    }
}
