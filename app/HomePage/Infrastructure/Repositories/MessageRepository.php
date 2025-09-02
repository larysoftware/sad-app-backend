<?php

namespace App\HomePage\Infrastructure\Repositories;

use App\HomePage\Domain\Entities\Message;
use App\HomePage\Domain\Repositories\MessageRepositoryInterface;

class MessageRepository implements MessageRepositoryInterface
{
    public function getWelcomeMessage(): Message
    {
        return new Message('hello');
    }
}
