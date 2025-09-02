<?php

declare(strict_types=1);

namespace App\HomePage\Infrastructure\Providers;

use App\HomePage\Domain\Repositories\MessageRepositoryInterface;
use App\HomePage\Infrastructure\Database\DatabaseConfig;
use App\HomePage\Infrastructure\Database\DatabaseConnection;
use App\HomePage\Infrastructure\Repositories\MessageRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

class HomePageServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register database configuration
        $this->app->singleton(DatabaseConfig::class, function (Application $app) {
            return new DatabaseConfig(
                host: config('database.connections.mysql.host', 'localhost'),
                database: config('database.connections.mysql.database', 'homepage'),
                username: config('database.connections.mysql.username', 'root'),
                password: config('database.connections.mysql.password', ''),
                port: config('database.connections.mysql.port', 3306)
            );
        });

        // Register database connection
        $this->app->singleton(DatabaseConnection::class, function ($app) {
            return new DatabaseConnection($app->make(DatabaseConfig::class));
        });

        // Register repository
        $this->app->bind(MessageRepositoryInterface::class, MessageRepository::class);
    }

    public function boot(): void
    {
        // Create table if it doesn't exist
        $this->app->booted(function () {
            $repository = $this->app->make(MessageRepositoryInterface::class);
            if ($repository instanceof MessageRepository) {
                $repository->createTableIfNotExists();
            }
        });
    }
}
