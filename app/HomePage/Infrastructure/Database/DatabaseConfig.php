<?php

declare(strict_types=1);

namespace App\HomePage\Infrastructure\Database;

class DatabaseConfig
{
    private string $host;
    private string $database;
    private string $username;
    private string $password;
    private int $port;

    public function __construct(
        string $host = 'localhost',
        string $database = 'homepage',
        string $username = 'root',
        string $password = '',
        int $port = 3306
    ) {
        $this->host = $host;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
        $this->port = $port;
    }

    public function getDsn(): string
    {
        return "mysql:host={$this->host};port={$this->port};dbname={$this->database};charset=utf8mb4";
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getOptions(): array
    {
        return [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => false,
        ];
    }
}
