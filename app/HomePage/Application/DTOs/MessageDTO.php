<?php

declare(strict_types=1);

namespace App\HomePage\Application\DTOs;

use JsonSerializable;

class MessageDTO implements JsonSerializable
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $message,
        public readonly ?string $createdAt = null
    ) {}

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'message' => $this->message,
            'created_at' => $this->createdAt
        ];
    }
}
