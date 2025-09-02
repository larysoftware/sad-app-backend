<?php

declare(strict_types=1);

namespace App\HomePage\Domain\Repositories;

use App\HomePage\Domain\Entities\Message;

interface MessageRepositoryInterface
{
    public function getWelcomeMessage(): Message;
    
    public function findById(int $id): ?Message;
    
    public function findAll(): array;
    
    public function save(Message $message): Message;
    
    public function delete(int $id): bool;
}
