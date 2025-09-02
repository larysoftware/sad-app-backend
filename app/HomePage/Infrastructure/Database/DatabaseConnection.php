<?php

declare(strict_types=1);

namespace App\HomePage\Infrastructure\Database;

use PDO;

class DatabaseConnection
{
    private ?PDO $connection = null;
    private DatabaseConfig $config;

    public function __construct(DatabaseConfig $config)
    {
        $this->config = $config;
    }

    public function getConnection(): PDO
    {
        if ($this->connection === null) {
            $this->connection = new PDO(
                $this->config->getDsn(),
                $this->config->getUsername(),
                $this->config->getPassword(),
                $this->config->getOptions()
            );
        }

        return $this->connection;
    }

    public function closeConnection(): void
    {
        $this->connection = null;
    }
}
