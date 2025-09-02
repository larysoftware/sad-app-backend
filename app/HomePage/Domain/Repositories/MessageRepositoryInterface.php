<?php

namespace App\HomePage\Domain\Repositories;

use App\HomePage\Domain\Entities\Message;

interface MessageRepositoryInterface
{
    public function getWelcomeMessage(): Message;
}
