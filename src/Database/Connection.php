<?php

namespace App\Database;

use PDO;
use PDOException;

class Connection
{
    private string $databasePath;

    public function __construct(string $databasePath)
    {
        $this->databasePath = $databasePath;
    }

    public function connect(): PDO
    {
        $dir = dirname($this->databasePath);
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        try {
            $pdo = new PDO('sqlite:' . $this->databasePath);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        } catch (PDOException $exception) {
            throw new PDOException('Unable to open database: ' . $exception->getMessage(), (int) $exception->getCode());
        }
    }
}
