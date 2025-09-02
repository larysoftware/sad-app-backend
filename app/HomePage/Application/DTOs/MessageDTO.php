<?php

namespace App\HomePage\Application\DTOs;

use JsonSerializable;

class MessageDTO implements JsonSerializable
{
    public function __construct(
        public readonly string $message
    ) {}

    public function jsonSerialize(): array
    {
        return [
            'message' => $this->message
        ];
    }
}
