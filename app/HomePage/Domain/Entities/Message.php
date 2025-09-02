<?php

declare(strict_types=1);

namespace App\HomePage\Domain\Entities;

class Message
{
    public function __construct(
        private ?int $id,
        private string $content,
        private ?string $createdAt = null
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public static function createFromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            content: $data['content'],
            createdAt: $data['created_at'] ?? null
        );
    }
}
